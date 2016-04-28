<?php  
	   include_once "getContent.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<link rel="stylesheet" href="styles/menu.css">
<script src="jquery-1.12.3.js"></script>
</head>
<body>
	<div class="header">
		<div id="left">
			<img src="images/logo.png">
		</div>

		<div id="header-text">
			<?php echo $header; ?>
		</div>

		<div id="right">
			<img src="images/logo1.png">
		</div>	
	</div>
	
	<div id="nav">
		<ul>
			<li><a class="menu_btn"  nav_choose="Home"        href="#">  Главная               </a></li>
			<li><a class="menu_btn1" nav_choose="for_emp"     href="#"> Работодателю          </a></li>
			<li><a class="menu_btn2" nav_choose="for_worker"  href="#"> Соискателю            </a></li>
			<li><a class="menu_btn3" nav_choose="Information" href="#"> Информация            </a></li>
			<li><a class="menu_btn4" nav_choose="Partners"    href="#"> С кем мы сотрудничаем </a></li>			
 			<script type="text/javascript">
				$('.menu_btn').click(function()
				{
					$.post("getContent.php",{navchoose: "Home"}, parse);
					function parse(data)
					{
						$('.flex-container').html(data);
					}
				});      	
				$('.menu_btn1').click(function()
				{
					$.post("getContent.php",{navchoose: "for_emp"}, parse);
					function parse(data)
					{
						$('.flex-container').html(data);
					}
				});
				$('.menu_btn2').click(function()
				{
					$.post("getContent.php",{navchoose: "for_worker"}, parse);
					function parse(data)
					{
						$('.flex-container').html(data);
					}
				});
				$('.menu_btn3').click(function()
				{
					$.post("getContent.php",{navchoose: "Information"}, parse);
					function parse(data)
					{
						$('.flex-container').html(data);
					}
				});
				$('.menu_btn4').click(function()
				{
					$.post("getContent.php",{navchoose: "Partners"}, parse);
					function parse(data)
					{
						$('.flex-container').html(data);
					}
				});
			</script>
		</ul>
	</div>

	<div class= "flex-container">
		<?php 		
			include_once "my_pages/main_page.php";
		?>
	</div>

	<div class="footer">
		<?php
			echo $footer . " ";
			// date($format, $timestamp);
			echo "Today is " . date("l F jS, Y - G:i:s", time());
			#string date ( string $format [, int $timestamp = time() ] )
		?>
	</div>
</body>
</html>