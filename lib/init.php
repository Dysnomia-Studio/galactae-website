<!DOCTYPE html>
<!-- 
	Code by Elanis
	2016
	Don't copy this without permission
	I hope this code is readable.
-->
<html>
<head>
<?php
session_start();

/* JUST LOAD IT ! */
function LoadIt() {
	/* Get Vars from Config */
	global $modules;
	global $main_config;
	global $sql_config;
	global $users_config;
	global $captcha_config;

	/* Create global vars */
	global $db;
	global $lang;
	global $user;

	/* Include all modules */
	foreach ($modules as $module_key => $module_value) {
		if($module_value) {
			require_once($module_key.'/main.php');
		}
	}
	/* SQL Launch */
	if($modules['sql']) {
		$db = new Database($sql_config['host'],$sql_config['database'],$sql_config['username'],$sql_config['password']);
	}
	else { $db = null; }
	if($modules['lang']) {
		$lang = new Language();
	}
	else { $lang = null; }
	if($modules['users']) {
		$user = new User();
	}
	else { $user = null; }

	if($main_config['dev']) {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}

	if(!isset($_SESSION['maxperpage'])) {
		$_SESSION['maxperpage'] = $main_config['default-maxperpage'];
	}

	echo "<title>".$main_config['website-name']."</title>";
}
?>
<meta charset="UTF-8">
<!-- On prepare le charset , les mots clés , le fichier css et l'icone du site -->
<meta name="keywords" content="<?php echo META_KEYS; ?>">
<meta name="description" content="<?php echo META_DESC; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/png" href="./img/favicon.png"/>
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="./lib/css/style.css"/>
</head>
<body>