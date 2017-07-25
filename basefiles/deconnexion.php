<?php
session_start();
setcookie('galactae-account-username', '', -1);
setcookie('galactae-account-id', '', -1);
setcookie('galactae-account-lvl', '', -1);
session_destroy();

header('Location: index.php');
?>