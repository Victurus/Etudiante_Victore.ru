<?php
	$fh = fopen("testfile.txt", "a+") or die("Failed to create file");
	$text = <<<_END
	Строка 4
	Строка 5
	Строка 6 \n
_END;

	fwrite($fh, $text) or die("Could not wright to file");
	fclose($fh);
	echo "File 'testfile.txt' written successfully";
?>