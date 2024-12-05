<?php
/*PHP Parser
1) To convert a Word XML document to database
2) To convert database to Word XML


Needs a helper/wizard to check if its XML or not, if not, provide guidance to save as XML... 
Rendering may be by PDF.js
Still need headless Word to PDF converter - check out Syncfusion Essential DOCIO
https://support.syncfusion.com/kb/article/8848/how-to-perform-word-to-pdf-conversion-in-azure-functions-v1

Will need to be written in C#

To split up Word file, Word seems to delineate by paragraph
Header information - goes to field X
Paragraph information - goes to relevant section field
Footer information - goes to field X

Isovist structure...
Break down divs - div per rule, RuleLevel determines font size (using HTML size categories 1-6)


//Two approaches
1)
Info was lost when going from Word to Isovist
Some may need to be reentered
However if database stores Word XML directly no information will be lost. 

2)
Going from Word, or anything else to PlanDo. 
Word seems to store by paragraph so it will break down by paragraph. This won't necessarily allow a distinguishing feature between rules and other sections
Will need some simple coding <rule>/<rule> for accuracy, <policy></policy>,<hyperlink>
Native PHP functions will read this XML file and break it into the chunks required. 


Use PHPHtmlParser (via Composer, check with Azure/Composer)

HOW TO VIEW ONLINE? 
XSLT? to HTML - maybe, but too fiddly with various lists etc
Pandoc as conversion engine - it'll do docx, pdf,HTML


This breaks up pages into sections. Sections useful for plantech
Will still need some markup where it is difficult to determine section breaks
And some treatement of tables

However, should also break it up into pages
Need something to link back to the definitions tables... Maybe DOM manipulation
Also cannot look like Isovist. 

A page contains pageid, list of pointers... 

//HTML to Word (with style changes to show it's not Isovist)
//Maybe Juypyter Scribe
//The Juypyter concept will help massively with plantech. 


*/

$arg1=$argv[1];

include_once("simplehtmldom_1_9_1/simple_html_dom.php");

//$dom = new Dom;
#$dom->loadStr($arg1);
//$dom->loadFromFile($arg1);

$dom=file_get_html($arg1);

//Parser constants
$plan="wdc.pdp.";
$level1pointer="none";
$level2pointer="none";
$pageids=explode("_",$arg1);
$pageid=$pageids[1];
//echo $pageid; 
$id=1;
$pointerid=""; 
$hyperlinks="";
$hyperlink="";
$sqltext="";


