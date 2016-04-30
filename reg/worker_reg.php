<?php //worker.php
	include_once $_SERVER['DOCUMENT_ROOT'] . "/class/db_helper.php";


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Регистрация соискателя</title>
<link rel="stylesheet" href="/styles/registration.css">
</head>

<script type="text/javascript">
	function hello()
	{
		document.write("Hello world!")
	}
</script>

<body>
	<div class="main">
		<div class="header">
			<h2>Регистрация</h2>
			<h3>Заполните пожалуйста все поля</h3>
		</div>

		<div class="reg-block">
			<pre>
				<form method="post" action="worker.php">
<?php 
	echo <<<_END
Подберите вашу специальность:	  <select name='knarea' size='1' onchange="hello()">
									<option value='Горох'> Горох </option>
									<option value='Фасоль'> Фасоль </option>
									<option value='Морковь'> Морковь </option>
									<option value='Капуста'> Капуста </option>
									<option value='Брокколи'> Брокколи </option>
								  </select>
_END;

 ?>   
Придумайте логин:                 <input type="text"     name="login"   size="30">
Придумайте пароль:                <input type="password" name="pass1"   size="30">
Повторите пароль:                 <input type="password" name="pass2"   size="30">
Ваше Фио (в именительном падеже): <input type="text"     name="fio"     size="30">
Введите ваш e-mail:               <input type="text"     name="e_mail"  size="30">
Номер сотового:                   <input type="text"     name="tel_mob" size="30">
Домашний номер:                   <input type="text"     name="tel_dom" size="30">
Приложите ваше резюме:            <input type="file" name="filename"    size="30">
Загрузите аватарку с расширением JPG, GIF, PNG или TIF:
<input type= 'file' name= 'filename' size= '10'>  <input type= 'submit' value= 'Зарегестрироваться'> <?php //echo $img_message; ?>
				</form>
			</pre>
		</div>
	</div>
</body>
</html>