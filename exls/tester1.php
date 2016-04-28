<?php //tester1.php
	if(isset($_POST['name']))
		$name = $_POST['name'];
	else
		$name = "Не введено";

	echo <<<_END
	<html>
	<head>
		<title> Form test </title>
		<meta charset="utf8">
	</head>
	<body>
		Вас зовут: $name <br>
		<form method="post" action="tester1.php">
			Как вас зовут?
			<input type="text" name="name">
			<input type="submit">
		</form>

		<textarea name="txtplace" cols="20" rows="5">
Hello, this is simple text.
		</textarea>
		<br>
		Я согласен <input type="checkbox" name="agree" value="1">
		<br>
		Подписаться? <input type="checkbox" name="news" checked="checked">
	</body>
	</html>
_END;
?>