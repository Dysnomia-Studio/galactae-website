<?php
$config = array(
	'mongoURL' => '',
	'SQLCredentials' => [
		'host' => '***REMOVED***',
		'db' => 'galactae',
		'id' => '***REMOVED***',
		'password' => '***REMOVED***',
		'driver' => 'pgsql',
		'port' => 5432
	],
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
		"mailconf",
		"forgotmypass",
		"changepassword",
		"profil",
		"editprofil"
	],

	"pass-minsize" => 8,

	"name-minsize" => 3,
	"name-maxsize" => 20,
);