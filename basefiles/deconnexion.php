<?php
session_start();

$mongoDB->removeContent("galactae","sessions",
	["user_session_uid" => $_COOKIE['galactae-phpsessid']]
);

session_destroy();

header('Location: index');
?>