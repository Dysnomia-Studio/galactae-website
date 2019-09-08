<?php
$variablesPost = [];

foreach($_POST as $key => $value) {
	$variablesPost[htmlspecialchars(trim($key), ENT_QUOTES | ENT_HTML5, 'UTF-8')] = htmlspecialchars(trim($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

// Mail template
require_once(DIR_VIEW.'mail_forgotmypass.php');

// Recaptcha check
require_once(DIR_CTRL.'recaptcha.php');

// Account exists ?
$data = [];

if(!empty($variablesPost['username'])) {
	$userMngr = new UserManager();
	$data = $userMngr->getGlobalUserByCaseInsensitiveName($variablesPost['username']);
}

if(isset($data['user_name'])) {
	// Send mail
	$passwd_link = Security::hashV1(time().$variablesPost['username']);

	$sqlDB = new SQLInterface();
	$sqlDB->addContent('recoverpasses',[[
			'user_id' => $data['id'],
			'user_name' => $data['user_name'],
			'passforgot_uid' => $passwd_link,
			'passforgot_time' => time()
		]]);

	$passwd_link = 'https://galactae.eu/changepassword?pid='.$passwd_link.'&username='.$data['user_name'];

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
	$mail_content = Swift_Message::newInstance(LOGIN_PASS_RESET)
	  ->setFrom(array('***REMOVED***' => 'Galactae: Space Age Dawn'))
	  ->setTo(array($data['user_mail'] => $data['user_name']))
	  ->setBody( $mail[0].LOGIN_PASS_RESET.$mail[1].PASS_MAIL_1.':
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
    max-width: 600px; "><td><a style="color: white;" href="'.$passwd_link.'">'.$passwd_link.'</a></td></tr><tr><td>'.PASS_MAIL_2.$mail[2].MAIL_NOREPLY.$mail[3], 'text/html')
	  ->addPart(LOGIN_PASS_RESET.'
'.PASS_MAIL_1.'
'.$passwd_link.'
'.PASS_MAIL_2.'
'.MAIL_NOREPLY,'text/plain')
	  ;

	// Send the message
	$result = $mail_mailer->send($mail_content);

	// Message
	$message = PASS_MAIL_SEND.' '.CLICK_HOME;
} else {
	$message = ERR_ACCOUNT_NOT_EXISTS.' '.CLICK_HOME;
}