//For section population
//WORK TO DO
//30 May 2023 - Needs work on finding rule titles.  
foreach ($dom->find('.divRuleTextContainer2') as $outerdiv) {
    echo $outerdiv->class."\n";
    $id++;

    //echo ("Pointers \n");
    //echo ("========== \n");
    if (str_contains($outerdiv->class,"RuleLevel1")) $level1pointer=$plan.$id; 
    if (str_contains($outerdiv->class,"RuleLevel2")) $level2pointer=$plan.$id;


    foreach ($outerdiv->find(".divRuleText") as $innerdiv) {
        //$id++;

        //Pointers
        if (str_contains($outerdiv->class,"RuleLevel6")) {$pointerid=$level2pointer;}
        if (str_contains($outerdiv->class,"RuleLevel2")) {$pointerid=$level1pointer;}
        if (str_contains($outerdiv->class,"RuleLevel1")) {$pointerid="None";}
    
        echo "Pointer: ".$pointerid . "\nID:".$plan.$id."\n\n";
    
        
        //echo $innerdiv->class."\n";
        //Search for P
        //$firstp=true;
        //Make a thing to remove the annoying variation toolbar. 
        //Find text. 
        foreach ($innerdiv->find("p") as $p) {
            //echo $p->outertext."\n";  
            //echo $p->outertext . "\n";
            $html_text=$p->outertext;
            $plain_text=$p->innertext; 
            //if ($firstp) break 1; 
            
        }
        //$firstp=false;

        

        //This one gets rule titles from the rule text
        foreach ($innerdiv->find("p b") as $pb) {
            echo $pb->innertext."\n\n";
            $firstpb=true;
            //echo $td . "\n";
            if ($firstpb) break 1; 
        }
        $firstpb=false; 

        //Get definition hyperlinks
        $sqlheader="ARRAY [";
        $sqlfooter="]"; 
        $firsta=true;
        foreach ($innerdiv->find("a[class=divRuleTextDef]") as $a) {
            //echo $a."\n";
            //echo $a->innertext."\n";
            //echo $a->innerHtml;
            //echo $a . "\n";
            if (!$firsta) {
                $sqltext=$sqltext."<start>".$a->innertext."<end>";
                $temp1=$sqlheader.$sqltext.$sqlfooter."\n\n";
                $temp2=str_replace("<start>","'",$temp1);
                $temp3=str_replace("<end>","',",$temp2);
                $temp4=str_replace(",]","]",$temp3);
            }
        $firsta=false; 
        
        }
    //echo $temp4;
    $hyperlinks="";
    $hyperlink="";

    //Get crossreference hyperlinks
    //$sqlheader="ARRAY [";
    //$sqlfooter="]"; 
    //$firsta=true;
    foreach ($innerdiv->find("a[class=crossreflink]") as $a) {
        //echo $a."\n";
        //echo $a->innertext."\n";
        //echo $a->innerHtml;
        //echo $a . "\n";
        //if (!$firsta) {
        //    $sqltext=$sqltext."<start>".$a->innertext."<end>";
        //    $temp1=$sqlheader.$sqltext.$sqlfooter."\n\n";
        //    $temp2=str_replace("<start>","'",$temp1);
        //    $temp3=str_replace("<end>","',",$temp2);
        //    $temp4=str_replace(",]","]",$temp3);
        //}
    //$firsta=false; 
    
    

    }
    $temp=trim(strip_tags($html_text,"<a><b><li><ol><td><tr><tbody><table>"),"\t\n\r\0\x0B\xC2\xA0");
    $mostlyplaintext=str_replace("&nbsp;", '', $temp);

    $temp=trim(strip_tags($html_text),"\t\n\r\0\x0B\xC2\xA0");
    $plaintext=str_replace("&nbsp;", '', $temp);

    $temp=trim(strip_tags($plain_text,"<b><li><ol><td><tr><tbody><table>"),"\t\n\r\0\x0B\xC2\xA0");
    $detailsmostlyplaintext=str_replace("&nbsp;", '', $temp);
    

    //echo $titles . "\n\n"; 
    //echo $html_text . "\n\n";
    /*
    if (!pg_connection_busy($dbconn)) {
        pg_send_query($dbconn, 
        "INSERT INTO content (section_title,xml_text, mostlyplaintext,plaintext,id,parentsection_id,hyperlinks,pageid) 
        VALUES ('".$titletext."','".htmlentities($html_text)."','".htmlentities($mostlyplaintext)."','".htmlentities($plaintext)."','".$plan.$id."','".$pointerid."',".$temp4.",'".$pageid."');");
    }
    if(!($result = pg_get_result($dbconn)))
    die("pg_get_result");
    echo(pg_result_error($result) . "<br />\n");
    */
}
}


