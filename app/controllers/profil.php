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

if($user == "" || strtolower($user) == strtolower($userData['user_name'])) { // Current user
	$currentUser = true;
	$searchedUser = $userData;
} else { // Other user
	// Search
	$searchedUser = $userMngr->getGlobalUserByCaseInsensitiveName($user);

	if(isset($searchedUser[0])) { // Found ?
		$searchedUser = (array) $searchedUser[0];
	} else { // Not Found ?
		echo "User not found";
		$found = false;
	}
}

/**
 * Db get
 */
if($found) {
	$game_ids = $userMngr->getAllUserGameData($searchedUser['_id']);

	$mongoDB = new MongoInterface();
	$globalRanks = array();
	foreach($game_ids as $userGameData) {
		$userGameData = json_decode(json_encode($userGameData), true);

		$currGlobalRank = $mongoDB->getCondContent('galactae','globalranks',
			['user_id' => $userGameData['game_id'],
			 'server_name' => $userGameData['server_name']
			]
		);

		array_push($globalRanks, json_decode(json_encode($currGlobalRank[0]), true));
	}
	$sectorRanks = array();
	foreach($game_ids as $userGameData) {
		$userGameData = json_decode(json_encode($userGameData), true);

		$currSectorRanks = $mongoDB->getCondContent('galactae','sectorranks',
			['user_id' => $userGameData['game_id'],
			 'server_name' => $userGameData['server_name']
			]
		);

		for($i=0; $i<count($currSectorRanks); $i++) {
			array_push($sectorRanks, json_decode(json_encode($currSectorRanks[$i]), true));
		}
	}
}
?>