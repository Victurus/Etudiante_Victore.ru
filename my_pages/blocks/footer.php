	<div class="footer">
		<?php
			echo $footer . " ";
			// date($format, $timestamp);
			echo "Today is " . date("l F jS, Y - G:i:s", time());
			#string date ( string $format [, int $timestamp = time() ] )
		?>
	</div>
</body>
</html>