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

	$rkMngr = new RanksManager();
	$globalRanks = array();
	foreach($game_ids as $userGameData) {
		$currGlobalRank = $rkMngr->getGlobalListByGameIdAndServer(
			$userGameData['game_id'],
			$userGameData['server_name']
		);

		if(isset($currGlobalRank[0])) {
			array_push($globalRanks, $currGlobalRank[0]);
		}
	}

	$sectorRanks = array();
	foreach($game_ids as $userGameData) {
		$currSectorRanks = $rkMngr->getSectorListByGameIdAndServer(
			$userGameData['game_id'],
			$userGameData['server_name']
		);

		for($i=0; $i<count($currSectorRanks); $i++) {
			array_push($sectorRanks, json_decode(json_encode($currSectorRanks[$i]), true));
		}
	}
}