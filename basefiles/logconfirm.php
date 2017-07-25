<?php
include_once('./basefiles/header.php');

$message = "";

foreach($_POST as $key => $value) {
	$variablesPost[htmlspecialchars(trim($key), ENT_QUOTES | ENT_HTML5, "UTF-8")] = htmlspecialchars(trim($value), ENT_QUOTES | ENT_HTML5, "UTF-8");
}

if(empty($_POST['username']) || empty($_POST['password']) ) {
	$message = ERR_FIELD. ' '.CLICK_BACK;
} else { // Check du couple pseudo/mdp
    $data = $db->getCondContent("users",[
    	["user_name",strtolower($_POST['username']),"str"],
    	["activated",1,"int"]
    	],0,1,"user_id");

    if($data==false) { // Test avec le mail
	    $data = $db->getCondContent("users",[
	    	["user_mail",strtolower($_POST['username']),"str"],
	    	["activated",1,"int"]
	    	],0,1,"user_id");
    }
    
	if($data!=false&&isset($data[0])) {
		$data = $data[0];
	}

    if ($data['user_passwd'] == encrypt($_POST['password'])) // Acces OK ! 
	{ 
	    if ($data['user_lvl'] == 0) //Le membre est banni 
	    { 
	        $message = ERR_BAN;
	    } 
	    else //Sinon c'est ok, on se connecte 
	    { 
	        $_SESSION['username'] = $data['user_name']; 
	        $_SESSION['level'] = $data['user_lvl']; 
	        $_SESSION['id'] = $data['user_id'];
	        if(isset($data['game_id'])) {
	        	$_SESSION['game_id'] = $data['game_id'];
	        } else {
	        	$_SESSION['game_id'] = "-1";
	        }
	          
	        $message = CONNECTED.' '.CLICK_GAME; 
	        header("Location: portal.php"); 
	    } 
	}
    else // Acces pas OK ! 
    { 
        $message = ERR_BAD_LOGIN. ' '.CLICK_BACK;
    }
}
?>
<body class="login-page">
	<ul>
		<li style="text-align: center;"><a href="index.html" style="color: white; text-decoration: none; font-weight: bold;">GALACTAE: SPACE AGE RISING</a></li>
	</ul>
		<section class="login" style="color: white; padding: 1em;">
			<?php
			echo $message;
			?>
		</section>
</body>