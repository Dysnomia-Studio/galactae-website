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
		<li style="text-align: center;"><a href="index.html" style="color: white; text-decoration: none; font-weight: bold;"><img src="img/logo-large-white.png" style="max-height: 6em;"></a></li>
	</ul>

	<section class="login">
		<?php 
			$uid = htmlentities(htmlspecialchars($_GET['mid']));
			$username = htmlentities(htmlspecialchars($_GET['username']));

			$data = $sqlDB->getCondContent("user_mailconfirm",[
				["mailconfirm_uid",$uid,"str"]
			],0,1,"user_id");

			if($data!=false && isset($data[0])) {
				$data = $data[0];
			}

			if($data!=false && isset($data["user_name"]) && $data["user_name"]==$username) {
				// Activate account
				$sqlDB->removeContent("user_mailconfirm",[
					["user_id",$data["user_id"],"int"]
				]);

				$sqlDB->updateContent("user_list",[
					["activated",1,"int"],	
				],[
					["user_id",$data["user_id"],"int"]
				]);
				// Draw message
				echo '<div id="login-section" class="login-onglet active-onglet" style="padding: 5px;">
					<p style="text-align: center;">'.ACCOUNT_ACTIVATED.'</p>
					<form method="post" action="https://galactae.eu/logconfirm">
						<input type="text" name="username" id="username" placeholder="'.LOGIN_USERMAIL.'">
						<input type="password" name="password" id="password" placeholder="'.LOGIN_PASSWORD.'">
						<input type="submit" value="'.LOGIN_LOGIN.'">
					</form>
				</div>';
			} else {
				echo '<div id="login-section" class="login-onglet active-onglet" style="padding: 5px;">
					<p style="text-align: center;">'.ACCOUNT_NOT_ACTIVATED.CLICK_HOME.'</p></div>';
			}
		?>
	</section>
</body>
</html>