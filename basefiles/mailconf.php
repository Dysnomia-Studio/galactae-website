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

			$data = $mongoDB->getCondContent("galactae","mailconfirmations",[
				"mailconfirm_uid" => $uid
			]);

			if(count($data) > 0 && isset($data[0])) {
				$data = (array) $data[0];
			}

			if(count($data) > 0 && isset($data["user_name"]) && $data["user_name"]==$username) {
				// Activate account
				$mongoDB->removeContent("galactae","mailconfirmations",[
					"_id" => $data["_id"]
				]);

				$mongoDB->updateContent("galactae","users",
					["_id" => $data["_id"]],
					["activated" => 1],	
				);

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