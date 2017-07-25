	<img id="hamburger" src="https://***REMOVED***/website/img/hamburger.png" alt="menu">

	<ul <?php if($currentname!="index") { echo "class=\"no-background\""; } ?> id="menu">
		<li class="menu-logo"><a href="index">GALACTAE: SPACE AGE DAWN</a></li>
		<li class="hamSpace"></li> <!-- Necessaire uniquement sur le menu hamburger -->
		<li><a href="login" class="menu-link menu-button"><?php echo MENU_PLAY_NOW; ?></a></li>
		<li><a href="medias" class="menu-link"><?php echo MENU_PICS; ?></a></li>
		<li><a href="blog" class="menu-link"><?php echo MENU_BLOG; ?></a></li>
		<li><a href="forum/" class="menu-link"><?php echo MENU_FORUM; ?></a></li>
		<li><a href="contact" class="menu-link"><?php echo MENU_CONTACT; ?></a></li>
		<li><form action="<?php echo $currentname; ?>.php" method="post" id="language-form">
	        <div id="language-list"></div>
	        <input type="text" id="selected-language" name="selected-language">
		</li>
	</ul>
	<?php 
	if($_SESSION['lang']=="en") { ?>
	<script type="text/javascript">
		window.addEventListener("load", function(){
				changed--;
				iconSelect.setSelectedIndex(1);
		});
	</script>
	<?php } ?>