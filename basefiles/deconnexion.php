<?php
session_start();
setcookie ( "galactae-phpsessid", '', -1,"/", ".galactae.eu",true, false);
setcookie ( "galactae-phpsessid", '', -1,"/", "galactae.eu",true, false);

$sqlDB->removeContent("user_session",[
	["user_session_uid",$_COOKIE['galactae-phpsessid'],"str"]]);

session_destroy();

header('Location: index.php');
?>