<?php
$userMngr->removeSessionByIds(
	$userData['id'],
	$_COOKIE['galactae-phpsessid']
);

session_destroy();

$pageData['pageName'] = "index.php";