<?php
if(!(isset($_COOKIE['galactae-phpsessid']) &&
	$_COOKIE['galactae-phpsessid'] != "")) { // Not Connected

	header('Location: index');
}

$sess_data = $mongoDB->getCondContent("galactae","sessions",
	["user_session_uid" => $_COOKIE['galactae-phpsessid']
);

if(size($sess_data) > 0 && isset($sess_data[0])) {
	$sess_data = (array) $sess_data[0];
}

if(isset($sess_data['user_id']) && isset($sess_data['user_session_expiration']) && ((int) $sess_data['user_session_expiration'] > time())) {
	if(!isset($sess_data['user_agent']) || $sess_data['user_agent'] != $_SERVER['HTTP_USER_AGENT']) {
		header('Location: index');
		exit();
	}

	$mongoDB->updateContent("galactae","sessions",
		["user_session_uid" => $_COOKIE['galactae-phpsessid']],
		[
		 	"user_session_expiration" => (time()+$expTime),
			"user_session_lang" => $lang->getLanguage()
		]		
	);
} else {
	header('Location: index');
	exit();
}

$userData = $mongoDB->getCondContent("galactae","users",
	["user_id" => $sess_data['user_id']]
);

if(size($userData) > 0 && isset($userData[0])) {
	$userData = (array) $userData[0];
}

if(!isset($userData["user_id"])) {
	header('Location: index');
	exit();
}

if(!isset($_SESSION['user_session_lang'])) {
	$_SESSION['lang'] = $sess_data['user_session_lang'];
}
?>