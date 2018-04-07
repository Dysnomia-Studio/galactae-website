<?php
include_once('adminCheck.php');

$_GET['u'] = (isset($_GET['u']))?$_GET['u']:'';
$user = htmlspecialchars(htmlentities($_GET['u']));

// Search
$searchedUser = $mongoDB->getCondContent('galactae','users',
	['user_name' =>  new \MongoDB\BSON\Regex('^'.preg_quote($user).'$', 'i')]
);

if(!isset($searchedUser[0])) {
	echo '<p style="text-align: center;">User not found</p>';
	die();
}
$searchedUser = (array) $searchedUser[0];

$privilegesList = $mongoDB->getCondContent('galactae','users',
	['user_id' =>  (string) $searchedUser["_id"]]
);

foreach ($privilegesList as $serverPrivileges) {
	$privilegeDOM .= '<tr><td>'.$serverPrivileges["server_name"].'</td><td>'.$serverPrivileges["user_privilege_lvl"].'</td><td>';

	if($serverPrivileges["user_privilege_lvl"]) {
		$privilegeDOM .= '<input type="checkbox" checked>';
	} else {
		$privilegeDOM .= '<input type="checkbox">';
	}

	$privilegeDOM .= '</td></tr>';
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