<?php


/* gets the data from a URL */
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, 'https://mobile.njit.edu/parking/cached.php');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_REFERER, 'https://mobile.njit.edu/parking/data');

	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	echo $data;








?>