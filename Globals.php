<?php //Globals.php
	include_once "class/employer.php";
	include_once "class/worker.php";
	include_once "class/vacancy.php";

	$title = "Академия кадров";
	$header = "<h4> Академия кадров </h4>
			   <h5> Вам в помощь!</h5>";
	$footer = "Copyright by Victor Zamataev (^_^)";
	$kernel = $_SERVER['DOCUMENT_ROOT'];

	function isAuth()
	{
		if (isset($_SESSION['username'])) 
		{
			return true;
		}
		else
			return false;
	}
	
	function out() 
	{
        $_SESSION = array(); //Очищаем сессию
        session_destroy(); //Уничтожаем
    }
?>