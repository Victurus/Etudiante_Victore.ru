<?php
	include_once "user.php";
	include_once $_SERVER['DOCUMENT_ROOT'] . "/class/db_helper.php";

	class employer extends user //Работодатель 
	{
		// public $sertificaty; // Наличие у фирмы сертификатов
		// public $license; //Лицензия* на работу только для фирмы
		public $who_needs; //Может пригодится здесь сделать выдачу вакансий,но скорее всего нет
		private $db;


		function __construct(/*$sertificat, $licen*/)
		{
			parent::__construct(1);
			$this->db = new db_helper();
			$this->db->connect_db();
		}

		function save_employer() // Заносит данные работодателя в БД работодателей
		{
			$this->save_user();
		}

		function employers_list() // Выдаёт список работодателей
		{
			$this->db->make_query("SELECT * FROM employers");
			$text = '';

			if($this->db->rows_count() == 0)
				return <<<_EOT
					<div class="emp_block">
					<h3>Нет пока никого, будь первым!!!</h3>
					</div>			
_EOT;
			else
				for($i = 0; $i < $this->db->rows_count();$i++)
				{
					$this->db->result->data_seek($i);
					$row = $this->db->result->fetch_array(MYSQLI_NUM);
					$text .= <<<_END
					<div class="emp_block">
						<div class="emp_img">
							<img src="reg/$row[2]" alt="Логотип компании" width="200" height="200">
						</div>

						<div class="emp_info"> 
							<br>    
							Название фирмы:    $row[1]    <br>
								
							Почта:             $row[4]  <br>
								
							Телефон оффиса:    $row[3] <br>
								
						</div>
					</div>			
_END;
				}

			$this->db->db_close();
			return $text;
		}
	}
?>
