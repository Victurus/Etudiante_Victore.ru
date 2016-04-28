<?php //exec.php
	$cmd = "ls -l";
	exec(escapeshellcmd($cmd), $output, $status);

	if($status) 
		echo "";
	else
	{
		echo "<pre>";
		foreach($output as $line) 
			echo htmlspecialchars("$line\n");
		echo "</pre>";
	}
?>