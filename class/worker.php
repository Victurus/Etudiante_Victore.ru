<?php
	include_once "user.php";

	class worker extends user //класс работника
	{
		public $cv; // Резюме*
		// public $sertificat; //Сертфикаты о дополнительном образовании
		private $experience; //Опыт работы
		private $year, $month, $day; //дата рождения
		private $profession;
		private $db;

		function __construct()
		{
			parent::__construct(0);

			$this->db = new db_helper("academycadres");
			$this->db->connect_db();
		}

		function save_worker()
		{
			$this->save_user();

			$this->save_user();
			$this->db->make_query("SELECT * FROM users WHERE login='$this->login'");

			if(!$this->db->rows_count())
			{
				$this->db->make_query("INSERT INTO users VALUES('NULL' , '$this->login' , '$this->password')");


				$this->db->make_query("SELECT * FROM users WHERE login='$this->login'");
				$row = $this->db->result->fetch_array(MYSQLI_NUM);

				$this->db->make_query("INSERT INTO workers VALUES ('NULL' , '$this->name' , '$this->e_mail' , '$this->tel_mob' , '$this->tel_dom' , '$this->experience' , '$this->profession' , '$this->curvitae' , '$this->born' , '$knarea_id' , '$workt_id'  , '$row[0]')");
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
					$row = $this->db->result->fetch_array(MYSQLI_NUMS);

					$text .= <<<_END
			<div class="for_worker">
				<div>
					<img src="reg/$row[3]" alt="Нет аватарки" height="100" width="60">
				</div>

				<div class="info">
					<br> Имя         $row[0] <br>
					     Опыт работы $row[1] <br>
					     Профессия   $row[2] <br>
				</div>

				<div class="description">
					О себе: <br>
					$row[3]
				</div>
			</div>
_END;
				}

			return $text;
		}
	}
?>