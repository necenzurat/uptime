<?php

/*
 * Pingdom Uptime Status
 * This source file is subject to Creative Commons Attribution 3.0.
 * License that is available at: http://creativecommons.org/licenses/by/3.0/
 * Design © Jonnie Hallman http://destroytoday.com/ jonnie@destroytoday.com
 * Code © Dmitriy Gavrilov http://gavrilov.me/ dmitriy@gavrilov.me
 */
date_default_timezone_set('Europe/Bucharest');

 	$settings = array(
 		'check_id' => '',
 		'username' => '',
 		'password' => '',
 		'api_key' => ''
 	);

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, 'https://api.pingdom.com/api/2.0/checks/' . $settings['check_id']);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($curl, CURLOPT_USERPWD, $settings['username'] . ':' . $settings['password']);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('App-Key: ' . $settings['api_key']));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$response = json_decode(curl_exec($curl), true);
	if (isset($response['error'])) {
		exit('Error: ' . $response['error']['errormessage']);
	}
	/* Debug shit
	echo time();
	echo " - ";
	echo $response['check']['lasterrortime'];
	*/
	$days = floor((time() - $response['check']['lasterrortime']) / 86400);
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
	<title>Uptime</title>
	<link href='uptime.css' type='text/css' rel='stylesheet' media='screen'>
</head>
<body>
	<div id='sign'>
		<div class='line'>This website</div>
		<div class='line'>has worked</div>
		<div class='line'>
			<div id='days-outer'>
				<div id='days-inner'><? echo $days; ?></div>
			</div>
			<div id='days-label'>days</div>
		</div>
		<div class='line'>without</div>
		<div class='line'>a lost time</div>
		<div class='line'>accident</div>
		<div class='caption-outer'>
			<div class='caption-inner'>Accidents are avoidable</div>
		</div>
	</div>
</body>
</html>
