<?php
include('./lib/config.php');

$currentpage = explode("?",$_SERVER['REQUEST_URI'])[0];
// Strtolower
$currentname = strtolower($currentpage);
// Strip .* et /
$currentname = str_replace(".php", "", $currentname);
$currentname = str_replace(".html", "", $currentname);
$currentname = str_replace(".htm", "", $currentname);
$currentname = str_replace("/", "", $currentname);
// Index verif
if($currentname=="") {
    $currentname = "index";
}

// Cache preparation
$cache = 'cache/'.$currentname.'-'.$_SESSION['lang'].'.html';
$expire = time()-86400 ; // valable un jour

// Commandes Get
$cached = 1;
if(isset($_GET['clear']) && $_GET['clear']==1) {
    $cached = 0;
}
if(isset($_GET['cache']) && $_GET['cache']==0) {
    $cached = 0;
}

if(file_exists($cache) && filemtime($cache) > $expire && array_search($currentname,$blacklist)===false && $cached==1) { // Fichier existant ET temps depuis dernier cache inferieur a l'expiration ET pas dans la blacklist
    readfile($cache);
}
elseif(array_search($currentname,$blacklist)!==false) {
    include_once('basefiles/'.$currentname.'.php'); // We don't need to cache it
}
else {
    if(!file_exists('basefiles/'.$currentname.'.php')) {
        include_once('errors/404.php');
    } else {    
        ob_start(); // ouverture du tampon
 
        include_once('basefiles/'.$currentname.'.php');

        $page = ob_get_contents(); // copie du contenu du tampon dans une chaîne
        ob_end_clean(); // effacement du contenu du tampon et arrêt de son fonctionnement
        
        file_put_contents($cache, $page) ; // on écrit la chaîne précédemment récupérée ($page) dans un fichier ($cache)

        echo $page ; // on affiche notre page :D 
    }
}
?>