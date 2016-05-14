<!-- priv_kab_employer.php -->

<?php //employer.php
	include_once "Globals.php";

	$db = new db_helper();
	$db->connect_db();

	session_start();

	$log_msg = '';
	$login_msg = '';
	$img_message = '';
	$org_name_msg = '';
	$pass_msg = '';
	$e_mail_msg = '';
	$tel_msg = '';

	$login = '';
	$pass = '';
	$org_name = '';
	$tel_org = '';
	$e_mail = '';

	$new_emp = new employer();

	if(!isset($_POST['sumb']))
	{
		$login = $_SESSION['username'];

		$db->make_query("SELECT * FROM users WHERE login='$login'");
		$db->result->data_seek(0);
		$row = $db->result->fetch_array(MYSQLI_NUM);

		$_SESSION['usr_id'] = $row[0];
		$usr_id = $row[0];
		$pass = $row[2];

		$db->make_query("SELECT * FROM employers WHERE usr_id='$usr_id'");
		$db->result->data_seek(0);
		$row = $db->result->fetch_array(MYSQLI_NUM);

		$_SESSION['emp_id'] = $row[0];
		$_SESSION['org_name'] = $row[1];
		$org_name = $row[1];
		$_SESSION['logo_path'] = $row[2];
		$tel_org = $row[3];
		$e_mail = $row[4];
	}

	if(isset($_POST['login']) &&  $_POST['login'] != '' && isset($_POST['sumb']) && $_POST['sumb'] == "profile")
	{
		$new_emp->set_login( sanitizeString($_POST['login']));
		if(isset($_POST['org_name']) && $_POST['org_name'] != '')
		{
			$new_emp->set_name( sanitizeString($_POST['org_name']));

			if(isset($_POST['pass1']) && isset($_POST['pass2']) && $_POST['pass1'] != ''  && $_POST['pass2'] != '')
			{
				$pass1 = sanitizeString($_POST['pass1']);
				$pass2 = sanitizeString($_POST['pass2']);

				if($pass1 == $pass2)
				{
					$new_emp->set_password($pass1);

					if(isset($_POST['e_mail']) && $_POST['e_mail'] != '')
					{
						$new_emp->set_email( sanitizeString($_POST['e_mail']));

						if(isset($_POST['tel']) && $_POST['tel'] != '')
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
									unlink("reg/" . $_SESSION['logo_path']);
									$n = "reg/users/employers/$now.$ext";
									$new_emp->set_path("users/employers/$now.$ext");
									move_uploaded_file($_FILES['filename']['tmp_name'], $n);
									$img_message = "Вот ваша аватарка '$name':<br>";
									$img_message .= "<img src= '$n' width='auto' height='200'>";

									$log_msg = $new_emp->update_employer($_SESSION['usr_id']);						
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
<title>Личный кабинет работодателя</title>
<link rel="stylesheet" href="/styles/priv_cab.css">
<script src="reg/JS/functions.js"></script>
</head>
<body>
	<div class="main">
	<div class="main_reg">
		<div class="header">
			<h2><?php echo "Кабинет пользователя " . $_SESSION['org_name']; ?></h2>
			<h3>Заполните пожалуйста все поля</h3>
			<h4><?php if($log_msg) echo "Операция обновления" . $log_msg; ?></h4>
		</div>	
		<div class="reg-block">
			<form action="priv_kab_employer.php" method="post" enctype= 'multipart/form-data'>
				<input type="hidden" name='sumb' value='profile'>
				<div class="lines">
					<div class="text">Придумайте логин</div> <input type="text" name="login" <?php echo "value='$login'";?> size="40"> <?php  echo $login_msg; ?>  
				</div>
				<div class="lines">
					<div class="text">Придумайте пароль</div> <input type="text" name="pass1" <?php echo "value='$pass'";?> size="40">
				</div>
				<div class="lines">
					<div class="text">Повторите пароль</div> <input type="text" name="pass2" <?php echo "value='$pass'";?> size="40"> <?php echo $pass_msg;     ?>  
				</div>
				<div class="lines">
					<div class="text">Название вашей организации</div> <input type="text" name="org_name" <?php echo "value='$org_name'";?> size="40"> <?php echo $org_name_msg; ?>     
				</div>
				<div class="lines">
					<div class="text">Введите e_mail</div> <input type="text" name="e_mail" <?php echo "value='$e_mail'";?> size="40"> <?php echo $e_mail_msg;   ?>  
				</div>
				<div class="lines">
					<div class="text">Введите основной телефон</div> <input type="text" name="tel" <?php echo "value='$tel_org'";?> size="40"> <?php echo $tel_msg;      ?>  
				</div>
				<div class="lines">
					<div class="text">Загрузите аватарку с расширением JPG, GIF, PNG или TIF:</div> <input type= 'file' name= 'filename' size= '40'> 
				</div> 
				<span class="button_sub">
					<input type= 'submit' value= 'Обновить инфрмацию'> <?php echo $img_message; ?>
				</span>
			
			</form>
			<input type="button" name="back" value="На главную" onclick="location.href='index.php'">
		</div>


	</div>

			<div class="vac_editor">
		<?php

		$db = new db_helper();
		$db->connect_db();
/////////////....Удаление элемента..............///////////////
	if (isset($_POST['delete']) && isset($_POST['vac_id']))
	{
		$vac_id = get_post($db->db_conn, 'vac_id');
		$db->make_query("DELETE FROM vacancy WHERE vac_id='$vac_id'");
	}

	// if(isset($_POST['knarea']) && isset($_POST['workt']))

///////.........Добавление элемента..............////////////////
	if (isset($_POST['knarea'])     && isset($_POST['workt'])  &&
		isset($_POST['name'])       && isset($_POST['salary']) &&
		isset($_POST['occupation']) && isset($_POST['description']))
	{
		$name = get_post($db->db_conn, 'name');
		$salary = get_post($db->db_conn, 'salary');
		$occupation = get_post($db->db_conn, 'occupation');
		$description = get_post($db->db_conn, 'description');
		$knarea_id = get_post($db->db_conn, 'knarea');
		$workt_id = get_post($db->db_conn, 'workt');
		$emp_id = $_SESSION['emp_id'];

		$db->make_query("INSERT INTO vacancy VALUES ('NULL' , '$knarea_id' , '$workt_id', '$emp_id', '$name', '$description', '$salary', '$occupation')");
	}

//////////////////////////////////////////////////////////////////////////
	
	$db->make_query("SELECT * FROM knowledge_area");
	$selector  = "<div class='text'>Выберите вашу область знания:</div>";
	$selector .= "<select name='knarea' size='1' onchange='send_get(this.options[this.selectedIndex].value)'>";
	$selector .= "<option value='1000'></option>";
	
	for($i = 0; $i < $db->rows_count(); $i++)
	{
		$db->result->data_seek($i);
		$row = $db->result->fetch_array(MYSQLI_NUM);

		$selector .= "<option value='$row[0]'> $row[1]</option>";
	}

	$selector .= "</select>";

	echo "<div class='add_class'> <form action='priv_kab_employer.php' method='post'>";
	echo $selector;
	echo "<div class='lines' id='workt_p'></div>";

	echo <<<_END
<div class='lines_ed'>
	<div class='text_ed'> Название должности </div> <input type="text" name="name" size="47">
</div>
<div class='lines_ed'>
	<div class='text_ed'> Заработная плата </div>  <input type="text" name='salary' size='47'>
</div>
<div class='lines_ed'>
	<div class='text_ed'> Занятость  </div>        <input type="text" name='occupation' size='47'>
</div>
<div class='text_ed'>
	<div class='text_ed'> Описание </div>
	<textarea  name='description' rows='5' cols='66'></textarea>
</div>

<div class="btn">
<input type="submit" value="ADD RECORD">
</div>
</form>
	</div>
_END;
	
	$employer_ID = $_SESSION['emp_id'];
	$db->make_query("SELECT * FROM vacancy WHERE employer_id='$employer_ID'");
	
	$rows = $db->rows_count();

	echo "<div class='vac_block'>";

	for($j = 0; $j < $rows; $j++)
	{
		$db->result->data_seek($j);
		$row = $db->result->fetch_array(MYSQLI_NUM);

		echo<<<_END
<div>
		<pre>
Название должности $row[4]
Заработная плата   $row[6]
Занятость          $row[7]
Описание           
<textarea readonly name='description'   cols='45'>$row[5]</textarea>
		</pre>
		<form action="priv_kab_employer.php" method="post">
		<input type="hidden" name="delete" value="yes">
		<input type="hidden" name="vac_id" value="$row[0]">
		<input type="submit" value="DELETE RECORD">
		</form>
</div>
_END;
	}

	echo "</div>";

	$db->db_close();
?>	
		</div>
	</div>
</body>
</html>