<section class="login-page">
	<ul>
		<li style="text-align: center;"><a href="index" style="color: white; text-decoration: none; font-weight: bold;"><img src="https://***REMOVED***/website/img/bannersAndLogos/logo-large-white.png" alt="logo" style="max-height: 6em;"></a></li>
	</ul>

	<section class="login" style="padding: 5px;">
		<div id="login-section" class="login-onglet active-onglet" style="padding: 5px;">
			<?php if(isset($message) && !empty($message)) {
				echo '<p style="text-align: center;">'.$message.'</p>';
			} ?>
			<form method="post" action="changepassword">
				<input type="password" name="password" id="password" placeholder="<?= LOGIN_PASSWORD ?>">
				<input type="password" name="confpassword" id="confpassword" placeholder="<?= LOGIN_CPASSWORD ?>">
				<input type="hidden" name="pid" id="pid" value="<?= $uid ?>">
				<input type="hidden" name="username" id="username" value="<?= $username ?>">
				<input type="submit" value="<?= PASS_SUBMIT ?>">
			</form>
		</div>
	</section>
</section>