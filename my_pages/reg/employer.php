<?php //employer.php
	$kernel_path = $_SERVER['DOCUMENT_ROOT'];
	include_once $kernel_path . "/class/db_helper.php";

	$img_message = '';
	$org_name_msg = '';
	$pass_msg = '';
	$e_mail_msg = '';
	$tel_msg = '';

	if(isset($_POST['org_name']))
	{
		$org_name = sanitizeString($_POST['org_name']);

		if(isset($_POST['pass1']) && isset($_POST['pass2']))
		{
			$pass1 = sanitizeString($_POST['pass1']);
			$pass2 = sanitizeString($_POST['pass2']);

			if($pass1 == $pass2)
			{
				if($_POST['e_mail'])
				{
					$e_mail = sanitizeString($_POST['e_mail']);

					if($_POST['tel'])
					{
						$tel = sanitizeString($_POST['tel']);

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
								move_uploaded_file($_FILES['filename']['tmp_name'], $n);
								$img_message = "Загружено изображение '$name':<br>";
								$img_message .= "<img src= \"$n\" >";

								$db = new db_helper("academycadres");
								$db->connect_db();

								$db->make_query("INSERT INTO employers VALUES ('NULL' , '$org_name' , '$pass1' , '$n' , '$tel' , '$e_mail')");
								//$db->result->close();
								//$db->db_conn->close();
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
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Регистрация работодателя</title>
</head>
<body>
	<div class="header">
		<h2>Регистрация</h2>
		<h3>Заполните пожалуйста все поля</h3>
	</div>
	<div class="main">
	<pre>
<form action="employer.php" method="post" enctype= 'multipart/form-data'>
Название вашей организации       <input type="text"     name="org_name" size="20"> <?php echo $org_name_msg; ?>     
Придумайте пароль                <input type="password" name="pass1"    size="20">
Повторите пароль                 <input type="password" name="pass2"    size="20"> <?php echo $pass_msg; ?>  
Введите e_mail                   <input type="text"     name="e_mail"   size="20"> <?php echo $e_mail_msg;?>  
Введите основной телефон         <input type="text"     name="tel"      size="20"> <?php echo $tel_msg;?>  
Выберите файл с расширением JPG, GIF, PNG или TIF:
<input type= 'file' name= 'filename' size= '10'>  <input type= 'submit' value= 'Загрузить'> <?php echo $img_message; ?>
</form>
	</pre>
	</div>
</body>
</html>