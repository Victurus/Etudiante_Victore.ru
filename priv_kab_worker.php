<?php //priv_kab_worker.php
	include_once "Globals.php";

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

	$login = '';
	$pass = '';
	$fio = '';
	$e_mail = '';
	$tel_mob = '';
	$tel_dom = '';
	$exp = '';
	$prof = '';
	$cv_path = '';
	$img_path = '';
	$born = '';
	$knarea_id = '';

	if(!isset($_POST['workt_p']) &&  !isset($_POST['knarea']))
	{

		$login = $_SESSION['username'];

		$db->make_query("SELECT * FROM users WHERE login='$login'");
		$db->result->data_seek(0);
		$row = $db->result->fetch_array(MYSQLI_NUM);

		$_SESSION['usr_id'] = $row[0];
		$usr_id = $row[0];
		$pass = $row[2];

		$db->make_query("SELECT * FROM workers WHERE usr_id=$usr_id");
		$db->result->data_seek(0);
		$row = $db->result->fetch_array(MYSQLI_NUM);

		$knarea_id = $row[10];
		$_SESSION['workt_id'] = $row[11];

		$_SESSION['fio'] = $row[1];
		$fio = $row[1];
		$e_mail = $row[2];
		$tel_mob = $row[3];
		$tel_dom = $row[4];
		$exp = $row[5];
		$prof = $row[6];
		$_SESSION['cv_path'] = $row[7];
		$_SESSION['img_path'] = $row[8];
		$born = $row[9];

		$db->make_query("SELECT * FROM knowledge_area");
		$selector  = "<div class='text'>Выберите вашу область знания:</div>";
		$selector .= " <select name='knarea' size='1' onchange='send_get(this.options[this.selectedIndex].value)'>";
		
		for($i = 0; $i < $db->rows_count(); $i++)
		{
			$db->result->data_seek($i);
			$row = $db->result->fetch_array(MYSQLI_NUM);

			if($i == $knarea_id - 1)
				$selector .= "<option selected='selected' value='$row[0]'> $row[1]</option>";
			else	
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

		$selector = "<div class='lines text'> Ваша область знания имеет номер:  $knarea_text </div>";
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
																unlink('reg/' . $_SESSION['img_path']);
																$n = "reg/users/workers/$now.$ext";

																$new_worker->set_imgpath("users/workers/$now.$ext");
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
																	unlink('reg/' . $_SESSION['cv_path']);
																	$dir = "reg/users/workers/CV/$now.$ext";
																	
																	move_uploaded_file($_FILES['curvitae']['tmp_name'], $dir);
																	$new_worker->set_docpath("users/workers/CV/$now.$ext");
																	$login_msg = $new_worker->update_worker($knarea, $workt, $_SESSION['usr_id']);
																	
																	$_SESSION['username'] = sanitizeString($_POST['login']);
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
<title>Личный кабинет соискателя</title>
<link rel="stylesheet" href="/styles/priv_cab.css">
<script src="reg/JS/functions.js"></script>
</head>
<body>
	<div class="main_reg_wrk">
		<div class="header">
			<h2><?php echo "Кабинет пользователя " . $_SESSION['fio']; ?></h2>
			<h3>Заполните пожалуйста все поля</h3>
			<h4><?php if($login_msg) echo "Операция обновления" . $login_msg; ?></h4>
		</div>

		<div class="reg-block">
			<form method="post" action="priv_kab_worker.php" enctype= 'multipart/form-data'>
			<?php 
				echo "<div class='lines' id='knarea_p'>" . $selector . "</div>";

				echo "<div class='lines' id='workt_p'>";
				if($knarea_id != '')
					if($knarea_id != 1000)
					{	
						echo "<div class='text'>Выберите ваш тип работ:</div> ";

						$db = new db_helper();
						$db->connect_db();

						$db->make_query("SELECT * FROM work_type WHERE knarea_id='$knarea_id'");

						echo "<select name='workt' size='1'>";
						echo "<option value='1000'></option>";

						$rule = 1000;
						if(isset($_SESSION['workt_id']))
						{
							$rule = $_SESSION['workt_id'];
						}

						for($i = 0; $i < $db->rows_count(); $i++)
						{
							$db->result->data_seek($i);
							$row = $db->result->fetch_array();
							if($row[0] == $rule)
								echo "<option selected='selected' value='$row[0]'> $row[1]</option>";
							else
								echo "<option value='$row[0]'> $row[1]</option>";
						}
					echo "</select>";
				}
				echo "</div>";
			?>
			<div class="lines">
			   <div class="text">Придумайте логин:<?php echo $login_msg; ?></div> <input type="text" name="login" <?php echo "value='$login'";?> size="43">
			</div>

			<div class="lines"> 
				<div class="text">Придумайте пароль:</div> <input type="text" name="pass1" <?php echo "value='$pass'";?> size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Повторите пароль:<?php echo $pass_msg; ?></div> <input type="text" name="pass2" <?php echo "value='$pass'";?> size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Ваше Фио (в именительном падеже):<?php echo $name_msg; ?></div> <input type="text" name="fio" <?php echo "value='$fio'";?> size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Введите ваш e-mail:<?php echo $e_mail_msg; ?></div> <input type="text" name="e_mail" <?php echo "value='$e_mail'";?> size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Номер сотового:<?php echo $tel_mob_msg; ?></div> <input type="text" name="tel_mob" <?php echo "value='$tel_mob'";?> size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Домашний номер:<?php echo $tel_dom_msg; ?></div> <input type="text" name="tel_dom" <?php echo "value='$tel_dom'";?> size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Опыт работы:<?php echo $experience_msg; ?></div> <input type="text" name="experience" <?php echo "value='$exp'";?> size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Наименование профессии:<?php echo $profession_msg; ?></div> <input type="text"  name="profession" <?php echo "value='$prof'";?> size="43"> 
			</div>

			<div class="lines"> 
				<div class="text">Укажите вашу дату рождения:<?php echo $year_msg . ' ' . $month_msg . ' ' . $date_msg; ?></div> 
				
				<?php
					if($fio != '')
					{
						$fulldate = substr($born, 0, 10);
						$year_ = substr($fulldate, 0, 4);
						$month = substr($fulldate, 5, 2);
						$real_date = substr($fulldate, 8 , 2);

						settype($year_, 'int');
						settype($month, 'int');
						settype($real_date, 'int');
					}
					else
						$month = 'this.options[this.selectedIndex].value';

					echo "<select name='year' size='1'>";
					for($i = 1990;$i < 2017; $i++)
						if($i == $year_)
							echo "<option selected='selected' value='$i'>$i</option>";
						else
							echo "<option value='$i'>$i</option>";
					echo "</select>";

					echo "<select name='month' size='1' onchange='set_day($month)'>";
						for($i = 1; $i < 13; $i++)
							if($i == $month)
								echo "<option selected='selected' value='$i'>$i</option>";
							else
								echo "<option value='$i'>$i</option>";
					echo "</select>";


					echo "<span id='selector_date'>";
					if($fio != '')
					{
						$count = 31;
						if ($month == 2)
							$count = 29;
						else 
							if($month == 4 || $month == 6 || $month == 9 || $month == 11)
								$count = 30;

						
						echo "<select name='date' size='1'>";
							for($i = 1; $i < $count; $i++)
								if($i == $real_date)
									echo "<option selected='selected' value='$i'>$i</option>";
								else
									echo "<option value='$i'>$i</option>";
						echo "</select>";
					}
					echo "</span>";
				?>

			</div>

			<div class="lines">
				<div class="text">Приложите ваше резюме в формате .pdf:<?php echo $doc_msg; ?></div> <input type="file" name="curvitae" > 
			</div>

			<div class="lines">
				<div class="text">Загрузите аватарку с расширением JPG, GIF, PNG или TIF:<?php echo $img_message; ?></div>
				<input type= 'file' name= 'image_avatar'>  

				<div class='button_sub'><input type= 'submit' value= 'Обновить информацию'></div>
			</div>
			</form>
			<input type="button" name="back" value="На главную" onclick="location.href='index.php'">

		</div>
	</div>
</body>
</html>