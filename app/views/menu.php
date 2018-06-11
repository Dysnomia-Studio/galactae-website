<?php
if($pageData['pageName'] == "menu.php") {
	http_response_code(404);
	include_once('errors/404.html');
	die();
}
?>
	<img id="logo" alt="logo" style="display: none;" src="https://***REMOVED***/website/img/bannersAndLogos/galactae-logo-512.jpg">

	<img id="hamburger" src="https://***REMOVED***/website/img/hamburger.png" alt="menu">

	<ul <?php if($pageData['pageName'] != 'index.php') { echo 'class="no-background"'; } ?> id="menu">
		<li class="menu-logo"><a href="index">GALACTAE: SPACE AGE DAWN</a></li>
		<li><a href="login" class="menu-link menu-button"><?php echo MENU_PLAY_NOW; ?></a></li>
		<li><a href="medias" class="menu-link"><?php echo MENU_PICS; ?></a></li>
		<li><a href="blog" class="menu-link"><?php echo MENU_BLOG; ?></a></li>
		<li><a href="forum/" class="menu-link"><?php echo MENU_FORUM; ?></a></li>
		<li><a href="contact" class="menu-link"><?php echo MENU_CONTACT; ?></a></li>
		<li><form method="post" id="language-form">
	        <div id="language-list"></div>
	        <input type="text" id="selected-language" name="selected-language">
	    </form>
		</li>
	</ul>
	<?php 
	if($lang->getLanguage()=='en') { ?>
	<script type="text/javascript">
		window.addEventListener('load', function(){
				changed--;
				iconSelect.setSelectedIndex(1);
		});
	</script>
	<?php } ?>

	<script type="text/javascript" src="https://***REMOVED***/website/js/iconselect/control/iconselect.js"></script>
	<script type="text/javascript" src="https://***REMOVED***/website/js/iconselect/iscroll.js"></script>
	<script type="text/javascript" src="https://***REMOVED***/website/js/language-list.js"></script>