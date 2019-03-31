<?php
$_GET['u'] = (isset($_GET['u']))?$_GET['u']:'';
$user = htmlspecialchars(htmlentities($_GET['u']));

$userMngr = new UserManager();
$privilegesMngr = new PrivilegesManager();
$banMngr = new BansManager();

// Search
$searchedUser = $userMngr->getGlobalUserByCaseInsensitiveName($user);

/**
 * Privileges
 */
$privilegesList = $privilegesMngr->getUserPrivileges($searchedUser['id']);

/**
 * Bans
 */
$bansList = $banMngr->getUserBans($searchedUser['id']);