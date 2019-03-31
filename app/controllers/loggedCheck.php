<?php
$userMngr = new UserManager();

if(isset($_COOKIE['galactae-phpsessid']) &&
	$_COOKIE['galactae-phpsessid'] != '') { // Connected ?

	$sess_data = $userMngr->getUserBySession($_COOKIE['galactae-phpsessid']);

	if(isset($sess_data['user_id']) && isset($sess_data['user_session_expiration']) && ((int) $sess_data['user_session_expiration'] > time())) {
		$browser = new Browser();

		if(isset($sess_data['user_agent']) && $sess_data['user_agent'] == $browser->getPlatform().'-'.$browser->getBrowser()) {

			$userMngr->updateUserSession();
			$userData = $userMngr->getGlobalUserById($sess_data['user_id']);

			if(isset($userData['id'])) {
				header('Location: portal');
				exit();
			}
		}
	}
} 