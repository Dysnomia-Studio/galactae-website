<section class="contact">
	<article>
		<?php
			if(!isset($message)) { 
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
				<form method="post" action="contact.php">
					<input type ="text" id="mail" name="mail" placeholder="<?php echo CONTACT_MAIL; ?> " required><br/>
					<textarea cols="40" rows="6" id="txt" name="txt" placeholder="<?php echo CONTACT_TXT; ?>" required></textarea><br/>
					
					<script src='https://www.google.com/recaptcha/api.js'></script>
					<div class="g-recaptcha" data-sitekey="***REMOVED***"></div>
					<input type="submit" value="<?php echo CONTACT_SEND; ?>" />
				</form>
			</div>
			
			<?php } else {
				echo'<h2>'.$message.'</h2>';
			}
			?>
	</article>
</section>