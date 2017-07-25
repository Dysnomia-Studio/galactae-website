<?php
/* Require */
require_once('init.php');

/* == Modules == */
$modules = [
'captcha' => true,
'canvas' => false,
'cookies' => false,
'encrypt' => true,
'forum' => false,
'hamburger' => true,
'lang' => true,
'mongodb' => false,
'payment' => false,
'sql' => true,
'sms' => false,
'users' => false
];

/* == Config == */
$main_config = [
'website-name' => 'Galactae: Space Age Rising',
'creation' => 2016,
'website-version' => 0.19,
'default-maxperpage' => 25,
'dev' => true
];

$sql_config = [
'host' => 'mysql',
'database' => 'galactae',
'username' => 'galactae',
'password' => '***REMOVED***'
];

$users_config = [
'username' => 'text',
'password' => 'password',
'mail' => 'text-mail',
'website' => 'text-website',
'born' => 'date',
'avatar' => 'image',
'signature' => 'text'
];

$captcha_config = [
'public-key' => 'NULL',
'private-key' => 'NULL'
];

$blacklist = array("logconfirm","regconfirm","portal","contactconfirm","deconnexion","login","contact","newsletter42"); // Pages ne devant en aucun cas etre mises en cache !!!!!!!!

//                 0      1      2        3           4          5
$rank_config = [BANNED,VISITOR,MEMBER,MODERATOR,ADMINISTRATOR,FOUNDER];

LoadIt();
?>