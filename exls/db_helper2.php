<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Add</title>
<script src="../reg/JS/functions.js"></script>
</head>
<style type="text/css">
	.myclass .btn input
	{
		width:100%;
		height:200px;
	}

	.my_block
	{
		border: 3px solid black;
		height:320px;
		overflow-y:scroll;
		padding-left: 7px;
	}
</style>
<body>

		<?php

		include_once $_SERVER['DOCUMENT_ROOT'] . "/class/db_helper.php";

		$db = new db_helper();
		$db->connect_db();

/////////////....Удаление элемента..............///////////////
	if (isset($_POST['delete']) && isset($_POST['vac_id']))
	{
		$vac_id = get_post($db->db_conn, 'vac_id');
		$db->make_query("DELETE FROM vacancy WHERE vac_id='$vac_id'");
	}

	// if(isset($_POST['knarea']) && isset($_POST['workt']))

///////.........Добавление элемента..............////////////////
	if (isset($_POST['knarea'])     && isset($_POST['workt'])  &&
		isset($_POST['name'])       && isset($_POST['salary']) &&
		isset($_POST['occupation']) && isset($_POST['description']))
	{
		$name = get_post($db->db_conn, 'name');
		$salary = get_post($db->db_conn, 'salary');
		$occupation = get_post($db->db_conn, 'occupation');
		$description = get_post($db->db_conn, 'description');
		$knarea_id = get_post($db->db_conn, 'knarea');
		$workt_id = get_post($db->db_conn, 'workt');
		$emp_id = 1;

		$db->make_query("INSERT INTO vacancy VALUES ('NULL' , '$knarea_id' , '$workt_id', '$emp_id', '$name', '$description', '$salary', '$occupation', 'NULL')");
	}

//////////////////////////////////////////////////////////////////////////
	
	$db->make_query("SELECT * FROM knowledge_area");
	$selector  = "<div class='text'>Выберите вашу область знания:</div>";
	$selector .= "<select name='knarea' size='1' onchange='send_get(this.options[this.selectedIndex].value)'>";
	$selector .= "<option value='1000'></option>";
	
	for($i = 0; $i < $db->rows_count(); $i++)
	{
		$db->result->data_seek($i);
		$row = $db->result->fetch_array(MYSQLI_NUM);

		$selector .= "<option value='$row[0]'> $row[1]</option>";
	}

	$selector .= "</select>";

	echo "<div class='myclass'> <form action='db_helper2.php' method='post'>";
	echo $selector;
	echo "<div class='lines' id='workt_p'></div>";

	echo <<<_END
<pre>
Название должности <input type="text" name="name" size="50">
Заработная плата   <input type="text" name='salary' size='50'>
Занятость          <input type="text" name='occupation' size='50'>
Описание           
<textarea  name='description' rows='10' cols='45'></textarea>
</pre>
<div class="btn">
<input type="submit" value="ADD RECORD">
</div>
</form>
	</div>
_END;

	$db->make_query("SELECT * FROM vacancy");
	
	$rows = $db->rows_count();

	echo "<div class='vac_block'>";

	for($j = 0; $j < $rows; $j++)
	{
		$db->result->data_seek($j);
		$row = $db->result->fetch_array(MYSQLI_NUM);

		echo<<<_END
		<pre>
Название должности $row[4]
Заработная плата   $row[6]
Занятость          $row[7]
Описание           
<textarea readonly name='description'   cols='45'>$row[5]</textarea>
		</pre>
		<form action="db_helper2.php" method="post">
		<input type="hidden" name="delete" value="yes">
		<input type="hidden" name="vac_id" value="$row[0]">
		<input type="submit" value="DELETE RECORD">
		</form>
_END;
	}

	echo "</div>";

	$db->db_close();
?>	

<?php //db_helper2.php

// 	session_start();

// 	$hn = "localhost";
// 	$db = "academycadres";
// 	$un = "victor";
// 	$pw = "MP123";

	

// 	$conn = new mysqli($hn, $un, $pw, $db);
// 	if($conn->connect_error) mysql_fatal_error("Возникла ошибка");

// /////////////....Удаление элемента..............///////////////
// 	if (isset($_POST['delete']) && isset($_POST['workt_id']))
// 	{
// 		$workt_id = get_post($conn, 'workt_id');
// 		$query = "DELETE FROM work_type WHERE workt_id='$workt_id'";
// 		$result = $conn->query($query);
// 		if (!$result) echo "DELETE failed: $query<br>" .
// 			$conn->error . "<br><br>";
// 	}
// /////////////////////////////////////////////////////////////////

