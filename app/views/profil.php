<section class="login-page">
<?php

function translateServerName($serverId) {
	$servers = [
		DEV,
		MILKYWAY,
		ANDROMEDA,
		PEGASUS,
		MAGELLAN
	];

	return $servers[(int) explode("-",$serverId)[1]];
}

if($found) { // Found ?
	echo '	<div id="profil-main">';
	
	echo '		<h3>'.PROFIL_INFO.'</h3>';

	// Basic infos
	// Username, mail, age
 	echo '
 		<span id="profil-username">'.$searchedUser['user_name'].'</span><br/>';
 	if($currentUser) {
 		?>
		<span id="profil-mail"><?= $searchedUser['user_mail'] ?></span><br/>

		<form action="editprofil" method="post" class="login-onglet" id="editprofil">
			<h4><?= PROFIL_NEWSLETTER ?></h4>

			<label for="newsletter_misc"><?= LOGIN_NEWS_MISC ?></label>
			<input id="profil-newsletter_misc" name="newsletter_misc" type="checkbox" <?= ($searchedUser['newsletter_misc']) ? 'checked' : ''; ?>>

			<label for="newsletter_misc"><?= LOGIN_NEWS_UPDATE ?></label>
			<input id="profil-newsletter_updates" name="newsletter_updates" type="checkbox" <?= ($searchedUser['newsletter_updates']) ? 'checked' : ''; ?>>

			<h4><?= LOGIN_PASSWORD ?></h4>

			<p><?= PROFIL_PASSWORD_TEXT ?></p>

			<input type="password" name="oldpassword" id="oldpassword" placeholder="<?php echo PROFIL_OLD_PASSWORD; ?>">
			<input type="password" name="newpassword" id="newpassword" placeholder="<?php echo PROFIL_NEW_PASSWORD; ?>">
			<input type="password" name="confpassword" id="confpassword" placeholder="<?php echo LOGIN_CPASSWORD; ?>">

			<br/>

			<input type="submit" value="<?= PROFIL_EDIT ?>">
		</form>
		<?php
	}
	if(isset($searchedUser['birth'])) {
 		echo '
		<span id="profil-birth">'.PROFIL_BORN.' '.date("d-m-Y", $searchedUser['birth']).' ('.floor((time() - $searchedUser['birth'])/3600/24/365).' '.PROFIL_YEAR.')</span><br/>';
	}

	// Ranks
	echo '
		<br/><br/>
		<h3>'.PROFIL_RANK.'</h3>
		<h4>'.PROFIL_GALAXY.'</h4>
		<table>
			<tr><th>'.PROFIL_GALAXY.'</th><th>'.PROFIL_RANK.'</th><th>'.PROFIL_POINTS.'</th><th>'.PROFIL_PLANETS.'</th></tr>';

	for($i=0; $i<count($globalRanks); $i++) {
		echo '<tr><td>'.translateServerName($globalRanks[$i]["server_name"]).'</td>
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

	for($i=0; $i<count($sectorRanks); $i++) {
		echo '<tr><td>'.translateServerName($sectorRanks[$i]["server_name"]).'</td>
			<td>'.$sectorRanks[$i]["sector"].'</td>
			<td>'.$sectorRanks[$i]["rank"].'</td>
			<td>'.$sectorRanks[$i]["points"].'</td>
			<td>'.$sectorRanks[$i]["planets"].'</td>
			</tr>
		';
	}

	echo '
		</table>
	</div>';
} else { // Not Found ?
	echo '<section class="login-page"><div id="profil-main">User not found</div></section>';
}
?>
</body>