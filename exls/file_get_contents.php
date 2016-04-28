<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Название сайта</title>
<link rel="stylesheet" href="styles/menu.css">
</head>
<body>
	<?php //file_get_contents.php
		$flag = false;
		if($flag)
		{
			echo "<pre>";
			echo file_get_contents("testfile.txt");
			echo "</pre>";
		}
		else
			echo file_get_contents("http://oreilly.com");
	?>    
</body>
</html>
