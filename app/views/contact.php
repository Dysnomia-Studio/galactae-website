<section class="contact">
	<article>
		<?php
			if(!isset($message)) {

			require_once(DIR_CTRL.'generateCaptcha.php');
			?>
			<h1>Contact</h1>
			<p>Vous pouvez nous contacter ...</p>
			<div class="contact-part">
				<h4>Par les reseaux sociaux</h4>
				<a href="https://www.facebook.com/galactaeSAD/">Facebook</a> -
				<a href="https://twitter.com/GalactaeSAD">Twitter</a> -
				<a href="https://www.youtube.com/user/ElanisGaming">Youtube</a>
				<br /><br />
			</div>
			<div class="contact-part">
				<h4>Par le formulaire</h4>
				<form method="post" action="contact">
					<input type="text" id="mail" name="mail" placeholder="<?php echo CONTACT_MAIL; ?> " required><br/>
					<textarea cols="40" rows="6" id="txt" name="txt" placeholder="<?php echo CONTACT_TXT; ?>" required></textarea><br/>
					<input
						type="text"
						id="additionAnswer"
						name="additionAnswer"
						placeholder="<?php echo $_SESSION['firstCaptchaItem'].' + '.$_SESSION['secondCaptchaItem'].' ?'?>"
					/>
					<div id="contact-other-field">
						<input
							type="text"
							id="otherField"
							name="otherField"
							placeholder="<?php echo (9-$_SESSION['firstCaptchaItem']).' + '.$_SESSION['firstCaptchaItem'].' ?'?>"
						/>

						<style>
							#contact-other-field {
								display: none;
							}
						</style>
					</div>

					<input type="submit" value="<?php echo CONTACT_SEND; ?>" />
				</form>
			</div>
			
			<?php } else {
				echo'<h2>'.$message.'</h2>';
			}
			?>
	</article>
</section>