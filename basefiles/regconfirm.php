<?php
include_once('./basefiles/header.php');

$message = "";
$config = array();
$config['name-minsize'] = 3;
$config['name-maxsize'] = 20;

if(empty($_POST['username']) || empty($_POST['password'])  || empty($_POST['mail']) || empty($_POST['cg'])) {
	// Empty form ?
	$message = ERR_FIELD.' '.CLICK_BACK;
} else {
	if($_POST['password']==$_POST['confpassword']) { // Same password
		if(strlen($_POST['username'])<$config['name-minsize'] || strlen($_POST['username'])>$config['name-maxsize']) {
			// Valid username ?
			$message = TOO_LONG_SHORT_USERNAME.' '.CLICK_BACK;
		} else { 
			// Valid mail format ?
			if (!preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['mail'])) {
				$message = NOT_VALID_MAIL.' '.CLICK_BACK;
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

			    	if($data==false) {
			    		// Add user
						$db->addContent('users',[
							["user_name",strtolower($_POST['username']),"str"],
							["user_mail",$_POST['mail'],"str"],
							["user_passwd",encrypt($_POST['password']),"str"],
							["game_id","-1","str"]
						]);

						$message = ACTIVATION.' '.CLICK_HOME;
					} else {
						$message = ACCOUNT_EXISTS.' '.CLICK_BACK;
					}
			}
		}
	} else {
		$message = NOT_SAME_PASSWD.' '.CLICK_BACK;
	}
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