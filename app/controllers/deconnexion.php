<?php
$userMngr->removeSessionByIds(
	$userData['_id'], 
	$_COOKIE['galactae-phpsessid']
);

session_destroy();

$pageData['pageName'] = "index.php";
?>