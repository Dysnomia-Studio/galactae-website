<?php
foreach($_POST as $key => $value) {
	$variablesPost[htmlspecialchars(trim($key), ENT_QUOTES | ENT_HTML5, 'UTF-8')] = htmlspecialchars(trim($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

$message = '';
$sqlDB = new SQLInterface();
$newData = [];

// Newsletter
$newData['newsletter_misc'] = (isset($variablesPost['newsletter_misc']) ? 1 : 0);
$newData['newsletter_updates'] = (isset($variablesPost['newsletter_updates']) ? 1 : 0);

// Password
if(!empty($variablesPost['newpassword'])) {

	if(!empty($variablesPost['oldpassword']) && !empty($variablesPost['confpassword'])) {

		if(Security::hashPassword($variablesPost['oldpassword']) == $userData['user_passwd']) {

			if($variablesPost['newpassword'] == $variablesPost['confpassword']) {

				if(strlen($variablesPost['newpassword'])<$config['pass-minsize']) { // Password size
					$message = ERR_TOO_LONG_SHORT_PASS.' '.CLICK_BACK;
				} else {
					$newData['user_passwd'] = Security::hashPassword($variablesPost['newpassword'], 1);
				}
				
			} else {
				$message = ERR_NOT_SAME_PASSWD.' '.CLICK_BACK;
			}

		} else {
			$message = ERR_INCORRECT_PASSWD.' '.CLICK_BACK;
		}

	} else {
		$message = ERR_FIELD.' '.CLICK_BACK;
	}

}

$oldmessage = $message;

if($message == '') {
	$message = PROFIL_EDIT_SUCCESS.' '.CLICK_GAME;

	// Update db
	$sqlDB->updateContent('users',
		$newData,
		['id' => $userData['id']]
	);
}