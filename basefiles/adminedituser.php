<?php
include_once('adminCheck.php');
?>
<style type="text/css">
	html, body {
		background: none;
		color: white;
	}

</style>
<?php
$_GET['u'] = (isset($_GET['u']))?$_GET['u']:'';
$user = htmlspecialchars(htmlentities($_GET['u']));

// Search
$searchedUser = $mongoDB->getCondContent('galactae','users',
	['user_name' =>  new \MongoDB\BSON\Regex('^'.preg_quote($user).'$', 'i')]
);

if(count($userData) == 0 || !isset($searchedUser[0])) {
	echo '<p style="text-align: center;">User not found</p>';
	die();
}
$searchedUser = (array) $searchedUser[0];

/**
 * Privileges
 */
$privilegesList = $mongoDB->getCondContent('galactae','privileges',[
	'user_id' => $searchedUser['_id']
]);

$privilegeDOM = ""; // @ADD: entete
foreach ($privilegesList as $serverPrivileges) {
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
$bansList = $mongoDB->getCondContent('galactae','privileges',[
	'user_id' => $searchedUser['_id']
]);

$bansDOM = ""; // @ADD: entete
foreach ($bansList as $serverBan) {
	$bansDOM .= '<tr><td>'.$serverBan["server_name"].'</td><td>'.$ban_type["user_privilege_lvl"].'</td><td>'.date('d/m/Y à H:i:s', $ban_type["ban_end"]/1000).'</td><td>'.$ban_type["ban_reason"].'</td><td>By '.$ban_type["admin"].'</td></tr>';


	// @ADD: edition de ban
	// @ADD: annulation de ban

	$bansDOM .= '</td></tr>';
}

echo '
	<div id="main-informations">
		<p id="main-username">'.$searchedUser["user_name"].'</p>
	</div>

	<div id="privileges-tab">
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

	<div id="ban-tab">
		<table id="ban-list">
			'.$bansDOM.'
		</table>
		<form method="post" action="admineditprivileges">
			<select id="ban-server-list">

			</select>
			<select id="ban-duration-unit">

			</select>
			<input type="checkbox" id="ban-duration-value">
			<input type="submit" value="Bannir">
		</form>
	</div>
	';
?>