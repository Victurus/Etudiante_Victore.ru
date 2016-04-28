<?php
	include_once "user.php";

	class worker extends user //класс работника
	{
		public $cv; // Резюме*
		public $sertificat; //Сертфикаты о дополнительном образовании
		public $experience; //Опыт работы
		public $year, $month, $day; //дата рождения
		public $profession;

		function __construct($c_v, $sertific, $exp)
		{
			parent::__construct();
			$this->who = false;
			$this->cv = $c_v;
			$this->sertificat = $sertific;
			$this->experience = $exp;
			$this->year = 1996;
			$this->month = sprintf("0%d", 8);
			$this->day = 22;
			$profession="Усидчивый пряникоед";
		}

		function save_worker()
		{
			$this->save_user();

			echo "Сохранить - $this->year <br>";
			echo "Сохранить - $this->month <br>";
			echo "Сохранить - $this->day <br>";
			
			if($this->cv)
			{
				echo "Резёме есть <br>";
			}

			if($this->sertificat)
			{
				echo "Сертификаты о дополнительном образовании есть <br>";
			}
		}

		// function read_wrkr() // Под этим методом я подразумеваю считывание
		// {					 // данных из БД об одном работнике
		// 	$this->name = "Работников Работник Работникович";
		// 	$this->e_mail = "Работник@мыло.com";
		// 	$this->tel_num = "+8 *** *** ** **";
		// }	

		function display() // Метод отображения данных одного работника
		{
			// print_r($this);
		}
	}

	function workers_list() // Выдаёт список из 20 работников
		{
			$db = new db_helper("academycadres");
			$db->connect_db();

			$db->make_query("SELECT * FROM workers");
			$text = '';

			if($db->rows_count() == 0)
				return <<<_EOT
					<div class="emp_block">
					<h3>Нет пока никого, будь первым!!!</h3>
					</div>			
_EOT;
			else
				for($i = 0; $i < $db->rows_count();$i++)
				{
					$db->result->data_seek($i);
					$row = $db->result->fetch_array(MYSQLI_NUMS);

					$text .= <<<_END
			<div class="for_worker">
				<div>
					<img src="my_pages/reg/$row[3]" alt="Нет аватарки" height="100" width="60">
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
?>