/*
//echo $e->outertext."\n";

#echo count($contents); 
#echo "\n";

//DB Connection
$dbconn = pg_connect('host=localhost port=5432 dbname=plandoo') or die("Could not connect");
//Plan constant

$id=1; 

$detailstext="None";

$first=true; 
foreach ($contents as $content)
{
	
    //Throw away first
    if($first) {
        $first = false;
        continue;
    }
    $class = $content->getAttribute('class');

	//$title = $titledom->getElementsByTag("p",0);
    

    $subcontent=$content->find(".divRuleText");
    
    
    //echo $title."\n";

    $details=$content->find(".divRuleTextMerge");
    
    //if (!empty($details->toArray())) $detailstext=$details->innerHtml;

    //TitleText
    //if (!empty($title->toArray())) $titletext=trim(strip_tags($title->innerHtml));
    
	//echo $class . "\n" . "========"."\n";
    //echo "wdc.pdp.".$id . "\n" . "========"."\n";
    //echo $titletext . "\n" . "========"."\n";

    //sort out parent and child pointers
    //When a RuleLevel1 is found - level1pointer=<id>
    //When a RuleLevel2 is found - level2pointer=<id>
    //NEED A GENERAL LEVEL SYSTEM - THIS ISNT GENERAL




	// do something with the html
	$html = $subcontent->innerHtml;
    
     
    //find hyperlinks
    //$dom2 = new Dom;
    //$dom2->loadStr($html);
    //$hyperlinks=$dom2->find('a');

    if (!empty($hyperlinks)) {

    $sqlheader="ARRAY [";
    $sqlfooter="]"; 
        foreach($hyperlinks as $hyperlink) {
     
            $sqltext=$sqltext."<start>".$hyperlink->innerHtml."<end>";
	 
    
            $temp1=$sqlheader.$sqltext.$sqlfooter."\n\n";
            $temp2=str_replace("<start>","'",$temp1);
            $temp3=str_replace("<end>","',",$temp2);
            $temp4=str_replace(",]","]",$temp3);
            #echo $temp4 ."\n";
            }
    }
    else {
        $temp4="None";
        //echo $temp4;
    }
    
    $hyperlinks="";
    $hyperlink="";

     //echo $child . "\n\n"; 
    
    
    /*** Do This 

    //Work out pointers
    

    //echo ("Pointers \n");
    //echo ("========== \n");
    if (str_contains($class,"RuleLevel6")) {$pointerid=$level2pointer;}
    if (str_contains($class,"RuleLevel2")) {$pointerid=$level1pointer;}
    if (str_contains($class,"RuleLevel1")) {$pointerid="None";}

    //echo "\n\n Pointer: ".$pointerid . "\n\n";

    //$test= "INSERT INTO content (section_title,xml_text, mostlyplaintext,plaintext,id,parentid,hyperlinks,pageid) 
    //VALUES ('".$titletext."','".$html."','".$mostlyplaintext."','".$plaintext."','".$plan.$id."','".$pointerid."','".$temp4."','".$pageid.");";
    
    //echo $temp4;
 
    /*
    if (!pg_connection_busy($dbconn)) {
        pg_send_query($dbconn, 
        "INSERT INTO content (section_title,xml_text, mostlyplaintext,plaintext,id,parentsection_id,hyperlinks,pageid) 
        VALUES ('".$titletext."','".htmlentities($html)."','".htmlentities($mostlyplaintext)."','".htmlentities($plaintext)."','".$plan.$id."','".$pointerid."',".$temp4.",'".$pageid."');");
    }
    if(!($result = pg_get_result($dbconn)))
    die("pg_get_result");
    echo(pg_result_error($result) . "<br />\n");

    //To do
    //Each chunk needs a unique ID (unique for that plan)
    //Contains a list of hyperlinks for that chunk
    //Versioning...
    //Plan object will maintain a start-end sequence of how to view the various sections. 
    

    //Interate $id counter

    $id++;
    $sqlheader="";
    $sqltext="";
    $sqlfooter="";

    /*Two dimensional array of pointers to display plan content - in plan database
    //Pop and push functions to place old versions onto pointer tree - old versions pushed back, 
    //Array is used at display time 
    //Also when editing - with a graphical node tree structure
    //Need to find compare/contrast software

    similar_text
    https://www.php.net/manual/en/function.xdiff-file-diff.php
    https://www.compose.com/articles/take-a-dip-into-postgresql-arrays/


}
*/






?>