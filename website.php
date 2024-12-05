<html>
<head>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
	<title>Plandoo</title>
	<style>
		body {
			margin: 0;
			padding: 0;
			font-family: Arial, sans-serif;
		}
		.topnav {
			position: fixed;
			top: 0;
			left: 0px;
			width: 100%;
			height: 80px;
			background-color: white;
			color: #fff;
			padding: 20px;
			box-sizing: border-box;
			overflow: none;

		}

		#toolbar {
			top: 80px;
			left: 210px;
			width: 100%;
			height: 50px;
			display: block;  
			background-color: white;

		}

        div .ham {
 		width: 35px;
  		height: 5px;
  		background-color: black;
  		margin: 6px 0;
		}

		.topnav a {
		float: left;
		color: blue;
		text-align: center;
		padding: 14px 16px;
		text-decoration: none;
		font-size: 17px;
		}

		/* Change the color of links on hover */
		.topnav a:hover {
		background-color: #ddd;
		color: black;
		}

		/* Add a color to the active/current link */
		.topnav a.active {
		background-color: #04AA6D;
		color: white;
		}

		.topnav p {
			color: black;
		}

		nav {
			position: fixed;
			top: 80px;
			left: 0;
			width: 200px;
			height: 100%;
			background-color: #333;
			color: #fff;
			padding: 20px;
			box-sizing: border-box;
			overflow: scroll;
		}
		nav ul {
			list-style: none;
			padding: 0;
			margin: 0;
		}
		nav ul li {
			margin-bottom: 10px;
		}
		nav ul li a {
			color: #fff;
			text-decoration: none;
			display: block;
			padding: 10px;
			border-radius: 5px;
			transition: background-color 0.3s ease;
		}
		nav ul li a:hover {
			background-color: #555;
		}
		nav ul li.active > a {
			background-color: #555;
		}
		.content {
			margin-top: 60px; 
			margin-left: 200px;
			padding: 20px;
			box-sizing: border-box;
		}
		.content h1 {
			margin-top: 0;
		}
		.content p {
			margin-bottom: 20px;
		}
	</style>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<script src="jquery.inline-edit.js"></script>
   

	<script>
		

		function showContent(content) {
			document.getElementById('contentbox').innerHTML = content;
			

		}
		
	</script>
	<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

	<script> 
	

	function editContent(content) {
		

		var toolbarOptions = [
		['bold', 'italic', 'underline', 'strike'],        // toggled buttons
		['blockquote', 'code-block'],

		[{ 'header': 1 }, { 'header': 2 }],               // custom button values
		[{ 'list': 'ordered'}, { 'list': 'bullet' }],
		[{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
		[{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
		[{ 'direction': 'rtl' }],                         // text direction

		[{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
		[{ 'header': [1, 2, 3, 4, 5, 6, false] }],

		[{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
		[{ 'font': [] }],
		[{ 'align': [] }],

		['clean']                                         // remove formatting button
		];

		
		var quill = new Quill('#contentbox', {
			modules: {
					'toolbar': toolbarOptions
				},	
				theme: 'snow'
			});

		//document.getElementById('toolbar').style.display='block';
		
	}
	</script>
	
</head>



<body>
	
	<nav>
		<ul>

<?php

// Create connection


$dbconn = pg_connect("host=localhost port=5432 dbname=plandoo");
if (!$dbconn) {
	echo "An error occurred.\n";
	exit;
  }

// SQL query to retrieve navigation data

$sql = "SELECT array_to_string(titles,',') as str_titles, content FROM pages";

if (!pg_connection_busy($dbconn)) {
	$result=pg_query($dbconn, $sql);
}

if (!$result) {
	echo "Failed to execute query";
	exit;
}
  // output data of each row
  while($row = pg_fetch_assoc($result)) {
	//$str= $row['section_title'];
	$str=$row['str_titles'];
	$titles=explode(",",$str);
	
	foreach($titles as $title) {
		//echo $title; 
    ?>
	
	<li><a href="#" onclick="showContent(<?php echo $row['content'] ?>)"> <?php echo $title ?> </a></li><br>

<?php     
  }
}
  
pg_close($dbconn);

?>
			
		</ul>
	</nav>
		
	    <div class="topnav">
	
  		<a class="active" onclick="showContent('search.html or php include')"href="#home">Home</a>
		<a href="#overview" href="#overview">Overview</a>
  		<a href="#news">News and Updates</a>
  		<a href="#search">Search for a property</a>
  		<a href="#about">About District Plan</a>
		<a href="#edit" onclick="editContent()">Edit Content</a>
		<p align="right"> Council Logo goes here </p>
	</div>
	<div id="toolbar"><p>Test<p></div>
	<div id="contentbox" class="content">
		<h1>Content Title</h1>
		
	</div>
	<div id="editor">
  	<p>Hello World!</p>
  	<p>Some initial <strong>bold</strong> text</p>
  	<p><br></p>


</div>
</body>
</html>




