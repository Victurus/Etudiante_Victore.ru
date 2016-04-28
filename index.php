<?php  
	setcookie('user_name', '341username143', time() + 60 * 60 * 24 * 7);
	//setcookie('user_name', 'yes', time() - 2592000);

	
	session_start();
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];


	include_once "my_pages/blocks/header.php";
?>



	<div class= "flex-container">
		<?php 		
			include_once "my_pages/main_page.php";
		?>
	</div>

<?php 
	include_once "my_pages/blocks/footer.php";
?>