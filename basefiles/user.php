<?php
include_once('./basefiles/connectCheck.php');
include_once('./basefiles/header.php');

$_GET['act'] = (isset($_GET['act']))?$_GET['act']:'';
$act = htmlspecialchars(htmlentities($_GET['act']));

$_GET['u'] = (isset($_GET['u']))?$_GET['u']:'';
$user = htmlspecialchars(htmlentities($_GET['u']));

switch ($act) {
	case 'modify':
		// Edit profile
		break;
	default:
		// Show profiles
		break;
}
?>