<?php
if(!(isset($_COOKIE['galactae-phpsessid']) &&
	$_COOKIE['galactae-phpsessid'] != "")) { // Not Connected

	header('Location: index');
}

$sess_data = $sqlDB->getCondContent("user_session",[
	["user_session_uid",$_COOKIE['galactae-phpsessid'],"str"]
	],0,1,"user_id");

if($sess_data!=false && isset($sess_data[0])) {
	$sess_data = $sess_data[0];
}

if(isset($sess_data['user_id']) && isset($sess_data['user_session_expiration']) && ((int) $sess_data['user_session_expiration'] > time())) {
	if(!isset($sess_data['user_agent']) || $sess_data['user_agent'] != $_SERVER['HTTP_USER_AGENT']) {
		header('Location: index');
		exit();
	}

	$sqlDB->updateContent('user_session',
		[ ["user_session_expiration",time()+2678400,"int"] ],
		[ ["user_session_uid",$_COOKIE['galactae-phpsessid'],"str"] ]);
} else {
	header('Location: index');
	exit();
}

$userData = $sqlDB->getCondContent("user_list",[
	["user_id",$sess_data['user_id'],"int"],
	],0,1,"user_id");

if($userData!=false && isset($userData[0])) {
	$userData = $userData[0];
}

if(!isset($userData["user_id"])) {
	header('Location: index');
	exit();
}
?>