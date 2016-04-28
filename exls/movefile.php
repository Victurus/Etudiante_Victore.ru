<?php 
	$dir = 'new/testfile2.new';
	mkdir("new");
	if(!rename('testfile.txt', $dir))
		echo "Переименование невозможно";
	else
		echo "Файл успешно переименован в $dir";
?>
