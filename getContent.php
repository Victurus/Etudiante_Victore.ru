<?php //getContentx.php
	if($_POST)
		$str = $_POST['navchoose'];
	else
		$str = "";

	switch ($str)
	{
		case 'Home':
			include_once "my_pages/main_page.php";	
			break;
		case 'for_emp':
			include_once "my_pages/for_emp.php";
			break;
		case "for_worker":
			include_once "my_pages/for_worker.php";
			break;
		case "Information":
			include_once "my_pages/Information.php";
			break;
		case "Partners":
			include_once "my_pages/Partners.php";
			break;
		default:
			break;
	}
?>