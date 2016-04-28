<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Название сайта</title>
<link rel="stylesheet" href="styles/menu.css">
</head>
<body>
    <header>
	    <h1>Результат работы файлов примеров</h1>
    	<hr>
    </header>
    <section>
        <?php
		$i = 0;
		switch($i)
		{
			case 0:
				include_once "testfile.php";
				break;
			case 1:
				include_once "copyfile.php";
				break;
			case 2:
				include_once "movefile.php";
				break;
			case 3:
				include_once "deletefile.php";
				break;
			case 4:
				include_once "exec.php";
				break;
			default:
				echo "Всё больше нет";
				break;
		}
	?>
    </section>
	<footer>
		<hr>
		Copyright by Victor (^_^)
	</footer>
</body>
</html>
