<?php
include_once('./basefiles/header.php');

$message = "";

$config['name-minsize'] = 3;
$config['name-maxsize'] = 20;

$config['pass-minsize'] = 8;
$config['pass-maxsize'] = 20;

/* Verifications */
if(!isset($_POST['username']) ||
	!isset($_POST['password']) ||
	!isset($_POST['mail']) ||
	empty($_POST['username']) ||
	empty($_POST['password']) ||
	empty($_POST['mail'])) { // No input empty

	$message = ERR_FIELD.' '.CLICK_BACK;
} elseif(!isset($_POST['cg']) || $_POST['cg']!="checked") {
	$message = ERR_CG.' '.CLICK_BACK;
} elseif($_POST['password']!=$_POST['confpassword']) { // Same Passwords
	$message = ERR_NOT_SAME_PASSWD.' '.CLICK_BACK;
} elseif(!preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['mail'])) { // Mail Format
	$message = ERR_NOT_VALID_MAIL.' '.CLICK_BACK;
} elseif(strlen($_POST['username'])<$config['name-minsize'] || 
	strlen($_POST['username'])>$config['name-maxsize']) { // Username size
	$message = ERR_TOO_LONG_SHORT_USERNAME.' '.CLICK_BACK;
} elseif(preg_match('/[^a-zA-Z_\-0-9]/i', $_POST['username'])) { // Username Format
	$message = ERR_NOT_VALID_USERNAME.' '.CLICK_BACK;
} elseif(strlen($_POST['password'])<$config['pass-minsize'] || 
	strlen($_POST['password'])>$config['pass-maxsize']) { // Password size
	$message = ERR_TOO_LONG_SHORT_PASS.' '.CLICK_BACK;
} elseif(preg_match('/[^a-zA-Z_\-0-9]/i', $_POST['password'])) { // Password Format
	$message = ERR_NOT_VALID_PASS.' '.CLICK_BACK;
} else {
	// Account exists ?
	$data = $db->getCondContent("users",[
	["user_name",strtolower($_POST['username']),"str"],
	],0,1,"user_id");

	if($data==false) { //Test with mail
		$data = $db->getCondContent("users",[
		["user_mail",strtolower($_POST['mail']),"str"],
		],0,1,"user_id");
	} 
	if(!$data) {
		$data = $data[0];
	}

	if($data!=false) {
		$message = ERR_ACCOUNT_EXISTS.' '.CLICK_BACK;
	}
}


// Draw message
if($message=="") {
	// Add user
	$db->addContent('users',[
		["user_name",strtolower($_POST['username']),"str"],
		["user_mail",$_POST['mail'],"str"],
		["user_passwd",encrypt($_POST['password']),"str"],
		["game_id","-1","str"]
	]);

	$message = ACTIVATION.' '.CLICK_HOME;
}
?>
<body class="login-page">
	<ul>
		<li style="text-align: center;"><a href="index.html" style="color: white; text-decoration: none; font-weight: bold;">GALACTAE: SPACE AGE RISING</a></li>
	</ul>
		<section class="login" style="color: white; padding: 1em;">
			<?php
			// Draw message and/or error
			echo $message;
			?>
		</section>
</body>