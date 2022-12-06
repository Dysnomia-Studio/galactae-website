<?php
foreach($_POST as $key => $value) {
	$variablesPost[htmlspecialchars(trim($key), ENT_QUOTES | ENT_HTML5, 'UTF-8')] = htmlspecialchars(trim($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

// Mail template
require_once(DIR_VIEW.'mail_register.php');

$userMngr = new UserManager();

$message = '';

if(!isset($variablesPost['newsletter_miscellaneous']) || $variablesPost['newsletter_miscellaneous']!='checked') {
	$user_news_misc = 0;
} else {
	$user_news_misc = 1;
}

if(!isset($variablesPost['newsletter_update']) || $variablesPost['newsletter_update']!='checked') {
	$user_news_updates = 0;
} else {
	$user_news_updates = 1;
}

/* Verifications */
if(isset($variablesPost['username']) &&
	isset($variablesPost['mail']) &&
	isset($variablesPost['password']) &&
	isset($variablesPost['confpassword'])) {
$user_name = htmlentities(htmlspecialchars($variablesPost['username']));
$user_mail = htmlentities(htmlspecialchars($variablesPost['mail']));
$user_passwd = htmlentities(htmlspecialchars($variablesPost['password']));
$user_confpasswd = htmlentities(htmlspecialchars($variablesPost['confpassword']));
$user_encpasswd = Security::hashPassword($user_passwd, 1);
} else {
	$message = ERR_FIELD.' '.CLICK_BACK;
}

// Captcha check
require_once(DIR_CTRL.'checkCaptcha.php');

if (!$captchaOK || (isset($_POST['otherField']) && !empty($_POST['otherField'])) || $message != '') { // One of input empty
	$message = ERR_FIELD.' '.CLICK_BACK;
} elseif(!isset($variablesPost['cg']) || $variablesPost['cg']!='checked') {
	$message = ERR_CG.' '.CLICK_BACK;
} elseif($user_passwd!=$user_confpasswd) { // Same Passwords
	$message = ERR_NOT_SAME_PASSWD.' '.CLICK_BACK;
} elseif(!preg_match('#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#', $user_mail) || Mail::isBlacklisted($user_mail)) { // Mail Format
	$message = ERR_NOT_VALID_MAIL.' '.CLICK_BACK;
} elseif(strlen($user_name)<$config['name-minsize'] ||
	strlen($user_name)>$config['name-maxsize']) { // Username size
	$message = ERR_TOO_LONG_SHORT_USERNAME.' '.CLICK_BACK;
} elseif(preg_match('/[^a-zA-Z_\-0-9]/i', $user_name)) { // Username Format
	$message = ERR_NOT_VALID_USERNAME.' '.CLICK_BACK;
} elseif(strlen($user_passwd)<$config['pass-minsize']) { // Password size
	$message = ERR_TOO_LONG_SHORT_PASS.' '.CLICK_BACK;
} else {
	// Account exists ?
	$data = $userMngr->getGlobalUserByCaseInsensitiveName($user_name);

	if(isset($data) && isset($data['user_name'])) {
		$message = ERR_ACCOUNT_EXISTS.' '.CLICK_BACK;
	}

	$data = $userMngr->getGlobalUserByCaseInsensitiveName($user_mail);

	if(isset($data) && isset($data['user_mail'])) {
		$message = ERR_ACCOUNT_EXISTS.' '.CLICK_BACK;
	}
}

// Draw message
if($message=='') {
	// Add user
	$conf_link = $userMngr->addGlobalUser(
		$user_name,
		$user_mail,
		$user_encpasswd,
		$user_news_misc,
		$user_news_updates
	);

	require_once '../lib/swiftmailer/swift_required.php';

	// Create the Transport
    $mail_transport = Swift_SmtpTransport::newInstance('***REMOVED***', 587, 'tls')
      ->setUsername('***REMOVED***')
      ->setPassword('***REMOVED***')
      ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer_name' => false, 'verify_peer' => false)))
      ;

	// Create the Mailer using your created Transport
	$mail_mailer = Swift_Mailer::newInstance($mail_transport);

	// Create a message
	$mail_content = Swift_Message::newInstance(LOGIN_REG)
	  ->setFrom(array('***REMOVED***' => 'Galactae: Space Age Dawn'))
	  ->setTo(array($user_mail => $user_name))
	  ->setBody( $mail[0].LOGIN_REG.$mail[1].REGISTER_MAIL_TEXT_1.':
	  	</td></tr><tr style="    overflow-wrap: break-word;
    word-wrap: break-word;
    -ms-word-break: break-all;
    word-break: break-all;
    word-break: break-word;
    -ms-hyphens: auto;
    -moz-hyphens: auto;
    -webkit-hyphens: auto;
    hyphens: auto;
    display: inline-block;
    max-width: 600px; "><td><a style="color: white;" href="'.$conf_link.'">'.$conf_link.'</a></td></tr><tr><td>'.REGISTER_MAIL_TEXT_2.$mail[2].MAIL_NOREPLY.$mail[3], 'text/html')
	  ->addPart(REGISTER_MAIL_TEXT_1.'
'.$conf_link.'
'.REGISTER_MAIL_TEXT_2.'
'.MAIL_NOREPLY,'text/plain')
	  ;

	// Send the message
	$result = $mail_mailer->send($mail_content);

	$message = ACTIVATION.' '.CLICK_HOME;
}