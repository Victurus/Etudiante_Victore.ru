<?php
	class user
	{
		/* 
		 *  Это суперкласс пользователя():
		 *  Для получения/занесения общих
		 *  данных о нём из/в БД
		*/

		public $who; //Кто это? - работадатель == 1, работник == 0
		private $password; // Пароль произвольного пользователя
		

		public $name; // ФИО* или Название организации
		public $e_mail; //Почта*
		public $tel_dom; //домашний телефонный номер*
		public $tel_mob; // рабочий телефонный номер*
		
		function __construct()
		{
			$this->name = "ФИО";
			$this->password = "пароль";
			$this->e_mail = "my_email.com";
			$this->tel_num = "Номер телефона пользователя";
		}

		function save_user()
		{
			echo "Сохранить - $this->name <br>";
			echo "Сохранить - $this->password <br>";
			echo "Сохранить - $this->e_mail <br>";
			echo "Сохранить - $this->tel_mob <br>";
			echo "Сохранить - $this->tel_dom <br>";
			
			$t = date("Y:m");
			$logs = fopen("logs/log_$t.txt", "a") or die("Усё сервак накрылся, музыки не будет");
			$ec_t = date("Y:m:d - H:i:s");
			$text = <<<_END
	[$ec_t] $this->name зарегистрирован + случайно гененрируемый для каждого id\n
_END;
			fwrite($logs, $text) or die("Ошибка сохранения файла");
			fclose($logs);
		}		

		function get_name()
		{
			return $this->name;
		}

		function get_email()
		{
			return $this->e_mail;
		}

		function get_telnum()
		{
			return $this->tel_num;
		}

		function who_st() //кто это
		{
			if($this->who)
				echo "<hr> Работодатель";
			else
				echo "<hr> Соискатель";
		}
	}
?>