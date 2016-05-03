<?php //worker.php
	include_once $_SERVER['DOCUMENT_ROOT'] . "/Globals.php";

	$db = new db_helper();
	$db->connect_db();

	session_start();

	$login_msg = '';
	$pass_msg = '';
	$name_msg = '';
	$e_mail_msg = '';
	$tel_mob_msg = '';
	$tel_dom_msg = '';
	$experience_msg = '';
	$profession_msg = '';
	$year_msg = '';
	$month_msg = '';
	$date_msg = '';
	$img_message = '';
	$doc_msg = '';


	if(!isset($_POST['workt']) &&  !isset($_POST['knarea']))
	{
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
		$db->db_close();
	}
	else 
	{
		$workt = sanitizeString($_POST['workt']);
		$knarea = sanitizeString($_POST['knarea']);

		$db->make_query("SELECT * FROM knowledge_area WHERE knarea_id='$knarea'");
		$db->result->data_seek(0);
		$row = $db->result->fetch_array(MYSQLI_NUM);
		$knarea_text = $row[1];

		$db->make_query("SELECT * FROM work_type WHERE workt_id='$workt'");
		$db->result->data_seek(0);
		$row = $db->result->fetch_array(MYSQLI_NUM);
		$workt_text = $row[1];

		$db->db_close();

		$selector = "<div class='lines text'> Ваша область знания:  $knarea_text </div>";
		$selector .= "<div class='lines text'>Ваш тип работ:                    $workt_text  </div> ";

		$new_worker = new worker();

		if(isset($_POST['login']) &&  $_POST['login'] != '')
		{
			$new_worker->set_login( sanitizeString($_POST['login']));

			if(isset($_POST['pass1']) && isset($_POST['pass2']) && $_POST['pass1'] != '' && $_POST['pass2'] != '')
			{
				$pass1 = sanitizeString($_POST['pass1']);
				$pass2 = sanitizeString($_POST['pass2']);

				if($pass1 == $pass2)
				{
					$new_worker->set_password($pass1);

					if(isset($_POST['fio']) && $_POST['fio'] != '')
					{
						$new_worker->set_name($_POST['fio']);

						if(isset($_POST['e_mail']) && $_POST['e_mail'] != '')
						{
							$new_worker->set_email( sanitizeString($_POST['e_mail']));

							if(isset($_POST['tel_mob']) && $_POST['tel_mob'] != '')
							{
								$new_worker->set_telmob( sanitizeString($_POST['tel_mob']));

								if(isset($_POST['tel_dom']) && $_POST['tel_dom'] != '')
								{
									$new_worker->set_teldom( sanitizeString($_POST['tel_dom']));

									if(isset($_POST['experience']) && $_POST['experience'] != '')
									{
										$new_worker->set_experience( sanitizeString($_POST['experience']));

										if (isset($_POST['profession']) && $_POST['profession'] != '')
										{
											$new_worker->set_profession( sanitizeString($_POST['profession']));

											if(isset($_POST['year']) && $_POST['year'] != '')
											{
												$new_worker->set_year( sanitizeString($_POST['year']));
											
												if(isset($_POST['month']) && $_POST['month'] != '')
												{
													$new_worker->set_month( sanitizeString($_POST['month']));
													
													if(isset($_POST['date']) && $_POST['date'] != '')
													{
														$new_worker->set_date( sanitizeString($_POST['date']));
														
														if($_FILES)
														{
															$name = $_FILES['image_avatar']['name'];
															
															switch($_FILES['image_avatar']['type'])
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
																$n = "users/workers/$now.$ext";
																$new_worker->set_imgpath($n);
																move_uploaded_file($_FILES['image_avatar']['tmp_name'], $n);
																$img_message = "Вот ваша аватарка '$name':<br>";
																$img_message .= "<img src= '$n' >";

																$doc_name = $_FILES['curvitae']['name'];

																switch($_FILES['curvitae']['type'])
																{
																	case 'application/pdf':   
																		$ext = 'pdf'; 
																		break;
																	default:
																		$ext = '';    
																		break;
																}

																if($ext)
																{
																	$now = time();
																	$dir = "users/workers/CV/$now.$ext";
																	$new_worker->set_docpath($dir);
																	move_uploaded_file($_FILES['curvitae']['tmp_name'], $dir);

																	$login_msg = $new_worker->save_worker($knarea, $workt);
																	// session_start();
																	$_SESSION['username'] = sanitizeString($_POST['login']);
																	$_SESSION['who'] = 0;
																}		
																else
																{
																	$doc_msg = "'$doc_name' - неприемлимый файл документа ";
																}												
															}
															else
																$img_message = "'$name' - неприемлимый файл изображения";
														}
														else
															$img_message = "Загрузки изображения не произошло";
													}
													else
													{
														$date_msg = "День не установлен";
													}
												}
												else
												{
													$month_msg = 'месяц не указан';
												}
											}
											else
											{
												$year_msg = 'год не указан';
											}
										}
										else
										{
											$profession_msg = 'ваша профессия не указана';
										}
									}
									else
									{
										$experience_msg = 'укажите вашь опыт работы';
									}
								}
								else
								{
									$tel_dom_msg = 'домашний номер не введён';
								}
							}
							else
							{
								$tel_mob_msg = "Вы не указали телефон вашей организации";
							}
						}
						else
						{
							$e_mail_msg = "e_mail не ввели!";	
						}
					}
					else
					{
						$name_msg = 'Имя не введено';
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
			$login_msg = "Вы не ввели логин";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Регистрация соискателя</title>
<link rel="stylesheet" href="/styles/registration.css">
<script src="JS/functions.js"></script>
</head>
<body>
	<div class="main">
		<div class="header">
			<h2>Регистрация</h2>
			<h3>Заполните пожалуйста все поля</h3>
			<h4><?php if($login_msg) echo "Регистрация" . $login_msg; ?></h4>
		</div>

		<div class="reg-block">
			<form method="post" action="worker_reg.php" enctype= 'multipart/form-data'>
			<?php 
				echo "<div class='lines' id='knarea_p'>" . $selector . "</div>";

				echo "<div class='lines' id='workt_p'></div>";
			?>
			<div class="lines">
			   <div class="text">Придумайте логин:</div> <input type="text" name="login" size="43">
			</div>

			<div class="lines"> 
				<div class="text">Придумайте пароль:</div> <input type="password" name="pass1" size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Повторите пароль:<?php echo $pass_msg; ?></div> <input type="password" name="pass2" size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Ваше Фио (в именительном падеже):<?php echo $name_msg; ?></div> <input type="text" name="fio" size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Введите ваш e-mail:<?php echo $e_mail_msg; ?></div> <input type="text" name="e_mail" size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Номер сотового:<?php echo $tel_mob_msg; ?></div> <input type="text" name="tel_mob" size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Домашний номер:<?php echo $tel_dom_msg; ?></div> <input type="text" name="tel_dom" size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Опыт работы:<?php echo $experience_msg; ?></div> <input type="text" name="experience" size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Наименование профессии:<?php echo $profession_msg; ?></div> <input type="text" name="profession" size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Укажите вашу дату рождения:<?php echo $year_msg . ' ' . $month_msg . ' ' . $date_msg; ?></div> 
				
				<?php
					echo "<select name='year' size='1'>";
					echo "<option value='0'></option>";
					for($i = 1990;$i < 2017; $i++ )
						echo "<option value='$i'>$i</option>";
					echo "</select>";
	
	
					echo "<select name='month' size='1' onchange='set_day(this.options[this.selectedIndex].value)'>";
					echo "<option value='0'></option>";
						for($i = 1; $i < 13; $i++)
							echo "<option value='$i'>$i</option>";
					echo "</select>";
					echo "<span id='selector_date'> </span>";

				?>

			</div>

			<div class="lines">
				<div class="text">Приложите ваше резюме в формате .pdf:<?php echo $doc_msg; ?></div> <input type="file" name="curvitae" > 
			</div>

			<div class="lines">
				<div class="text">Загрузите аватарку с расширением JPG, GIF, PNG или TIF:<?php echo $img_message; ?></div>
				<input type= 'file' name= 'image_avatar' >  

				<input type= 'submit' value= 'Зарегестрироваться'>
			</div>
			</form>
			<input type="button" name="back" value="На главную" onclick="location.href='../index.php'">
		</div>
	</div>
</body>
</html>