// ///////.........Добавление элемента..............////////////////
// 	if(!isset($_SESION['v']))
// 			$_SESION['v'] = 0;
// 	if (isset($_POST['name']) && isset($_POST['knarea_id']))
// 	{
// 		$name = get_post($conn, 'name');
// 		$knarea_id = get_post($conn, 'knarea_id');

// 		if($_SESION['v'] != $knarea_id)
// 		{
// 			$_SESION['v'] = $knarea_id;
// 		}


// 		$query = "INSERT INTO work_type VALUES" . 
// 			"('NULL' , '$name' , '$knarea_id')";
// 		$result = $conn->query($query);
// 		if (!$result) echo "INSERT failed: $query<br>" .
// 		$conn->error . "<br><br>";
// 	}
// 	$v = $_SESION['v'];
// /////////////////////////////////////////////////////////////////
// 	echo <<<_END
// 	<div class="myclass">
// <form action="db_helper2.php" method="post"><pre>
// Work_type          <input type="text" name="name" size="50" autofocus="autofocus">
// knowledge_area_id  <input type="text" name="knarea_id" value="$v" size="50">
// <div class="btn">
// <input type="submit" value="ADD RECORD">
// </div>
// </pre></form>
// 	</div>
// _END;

// 	$query = "SELECT * FROM work_type";
// 	$result = $conn->query($query);
// 	if(!$result) mysql_fatal_error("Возникла ошибка");

// 	$rows = $result->num_rows;

// 	echo "<div class='my_block'>";

// 	for($j = 0; $j < $rows; $j++)
// 	{
// 		$result->data_seek($j);
// 		$row = $result->fetch_array(MYSQLI_NUM);

// 		echo<<<_END
// 		<pre>
// Work_type_id:      $row[0]
// Name:              $row[1]
// Knowledge_area_id: $row[2]
// 		</pre>
// 		<form action="db_helper2.php" method="post">
// 		<input type="hidden" name="delete" value="yes">
// 		<input type="hidden" name="workt_id" value="$row[0]">
// 		<input type="submit" value="DELETE RECORD">
// 		</form>
// _END;
// 	}

// 	echo "</div>";

// 	$result->close();
// 	$conn->close();

// 	function get_post($conn, $var)
// 	{
// 		return $conn->real_escape_string($_POST[$var]);
// 	}

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



<?php //db_helper.php
	
// 	$db_hostname = 'localhost';
// 	$db_database = 'academycadres';
// 	$db_username = 'victor';
// 	$db_password = 'MP123';

// /////...Это, как к базе подключаться через mysqli................................./////////////////////	
// //	$db_conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// //	if(!$db_conn) mysql_fatal_error("Возникла ошибка");
// ///////////////////////////////////////////////////////////////////////////////////////////////////////	

// ////...Это, как к ней делать запрос.................................//////////
// //	$result = $db_conn->query($query);
// //	if(!$result) mysql_fatal_error("Сбой при доступе к база данных");
// //////////////////////////////////////////////////////////////////////////////

// ////...Эта функция показывает как работать с базой........///////////////////////////
// 	function Describe_db()
// 	{
// 		$db_hostname = 'localhost';
// 		$db_database = 'academycadres';
// 		$db_username = 'victor';
// 		$db_password = 'MP123';

// 		$db_conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
// 		if(!$db_conn) mysql_fatal_error("Возникла ошибка");

// 		$query = "SHOW TABLES";

// 		$result = $db_conn->query($query);
// 		if(!$result) mysql_fatal_error("Сбой при доступе к базе данных");

// 		$rows = $result->num_rows;

// 		for($i = 0; $i < $rows; $i++)
// 		{
// 			$result->data_seek($i);
// 			$row = $result->fetch_array("MYSQLI_NUM");
// 			echo<<<_END
// 			$row[0] <br><br>
// _END;
// 		}
// 	}
// //////////////////////////////////////////////////////////////////////////////////////

// 	function db_close($result, $db_conn)
// 	{
// 		$result->close();
// 		$db_conn->close();
// 	}

// 	function get_post($conn, $var)
// 	{
// 		return $conn->real_escape_string($_POST[$var]);
// 	}

// 	function sanitizeString($var)
// 	{
// 		$var = stripslashes($var);
// 		$var = htmlentities($var);
// 		$var = strip_tags($var);
// 		return $var;
// 	}

// 	function sinitizeMySQL($conn, $var)
// 	{
// 		$var = mysqli_real_escape_string($conn, $var);
// 		$var = sanitizeString($var);
// 		return $var;
// 	}

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

</body>
</html>