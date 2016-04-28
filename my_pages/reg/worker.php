<?php //worker.php
	include_once $_SERVER['DOCUMENT_ROOT'] . "/class/db_helper.php";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Регистрация соискателя</title>
</head>
<body>
	<div class="main">
		<form method="post" action="worker.php">
			<pre>
				*Ваше Фио (в именительном падеже): <input type="text" name="fio">
				*Придумайте пароль:                <input typy="password" name="pass1">
				*Повторите пароль:                 <input typy="password" name="pass2">
				*Введите ваш e-mail:               <input type="text" name="e_mail">
				*Номер сотового:                   <input type="text" name="tel_mob">
				 Домашний номер:                   <input type="text" name="tel_dob">
				*Подберите вашу специальность:     
				*Приложите ваше резюме:
			</pre>
		</form>
	</div>
</body>
</html>