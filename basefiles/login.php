<?php
include_once('./basefiles/header.php');

if(isset($_COOKIE['galactae-phpsessid']) &&
	$_COOKIE['galactae-phpsessid'] != "") { // Connected ?

	$sess_data = $sqlDB->getCondContent("user_session",[
		["user_session_uid",$_COOKIE['galactae-phpsessid'],"str"]
		],0,1,"user_id");

	if($sess_data!=false && isset($sess_data[0])) {
		$sess_data = $sess_data[0];
	}

	if(isset($sess_data['user_id']) && isset($sess_data['user_session_expiration']) && ((int) $sess_data['user_session_expiration'] > time())) {
		$sqlDB->updateContent('user_session',
			[ ["user_session_expiration",time()+2678400,"int"] ],
			[ ["user_session_uid",$_COOKIE['galactae-phpsessid'],"str"] ]);

		$userData = $sqlDB->getCondContent("user_list",[
			["user_id",$sess_data['user_id'],"int"],
		],0,1,"user_id");

		if($userData!=false && isset($userData[0])) {
			$userData = $userData[0];
		}

		if(isset($userData["user_id"])) {
			header('Location: portal');
			exit();
		}
	}
}
?>
<body class="login-page">
	<ul>
		<li style="text-align: center;"><a href="index.html" style="color: white; text-decoration: none; font-weight: bold;"><img src="https://***REMOVED***/website/img/bannersAndLogos/logo-large-white.png" style="max-height: 6em;"></a></li>
	</ul>

	<script type="text/javascript">
		window.addEventListener('load',function() {
			function active(div) {
				document.getElementById(div+'-section').className = "login-onglet active-onglet";

				if(div=="forgot-pass") { div="login"; }
				document.getElementById(div+'-td').className = "active";
			}
			function desactive(div) {
				document.getElementById(div+'-section').className = "login-onglet";

				if(div=="forgot-pass") { div="login"; }
				document.getElementById(div+'-td').className = "";
			}

			document.getElementById('login-button').addEventListener('click', function() {
				desactive("register");
				desactive("forgot-pass");

				active("login");
			});

			function register() {
				desactive("login");
				desactive("forgot-pass");

				active("register");
			}
			document.getElementById('register-button').addEventListener('click', function() {
				register();
			});
			if(window.location.hash=="#register"){
				register();
			}

			document.getElementById('forgot-pass-button').addEventListener('click', function() {
				desactive("login");
				desactive("register");

				active("forgot-pass");
			});


			document.getElementById('rememberMe').addEventListener("change", function() {
				setCookie('rememberMe',document.getElementById('rememberMe').checked,30);
			});
		});
	</script>

	<section class="login">
		<table>
			<tr>
				<td class="active" id="login-td"><a href="#login" id="login-button"><?php echo LOGIN_LOGIN; ?></a></td>
				<td id="register-td"><a href="#register" id="register-button"><?php echo LOGIN_REG; ?></a></td>
			</tr>
		</table>

		<div id="login-section" class="login-onglet active-onglet">
			<form method="post" action="logconfirm">
				<input type="text" name="username" id="username" placeholder="<?php echo LOGIN_USERMAIL; ?>">
				<input type="password" name="password" id="password" placeholder="<?php echo LOGIN_PASSWORD; ?>">
				<span class="login-checkbox">
					<input type="checkbox" name="rememberMe" id="rememberMe"
					<?php
					var_dump($_COOKIE['rememberMe']);
					if(!isset($_COOKIE['rememberMe']) || $_COOKIE['rememberMe'] != false || $_COOKIE['rememberMe'] != "false") {
						echo "checked";
					}
					?>
					>
					<?php echo LOGIN_REMEMBER; ?>
				</span>
				<input type="submit" value="<?php echo LOGIN_LOGIN; ?>">
			</form>
			<a href="#forgotmypass" id="forgot-pass-button"><?php echo LOGIN_FORGOTPASS; ?></a>
		</div>

		<div id="forgot-pass-section" class="login-onglet">
			<form method="post" action="forgotmypass">
				<?php echo LOGIN_FORGOTPASS; ?><br/>
				<input type="text" name="username" id="username" placeholder="<?php echo LOGIN_USERMAIL; ?>">
				<input type="submit" value="<?php echo LOGIN_FORGOT_SUBMIT; ?>">
			</form>
		</div>

		<div id="register-section" class="login-onglet">
			<form method="post" action="regconfirm">
				<input type="text" name="username" id="username" placeholder="<?php echo LOGIN_USERNAME; ?>" required>
				<input type="text" name="mail" id="mail" placeholder="<?php echo LOGIN_MAIL; ?>" required>
				<input type="password" name="password" id="password" placeholder="<?php echo LOGIN_PASSWORD; ?>" required>
				<input type="password" name="confpassword" id="confpassword" placeholder="<?php echo LOGIN_CPASSWORD; ?>" required>
				<span class="login-checkbox"><input type="checkbox" name="cg" id="cg" value="checked" required><?php echo LOGIN_CG; ?></span>
				<span class="login-checkbox"><input type="checkbox" name="newsletter_update" id="newsletter_update" value="checked" checked><?php echo LOGIN_NEWS_UPDATE; ?></span>
				<span class="login-checkbox"><input type="checkbox" name="newsletter_miscellaneous" id="newsletter_miscellaneous" value="checked"><?php echo LOGIN_NEWS_MISC; ?></span>
				<input type="submit" value="<?php echo LOGIN_REG; ?>">
			</form>
		</div>
	</section>
</body>
</html>