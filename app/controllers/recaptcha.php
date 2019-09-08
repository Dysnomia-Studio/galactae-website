<?php
$recaptchaOK = false;

if(!empty($variablesPost["g-recaptcha-response"])) {
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array(
		'secret' => '***REMOVED***',
		'response' => $variablesPost["g-recaptcha-response"]
	);
	$query = http_build_query($data);
	$options = array(
		'http' => array (
		'header' => 'Content-Type: application/x-www-form-urlencoded\r\nContent-Length: '.strlen($query).'\r\n',
			'method' => 'POST',
			'content' => $query,
		)
	);
	$context  = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$resp=json_decode($verify);

	$recaptchaOK = true;

	if ($resp == null ||
		!$resp->success) {

		$recaptchaOK = false;
	}
}