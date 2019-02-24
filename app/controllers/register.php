<?php
$mail = array();
$mail[0] = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>'; 
// Title
$mail[1] = '</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<style>
	@import url(\'https://fonts.googleapis.com/css?family=Titillium+Web\');
	@media all and (max-width: 600px) {
		table, img[class="banner"] {
			width: 100%;
		}
	}
</style>
</head>
<body style="margin: 0; padding: 0;" bgcolor="#0b1012">
	<table align="center" style="margin: 0; padding: 0; width: 100%; font-family: \'Titillium Web\', sans-serif;" cellpadding="0" cellspacing="0" bgcolor="#0b1012">
		<tr>
			<td align="center">
				<table width="600" style="border-collapse: collapse;">
					<tr height="134">
						<td>
							<img alt="logo" class="banner" src="https://***REMOVED***/website/img/bannersAndLogos/banner.jpg" width="600"  alt="Galactae: Space Age Dawn">
						</td>
					</tr>
					<tr style="line-height: 0.5em;"><td>&nbsp;</td></tr>
					<tr style="color: #93fcfb;">
						<td style="padding: 0.2em 0.8em 0.2em 0.8em;">
							<table style="max-width: 600px;"><tr><td>';
// Mail text
$mail[2] = '		</td>
					</tr>
					</table>
					</tr>
					<tr style="line-height: 1.5em;"><td>&nbsp;</td></tr>
					<tr style="color: white; font-size: 0.8em;">
						<td align="center" style="padding: 0.2em 1em 0.2em 1em;">';
// no-reply text
$mail[3] = '		</td>
					</tr>
					<tr style="line-height: 2em;"><td>&nbsp;</td></tr>
					<tr align="center">
						<td>
						<a href="https://galactae.eu/redir/facebook.php">
							<img src="https://***REMOVED***/website/img/logos/facebook.png" alt="Facebook">
						</a> 
						<a href="https://galactae.eu/redir/twitter.php">
							<img src="https://***REMOVED***/website/img/logos/twitter.png" alt="Twitter">
						</a>
						<a href="https://galactae.eu/redir/youtube.php">
							<img src="https://***REMOVED***/website/img/logos/youtube.png" alt="Youtube">
						</a>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr style="color: white; font-size: 0.8em;" align="center">
						<td>Galactae: Space Age Dawn - Copyright 2016-'.date('Y').'</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
				</table>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
	</table>
</body>
</html>';

$userMngr = new UserManager();

$message = '';

$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = array(
	'secret' => '***REMOVED***',
	'response' => $variablesPost["g-recaptcha-response"]
);
$query = http_build_query($data);
$options = array(
	'http' => array (
	'header' => 'Content-Type: application/x-www-form-urlencoded\r\n'.
				'Content-Length: '.strlen($query).'\r\n',
		'method' => 'POST',
		'content' => $query,
	)
);
$context  = stream_context_create($options);
$verify = file_get_contents($url, false, $context);
$resp=json_decode($verify);

if(!isset($_POST['newsletter_miscellaneous']) || $_POST['newsletter_miscellaneous']!='checked') {
	$user_news_misc = 0;
} else {
	$user_news_misc = 1;
}

if(!isset($_POST['newsletter_update']) || $_POST['newsletter_update']!='checked') {
	$user_news_updates = 0;
} else {
	$user_news_updates = 1;
}

/* Verifications */
if(isset($_POST['username']) &&
	isset($_POST['mail']) &&
	isset($_POST['password']) &&
	isset($_POST['confpassword'])) {
$user_name = htmlentities(htmlspecialchars($_POST['username']));
$user_mail = htmlentities(htmlspecialchars($_POST['mail']));
$user_passwd = htmlentities(htmlspecialchars($_POST['password']));
$user_confpasswd = htmlentities(htmlspecialchars($_POST['confpassword']));
$user_encpasswd = Security::hashPassword($user_passwd, 1);
} else {
	$message = ERR_FIELD.' '.CLICK_BACK;
}

if ($resp == null || 
	!$resp->success ||
	!isset($user_name) || 
	empty($user_name) ||
	empty($user_passwd) ||
	empty($user_mail)) { // One of input empty

	$message = ERR_FIELD.' '.CLICK_BACK;
} elseif(!isset($_POST['cg']) || $_POST['cg']!='checked') {
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
?>