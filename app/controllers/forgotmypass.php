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

$_POST['username'] = (isset($_POST['username'])) ? $_POST['username'] : '';
$user_name = htmlentities(htmlspecialchars($_POST['username']));

// Account exists ?
$userMngr = new UserManager();
$data = $userMngr->getGlobalUserByCaseInsensitiveName($user_name);

if(isset($data['user_name'])) {
	// Send mail
	$passwd_link = Security::hashV1(time().$user_name);

	$mongoDB = new MongoInterface();
	$mongoDB->addContent('galactae','recoverpasses',[
		'user_id' => $data['_id'],
		'user_name' => $data['user_name'],
		'passforgot_uid' => $passwd_link,
		'passforgot_time' => time()
	]);

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