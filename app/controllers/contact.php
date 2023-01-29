<?php
	if(isset($_POST['txt'],$_POST['mail']) &&
		!empty($_POST['txt']) &&
		!empty($_POST['mail']) &&
		strlen(trim($_POST['txt'])) > 0 &&
		strlen(trim($_POST['mail'])) > 0
	) {

		foreach($_POST as $key => $value) {
			$variablesPost[htmlspecialchars(trim($key), ENT_QUOTES | ENT_HTML5, 'UTF-8')] = htmlspecialchars(trim($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
		}

		// Captcha check
		require_once(DIR_CTRL.'checkCaptcha.php');

		if ($captchaOK && (!isset($_POST['otherField']) || empty($_POST['otherField']))) {
			require_once '../lib/swiftmailer/swift_required.php';

			// Create the Transport
		    $transport = (new Swift_SmtpTransport('mail.elanis.eu', 587, 'tls'))
		      ->setUsername('noreply@galactae.eu')
		      ->setPassword($config['mail_password'])
		      ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer_name' => false, 'verify_peer' => false)))
		      ;

			// Create the Mailer using your created Transport
			$mailer = new Swift_Mailer($transport);

			$variablesPost['txt'] = nl2br($variablesPost['txt']);

			$userMngr = new UserManager();
			$sess_data = $userMngr->getUserBySession($_COOKIE['galactae-phpsessid']);
			$user = 'N/A';
			if(isset($sess_data) && isset($sess_data['user_id'])) {
				$userData = $userMngr->getGlobalUserById($sess_data['user_id']);
				$user = $userData['user_name'];
			}

			// Create a message
			$message = (new Swift_Message('Galactae Contact'))
			  ->setFrom(array('noreply@galactae.eu' => 'Galactae Contact'))
			  ->setTo(array('contact@galactae.eu' => 'Galactae Contact'))
			  ->setBody($variablesPost['txt'].'<br/><br/>'.$variablesPost['mail'].' - Username: '.$user, 'text/html')
			  ;

			// Send the message
			$result = $mailer->send($message);
			
			$message = CONTACT_OK;
		} else {
			$message = CONTACT_PAS_OK;
		}
	}