<?php
if(isset($_COOKIES['galactae_settings_general_language'])) {
	$lang->setLanguage($_COOKIES['galactae_settings_general_language']);
}

setcookie ( "galactae_settings_general_language", $lang->getLanguage(), time()+$expTime,"/", ".galactae.eu");
setcookie ( "galactae_settings_general_language", $lang->getLanguage(), time()+$expTime,"/", "galactae.eu");