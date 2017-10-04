<?php
include_once('./basefiles/header.php');

$config['pass-minsize'] = 8;
$config['pass-maxsize'] = 20;

if((isset($_COOKIE['galactae-account-username']) && 
	$_COOKIE['galactae-account-username']!="" && 
	isset($_COOKIE['galactae-account-bid']) && 
	$_COOKIE['galactae-account-bid']!="" &&
	isset($_COOKIE['galactae-account-id']) && 
	$_COOKIE['galactae-account-id']!=0) ||
	(isset($_SESSION['username']) &&
	$_SESSION['username'] != "" &&
	isset($_SESSION['id']) &&
	$_SESSION['id'] !=0 &&
	isset($_SESSION['game_id']) &&
	$_SESSION['game_id'] != "")) {

	header('Location: portal');
}
?>
<body class="login-page">
	<ul>
		<li style="text-align: center;"><a href="index.html" style="color: white; text-decoration: none; font-weight: bold;"><img src="https://***REMOVED***/website/img/bannersAndLogos/logo-large-white.png" style="max-height: 6em;"></a></li>
	</ul>

	<section class="login" style="padding: 5px;">
		<?php
		// Set password
		if(isset($_POST['password'])) {
			$password = htmlentities(htmlspecialchars($_POST['password']));
			$confpassword = htmlentities(htmlspecialchars($_POST['confpassword']));
			$encpassword = encrypt($password);
			$uid = htmlentities(htmlspecialchars($_POST['pid']));
			$username = htmlentities(htmlspecialchars($_POST['username']));
			$mintime = time() - (24*60*60);
			$error = "";

			if(strlen($password)<$config['pass-minsize'] || 
				strlen($password)>$config['pass-maxsize']) { // Password size
				$error.= ERR_TOO_LONG_SHORT_PASS;
			} elseif(preg_match('/[^a-zA-Z_\-0-9]/i', $password)) { // Password Format
				$error.= ERR_NOT_VALID_PASS;
			} elseif($password==$confpassword) {
				$data = $sqlDB->getCondContent("user_passforgot",[
					["passforgot_uid",$uid,"str"]
				],0,1,"user_id");

				if($data!=false && isset($data[0])) {
					$data = $data[0];
				}

				if($data!=false && isset($data["user_name"]) && $data["user_name"]==$username && $data['passforgot_time'] > $mintime) { 
					// Set db
					/*$data = $sqlDB->removeContent("passforgot",[
						["user_id",$data["user_id"],"int"]
					]);*/

					$data = $sqlDB->updateContent("user_list",[
						["user_passwd",$encpassword,"str"],	
					],[
						["user_id",$data["user_id"],"int"]
					]);
				} else { // Invalid data
					$error.= PASS_INVALID_LINK.CLICK_HOME;
					exit(0);
				}
			} else {
				$error .= ERR_NOT_SAME_PASSWD;
			}

			if($error!="") {// Error message & form
				echo '
					<div id="login-section" class="login-onglet active-onglet" style="padding: 5px;">
						<p style="text-align: center;">'.$error.'</p>
						<form method="post" action="https://galactae.eu/changepassword">
							<input type="password" name="password" id="password" placeholder="'.LOGIN_PASSWORD.'">
							<input type="password" name="confpassword" id="confpassword" placeholder="'.LOGIN_CPASSWORD.'">
							<input type="hidden" name="pid" id="pid" value="'.$uid.'">
							<input type="hidden" name="username" id="username" value="'.$username.'">
							<input type="submit" value="'.PASS_SUBMIT.'">
						</form>
					</div>';
			} else {
				echo PASS_CHANGED.CLICK_LOGIN;
			}
			
		} else {
			if(isset($_GET['pid'])) {
				$uid = htmlentities(htmlspecialchars($_GET['pid']));
			} else {
				$uid = "";
			}
			if(isset($_GET['username'])) {
				$username = htmlentities(htmlspecialchars($_GET['username']));
			} else {
				$username = "";
			}
			$mintime = time() - (24*60*60);

			$data = $sqlDB->getCondContent("user_passforgot",[
				["passforgot_uid",$uid,"str"]
			],0,1,"user_id");

			if($data!=false && isset($data[0])) {
				$data = $data[0];
			}

			// Form
			if($data!=false && isset($data["user_name"]) && $data["user_name"]==$username && $data['passforgot_time'] > $mintime) { 
				echo '
					<div id="login-section" class="login-onglet active-onglet" style="padding: 5px;">
						<form method="post" action="https://galactae.eu/changepassword">
							<input type="password" name="password" id="password" placeholder="'.LOGIN_PASSWORD.'">
							<input type="password" name="confpassword" id="confpassword" placeholder="'.LOGIN_CPASSWORD.'">
							<input type="hidden" name="pid" id="pid" value="'.$uid.'">
							<input type="hidden" name="username" id="username" value="'.$username.'">
							<input type="submit" value="'.PASS_SUBMIT.'">
						</form>
					</div>';
			} else { // Invalid data
				echo PASS_INVALID_LINK.CLICK_HOME;
			}
		}
		?>
	</section>
</body>
</html>