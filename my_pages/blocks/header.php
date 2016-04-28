<?php include_once "Globals.php";?>
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
			<li><a href="/my_pages/main_page.php"> Главная               </a></li>
			<li><a href="#"> Работодателю          </a></li>
			<li><a href="#"> Соискателю            </a></li>
			<li><a href="#"> Информация            </a></li>
			<li><a href="#"> С кем мы сотрудничаем </a></li>			
 			
		</ul>
	</div>