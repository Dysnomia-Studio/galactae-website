<?php session_start(); ?>
<!DOCTYPE html>
<!-- 
	Code by Elanis
	2016
	Don't copy this without permission
	I hope this code is readable.
-->
<?php
if(isset($_POST['langue'])) {

if($_POST['langue']=="Francais") { $_SESSION['lang'] =""; }
if($_POST['langue']=="English") { $_SESSION['lang'] ="en"; }
if($_POST['langue']=="Deutsch") { $_SESSION['lang'] ="de"; }

}

if(!isset($_SESSION['lang'])) { $_SESSION['lang']=""; }

//PHP INCLUDE
include_once('./lib/php/lang.php');
?>
<html lang="<?php echo ($_SESSION['lang']!="")?$_SESSION['lang']:"fr"; ?>">
<head>
	<!-- Title -->
	<title>Galactae</title>
	<!-- Meta -->
	<meta charset="UTF-8">
	<meta name="keywords" content="<?php echo META_KEYWORDS; ?>">
	<meta name="description" content="<?php echo META_DESC; ?>" />
	<meta name="author" content="Elanis">
	<!-- CSS INCLUDE -->
	<link rel="shortcut icon" type="image/png" href="./img/favicon.png"/>
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="./lib/css/style.css"/>
</head>
<body>