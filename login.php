<?php 
session_start();

function encrypt($data) {
	$token = ***REMOVED***;
	$part1 = ***REMOVED***;
	$part2 = ***REMOVED***;
	$part3 = ***REMOVED***;
	$part4 = ***REMOVED***;

	return $part4;
}

$err = 0;

if(!isset($_POST['username'])||!isset($_POST['password'])) { 
	$err++; 
}
else {
	$username = (string) $_POST['username'];
	$password = (string) $_POST['password'];

	$mongo = new MongoClient();
	$c = $mongo->spacegame->users;

	$data = $c->findOne(array('username' => $username));

	if(isset($data['password'])) {
		if($data['password']==encrypt($password)) {
			$_SESSION['id'] = $data['_id'];
			$_SESSION['username'] = $username;
			$_SESSION['lvl'] = $data['lvl'];
			header('Location: home.php');	
		}
		else {
			$err++;
		}
	}
	else { $err++; }

	echo encrypt($password);
}

?>
