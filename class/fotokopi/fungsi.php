<?php
	$nilai = array(1,2,3,4,5);
	$pPol = 10;
	$result = 0;

	foreach ($nilai as $key) {
		$result = $result + $key * $key;		
	}
	// echo $result * $pPol;
	echo "$result<br>";

?>