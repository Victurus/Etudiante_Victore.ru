<?php 
	include_once "class/db_helper.php"; 
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Название сайта</title>
</head>
<body>
	<?php //tester.php
		$db = new db_helper("publications");
		$db->connect_db();

		if(isset($_POST['delete']) && isset($_POST['isbn']))
		{
			$isbn = get_post($db->db_conn, 'isbn');
			$db->make_query("DELETE FROM classics WHERE isbn='$isbn'");
		}

		if( isset($_POST['author']) &&
			isset($_POST['title']) &&
			isset($_POST['category']) &&
			isset($_POST['year']) &&
			isset($_POST['isbn']))
		{
			$author = get_post($db->db_conn, 'author');
			$title = get_post($db->db_conn, 'title');
			$category = get_post($db->db_conn, 'category');
			$year = get_post($db->db_conn, 'year');
			$isbn = get_post($db->db_conn, 'isbn');

			$db->make_query("INSERT INTO classics VALUES ('$author' , '$title' , '$category' , '$year' , '$isbn')");
		}

		echo <<<_END
<form action="tester.php" method="post"><pre>
Author   <input type="text" name="author">
Title    <input type="text" name="title">
Category <input type="text" name="category">
Year     <input type="text" name="year">
ISBN     <input type="text" name="isbn">
<input type="submit" value="ADD RECORD">
		</pre></form>
_END;

		$db->make_query("SELECT * FROM classics");

		for($i = 0; $i < $db->rows_count(); $i++)
		{
			$db->result->data_seek($i);
			$row = $db->result->fetch_array(MYSQLI_NUM);

			echo <<<_END
			<pre>
Author:   $row[0] 
Title:    $row[1] 
Category: $row[2]
Year:     $row[3] 
ISBN:     $row[4] 
			</pre>
			<form action="tester.php" method="post">
			<input type="hidden" name="delete" value="yes">
			<input type="hidden" name="isbn" value="$row[4]">
			<input type="submit" value="DELETE RECORD">
			</form>
_END;
		}

		$db->db_close();

		
	?>
</body>
</html>