<?php //vacancy.php
	// include_once "employer.php";
	include_once $_SERVER['DOCUMENT_ROOT'] . "/class/db_helper.php";

	class vacancy /*extends employer*/
	{
		private $knowledge_ID; //область знания
		private $work_type_ID; //вид работ
		private $work_name; //название вида работ
		private $description; //Требования - описание
		private $salary; //заработная плата
		private $occupation; //занятость
		private $db;

		function __construct()
		{
			$knowledge_ID = ''; 
			$work_type_ID = ''; 
			$work_name = ''; 
			$description = ''; 
			$salary = '';
			$occupation = '';

			$this->db = new db_helper();
			$this->db->connect_db();
		}

		function add_vacancy($emp_id)
		{
			if ($knowledge_ID != '' && $work_type_ID   != '' && 
			    $work_name    != '' && $description != '' && 
			    $salary       != '' && $occupation  != ''   )
			{
				$this->db->make_query("INSERT INTO vacancy VALUES ('NULL' , '$this->knowledge_ID' , 
					'$this->work_type_ID' , '$emp_id' , '$this->work_name' , '$this->description' , 
					'$this->salary' , '$this->occupation' )");
			}
		}

		function del_vacancy($del_id)
		{
			$this->db->make_query("DELETE FROM vacancy WHERE vac_id='$del_id'");
		}

		function vacancy_list($rule, $condition)
		{
			$this->db->make_query("SELECT * FROM vacancy $condition");

			$text = "";
			$rows = $this->db->rows_count();
			if($rows)
			{
				$emp_db = new db_helper();
				$emp_db->connect_db();

				for($i = 0; $i < $rows; $i++)
				{
					$this->db->result->data_seek($i);
					$row = $this->db->result->fetch_array(MYSQLI_NUM);

					$emp_db->make_query("SELECT * FROM employers WHERE employer_id='$row[3]'");
					$emp_db->result->data_seek(0);
					$row2 = $emp_db->result->fetch_array(MYSQLI_NUM);

					if(!$rule)
					$but = "<form action='for_worker.php' method='post'><input type='hidden' name='vac_' value='$row[0]'><span><input type='submit' name='wanted' value='Откликнуться' onclick='alert('Заявка отослана')></span></form>";
					else
						$but = '';


					$text .= <<<_END
					<div class='vac_block'>
						<div class='vac_img'>
							<img src="reg/$row2[2]" alt="Логотип компании" width="200" height="200">
						</div>

						<div class="vac_info">
						<pre>
Фирма: $row2[1]
Название профессии: $row[4]
Заработна плата:    $row[6]
Занятость:          $row[7]

Описание: 
$row[5]
$but
</pre>
						</div>
					</div>
_END;
				}
			}
			else
			{
				$text = <<<_END
				<div class="vac_block">
				<h3>Вакансий пока нет.</h3>
				</div>
_END;
			}

			return $text;
		}

		function set_kn_ID($n_id)
		{
			$this->knowledge_ID = $n_id;
		}

		function set_wtype($n_wtype)
		{
			$this->work_type_ID = $n_wtype;
		}

		function set_wname($n_wname)
		{
			$this->work_name = $n_wname;
		}

		function set_descript($n_descript)
		{
			$this->description = $n_descript;
		}

		function set_slr($n_slr)
		{
			$this->salary = $n_slr;
		}

		function set_ocup($n_occup)
		{
			$this->occupation = $n_occup;
		}
	}
?>