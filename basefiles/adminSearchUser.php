<?php
include_once('adminCheck.php');

$_GET['u'] = (isset($_GET['u']))?$_GET['u']:'';
$user = htmlspecialchars(htmlentities($_GET['u']));

if(strlen($user) > 2) { // Don't query small words
	// Search
	$searchedUser = $mongoDB->getCondContent('galactae','users',
		['user_name' =>  new \MongoDB\BSON\Regex(preg_quote($user), 'i')]
	);

	if(count($searchedUser) > 0) { // Found ?
		foreach($searchedUser as $user) {
			// Transform to array
			$user = json_decode(json_encode($user), true);

			// Draw informations
			echo '
			<p class="user">
				<span class="username">'.$user['user_name'].'</span>
				<span class="id">'.(string) $user['_id'].'</span>
			</p>';
		}
	} else { // Not Found ?
		echo "User not found";
	}
}
?>