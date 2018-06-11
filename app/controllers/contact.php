<?php
	if(isset($_POST['txt'],$_POST['mail']) && 
		!empty($_POST['txt']) &&
		!empty($_POST['mail'])) {

		$reCaptcha = new ReCaptcha('***REMOVED***');

		$resp = $reCaptcha->verifyResponse(
			$_SERVER['REMOTE_ADDR'],
			$_POST['g-recaptcha-response']
			);
		if ($resp != null && $resp->success) {
			require_once './lib/swiftmailer/swift_required.php';

			// Create the Transport
			$transport = Swift_SmtpTransport::newInstance('***REMOVED***', 465, 'ssl')
			  ->setUsername('***REMOVED***')
			  ->setPassword('***REMOVED***')
			  ;

			// Create the Mailer using your created Transport
			$mailer = Swift_Mailer::newInstance($transport);

			// Create a message
			$message = Swift_Message::newInstance('Galactae Contact')
			  ->setFrom(array('***REMOVED***' => 'Galactae Contact'))
			  ->setTo(array('***REMOVED***' => 'Elanis'))
			  ->setBody($_POST['txt'].'<br/><br/>'.$_POST['mail'] , 'text/html')
			  ;

			// Send the message
			$result = $mailer->send($message);
			
			$message = CONTACT_OK;
		} else {
			$message = CONTACT_PAS_OK;
		}
	}
	?>