	<div class="footer">
	<?php
		echo $footer . " ";
		// date($format, $timestamp);
		echo "Today is " . date("l F jS, Y - G:i:s", time());
		#string date ( string $format [, int $timestamp = time() ] )

		if(!isset($_SESSION['ip']) && !isset($_SESSION['ua']))
			die("Что-то пошло не так");
	?>

	</div>
</body>
</html>