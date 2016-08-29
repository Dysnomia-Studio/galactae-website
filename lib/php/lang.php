<?php
//English
if($_SESSION['lang']=="en") {
	//Galaxies
	define('MILKY_WAY','Milky Way');
	define('ANDROMEDA','Andromeda');
	define('MAGELLAN','Magellan');

	//Autre
	define('WELCOME_MESSAGE','Welcome ! Please choose your galaxy:');
	define('GALAXY','Galaxy');
	define('STATUS','Status');
	define('ONLINE','Online');
	define('OFFLINE','Offline');
	define('CONNECT','Connect');
	

} else { //Francais
	//Galaxies
	define('MILKY_WAY','Voie Lactée');
	define('ANDROMEDA','Andromède');
	define('MAGELLAN','Magellan');

	//Autre
	define('WELCOME_MESSAGE','Bienvenue ! Veuillez choisir votre galaxie:');
	define('GALAXY','Galaxie');
	define('STATUS','Statut');
	define('ONLINE','En Ligne');
	define('OFFLINE','Hors Ligne');
	define('CONNECT','Se connecter');
}