<?php
$_GET['u'] = (isset($_GET['u']))?$_GET['u']:'';
$user = htmlspecialchars(htmlentities($_GET['u']));

/**
 * Recherche de l'utilisateur
 */
$currentUser = false;
$found = true;
$searchedUser = [];

$userMngr = new UserManager();

if($user == '' || strtolower($user) == strtolower($userData['user_name'])) { // Current user
	$currentUser = true;
	$searchedUser = $userData;
} else { // Other user
	// Search
	$searchedUser = $userMngr->getGlobalUserByCaseInsensitiveName($user);

	if(!isset($searchedUser)) { // Not Found ?
		$found = false;
	}
}

/**
 * Db get
 */
if($found) {
	$game_ids = $userMngr->getAllUserGameData($searchedUser['id']);

	$sqlDB = new SQLInterface();
	$globalRanks = array();
	foreach($game_ids as $userGameData) {
		$userGameData = json_decode(json_encode($userGameData), true);

		$currGlobalRank = $sqlDB->getCondContent('globalRanks',
			[
				'game_id' => $userGameData['game_id'],
				'server_name' => $userGameData['server_name']
			]
		);

		array_push($globalRanks, json_decode(json_encode($currGlobalRank[0]), true));
	}
	$sectorRanks = array();
	foreach($game_ids as $userGameData) {
		$userGameData = json_decode(json_encode($userGameData), true);

		$currSectorRanks = $sqlDB->getCondContent('sectorRanks',
			[
				'game_id' => $userGameData['game_id'],
				'server_name' => $userGameData['server_name']
			]
		);

		for($i=0; $i<count($currSectorRanks); $i++) {
			array_push($sectorRanks, json_decode(json_encode($currSectorRanks[$i]), true));
		}
	}
}
?>