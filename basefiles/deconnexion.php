<?php
session_start();

$sqlDB->removeContent("user_session",[
	["user_session_uid",$_COOKIE['galactae-phpsessid'],"str"]]);

session_destroy();

header('Location: index.php');
?>