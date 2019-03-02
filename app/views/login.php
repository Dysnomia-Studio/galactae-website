<section class="login-page">
	<ul style="list-style: none;">
		<li style="text-align: center;"><a href="index" style="color: white; text-decoration: none; font-weight: bold;"><img src="https://***REMOVED***/website/img/bannersAndLogos/logo-large-white.png" alt="logo" style="max-height: 6em;"></a></li>
	</ul>

	<section class="login">
		<?php
		if(isset($message) && !empty($message)) {
			echo $message;
		} else {
		?>
		<script type="text/javascript" src="https://***REMOVED***/website/js/login.js"></script>
		<table>
			<tr>
				<td class="active" id="login-td"><a href="#login" id="login-button"><?php echo LOGIN_LOGIN; ?></a></td>
				<td id="register-td"><a href="#register" id="register-button"><?php echo LOGIN_REG; ?></a></td>
			</tr>
		</table>

		<div id="login-section" class="login-onglet active-onglet">
			<form method="post" action="login">
				<input type="text" name="username" id="username" placeholder="<?php echo LOGIN_USERMAIL; ?>">
				<input type="password" name="password" id="password" placeholder="<?php echo LOGIN_PASSWORD; ?>">
				<span class="login-checkbox">
					<input type="checkbox" name="rememberMe" id="rememberMe"
					<?php
					if(!isset($_COOKIE['rememberMe']) || (!$_COOKIE['rememberMe'] && $_COOKIE['rememberMe'] != 'false')) {
						echo 'checked';
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
			<form method="post" action="register">
				<input type="text" name="username" id="username" placeholder="<?php echo LOGIN_USERNAME; ?>" required>
				<input type="text" name="mail" id="mail" placeholder="<?php echo LOGIN_MAIL; ?>" required>
				<input type="password" name="password" id="password" placeholder="<?php echo LOGIN_PASSWORD; ?>" required>
				<input type="password" name="confpassword" id="confpassword" placeholder="<?php echo LOGIN_CPASSWORD; ?>" required>
				<span class="login-checkbox" style="display: inherit;"><input type="checkbox" name="cg" id="cg" value="checked" required><?php echo LOGIN_CG; ?></span>
				<span class="login-checkbox"><input type="checkbox" name="newsletter_update" id="newsletter_update" value="checked" checked><?php echo LOGIN_NEWS_UPDATE; ?></span>
				<span class="login-checkbox"><input type="checkbox" name="newsletter_miscellaneous" id="newsletter_miscellaneous" value="checked"><?php echo LOGIN_NEWS_MISC; ?></span>
				<br />
				<br />
				<script src='https://www.google.com/recaptcha/api.js'></script>
				<div class="g-recaptcha" data-sitekey="***REMOVED***"></div>
				<input type="submit" value="<?php echo LOGIN_REG; ?>">
			</form>
		</div>
		<?php } ?>
	</section>
</section>