<?php //for_worker.php
	include_once "header.php";

	$chosen = 'Выбирайте';
	$choice='';
	$button_for = "<input type='submit' name='kn_name' value='Выбрать'>";
	$condition = '';

	if(!isset($_SESSION['i']))
	{
		$_SESSION['i'] = '0';
		unset($_SESSION['query']);
 		unset($_SESSION['chosen']);
 		unset($_SESSION['condition']);
	}

	if (isset($_POST['kn_name']))
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
 	$button_for = "<input type='button' name='kn_name' value='назад' onclick='location.href=\"for_worker.php\"'>";
 				$_SESSION['condition'] .= " AND workt_id='$choice'";
 				unset($_SESSION['i']);
 				break;
 			default:
 				$chosen = 'Выбирайте';
				$choice='';
 				$button_for = "<input type='submit' value='Далее'>";
 				unset($_SESSION['i']);
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
			<?php echo "Поиск"; ?>
		</div>

		<div class="but-choose">
			
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
					<form method='post' action='for_worker.php'>
					<li>
						<label>
							<div class="element_list">
								<div class="lft">$row[1]</div>
								<div class="rt">$button_for</div>
								<input type="hidden" name="kn_area" value="$row[0]">
							</div>
						</label>
					</li>
					</form>		
_END;
						}

						for($j = 1; $j < $rows; $j++)
						{
							$db->result->data_seek($j);
							$row = $db->result->fetch_array(MYSQLI_NUM);

							echo<<<_END
					<form method='post' action='for_worker.php'>
					<li>
						<label>
							<div class="element_list">
								<div class="lft">$row[1]</div>
								<div class="rt">$button_for</div>
								<input type="hidden" name="kn_area" value="$row[0]">
								</div>
						</label>
					</li>
        			</form>
_END;
						}	
						
						$db->db_close();
					?>

					</ul>
				</div>

				<!--<div class="button-next">
					<input type="hidden" name="sumbitted" value="yes">
					<?php echo $button_for; ?>

				</div>-->
		</div>
	</div>

	<div class="right-part">
	<?php


		if(isset($_POST['vac_']))
		{
			$vac_id = $_POST['vac_'];
			// echo $vac_id;
			$usr_id = $_SESSION['id'];
			// echo '/'. $usr_id;

			$db = new db_helper();
			$db->connect_db();

			$db->make_query("SELECT * FROM workers WHERE usr_id = '$usr_id' ");
			$db->result->data_seek(0);

			$row = $db->result->fetch_array(MYSQLI_NUM);
			$db->make_query("INSERT INTO otclick_worker VALUES('NULL', '$row[0]', '$vac_id') ");
			// $db->db_close();
		}

		$new_vacancy = new vacancy();
		if(isset($_SESSION['username']) && isset($_SESSION['who']))
			echo $new_vacancy->vacancy_list($_SESSION['who'], $condition);
		else
			echo $new_vacancy->vacancy_list('1', $condition);
		// echo $choice;
	?>

	</div>
</div>

<?php
	include_once "footer.php";
?>