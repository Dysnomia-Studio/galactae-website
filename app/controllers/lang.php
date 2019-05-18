<?php
if(isset($_COOKIES['general_language'])) {
	$lang->setLanguage($_COOKIES['general_language']);
}

setcookie ( "general_language", $lang->getLanguage(), time()+$expTime,"/", ".galactae.eu");
setcookie ( "general_language", $lang->getLanguage(), time()+$expTime,"/", "galactae.eu");