<!-- linktest.php -->

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Тестирование ссылки</title>
</head>
<script type="text/javascript">
	function $(id)
	{
		return document.getElementById(id)
	}
</script>
<body>

<!-- <a id="mylink" href="http://etudiante_victore.ru">Щёлкни</a><br> -->

<script type="text/javascript">
	// url = $('mylink').href
	// document.write('URL - адрес - ' + url + '<br>')
	// document.write(history.length)
	// history.go(-3)
	// document.location.href = 'http://google.com'

	// onerror = errorHandler

	// document.write("Добро пожаловать на этот сайт!")

	// function errorHandler (message, url, line)
	// {
	// 	out = "К сожалению, обнаружена ошибка. \n\n ";
	// 	out += "Ошибка: " + message + "\n";
	// 	out += "URL: " + url + "\n";
	// 	out += "Строка: " + line + "\n\n";
	// 	out += "Щёлкните на кнопке ОК для продолжения работы\n\n";
	// 	alert(out);
	// 	return true;
	// }
</script>

	<form name="form1">
	<textarea name="ta1"> Один щелчок мышью и мы у цели!</textarea>
		<input type="button" value="Выделить текст" 
			onclick="document.form1.ta1.select()"/>
		<input type="button" value="Отобразить текст"
			onclick="document.write(document.form1.ta1.value)"/>
			</form>




</body>
</html>