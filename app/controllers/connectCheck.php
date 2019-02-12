<?php
/**
 * Do not call it directly
 */
if($pageData['pageName'] == "connectCheck.php") {
	http_response_code(404);
	include_once('../errors/404.html');
	die();
}

/**
 * Have session cookie ?
 */
if(!isset($_COOKIE['galactae-phpsessid']) ||
	empty($_COOKIE['galactae-phpsessid']) ||
	$_COOKIE['galactae-phpsessid'] == '') { // Not Connected

	header('Location: index');
}

$userMngr = new UserManager();

/**
 * Is Connected ?
 */
$sess_data = $userMngr->getUserBySession($_COOKIE['galactae-phpsessid']);

if(isset($sess_data['user_id']) && isset($sess_data['user_session_expiration']) && ((int) $sess_data['user_session_expiration'] > time())) {

	$browser = new Browser();

	/**
	 * Check user Agent
	 */
	if(!isset($sess_data['user_agent']) || $sess_data['user_agent'] != $browser->getPlatform().'-'.$browser->getBrowser()) {
		http_response_code(404);
		include_once('../errors/404.html');
		die();
	}

	$userMngr->updateUserSession();
	
} else {
	header('Location: index');
	exit();
}

/**
 * Get user Data
 */
$userData = $userMngr->getGlobalUserById($sess_data['user_id']);

/**
 * Get Language
 */
if(isset($userData['user_session_lang']) && $lang->getLanguage() != $userData['user_session_lang']
		&& !(isset($_POST['selected-language']) && !empty($_POST['selected-language']))) {

	$lang->setLanguage($userData['user_session_lang']);
}

if(!isset($userData['_id'])) {
	header('Location: index');
	exit();
}
?>