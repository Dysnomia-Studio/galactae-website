<?php
include_once('./basefiles/header.php');

$message = '';

foreach($_POST as $key => $value) {
	$variablesPost[htmlspecialchars(trim($key), ENT_QUOTES | ENT_HTML5, 'UTF-8')] = htmlspecialchars(trim($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

if(empty($_POST['username']) || empty($_POST['password']) ) {
	$message = ERR_FIELD. ' '.CLICK_BACK;
} else { // Check du couple pseudo/mdp
	$data = $mongoDB->getCondContent('galactae','users',
		['user_name' => new \MongoDB\BSON\Regex(preg_quote($variablesPost['username']), 'i')] 
	);

    if(count($data)==0) { // Test avec le mail
		$data = $mongoDB->getCondContent('galactae','users',
			['user_mail' => new \MongoDB\BSON\Regex(preg_quote($variablesPost['username']), 'i')]
		);
    }
    
	if(count($data) > 0 && isset($data[0])) {
		$data = (array) $data[0];
	}

    if(isset($data['activated']) && $data['activated']!=1) { // Compte non-activé
		$message = ERR_NOT_ACTIVATED.' '.CLICK_BACK;
	} else {
		if(isset($data['user_passwd']) && $data['user_passwd']  == encrypt($_POST['password'])) { // Acces OK ! 	
	        $mongoDB->removeContent('galactae','sessions',[
				'user_id' => $data['_id'],
				'user_session_uid' => $_COOKIE['galactae-phpsessid']
			]);

	        $mongoDB->addContent('galactae','sessions',[
				'user_id' => $data['_id'],
				'user_session_uid' => $_COOKIE['galactae-phpsessid'],
				'user_session_expiration' => (time()+$expTime),
				'user_session_lang' => $lang->getLanguage(),
				'user_agent' => $_SERVER['HTTP_USER_AGENT']
			]);
	          
	        $message = CONNECTED.' '.CLICK_GAME; 
	        header('Location: portal.php'); 
		} else { // Acces pas OK ! 
	        $message = ERR_BAD_LOGIN. ' '.CLICK_BACK;
	    }
	}
}
?>
<body class="login-page">
	<ul>
		<li style="text-align: center;"><a href="index.html" style="color: white; text-decoration: none; font-weight: bold;">GALACTAE: SPACE AGE DAWN</a></li>
	</ul>
		<section class="login" style="color: white; padding: 1em;">
			<?php
			echo $message;
			?>
		</section>
</body>