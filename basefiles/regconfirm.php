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
						<td>Galactae: Space Age Dawn - Copyright 2016-2017</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
				</table>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
	</table>
</body>
</html>';

include_once('./basefiles/header.php');

$message = "";

$config['name-minsize'] = 3;
$config['name-maxsize'] = 20;

$config['pass-minsize'] = 8;
$config['pass-maxsize'] = 20;

$user_name = htmlentities(htmlspecialchars($_POST['username']));
$user_mail = htmlentities(htmlspecialchars($_POST['mail']));
$user_passwd = htmlentities(htmlspecialchars($_POST['password']));
$user_confpasswd = htmlentities(htmlspecialchars($_POST['confpassword']));
$user_encpasswd = encrypt($user_passwd);

if(!isset($_POST['newsletter_miscellaneous']) || $_POST['newsletter_miscellaneous']!="checked") {
	$user_news_misc = 0;
} else {
	$user_news_misc = 1;
}

if(!isset($_POST['newsletter_update']) || $_POST['newsletter_update']!="checked") {
	$user_news_updates = 0;
} else {
	$user_news_updates = 1;
}


/* Verifications */
if(empty($user_name) ||
	empty($user_passwd) ||
	empty($user_mail)) { // No input empty

	$message = ERR_FIELD.' '.CLICK_BACK;
} elseif(!isset($_POST['cg']) || $_POST['cg']!="checked") {
	$message = ERR_CG.' '.CLICK_BACK;
} elseif($user_passwd!=$user_confpasswd) { // Same Passwords
	$message = ERR_NOT_SAME_PASSWD.' '.CLICK_BACK;
} elseif(!preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $user_mail)) { // Mail Format
	$message = ERR_NOT_VALID_MAIL.' '.CLICK_BACK;
} elseif(strlen($user_name)<$config['name-minsize'] || 
	strlen($user_name)>$config['name-maxsize']) { // Username size
	$message = ERR_TOO_LONG_SHORT_USERNAME.' '.CLICK_BACK;
} elseif(preg_match('/[^a-zA-Z_\-0-9]/i', $user_name)) { // Username Format
	$message = ERR_NOT_VALID_USERNAME.' '.CLICK_BACK;
} elseif(strlen($user_passwd)<$config['pass-minsize'] || 
	strlen($user_passwd)>$config['pass-maxsize']) { // Password size
	$message = ERR_TOO_LONG_SHORT_PASS.' '.CLICK_BACK;
} elseif(preg_match('/[^a-zA-Z_\-0-9]/i', $user_passwd)) { // Password Format
	$message = ERR_NOT_VALID_PASS.' '.CLICK_BACK;
} else {
	// Account exists ?
	$data = $sqlDB->getCondContent("user_list",[
	["user_name",$user_name,"str"],
	],0,1,"user_id");

	if($data==false) { //Test with mail
		$data = $sqlDB->getCondContent("user_list",[
		["user_mail",$user_mail,"str"],
		],0,1,"user_id");
	} 

	if($data!=false) {
		$message = ERR_ACCOUNT_EXISTS.' '.CLICK_BACK;
	}
}


// Draw message
if($message=="") {
	// Add user
	$sqlDB->addContent('user_list',[
		["user_name",$user_name,"str"],
		["user_mail",$user_mail,"str"],
		["user_passwd",$user_encpasswd,"str"],
		["newsletter_misc",$user_news_misc,"int"],
		["newsletter_updates",$user_news_updates,"int"],
	]);

    $data = $sqlDB->getCondContent("user_list",[
    	["user_name",$user_name,"str"],
    ],0,1,"user_id");

    if($data!=false && isset($data[0]) && isset($data[0]['user_id'])) {
		$data = $data[0];
	}

	$conf_link = encrypt(time().$user_name);

	$sqlDB->addContent('user_mailconfirm',[
		["user_id",$data["user_id"],"int"],
		["user_name",$data["user_name"],"str"],
		["mailconfirm_uid",$conf_link,"str"],
	]);

	$conf_link = "https://galactae.eu/mailconf?mid=".$conf_link."&username=".$user_name;

	require_once './lib/swiftmailer/swift_required.php';

	// Create the Transport
	$mail_transport = Swift_SmtpTransport::newInstance('***REMOVED***', 465, 'ssl')
	  ->setUsername('***REMOVED***')
	  ->setPassword('***REMOVED***')
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
<body class="login-page">
	<ul>
		<li style="text-align: center;"><a href="index.html" style="color: white; text-decoration: none; font-weight: bold;">GALACTAE: SPACE AGE DAWN</a></li>
	</ul>
		<section class="login" style="color: white; padding: 1em;">
			<?php
			// Draw message and/or error
			echo $message;
			?>
		</section>
</body>