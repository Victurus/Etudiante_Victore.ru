<?php
	include_once "db_helper.php";

	class user
	{
		/* 
		 *  Это суперкласс пользователя():
		 *  Для получения/занесения общих
		 *  данных о нём из/в БД
		*/

		protected $who; //Кто это? - работадатель == 1, работник == 0

		protected $name; // ФИО* или Название организации
		protected $login;
		protected $password; // Пароль произвольного пользователя

		protected $e_mail;  //Почта*
		protected $tel_mob; // рабочий телефонный номер*
		protected $tel_dom; //домашний телефонный номер*
		
		function __construct($who_is_it)
		{
			$who = $who_is_it;
		}

		function save_user()
		{		
		///...Это область создания и сохранения логов.....//////////////////////////////////////
			$t = date("Y:m");
			$logs = fopen("/home/victor/Data/sites/Etudiante_Victore.ru/logs/log_$t.txt", "a") or die("Усё сервак накрылся, музыки не будет");
			chmod("/home/victor/Data/sites/Etudiante_Victore.ru/logs/log_$t.txt", 0755);
			$ec_t = date("Y:m:d - H:i:s");
			$text = <<<_END
	[$ec_t] $this->name зарегистрирован. Под логином $this->login \n
_END;
			fwrite($logs, $text) or die("Ошибка сохранения файла");
			fclose($logs);
		}		

		function set_name($new_name)
		{
			$this->name = $new_name;
		}

		function set_login($new_login)
		{
			$this->login = $new_login;
		}

		function set_password($pass)
		{
			$this->password = $pass;
		}

		function set_email($new_email)
		{
			$this->e_mail = $new_email;
		}

		function set_telmob($new_telmob)
		{
			$this->tel_mob = $new_telmob;
		}

		function set_teldom($new_teldom)
		{
			$this->tel_dom = $new_teldom;
		}
	}
?>