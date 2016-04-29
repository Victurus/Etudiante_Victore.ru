<?php  
	if(!isset($_COOKIE['username']))
	{
		setcookie('username', '341username143', time() + 60 * 60 * 24 * 7);
	}
	elseif($_COOKIE['username'] != "341username143")
	{
		$username = $_COOKIE['username'];
		$inpt_usr_val = "value='$username'";
	}
	else
		$inpt_usr_val = '';

	//setcookie('user_name', 'yes', time() - 2592000);
	include_once "header.php";
	
	$msg = '';

	if(isset($_POST['login']))
	{
		$login = sanitizeMySQL($db->db_conn, $_POST['login']);

		if(isset($_POST['pass']))
		{
			$password = sanitizeMySQL($db->db_conn, $_POST['pass']);
			$db->make_query("SELECT * FROM users WHERE login='$login', pass='$password'");
			if($db->rows_count() == 0)
			{
				$msg = 'Такого пользователя не существует';
			}
			else
			{
				$row = $db->result->fetch_array(MYSQLI_NUM);
				session_start();
				$_SESSION['username'] = $row[1];
			}
		}
	}
	else
	{
		session_start();
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
	}
	
?>
<div class= 'flex-container'>
	<div class="lr_item left">
		<div class="left_header">
			<span> С кем мы работаем: </span>
		</div>	
		<?php //main_page.php
			$new_employer = new employer();
			echo $new_employer->employers_list();
		?>
	</div>

	<div class="lr_item right">
		<div class="form">
		Авторизация: <span id='authentication_msg'><?php echo $msg; ?>  </span>
			<form method='post'action= 'index.php' enctype= 'text/plain'>
				<div class="logpass">
					<div class="login">
						Логин:
						<div class="input_log">
							<input type= 'text' name= 'login' size='15' <?php echo $inpt_usr_val;?> placeholder="Введите логин"> <br>
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
<?php include_once "footer.php";?>