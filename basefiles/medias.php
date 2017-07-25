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
 			<?php
 			$files = File_Find(["img/backgrounds"], ["png"]);

 			for($i=0; $i<count($files['files'][0]); $i++) {
 				$name = str_replace(".png", "", $files['files'][0][$i]);

 				echo "<li><h3>".$name."</h3>
 					<img src=\"img/backgrounds/".$name."-min.jpg\" onclick=\"FullPictureShow(this.src)\" alt=\"backgrounds ".$name."\">
 					</li>";
 			}
 			?>
		</ul>
		<h1 id="gameEvolution"><?php echo MEDIAS_EVOLUTION; ?></h1>
		<h2><?php echo MEDIAS_EVOLUTION_PLANET; ?></h2>
 		<ul class="picture-list">
 			<?php
 			$files = File_Find(["img/archives/planet"], ["png"]);

 			for($i=(count($files['files'][0])-1); $i>=0; $i--) {
 				$name = str_replace(".png", "", $files['files'][0][$i]);

 				echo "<li><h3>".$name."</h3>
 					<img src=\"img/archives/planet/".$name."-min.jpg\" onclick=\"FullPictureShow(this.src)\" alt=\"planet ".$name."\">
 					</li>";
 			}
 			?>
		</ul>
		<h2><?php echo MEDIAS_EVOLUTION_MAP; ?></h2>
 		<ul class="picture-list">
 		 	<?php
 			$files = File_Find(["img/archives/solar-system"], ["png"]);

 			for($i=(count($files['files'][0])-1); $i>=0; $i--) {
 				$name = str_replace(".png", "", $files['files'][0][$i]);
 				
 				echo "<li><h3>".$name."</h3>
 					<img src=\"img/archives/solar-system/".$name."-min.jpg\" onclick=\"FullPictureShow(this.src)\" alt=\"solar-system ".$name."\">
 					</li>";
 			}
 			?>
		</ul>
		<h2><?php echo MEDIAS_EVOLUTION_PORTAL; ?></h2>
 		<ul class="picture-list">
 		 	<?php
 			$files = File_Find(["img/archives/connectedScreen"], ["png"]);

 			for($i=(count($files['files'][0])-1); $i>=0; $i--) {
 				$name = str_replace(".png", "", $files['files'][0][$i]);
 				
 				echo "<li><h3>".$name."</h3>
 					<img src=\"img/archives/connectedScreen/".$name."-min.jpg\" onclick=\"FullPictureShow(this.src)\" alt=\"connectedScreen ".$name."\">
 					</li>";
 			}
 			?>
		</ul>
		<h2><?php echo MEDIAS_EVOLUTION_INDEX; ?></h2>
 		<ul class="picture-list">
 		 	<?php
 			$files = File_Find(["img/archives/index"], ["png"]);

 			for($i=(count($files['files'][0])-1); $i>=0; $i--) {
 				$name = str_replace(".png", "", $files['files'][0][$i]);
 				
 				echo "<li><h3>".$name."</h3>
 					<img src=\"img/archives/index/".$name."-min.jpg\" onclick=\"FullPictureShow(this.src)\" alt=\"index ".$name."\">
 					</li>";
 			}
 			?>
		</ul>
	</section>
	
	<script type="text/javascript" src="https://***REMOVED***/website/js/medias-pictureShow.js"></script>
<?php
include_once('./basefiles/footer.php');
?>