<?php //db_helper2.php	
	include_once "header.php";
?>

<div class='main-cont'>
	<div class='left-part'>
		<?php //db_helper2.php
			
			$db->make_query("SELECT * FROM knowledge_area");
			$rows = $db->rows_count();

			if($rows)
			{
				$db->result->data_seek(0);
				$row = $db->result->fetch_array(MYSQLI_NUM);
				// echo $row[0];
				echo <<<_END
				<div class='lbl_knarea'>
					<label><span>$row[1]</span><input type="radio" name="kn_area" value="$row[0]" checked="checked"> </label>
				</div>
				<br>
_END;
			}

			for($j = 1; $j < $rows; $j++)
			{
				$db->result->data_seek($j);
				$row = $db->result->fetch_array(MYSQLI_NUM);
				echo<<<_END
				<div class='lbl_knarea'>
		        	<label><span>$row[1]</span><input type="radio" name="kn_area" value="$row[0]"></label>
		        </div>
		        <br>
_END;
			}		
			$db->db_close();
		?>
	</div>

	<div class="right-part">
		<?php
			$new_worker = new worker(1, 1, 1);
			echo $new_worker->workers_list();
		?>
	</div>
</div>

<?php
	include_once "footer.php";
?>