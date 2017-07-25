<?php
include_once('./basefiles/header.php');
include_once('./basefiles/menu.php');
?>
<section class="contact">
	<?php
		if(!isset($_POST['txt']))
		{ ?>
	
		<h1>Contact</h1>
		<p>Vous pouvez nous contacter ...</p>
		<div class="contact-part">
			<h4>Par les reseaux sociaux</h4>
			<a href="https://www.facebook.com/elanisgaming/">Facebook</a> - 
			<a href="https://twitter.com/ElanisGaming">Twitter</a> - 
			<a href="https://www.youtube.com/user/ElanisGaming">Youtube</a>
			<br /><br />
		</div>
		<div class="contact-part">
			<h4>Par le formulaire</h4>
				<form method="post" action="contact">
					<input type ="text" id="mail" name="mail" placeholder="<?php echo CONTACT_MAIL; ?> " required><br/>
					<textarea cols="40" rows="6" id="txt" name="txt" placeholder="<?php echo CONTACT_TXT; ?>" required></textarea><br/>
					<div class="g-recaptcha" data-sitekey="***REMOVED***"></div>
					<input type="submit" value="<?php echo CONTACT_SEND; ?>" />
				</form>
		</div>
		
		<?php }
		else {
			$reCaptcha = new ReCaptcha("***REMOVED***");

			$resp = $reCaptcha->verifyResponse(
				$_SERVER["REMOTE_ADDR"],
				$_POST["g-recaptcha-response"]
				);
			if ($resp != null && $resp->success) {

			require_once './lib/swiftmailer/lib/swift_required.php';

			// Create the Transport
			$transport = Swift_SmtpTransport::newInstance('***REMOVED***', 465, 'ssl')
			  ->setUsername('***REMOVED***')
			  ->setPassword('***REMOVED***')
			  ;

			// Create the Mailer using your created Transport
			$mailer = Swift_Mailer::newInstance($transport);

			// Create a message
			$message = Swift_Message::newInstance($_POST['reason'])
			  ->setFrom(array('***REMOVED***' => 'Contact elanistudio'))
			  ->setTo(array('***REMOVED***' => 'Elanis'))
			  ->setBody($_POST['txt'].'<br/><br/>'.$_POST['mail'] , 'text/html')
			  ;

			// Send the message
			$result = $mailer->send($message);
			
			echo'<h2>'.CONTACT_OK.'</h2>';
			}
			else
			{
			echo'<h2>'.CONTACT_PAS_OK.'</h2>';
			}
		}
		?>
</section>
<?php
include_once('./basefiles/footer.php');
?>