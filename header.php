<?php
	session_start();
	include_once "Globals.php";

	$db = new db_helper();
	$db->connect_db();

	if(isset($_POST['submitted']))
	{
		out();
	}

	if(!isAuth())
	{
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];

		$_SESSION['msg'] = 'не пройдена';
		$_SESSION['up_msg'] = "Пройдите регистрацию в форме на главной";	

		if(isset($_POST['login']))
		{			
			$login = sanitizeMySQL($db->db_conn, $_POST['login']);

			if(isset($_POST['pass']))
			{
				if(!isset($_SESSION['username']))
				{
					$_SESSION = array();
				}

				$password = sanitizeMySQL($db->db_conn, $_POST['pass']);
				$db->make_query("SELECT * FROM users WHERE login='$login' AND pass='$password'");
				if($db->rows_count() == 0)
				{
					$_SESSION['msg'] = 'Неправильно введён логин-пароль';
				}
				else
				{
					$row = $db->result->fetch_array(MYSQLI_NUM);
					$_SESSION['id'] = $row[0];
					$_SESSION['username'] = $row[1];
					$_SESSION['who'] = $row[3];
					$_SESSION['msg'] = "пройдена";
					$_SESSION['up_msg'] = "Вы зашли под именем  " . $_SESSION['username']; 
				}
			}
		}
	}
	else
	{
		$_SESSION['up_msg'] = "Вы зашли под именем  " . $_SESSION['username']; 
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<link rel="stylesheet" href="/styles/menu.css">
<link rel="stylesheet" href="/styles/femployer.css">
<link rel="stylesheet" href="/styles/fworker.css">
<link rel="stylesheet" href="/styles/otclick.css">
</head>
<body>
	<div class="header">
		<div id="left">
			<img src="/images/logo.png">
		</div>

		<div id="header-text">
			<?php echo $header; ?>
			
		</div>

		<div id="right">
			<img src="/images/logo1.png">
		</div>
	</div>
	
	<div id="nav">
		<ul>
			<li><a href="index.php">       Главная               </a></li>
			<li><a href="for_emp.php">     Работодателю          </a></li>
			<li><a href="for_worker.php">  Соискателю            </a></li>
			<li><a href="Information.php"> Информация            </a></li>
			<?php 
				if(isset($_SESSION['username']))
				echo "<li><a href='otclick.php'> Кто откликнулся</a></li>"; 
			?>		
			
				<div class="user_name">
					<?php 
						echo $_SESSION['up_msg'];	
					?>
				</div>	
			
		</ul>
	</div>