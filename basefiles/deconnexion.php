<?php
session_start();
setcookie ( "galactae-account-username", '', -1,"/", ".galactae.elanis.eu",true, false);
setcookie ( "galactae-account-username", '', -1,"/", "galactae.elanis.eu",true, false);
setcookie ( "galactae-account-id", '', -1,"/", ".galactae.elanis.eu",true, false);
setcookie ( "galactae-account-id",'', -1,"/", "galactae.elanis.eu",true, false);
setcookie ( "galactae-account-bid",'', -1,"/", ".galactae.elanis.eu",true, false);
setcookie ( "galactae-account-bid", '', -1,"/", "galactae.elanis.eu",true, false);

$_SESSION['username'] = "";
$_SESSION['game_id'] = "";
$_SESSION['id'] = "";

setcookie ( session_name(), '', -1,"/", "galactae.elanis.eu",true, false);

session_destroy();

header('Location: index.php');
?>