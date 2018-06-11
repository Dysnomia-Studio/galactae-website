<section class="login-page">
	<ul>
		<li style="text-align: center;"><a href="index.html" style="color: white; text-decoration: none; font-weight: bold;"><img src="https://***REMOVED***/website/img/bannersAndLogos/logo-large-white.png" style="max-height: 6em;"></a></li>
	</ul>

	<section class="login">
		<?php
			if($activated) {
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
</section>