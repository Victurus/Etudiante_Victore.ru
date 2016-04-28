<?php //db_helper2.php
	$hn = "localhost";
	$db = "academycadres";
	$un = "victor";
	$pw = "MP123";

echo "<pre>";
	$conn = new mysqli($hn, $un, $pw, $db);
	if($conn->connect_error) mysql_fatal_error("Возникла ошибка");

	if (isset($_POST['delete']) && isset($_POST['knarea_id']))
	{
		$knarea_id = get_post($conn, 'knarea_id');
		$query = "DELETE FROM knowledge_area WHERE knarea_id='$knarea_id'";
		$result = $conn->query($query);
		if (!$result) echo "DELETE failed: $query<br>" .
			$conn->error . "<br><br>";
	}
	if (isset($_POST['name']))
	{
		$name = get_post($conn, 'name');
		$query = "INSERT INTO knowledge_area VALUES" . 
			"('NULL' , '$name')";
		$result = $conn->query($query);
		if (!$result) echo "INSERT failed: $query<br>" .
		$conn->error . "<br><br>";
	}
	
	echo <<<_END
<form action="for_emp.php" method="post"><pre>
Name_knowledge_area <input type="text" name="name">
<input type="submit" value="ADD RECORD">
</pre></form>
_END;

	$query = "SELECT * FROM knowledge_area";
	$result = $conn->query($query);
	if(!$result) mysql_fatal_error("Возникла ошибка");

	$rows = $result->num_rows;

	for($j = 0; $j < $rows; $j++)
	{
		$result->data_seek($j);
		$row = $result->fetch_array(MYSQLI_NUM);

		echo<<<_END
		<br>
		<pre>
Knowledge_area_id: $row[0]
Name'              $row[1]
		</pre>
		<form action="for_emp.php" method="post">
		<input type="hidden" name="delete" value="yes">
		<input type="hidden" name="knarea_id" value="$row[0]">
		<input type="submit" value="DELETE RECORD">
		</form>
		<br>
_END;
	}
echo "</pre>";
	$result->close();
	$conn->close();

	//function get_post($conn, $var)
	//{
//		return $conn->real_escape_string($_POST[$var]);
	// }

// 	function mysql_fatal_error($msg)
// 	{
// 		$msg2 = mysql_error();
// 		echo <<<_END
// 		К сожалению, завершить запрашиваемую операцию не представилось возможным.
// 		Было получено следующее сообщение об ошибке:
// 		<p>$msg: $msg2 </p>
// 		Пожалуйста нажмите кнопку возврата вашего браузера
// 		и повторите попытку. Если проблемы не прекратятся,
// 		пожалуйста, <a href= "index.php"> сообщите 
// 		о них нашему администратору </a>
// 		Спасибо.
// _END;
// 	}
?>