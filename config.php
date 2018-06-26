<?php
$config = array(
	"mongoURL" => "***REMOVED***",
	"languageList" => [
		'en' => 'English',
		'fr' => 'Francais',
		//'de' => 'Deutsch',
		//'ru' => 'русский'
	],
	"cacheBlacklist" => [
		"login",
		"register",
		"portal",
		"contact",
		"deconnexion",
		"secret42",
		"stats42",
		"mailconf",
		"forgotmypass",
		"changepassword",
		"profil",
		"adminsearchuser",
		"adminedituser"
	],

	"pass-minsize" => 8,

	"name-minsize" => 3,
	"name-maxsize" => 20,
);