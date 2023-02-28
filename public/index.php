<?php
// Cookies
if(!isset($_COOKIE['rememberMe']) || (!$_COOKIE['rememberMe'] && $_COOKIE['rememberMe'] != "false")) {
    $expTime = 2678400; // One month
} else {
    $expTime = 1800; // 30 min
}

ini_set('session.cookie_domain', '.galactae.eu' );
ini_set('session.cookie_lifetime ', $expTime); // Set expiration to 1 month
ini_set('session.gc_maxlifetime', $expTime); // Set expiration to 1 month

if(isset($_COOKIE['galactae-phpsessid']) && $_COOKIE['galactae-phpsessid'] != "") {
    session_id($_COOKIE['galactae-phpsessid']);
}

session_start();

setcookie ( "galactae-phpsessid", session_id(), time()+$expTime,"/", ".galactae.eu");
setcookie ( "galactae-phpsessid", session_id(), time()+$expTime,"/", "galactae.eu");

// Directories
define('DIR_CTRL', '..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR);
define('DIR_ERRORS', '..'.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR);
define('DIR_LIB', '..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR);
define('DIR_LANG', '..'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR);
define('DIR_VIEW', '..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);
define('DIR_MODEL', '..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR);
define('FILE_CONFIG', '..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

require_once DIR_CTRL.'autoload.php';

include_once(FILE_CONFIG);

$lang = new Language(); // Init Translation system

define('DIR_CACHE', '..'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.$lang->getLanguage().'-');

$currentPage = (isset($_GET['route']) && $_GET['route'] != "")?$_GET['route']:"index";
$currentPage = htmlentities(htmlspecialchars($currentPage));
$currentPage = explode(".", $currentPage)[0];

$router = new Router();
$pageData = $router->get($currentPage);

include DIR_VIEW.'mainstruct.php';