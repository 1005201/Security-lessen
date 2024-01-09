<?php
function register($woonplaats, $verkoper)
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,"http://127.0.0.1/security/les2/register.php");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
				"postvar1=value1&postvar2=value2&postvar3=value3");

	// In real life you should use something like:
	 curl_setopt($ch, CURLOPT_POSTFIELDS, 
			  http_build_query(array('woonplaats' => $woonplaats, 'verkoper' => $verkoper)));

	// Receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);

	curl_close ($ch);
}

for($i = 0; $i < 10; $i++)
{
	$verkoper = rand(1000,10000);
	$woonplaats = rand(123123, 123123123);
	register($woonplaats, $verkoper);
}
