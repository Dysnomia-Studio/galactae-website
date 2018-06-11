<style type="text/css">
	html, body {
		background: none;
		color: white;
	}

	.tab {
		width: calc(32% - 1em);
		height: calc(100% - 1.5em);
		overflow-y: auto;
		overflow-x: hidden;
		padding: 0.5em;
		border-right: 1px solid #0EC6C6;
		display: inline-block;
	}
	.tab a {
		color: white;
		text-decoration: none;
	}
	.tab a:hover {
		font-weight: bold;
		text-decoration: underline;
	}
	.tab form {
		position: absolute;
		bottom: 0.5em;
		width: calc(32% - 1em);
	}
	.tab table {
		width: calc(100% - 1em);
	}
	.tab form input[type=submit] {
		width: 80%;
		margin: 0.3em auto;
		display: inherit;
	}
</style>
<?php
/**
 * Privileges
 */
$privilegeDOM = ""; // @ADD: entete
foreach ($privilegesList as $serverPrivileges) {
	$serverPrivileges = json_decode(json_encode($serverPrivileges), true);
	$privilegeDOM .= '<tr><td>'.$serverPrivileges["server_name"].'</td><td>'.$serverPrivileges["user_privilege_lvl"].'</td><td>';

	if($serverPrivileges["user_whitelist"]) {
		$privilegeDOM .= '<input type="checkbox" checked>';
	} else {
		$privilegeDOM .= '<input type="checkbox">';
	}
	// @ADD: auto form submit when edit a field

	$privilegeDOM .= '</td></tr>';
}

/**
 * Bans
 */
$bansDOM = ""; // @ADD: entete
foreach ($bansList as $serverBan) {
	$serverBan = json_decode(json_encode($serverBan), true);
	$bansDOM .= '<tr><td>'.$serverBan["server_name"].'</td><td>'.$serverBan["ban_type"].'</td><td>'.date('d/m/Y à H:i:s', $serverBan["ban_end"]/1000).'</td><td>'.$serverBan["ban_reason"].'</td><td>By '.$serverBan["admin"].'</td></tr>';

	// @ADD: edition de ban
	// @ADD: annulation de ban

	$bansDOM .= '</td></tr>';
}

/**
 * Draw UI
 */
echo '
	<div id="main-informations" class="tab">
		<p id="main-username"><a target="_blank" href="profil.php?u='.$searchedUser["user_name"].'">'.$searchedUser["user_name"].'</a></p>
	</div>

	<div id="privileges-tab" class="tab">
		<table id="privileges-list">
			'.$privilegeDOM.'
		</table>
		<form method="post" action="admineditprivileges">
			<select id="privileges-server-list">

			</select>
			<select id="privileges-level-list">

			</select>
			<input type="checkbox" id="privileges-whitelist">
			<input type="submit" value="Ajouter">
		</form>
	</div>

	<div id="ban-tab" class="tab">
		<table id="ban-list">
			'.$bansDOM.'
		</table>
		<form method="post" action="admineditprivileges">
			<select id="ban-server-list">

			</select>
			<select id="ban-type">

			</select>
			<select id="ban-duration-unit">

			</select>
			<input type="number" id="ban-duration-value">
			<input type="submit" value="Bannir">
		</form>
	</div>
	';
?>