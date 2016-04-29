<?php
	include_once "user.php";

	class worker extends user //класс работника
	{
		public $cv; // Резюме*
		public $sertificat; //Сертфикаты о дополнительном образовании
		public $experience; //Опыт работы
		public $year, $month, $day; //дата рождения
		public $profession;
		private $db;

		function __construct($c_v, $sertific, $exp)
		{
			parent::__construct(1);
			$this->who = false;
			$this->cv = $c_v;
			$this->sertificat = $sertific;
			$this->experience = $exp;
			$this->year = 1996;
			$this->month = sprintf("0%d", 8);
			$this->day = 22;
			$profession="Усидчивый пряникоед";

			$this->db = new db_helper("academycadres");
			$this->db->connect_db();
		}

		function save_worker()
		{
			$this->save_user();
		}

		function workers_list() // Выдаёт список работников
		{
			$this->db->make_query("SELECT * FROM workers");
			$text = '';
			$rows = $this->db->rows_count();

			if($rows == 0)
				$text = <<<_EOT
					<div class="emp_block">
					<h3>Нет пока никого, будь первым!!!</h3>
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
					<br> Имя $row[0]   <br>
					     Опыт работы $row[1] <br>
					     Профессия $row[2] <br>
				</div>

				<div class="description">
					О себе:<br>
					$row[3]
				</div>
			</div>
_END;
				}

			return $text;
		}
	}
?>