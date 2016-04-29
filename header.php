<?php 
	include_once "Globals.php";

	$db = new db_helper();
	$db->connect_db();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<link rel="stylesheet" href="/styles/menu.css">
</head>
<body>
	<div class="header">
		<div id="left">
			<img src="/images/logo.png">
		</div>

		<div id="header-text">
			<?php echo $header; ?>
		</div>

		<div id="right">
			<img src="/images/logo1.png">
		</div>
	</div>
	
	<div id="nav">
		<ul>
			<li><a href="index.php">       Главная               </a></li>
			<li><a href="for_emp.php">     Работодателю          </a></li>
			<li><a href="for_worker.php">  Соискателю            </a></li>
			<li><a href="Information.php"> Информация            </a></li>
			<li><a href="Partners.php">    С кем мы сотрудничаем </a></li>			
 			
		</ul>
	</div>