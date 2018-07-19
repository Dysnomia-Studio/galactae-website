<?php
if(count($searchedUser) > 0) { // Found ?
	foreach($searchedUser as $user) {
		// Draw informations
		echo '
		<p class="user">'.$user->user_name.'</p>';
	}
}