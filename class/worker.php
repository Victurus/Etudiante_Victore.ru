<?php
	include_once "user.php";

	class worker extends user //класс работника
	{
		// public $sertificat; //Сертфикаты о дополнительном образовании
		private $experience; //Опыт работы
		private $year, $month, $day; //дата рождения
		private $profession;
		private $imgpath;
		private $curvitaepath;
		private $db;

		function __construct()
		{
			parent::__construct(0);

			$this->db = new db_helper("academycadres");
			$this->db->connect_db();
		}

		function save_worker($knarea_id, $workt_id)
		{
			$this->save_user();

			$this->db->make_query("SELECT * FROM users WHERE login='$this->login'");

			if(!$this->db->rows_count())
			{
				$this->db->make_query("INSERT INTO users VALUES('NULL' , '$this->login' , '$this->password')");

				$this->db->make_query("SELECT * FROM users WHERE login='$this->login'");
				$row = $this->db->result->fetch_array(MYSQLI_NUM);

				$born = $this->year . "-" . $this->month . "-" . $this->date;

				$this->db->make_query("INSERT INTO workers VALUES ('NULL' , '$this->name' , '$this->e_mail' , '$this->tel_mob' , '$this->tel_dom' , '$this->experience' , '$this->profession' , '$this->curvitaepath', '$this->imgpath' , '$born' , '$knarea_id' , '$workt_id' , '$row[0]')");
				return "Регистрация прошла упешно";
			}
			else
			{
				return "Пользователь с таким именем уже существует, придумайте другое";
			}
		}

		function workers_list($condition) // Выдаёт список работников
		{
			$this->db->make_query("SELECT * FROM workers $condition");
			$text = '';
			$rows = $this->db->rows_count();

			if($rows == 0)
				$text = <<<_EOT
	<div class="emp_block">
			<h3>Список соискателей пока пуст.</h3>
		</div>			
_EOT;
			else
				for($i = 0; $i < $rows;$i++)
				{
					$this->db->result->data_seek($i);
					$row = $this->db->result->fetch_array(MYSQLI_NUM);

					$text .= <<<_END
			<div class="worker_block">
				<div>
					<img src="reg/$row[8]" alt="Нет аватарки" height="auto" width="200">
				</div>

				<div class="worker_info">
				<pre>
Имя:        $row[1]
Опыт работы:$row[5]
Профессия:  $row[6]
				</pre>
				</div>
			</div>
_END;
				}

			return $text;
		}

		function set_imgpath($new_path)
		{
			$this->imgpath = $new_path;
		}

		function set_docpath($new_path)
		{
			$this->curvitaepath = $new_path;
		}

		function set_year($var)
		{
			$this->year = $var;
		}

		function set_month($var)
		{
			$this->month = $var;
		}

		function set_date($var)
		{
			$this->date = $var;
		}

		function set_experience($var)
		{
			$this->experience = $var;
		}

		function set_profession($var)
		{
			$this->profession = $var;
		}
	}
?>