<?php //deletefile.php
	$flname = 'testfile2.new';
	rmdir('new');
	if(!unlink($flname))
		echo "Удаление невозможно";
	else
		echo "Файл $flname удалён успешно";
?>