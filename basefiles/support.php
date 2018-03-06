<?php
include_once('./basefiles/connectCheck.php');
include_once('./basefiles/header.php');

$_GET['t'] = (isset($_GET['t']))?$_GET['t']:'';
$t = htmlspecialchars(htmlentities($_GET['t']));