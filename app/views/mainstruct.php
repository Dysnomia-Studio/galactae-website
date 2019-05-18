<?php 
$debut = round(microtime(true) * 1000);
?>
<!DOCTYPE html>
<!-- 
	Code by Elanis
	Copyright 2018-<?= date('Y') ?> 
	Don't copy this without permission
	I hope this code is readable.
-->
<html lang="<?= $lang->getLanguage(); ?>">
	<head>
		<?php
		include_once(DIR_CTRL.'lang.php');
		?>

		<title>Galactae: Space Age Dawn</title>
		<meta name="theme-color" content="#0b1012">
		<meta charset="UTF-8">
		<!-- On prepare le charset , les mots clés , le fichier css et l'icone du site -->
		<meta name="keywords" content="<?= META_KEYS ?>">
		<meta name="description" content="<?= META_DESC ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="manifest" href="/manifest.json">

		<link rel="shortcut icon" type="image/png" href="https://***REMOVED***/website/img/favicon.png"/>
		<link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway" rel="stylesheet">
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="https://***REMOVED***/website/css/style.css"/>

		<?php $lang->drawCached(); ?>
	</head>
	<body>
		<?php
			$menuPages = [
				"blog.php",
				"contact.php",
				"faq.php",
				"index.php",
				"medias.php",
				"partners.php",
				"theteam.php",
			];

			$menuConnectedPages = [
				"portal.php",
				"profil.php",
				"support.php",
			];

			$adminCheckPages = [
				"adminedituser.php",
				"adminsearchuser.php",
				"secret42.php",
				"stats42.php",
			];

			$connectCheckPages = [
				"deconnexion.php",
				"portal.php",
				"profil.php",
				"support.php",
			];

			$loggedCheckPages = [
				"forgotmypass.php",
				"login.php",
				"mailconf.php",
			];


			if(in_array($pageData['pageName'], $adminCheckPages)) {
				include(DIR_CTRL.'adminCheck.php');
			} elseif(in_array($pageData['pageName'], $connectCheckPages)) {
				include(DIR_CTRL.'connectCheck.php');
			} elseif(in_array($pageData['pageName'], $loggedCheckPages)) {
				include(DIR_CTRL.'loggedCheck.php');
			}


			if($pageData['readCache']) { // Read HTML
				readfile($pageData['cacheName']);
			} else { // Read PHP
				include_once(FILE_CONFIG);

				if(file_exists(DIR_VIEW.$pageData['pageName']) || file_exists(DIR_CTRL.$pageData['pageName'])) {
					if($pageData['writeCache']) {
						ob_start(); // ouverture du tampon
					}

					if(file_exists(DIR_CTRL.$pageData['pageName'])) {
						include(DIR_CTRL.$pageData['pageName']);
					}

					if(file_exists(DIR_VIEW.$pageData['pageName'])) {
						if(in_array($pageData['pageName'], $menuPages)) {
							include(DIR_VIEW.'menu.php');
						} elseif(in_array($pageData['pageName'], $menuConnectedPages)) {
							include(DIR_VIEW.'menuConnected.php');
						}
						
						
						include(DIR_VIEW.$pageData['pageName']);
					} else {
						http_response_code(404);
						include_once(DIR_ERRORS.'404.html');
						die();
					}

					if(in_array($pageData['pageName'], $menuPages)) {
						
						include_once(DIR_VIEW.'footer.php');
					}

					if($pageData['writeCache']) {
						$pageContent = ob_get_contents(); // copie du contenu du tampon dans une chaîne
						ob_end_clean(); // effacement du contenu du tampon et arrêt de son fonctionnement

						file_put_contents($pageData['cacheName'], $pageContent); // on écrit la chaîne précédemment récupérée ($pageContent) dans un fichier ($pageData['cacheName'])

						echo $pageContent;
					}
				} else {
					http_response_code(404);
					include_once(DIR_ERRORS.'404.html');
					die();
				}
			}
		?>
	</body>
	<!-- Page generated in <?= (round(microtime(true) * 1000) - $debut) ?> ms -->
</html>