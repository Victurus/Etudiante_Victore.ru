<?php //get_work_type.php
	include_once $_SERVER['DOCUMENT_ROOT'] . "/Globals.php";

	if (isset($_POST['knarea_id']))
	{
		$knarea_id = SanitizeString($_POST['knarea_id']);
		if($knarea_id != 1000)
		{	
			echo "<div class='text'>Выберите ваш тип работ:</div> ";

			$db = new db_helper();
			$db->connect_db();

			$db->make_query("SELECT * FROM work_type WHERE knarea_id='$knarea_id'");

			echo "<select name='workt' size='1'>";
			echo "<option value='1000'></option>";
			for($i = 0; $i < $db->rows_count(); $i++)
			{
				$db->result->data_seek($i);
				$row = $db->result->fetch_array();
				echo "<option value='$row[0]'> $row[1]</option>";
			}
			echo "</select>";
		}
	}
?>