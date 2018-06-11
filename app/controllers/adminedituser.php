<?php
$_GET['u'] = (isset($_GET['u']))?$_GET['u']:'';
$user = htmlspecialchars(htmlentities($_GET['u']));

$userMngr = new UserManager();

// Search
$userMngr->getGlobalUserByCaseInsensitiveName($user);

if(count($searchedUser) == 0 || !isset($searchedUser[0])) {
	echo '<p style="text-align: center;">User not found</p>';
	die();
}
$searchedUser = (array) $searchedUser[0];

$mongoDB = new MongoInterface();

/**
 * Privileges
 */
$privilegesList = $mongoDB->getCondContent('galactae','privileges',[
	'user_id' => $searchedUser['_id']
]);

/**
 * Bans
 */
$bansList = $mongoDB->getCondContent('galactae','bans',[
	'user_id' => $searchedUser['_id']
]);