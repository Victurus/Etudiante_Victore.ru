<?php //Globals.php
	include_once "class/employer.php";
	include_once "class/worker.php";

	$title = "Академия кадров";
	$header = "<h4> Академия кадров </h4>
			   <h5> Вам в помощь!</h5>";
	$footer = "Copyright by Victor Zamataev (^_^)";
	$is_user_registred = false; //Зарегистрирован ли пользователь
	$page = "";
	$kernel = $_SERVER['DOCUMENT_ROOT'];
?>