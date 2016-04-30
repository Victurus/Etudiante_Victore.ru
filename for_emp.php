<?php //db_helper2.php
	include_once "header.php";

	$chosen = 'Выбирайте';
	$choice='';
	$button_for = "<input type='submit' value='Далее'>";
	$condition = '';

	if(!isset($_SESSION['i']))
	{
		$_SESSION['i'] = '0';
	}

	if (isset($_POST['sumbitted']))
 	{
 		switch ($_SESSION['i']) 
 		{
 			case '0':
 				$choice = $_POST['kn_area'];
		 		$_SESSION['query'] = "SELECT * FROM work_type WHERE knarea_id='$choice'";

		 		$db->make_query("SELECT * FROM knowledge_area WHERE knarea_id='$choice'");
		 		$db->result->data_seek(0);
				$row = $db->result->fetch_array(MYSQLI_NUM);
				$_SESSION['chosen'] = $row[1];
				$_SESSION['i'] = '1';
				$_SESSION['condition'] = " WHERE knarea_id='$choice'";
 				break;
 			case '1':
 				$choice = $_POST['kn_area'];
 				$_SESSION['query'] = "SELECT * FROM work_type WHERE workt_id='$choice'";
 				$button_for = "<input type='button' value='Назад' onclick='location.href=\"for_emp.php\"' >";
 				$_SESSION['condition'] .= " AND workt_id='$choice'";
 				session_destroy();
 				break;
 			default:
 				$chosen = 'Выбирайте';
				$choice='';
 				$button_for = "<input type='submit' value='Далее'>";
 				session_destroy();
 				break;
 		}
 	}

 	if (isset($_SESSION['chosen']))
	{
		$chosen = $_SESSION['chosen'];
	}

	if(!isset($_SESSION['query']))
		$query = "SELECT * FROM knowledge_area";
	else
		$query = $_SESSION['query'];

	if (!isset($_SESSION['condition']))
		$condition = '';
	else
		$condition = $_SESSION['condition'];

?>

<div class='main-cont'>
	<div class='left-part'>
		<div class="filter-name">
			Фильтр: <?php echo $chosen; ?>
		</div>

		<div class="but-choose">
			<form method='post' action='for_emp.php'>
				<div class="fscroll">
					<ul>
						<?php
						
						$db->make_query($query);
						$rows = $db->rows_count();

						if($rows)
						{
							$db->result->data_seek(0);
							$row = $db->result->fetch_array(MYSQLI_NUM);

							echo <<<_END

					<li><label><div>$row[1]</div><input type="radio" name="kn_area" value="$row[0]" checked="checked"></label><li>
							
_END;
						}

						for($j = 1; $j < $rows; $j++)
						{
							$db->result->data_seek($j);
							$row = $db->result->fetch_array(MYSQLI_NUM);

							echo<<<_END

					<li><label><div>$row[1]</div><input type="radio" name="kn_area" value="$row[0]"></label><li>
        
_END;
						}	
						
						$db->db_close();
					?>

					</ul>
				</div>

				<div class="button-next">
					<input type="hidden" name="sumbitted" value="yes">
					<?php echo $button_for; ?>

				</div>
			</form>
		</div>
	</div>

	<div class="right-part">
	<?php
		$new_worker = new worker();
		echo $new_worker->workers_list($condition);
		echo $choice;
	?>

	</div>
</div>

<?php
	include_once "footer.php";
?>