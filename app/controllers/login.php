<?php
$message = '';

foreach($_POST as $key => $value) {
	$variablesPost[htmlspecialchars(trim($key), ENT_QUOTES | ENT_HTML5, 'UTF-8')] = htmlspecialchars(trim($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

if(isset($_SESSION['ip']) && 
	$_SESSION['ip'] == Web::get_client_ip() && 
	isset($_POST['username']) && 
	isset($_POST['password'])) {

	if(empty($_POST['username']) || empty($_POST['password']) ) {
		$message = ERR_FIELD. ' '.CLICK_BACK;
	} else { // Check du couple pseudo/mdp
		$data = $userMngr->getGlobalUserByCaseInsensitiveName($variablesPost['username']);

	    if(isset($data['activated']) && $data['activated']!=1) { // Compte non-activé
			$message = ERR_NOT_ACTIVATED.' '.CLICK_BACK;
		} else {
			if(isset($data['user_passwd']) && $data['user_passwd']  == Security::hashPassword($_POST['password'], 1)) { // Acces OK ! 	
				$userMngr->removeSessionByIds(
					$data['_id'], 
					$_COOKIE['galactae-phpsessid']
				);

				$browser = new Browser();

				$userMngr->addSession(
					$data['_id'],
					$_COOKIE['galactae-phpsessid'],
					($browser->getPlatform().'-'.$browser->getBrowser())
				);
		          
		        $message = CONNECTED.' '.CLICK_GAME; 
		        header('Location: portal.php'); 
			} else { // Acces pas OK ! 
		        $message = ERR_BAD_LOGIN. ' '.CLICK_BACK;
		    }
		}
	}
}

if(!isset($_SESSION['ip']) || $_SESSION['ip'] != Web::get_client_ip()) {
	$_SESSION['ip'] = Web::get_client_ip();
}