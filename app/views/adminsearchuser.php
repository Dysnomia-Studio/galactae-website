<?php
if(count($searchedUser) > 0) { // Found ?
	foreach($searchedUser as $user) {
		// Transform to array
		$user = json_decode(json_encode($user), true);

		// Draw informations
		echo '
		<p class="user">'.$user['user_name'].'</p>';
	}
}