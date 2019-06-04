<?php
if($pageData['pageName'] == "menuConnected.php") {
	http_response_code(404);
	include_once('errors/404.html');
	die();
}
?>
	<img id="hamburger" src="https://***REMOVED***/website/img/hamburger.png" alt="menu">
	<ul id="menu">
		<li class="menu-logo">
			<a href="index">GALACTAE: SPACE AGE DAWN</a>
		</li>
		<li class="hamSpace"></li>
		<li><a href="portal" class="menu-link"><?php echo PORTAL; ?></a></li>
		<li><a href="profil" class="menu-link"><?php echo PROFIL; ?></a></li>
		<li><a href="support" class="menu-link"><?php echo SUPPORT; ?></a></li>
		<li><a href="deconnexion" class="menu-link"><?php echo DISCONNECT; ?></a></li>
	</ul>