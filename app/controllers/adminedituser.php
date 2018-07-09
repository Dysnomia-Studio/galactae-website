<?php
$_GET['u'] = (isset($_GET['u']))?$_GET['u']:'';
$user = htmlspecialchars(htmlentities($_GET['u']));

$userMngr = new UserManager();
$privilegesMngr = new PrivilegesManager();
$banMngr = new BansManager();

// Search
$searchedUser = $userMngr->getAllGlobalUsersByCaseInsensitiveName($user);

/**
 * Privileges
 */
$privilegesList = $privilegesMngr->getUserPrivileges($searchedUser['_id']);

/**
 * Bans
 */
$bansList = $banMngr->getUserBans($searchedUser['_id']);