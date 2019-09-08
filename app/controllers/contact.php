<?php
	if(isset($_POST['txt'],$_POST['mail']) &&
		!empty($_POST['txt']) &&
		!empty($_POST['mail'])) {

		foreach($_POST as $key => $value) {
			$variablesPost[htmlspecialchars(trim($key), ENT_QUOTES | ENT_HTML5, 'UTF-8')] = htmlspecialchars(trim($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
		}

		// Recaptcha check
		require_once(DIR_CTRL.'recaptcha.php');

		if ($recaptchaOK) {
			require_once '../lib/swiftmailer/swift_required.php';

			// Create the Transport
		    $transport = (new Swift_SmtpTransport('***REMOVED***', 587, 'tls'))
		      ->setUsername('***REMOVED***')
		      ->setPassword('***REMOVED***')
		      ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer_name' => false, 'verify_peer' => false)))
		      ;

			// Create the Mailer using your created Transport
			$mailer = new Swift_Mailer($transport);

			$variablesPost['txt'] = nl2br($variablesPost['txt']);

			// Create a message
			$message = (new Swift_Message('Galactae Contact'))
			  ->setFrom(array('***REMOVED***' => 'Galactae Contact'))
			  ->setTo(array('***REMOVED***' => 'Galactae Contact'))
			  ->setBody($variablesPost['txt'].'<br/><br/>'.$variablesPost['mail'] , 'text/html')
			  ;

			// Send the message
			$result = $mailer->send($message);
			
			$message = CONTACT_OK;
		} else {
			$message = CONTACT_PAS_OK;
		}
	}