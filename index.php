<?php
	include_once "header.php";
?>
<div class= 'flex-container'>
	<div class="lr_item left">
		<div class="left_header">
			<span> С кем мы работаем: </span>
		</div>	
		<?php //main_page.php
			$new_employer = new employer();
			echo $new_employer->employers_list('');
		?>
	</div>

	<div class="lr_item right">

		<?php
			if(!isAuth())
			{
				$msg = $_SESSION['msg'];
			echo <<<_END
	<div class="form">
		Авторизация: <span id='authentication_msg'> $msg  </span>

		<form method='post' action= 'index.php'>
			<div class="logpass">

				<div class="login">
					Логин:
					<div class="input_log">
						<input type='text' name='login' size='15' placeholder="Введите логин"> <br>
					</div>
				</div>

				<div class="pass">
					Пароль:
					<div class="input_pass">
						<input type='password' name='pass' size='15' placeholder="Введите пароль"> <br>
					</div>
				</div>
			</div>
				<input type= 'submit' value= 'Войти' autofocus="autofocus">
				<input type= 'button' value= 'Зарегестрироваться' onclick="location.href='registration.php'">
		</form>
	</div>
_END;
			}
			else
			{
				if($_SESSION['who'])
				{
					$link = "<a href='priv_kab_employer.php'>Войти в личный кабинет</a>";
				}
				else
					$link = "<a href='priv_kab_worker.php'>Войти в личный кабинет</a>";

				$username = $_SESSION['username'];
				echo <<<_REG
		<div class="form">
			<form method='post' action='index.php'>
				Приветствую: $username <br>
				<input type="hidden" name="submitted" value="yes">
				<input type="submit" name="out" value="Выйти">
			</form>

			<div class='en_prkab'>
				$link
			</div>
		</div>
		
_REG;
			}

		?>


	</div>
</div>
<?php include_once "footer.php";?>