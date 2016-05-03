<?php //db_helper2.php
	
	include_once "header.php";
?>
<div class='main_otcl'>
	<?php
		if($_SESSION['who'])
		{
			$db->make_query("SELECT * FROM otclick_worker");
			$rows = $db->rows_count();
			if($rows)
			{
				$db2 = new db_helper();
				$db2->connect_db();

				for($i = 0; $i < $rows;$i++)
				{
					echo "<div class='otclick_block'>";
					$db->result->data_seek($i);
					$row = $db->result->fetch_array(MYSQLI_NUM);
					$worker_id = $row[1];
					$vac_id = $row[2];

					$db2->make_query("SELECT * FROM workers WHERE worker_id='$worker_id'");
					$row = $db2->result->fetch_array(MYSQLI_NUM);

					$db2->make_query("SELECT * FROM vacancy WHERE vac_id='$vac_id'");
					$row1 = $db2->result->fetch_array(MYSQLI_NUM);				
					echo <<<_END
					<pre>
Работник по имени: $row[1]
Телефонный номер
мобильный:         $row[3]
домашний:          $row[4]
email:             $row[2]
опыт работы:       $row[5]
<h3>Откликнулся на вакансию:</h3>$row1[4]
с оплатой: $row1[6]
					</pre>
_END;
					echo "</div>";
				}
			}
			else
			{
				echo "<div class='otclick_block'>Откликов пока не было</div>";
			}
		}
		else
		{
			$db->make_query("SELECT * FROM otclick_employer");
			$rows = $db->rows_count();
			if($rows)
			{
				$db2 = new db_helper();
				$db2->connect_db();

				for($i = 0; $i < $rows;$i++)
				{
					echo "<div class='otclick_block'>";
					$db->result->data_seek($i);
					$row = $db->result->fetch_array(MYSQLI_NUM);
					$employer_id = $row[1];
					$worker_id = $row[2];

					$db2->make_query("SELECT * FROM employers WHERE employer_id='$employer_id'");
					$row1 = $db2->result->fetch_array(MYSQLI_NUM);				
					echo <<<_END
					<pre>
Фирма: 	   $row1[1]
Телефонный номер
основной:  $row1[3]
email:     $row1[4]
</pre>
_END;
					echo "</div>";
				}
			}
			else
			{
				echo "<div class='otclick_block'>Откликов пока не было</div>";
			}
		}
		
	?>
</div>

<?php
	include_once "footer.php";
?>