<?php
include_once('./basefiles/header.php');

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
		<li style="text-align: center;"><a href="index.html" style="color: white; text-decoration: none; font-weight: bold;">GALACTAE: SPACE AGE RISING</a></li>
	</ul>

	<script type="text/javascript">
		window.addEventListener('load',function() {
			function register() {
					/* Buttons Colors */
					document.getElementById('login-td').className = "";
					document.getElementById('register-td').className = "active";

					/* Onglets */
					document.getElementById('register-section').className = "login-onglet active-onglet";
					document.getElementById('login-section').className = "login-onglet";
			}

			function login() {
					/* Buttons Colors */
					document.getElementById('register-td').className = "";
					document.getElementById('login-td').className = "active";

					/* Onglets */
					document.getElementById('login-section').className = "login-onglet active-onglet";
					document.getElementById('register-section').className = "login-onglet";
			}


			document.getElementById('login-button').addEventListener('click', function() {
				login();
			});
			document.getElementById('register-button').addEventListener('click', function() {
				register();
			});

			if(window.location.hash=="#register"){
				register();
			}
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
			<form method="post" action="https://galactae.elanis.eu/logconfirm">
				<input type="text" name="username" id="username" placeholder="<?php echo LOGIN_USERMAIL; ?>">
				<input type="password" name="password" id="password" placeholder="<?php echo LOGIN_PASSWORD; ?>">
				<input type="submit" value="<?php echo LOGIN_LOGIN; ?>">
			</form>
		</div>
		<div id="register-section" class="login-onglet">
			<form method="post" action="https://galactae.elanis.eu/regconfirm">
				<input type="text" name="username" id="username" placeholder="<?php echo LOGIN_USERNAME; ?>" required>
				<input type="text" name="mail" id="mail" placeholder="<?php echo LOGIN_MAIL; ?>" required>
				<input type="password" name="password" id="password" placeholder="<?php echo LOGIN_PASSWORD; ?>" required>
				<input type="password" name="confpassword" id="confpassword" placeholder="<?php echo LOGIN_CPASSWORD; ?>" required>
				<span id="cg-desc"><input type="checkbox" name="cg" id="cg" value="checked"><?php echo LOGIN_CG; ?></span>
				<input type="submit" value="<?php echo LOGIN_REG; ?>">
			</form>
		</div>
	</section>
</body>
</html>