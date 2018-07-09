<?php
$_GET['u'] = (isset($_GET['u']))?$_GET['u']:'';
$user = htmlspecialchars(htmlentities($_GET['u']));
$searchedUser = [];

if(strlen($user) > 2) { // Don't query small words
	// Search
	$userMngr = new UserManager();
	$searchedUser = $userMngr->getGlobalUsersByCaseInsensitiveName($user);
}