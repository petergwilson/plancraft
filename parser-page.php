<?php
/*PHP Parser - Page

To do 30 May 2023
-General tidy up
-May also need templates for different types of documents. 
To do 1 June 2023
-Won't work, build from section parser but add on the "title search" 


*/
function to_pg_array($set) {
    settype($set, 'array'); // can be called with a scalar or array
    $result = array();
    foreach ($set as $t) {
        if (is_array($t)) {
            $result[] = to_pg_array($t);
        } else {
            $t = str_replace('"', '\\"', $t); // escape double quote
            if (! is_numeric($t)) // quote only non-numeric values
                $t = '"' . $t . '"';
            $result[] = $t;
        }
    }
    return '{' . implode(",", $result) . '}'; // format
}


$arg1=$argv[1];

include_once("simplehtmldom_1_9_1/simple_html_dom.php");

//$dom = new Dom;
#$dom->loadStr($arg1);
//$dom->loadFromFile($arg1);

$dom=file_get_html($arg1);

//Parser constants
$planid="wdc.pdp";

$pageids=explode("_",$arg1);
$pageid=$pageids[1];

echo $pageid."\n"; 
$titles = array(); 


//For page population
//WORK TO DO
//30 May 2023 - 

foreach ($dom->find('.divRuleTextContainer2') as $outerdiv) {

    foreach ($outerdiv->find(".divRuleText") as $innerdiv) {

        foreach ($innerdiv->find("p") as $p) {

            if (str_contains($p->innertext,"Introduction")) {array_push($titles,"Introduction");}
            if (str_contains($p->innertext,"Objectives")) {array_push($titles,"Objectives");}
            if (str_contains($p->innertext,"Policies")) {array_push($titles,"Policies");}
            if (str_contains($p->innertext,"Activity Rules")) {array_push($titles,"Activity Rules");}
            if (str_contains($p->innertext,"Built Form Standards")) {array_push($titles,"Built Form Standards");}
            if (str_contains($p->innertext,"Activity Standards")) {array_push($titles,"Activity Standards");}
            if (str_contains($p->innertext,"Matters of Discretion")) {array_push($titles,"Matters of Discretion");}
            if (str_contains($p->innertext,"Schedules")) {array_push($titles,"Schedules");}
            
        }
    /* 
    $temp=trim(strip_tags($html_text,"<a><b><li><ol><td><tr><tbody><table>"),"\t\n\r\0\x0B\xC2\xA0");
    $mostlyplaintext=str_replace("&nbsp;", '', $temp);

    $temp=trim(strip_tags($html_text),"\t\n\r\0\x0B\xC2\xA0");
    $plaintext=str_replace("&nbsp;", '', $temp);

    $temp=trim(strip_tags($plain_text,"<b><li><ol><td><tr><tbody><table>"),"\t\n\r\0\x0B\xC2\xA0");
    $detailsmostlyplaintext=str_replace("&nbsp;", '', $temp);
    */

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

foreach ($titles as $title) {
 //echo $title . "\n";
    
}

//Get entire HTML rules container #__isoplan_rules_container
//May actually need to build up from sections - back to section parser. 
$html="";
foreach ($dom->find('#__isoplan_rules_container') as $item) {
    $html=$item->outertext;    
}
//echo $html;


$pgtitles=to_pg_array($titles);

//echo $pgtitles; 

//Insert into database
$sql="INSERT INTO pages (pageno,planid,titles,content) 
    VALUES ('".$pageid."','".$planid."','".$pgtitles."','".htmlentities($html)."')";

//echo $sql."\n"; 

$dbconn = pg_connect('host=localhost port=5432 dbname=plandoo') or die("Could not connect");


if (!pg_connection_busy($dbconn)) {
    pg_send_query($dbconn, $sql);
}

if(!($result = pg_get_result($dbconn)))
die("pg_get_result");
echo(pg_result_error($result) . "<br />\n");

