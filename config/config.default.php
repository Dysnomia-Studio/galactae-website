<?php
$config = array(
	'mongoURL' => '',
	'SQLCredentials' => [
		'host' => 'HOST',
		'db' => 'DATABASE',
		'id' => 'USERNAME',
		'password' => 'PASSWORD',
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
	"mail_server" => 'SERVER',
	"mail_username" => 'USERNAME',
	"mail_password" => 'PASSWORD',

	"pass-minsize" => 8,

	"name-minsize" => 3,
	"name-maxsize" => 20,
);