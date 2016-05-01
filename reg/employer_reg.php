<?php //employer.php
	include_once $_SERVER['DOCUMENT_ROOT'] . "/Globals.php";

	$login_msg = '';
	$img_message = '';
	$org_name_msg = '';
	$pass_msg = '';
	$e_mail_msg = '';
	$tel_msg = '';

	//$db = new db_helper();
	//$db->connect_db();

	$new_emp = new employer();

	if(isset($_POST['login']))
	{
		$new_emp->set_login( sanitizeString($_POST['login']));
		if(isset($_POST['org_name']))
		{
			$new_emp->set_name( sanitizeString($_POST['org_name']));

			if(isset($_POST['pass1']) && isset($_POST['pass2']))
			{
				$pass1 = sanitizeString($_POST['pass1']);
				$pass2 = sanitizeString($_POST['pass2']);

				if($pass1 == $pass2)
				{
					$new_emp->set_password($pass1);

					if(isset($_POST['e_mail']))
					{
						$new_emp->set_email( sanitizeString($_POST['e_mail']));

						if(isset($_POST['tel']))
						{
							$new_emp->set_teldom( sanitizeString($_POST['tel']));

							if($_FILES)
							{
								$name = $_FILES['filename']['name'];

								switch($_FILES['filename']['type'])
								{
									case 'image/pjpeg':
									case 'image/jpeg': $ext = 'jpg'; break;
									case 'image/gif':  $ext = 'gif'; break;
									case 'image/png':  $ext = 'png'; break;
									case 'image/tiff': $ext = 'tif'; break;
									default:           $ext = '';    break;
								}

								if($ext)
								{
									$now = time();
									$n = "users/employers/$now.$ext";
									$new_emp->set_path($n);
									move_uploaded_file($_FILES['filename']['tmp_name'], $n);
									$img_message = "Вот ваша аватарка '$name':<br>";
									$img_message .= "<img src= '$n' >";

									$login_msg = $new_emp->save_employer();
									
								}
								else
									$img_message = "'$name' - неприемлимый файл изображения";
							}
							else
								$img_message = "Загрузки изображения не произошло";
						}
						else
						{
							$tel_msg = "Вы не указали телефон вашей организации";
						}
					}
					else
					{
						$e_mail_msg = "e_mail не ввели!";	
					}
				}
				else
				{
					$pass_msg = "Праоли не совпадают! Проверьте правильность ввода!";
				}
			}
			else
			{
				$pass_msg = "Пароли не ввели!";
			}
		}
		else
		{
			$org_name_msg = "Название компании/фирмы не ввели!";
		}
	}
	else
	{
		$login_msg = "Вы не ввели логин";
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Регистрация работодателя</title>
<link rel="stylesheet" href="/styles/registration.css">
</head>
<body>
	<div class="main">
		<div class="header">
			<h2>Регистрация</h2>
			<h3>Заполните пожалуйста все поля</h3>
		</div>
		
		<div class="reg-block">
			<pre>
				<form action="employer_reg.php" method="post" enctype= 'multipart/form-data'>
Придумайте логин                 <input type="text"     name="login"    size="20"> <?php echo $login_msg;    ?>  
Придумайте пароль                <input type="password" name="pass1"    size="20">
Повторите пароль                 <input type="password" name="pass2"    size="20"> <?php echo $pass_msg;     ?>  
Название вашей организации       <input type="text"     name="org_name" size="20"> <?php echo $org_name_msg; ?>     
Введите e_mail                   <input type="text"     name="e_mail"   size="20"> <?php echo $e_mail_msg;   ?>  
Введите основной телефон         <input type="text"     name="tel"      size="20"> <?php echo $tel_msg;      ?>  
Загрузите аватарку с расширением JPG, GIF, PNG или TIF:
<input type= 'file' name= 'filename' size= '10'>  <input type= 'submit' value= 'Загрегестрироваться'> <?php echo $img_message; ?>
				</form>
			</pre>
		</div>
	</div>
</body>
</html>