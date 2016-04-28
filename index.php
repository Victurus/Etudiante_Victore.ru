<?php  
	setcookie('user_name', '341username143', time() + 60 * 60 * 24 * 7);
	//setcookie('user_name', 'yes', time() - 2592000);

	session_start();
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];

	include_once "my_pages/blocks/header.php";

?>

<div class= 'flex-container'>
<div class="lr_item left">
	<div class="left_header">
		<span> С кем мы работаем: </span>
	</div>	
	<?php //main_page.php
		include_once $_SERVER['DOCUMENT_ROOT']."/Globals.php";
		$new_employer = new employer();
		echo $new_employer->employers_list();
	?>
</div>

<div class="lr_item right">
	<div class="form">
	Авторизация:
		<form method='post'action= 'index.php' enctype= 'text/plain'>
			<div class="logpass">
				<div class="login">
					Логин:
					<div class="input_log">
						<input type= 'text' name= 'login' size='15' placeholder="Введите логин"> <br>
					</div>
				</div>

				<div class="pass">
					Пароль:
					<div class="input_pass">
						<input type= 'password' name= 'pass' size='15' placeholder="Введите пароль"> <br>
					</div>
				</div>
			</div>
				<input type="hidden" name="submitted" value="yes">
				<input type= 'submit' value= 'Войти' autofocus="autofocus">
				<input type= 'button' value= 'Зарегестрироваться' onclick="location.href='registration.php' ">
		</form>
	</div>
</div>
</div>

<?php
	include_once "my_pages/blocks/footer.php";
?>