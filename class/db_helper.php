<?php //db_helper.php
	class db_helper
	{
		protected $db_hostname;
		protected $db_database;
		protected $db_username;
		protected $db_password;
		public $db_conn;
		public $result;
		protected $rows;
		
		function __construct()
		{
			$this->db_hostname = 'localhost';
			$this->db_database = 'academycadres';
			$this->db_username = 'victor';
			$this->db_password = 'MP123';
		}

		function  connect_db()
		{
			$this->db_conn = new mysqli($this->db_hostname, $this->db_username, $this->db_password, $this->db_database);
			if(!$this->db_conn) mysql_fatal_error("Возникла ошибка", $this->db_conn);
		}

		function make_query($query)
		{
			$this->result = $this->db_conn->query($query);
			if(!$this->result) mysql_fatal_error("Сбой при доступе к базе данных", $this->db_conn);
		}

		function rows_count()
		{
			$this->rows = $this->result->num_rows;
			return $this->rows;
		}

		function db_close()
		{
			$this->result->close();
			$this->db_conn->close();
		}

	}

	function get_post($conn, $var)
	{
		return $conn->real_escape_string($_POST[$var]);
	}

	function sanitizeString($var)
	{
		$var = stripslashes($var);
		$var = htmlentities($var);
		$var = strip_tags($var);
		return $var;
	}

	function sanitizeMySQL($conn, $var)
	{
		$var = mysqli_real_escape_string($conn, $var);
		$var = sanitizeString($var);
		return $var;
	}

	function mysql_fatal_error($msg, $connection)
	{
		$msg2 = $connection->error;
		echo <<<_END
		К сожалению, завершить запрашиваемую операцию не представилось возможным.
		Было получено следующее сообщение об ошибке:
		<p>$msg: $msg2 </p>
		Пожалуйста нажмите кнопку возврата вашего браузера
		и повторите попытку. Если проблемы не прекратятся,
		пожалуйста, <a href= "index.php"> сообщите 
		о них нашему администратору </a>
		Спасибо.
_END;
	}
?>
