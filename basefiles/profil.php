<?php
include_once('./basefiles/connectCheck.php');
include_once('./basefiles/header.php');

$_GET['u'] = (isset($_GET['u']))?$_GET['u']:'';
$user = htmlspecialchars(htmlentities($_GET['u']));
?>
<body class="login-page">
<?php
include_once('./basefiles/menuConnected.php');

// Draw profile
function drawProfile($user,$mongoDB,$isCurrentUser) {
	echo '	<div id="profil-main">';
	
	// Edit button
	if($isCurrentUser) {
		echo '<a id="edit-button">'.PROFIL_EDIT.'</a><br/>';
		// JS Script to switch to edit
	}

	echo '		<h3>'.PROFIL_INFO.'</h3>';

	// Basic infos
	// Username, mail, age
 	echo '
 		<span id="profil-username">'.$user['user_name'].'</span><br/>';
 	if($isCurrentUser) {
 		echo '
		<span id="profil-mail">'.$user['user_mail'].'</span><br/>';
	}
	if(isset($user['birth'])) {
 		echo '
		<span id="profil-birth">'.PROFIL_BORN.' '.date("d-m-Y", $user['birth']).' ('.floor((time() - $user['birth'])/3600/24/365).' '.PROFIL_YEAR.')</span><br/>';
	}

	$game_ids = $mongoDB->getCondContent('galactae','game_ids',
		['user_id' => $user['_id']]
	);

	$globalRanks = array();
	foreach($game_ids as $userGameData) {
		$currGlobalRank = $mongoDB->getCondContent('galactae','globalRanks',
			['user_id' => $user['_id'],
			 'server_name' => $userGameData['server_name']
			]
		);

		array_push($globalRanks, $currGlobalRank);
	}

	// Ranks
	echo '
		<br/><br/>
		<h3>'.PROFIL_RANK.'</h3>
		<h4>'.PROFIL_GALAXY.'</h4>
		<table>
			<tr><th>'.PROFIL_GALAXY.'</th><th>'.PROFIL_RANK.'</th><th>'.PROFIL_POINTS.'</th>><th>'.PROFIL_PLANETS.'</th></tr>';

	for($i=0; $i<count($globalRanks); $i++) {
		echo '<tr><td>'.$globalRanks[$i]["server_name"].'</td>
			<td>'.$globalRanks[$i]["rank"].'</td>
			<td>'.$globalRanks[$i]["points"].'</td>
			<td>'.$globalRanks[$i]["planets"].'</td>
			</tr>
		';
	}

	echo '
		</table>
		<h4>Secteur</h4>
		<table>
			<tr><th>'.PROFIL_GALAXY.'</th><th>'.PROFIL_SECTOR.'</th><th>'.PROFIL_RANK.'</th><th>'.PROFIL_POINTS.'</th><th>'.PROFIL_PLANETS.'</th></tr>';

	// @ADD: list sector ranks

	echo '
		</table>
	</div>';
}

if($user == "" || strtolower($user) == strtolower($userData['user_name'])) { // Current user
	drawProfile($userData,$mongoDB,true);
} else { // Other user
	// Search
	$searchedUser = $mongoDB->getCondContent('galactae','users',
		['user_name' =>  new \MongoDB\BSON\Regex('^'.preg_quote($user).'$', 'i')]
	);

	if(isset($searchedUser[0])) { // Found ?
		$searchedUser = (array) $searchedUser[0];
		drawProfile($searchedUser,$mongoDB,false);
	} else { // Not Found ?
		echo "User not found";
	}
}
?>
</body>