<?php
include_once('./basefiles/header.php');
include_once('./basefiles/menu.php');
?>
	<div id="image-full-div">
		<img src="?" id="image-full">
	</div>

	<section class="medias">
		<h1 id="backgrounds"><?php echo MEDIAS_BACKGROUNDS; ?></h1>
 		<ul class="picture-list">
			<li><img src="img/backgrounds/0-min.jpg" onclick="FullPictureShow(this.src)" alt="background 1"></li>
			<li><img src="img/backgrounds/1-min.jpg" onclick="FullPictureShow(this.src)" alt="background 2"></li>
			<li><img src="img/backgrounds/2-min.jpg" onclick="FullPictureShow(this.src)" alt="background 3"></li>
		</ul>
		<h1 id="gameEvolution"><?php echo MEDIAS_EVOLUTION; ?></h1>
		<h2><?php echo MEDIAS_EVOLUTION_PLANET; ?></h2>
 		<ul class="picture-list">
			<li><h3>0.2.0</h3><img src="img/archives/planet/0.2.0-min.jpg" onclick="FullPictureShow(this.src)" alt="planet 0.2.0">></li>
			<li><h3>0.1.1</h3><img src="img/archives/planet/0.1.1-min.jpg" onclick="FullPictureShow(this.src)" alt="planet 0.1.1">></li>
			<li><h3>0.1.0</h3><img src="img/archives/planet/0.1.0-min.jpg" onclick="FullPictureShow(this.src)" alt="planet 0.1.0"></li>
			<li><h3>0.0.7</h3><img src="img/archives/planet/0.0.7-min.jpg" onclick="FullPictureShow(this.src)" alt="planet 0.0.7"></li>
			<li><h3>0.0.6</h3><img src="img/archives/planet/0.0.6-min.jpg" onclick="FullPictureShow(this.src)" alt="planet 0.0.6"></li>
			<li><h3>0.0.4</h3><img src="img/archives/planet/0.0.4-min.jpg" onclick="FullPictureShow(this.src)" alt="planet 0.0.4"></li>
			<li><h3>0.0.2</h3><img src="img/archives/planet/0.0.2-min.jpg" onclick="FullPictureShow(this.src)" alt="planet 0.0.2"></li>
		</ul>
		<h2><?php echo MEDIAS_EVOLUTION_MAP; ?></h2>
 		<ul class="picture-list">
			<li><h3>0.1.0</h3><img src="img/archives/solar-system/0.1.0-min.jpg" onclick="FullPictureShow(this.src)" alt="solar system 0.1.0"></li>
		</ul>
		<h2><?php echo MEDIAS_EVOLUTION_PORTAL; ?></h2>
 		<ul class="picture-list">
			<li><h3>0.1.1</h3><img src="img/archives/connectedScreen/0.1.1-min.jpg" onclick="FullPictureShow(this.src)" alt="server list 0.1.1"></li>
		</ul>
		<h2><?php echo MEDIAS_EVOLUTION_INDEX; ?></h2>
 		<ul class="picture-list">
 			<li><h3>0.1.2</h3><img src="img/archives/index/0.1.2-min.jpg" onclick="FullPictureShow(this.src)" alt="index 0.1.2"></li>
			<li><h3>0.0.4</h3><img src="img/archives/index/0.0.4-min.jpg" onclick="FullPictureShow(this.src)" alt="index 0.0.4"></li>
		</ul>
	</section>
	
	<script type="text/javascript" src="lib/medias-pictureShow.js"></script>
<?php
include_once('./basefiles/footer.php');
?>