<?php
include_once('./basefiles/connectCheck.php');
include_once('./basefiles/header.php');

$_GET['u'] = (isset($_GET['u']))?$_GET['u']:'';
$user = htmlspecialchars(htmlentities($_GET['u']));

// Draw profile
function drawProfile($user,$isCurrentUser) {
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
 		<span id="profil-username">'.$userData['user_name'].'</span><br/>';
 	if($isCurrentUser) {
 		echo '
		<span id="profil-mail">'.$userData['user_mail'].'</span><br/>';
	}
	if(isset($userData['birth'])) {
 		echo '
		<span id="profil-birth">'.PROFIL_BORN.' '.date("d-m-Y", $userData['birth']).' ('.floor((time() - $userData['birth'])/3600/24/365).' '.PROFIL_YEAR.')</span><br/>';
	}

	// Ranks
	echo '
		<br/><br/>
		<h3>'.PROFIL_RANKS.'</h3>
		<h4>'.PROFIL_GALAXY.'</h4>
		<table>
			<tr><th>'.PROFIL_GALAXY.'</th><th>'.PROFIL_RANK.'</th><th>'.PROFIL_POINTS.'</th></tr>';

	// @ADD: list global ranks

	echo '
		</table>
		<h4>Secteur</h4>
		<table>
			<tr><th>'.PROFIL_GALAXY.'</th><th>'.PROFIL_SECTOR.'</th><th>'.PROFIL_RANK.'</th><th>'.PROFIL_POINTS.'</th></tr>';

	// @ADD: list sector ranks

	echo '
		</table>
	</div>';
}

if($user == "" || $user == $userData['user_name']) { // Current user
	drawProfile($userData,true);
} else { // Other user
	// Search
	$searchedUser = $mongoDB->getCondContent('galactae','users',
		['user_name' =>  new \MongoDB\BSON\Regex(preg_quote($user), 'i')]
	);

	var_dump($searchedUser);

	if(isset($searchedUser[0])) { // Found ?
		drawProfile($searchedUser[0],false);
	} else { // Not Found ?
		
	}
}
?>