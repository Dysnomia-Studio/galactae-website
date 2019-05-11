<section class="login-page">
	<ul>
		<li style="text-align: center;"><a href="index" style="color: white; text-decoration: none; font-weight: bold;"><img src="https://***REMOVED***/website/img/bannersAndLogos/logo-large-white.png" alt="logo" style="max-height: 6em;"></a></li>
	</ul>

	<section class="login">
		<?php
			if($activated) {
				// Draw message
				echo '<div id="login-section" class="login-onglet active-onglet" style="padding: 5px;">
					<p style="text-align: center;">'.ACCOUNT_ACTIVATED.CLICK_LOGIN.'</p>
				</div>';
			} else {
				echo '<div id="login-section" class="login-onglet active-onglet" style="padding: 5px;">
					<p style="text-align: center;">'.ACCOUNT_NOT_ACTIVATED.CLICK_HOME.'</p></div>';
			}
		?>
	</section>
</section>