<html>
<head>
	<title>Changelogs</title>
	<link rel="stylesheet" type="text/css" href="lib/css/style.css">

	<!-- jQuery -->
	<script src="lib/js/jquery.min.js"></script>
	<script type="text/javascript">
		function FullPictureHide() {
			var imgfulldiv = document.getElementById("image-full-div");
				imgfulldiv.style.display = "none";
		}
		function FullPictureShow(newsrc) {
			var imgfulldiv = document.getElementById("image-full-div");
			imgfulldiv.style.display = "block";
			var imgfull = document.getElementById("image-full");
			imgfull.src = newsrc;
		}
	</script>
</head>
	<?php
	$scan = array();
	$scan['planet'] = array_reverse(scandir('img/archives/planet'));
	$scan['gameIndex'] = array_reverse(scandir('img/archives/index'));
	$scan['solar-system'] = array_reverse(scandir('img/archives/solar-system'));
	$scan['connectedScreen'] = array_reverse(scandir('img/archives/connectedScreen'));
	?>
<body>
<div id="image-full-div" onclick="FullPictureHide()">
	<img id="image-full" src="">
</div>
<section id="planet" class="images" style="width: 80%; margin: 0 auto; text-align: center;">
	<h1>Planet</h1>
	<ul>
	<?php
  	for($i=0; $i<count($scan['planet']); $i++) {
  		$words = explode(".",$scan['planet'][$i]);
  		if($words[3]=="jpg"||$words[3]=="jpeg"||$words[3]=="png"||$words[3]=="bmp") { // Then it's a picture file.
			echo '<li><h3>'.$words[0].'.'.$words[1].'.'.$words[2].'</h3><img src="img/archives/planet/'.$scan['planet'][$i].'" onclick="FullPictureShow(this.src)"></li>';
		}
	}
	?>
  	</ul>
</section>
<section id="solar-system" class="images" style="width: 80%; margin: 0 auto; text-align: center;">
	<h1>Solar System</h1>
  <ul>
	<?php
  	for($i=0; $i<count($scan['solar-system']); $i++) {
  		$words = explode(".",$scan['solar-system'][$i]);
  		if($words[3]=="jpg"||$words[3]=="jpeg"||$words[3]=="png"||$words[3]=="bmp") { // Then it's a picture file.
			echo '<li><h3>'.$words[0].'.'.$words[1].'.'.$words[2].'</h3><img src="img/archives/solar-system/'.$scan['solar-system'][$i].'" onclick="FullPictureShow(this.src)"></li>';
		}
	}
	?>
  </ul>
</section>
<section id="connectedScreen" class="images" style="width: 80%; margin: 0 auto; text-align: center;">
	<h1>Connected Screen</h1>
  <ul>
	<?php
  	for($i=0; $i<count($scan['connectedScreen']); $i++) {
  		$words = explode(".",$scan['connectedScreen'][$i]);
  		if($words[3]=="jpg"||$words[3]=="jpeg"||$words[3]=="png"||$words[3]=="bmp") { // Then it's a picture file.
			echo '<li><h3>'.$words[0].'.'.$words[1].'.'.$words[2].'</h3><img src="img/archives/connectedScreen/'.$scan['connectedScreen'][$i].'" onclick="FullPictureShow(this.src)"></li>';
		}
	}
	?>
  </ul>
</section>
<section id="gameIndex" class="images" style="width: 80%; margin: 0 auto; text-align: center;">
	<h1>Game Index</h1>
  <ul>
	<?php
  	for($i=0; $i<count($scan['gameIndex']); $i++) {
  		$words = explode(".",$scan['gameIndex'][$i]);
  		if($words[3]=="jpg"||$words[3]=="jpeg"||$words[3]=="png"||$words[3]=="bmp") { // Then it's a picture file.
			echo '<li><h3>'.$words[0].'.'.$words[1].'.'.$words[2].'</h3><img src="img/archives/index/'.$scan['gameIndex'][$i].'" onclick="FullPictureShow(this.src)"></li>';
		}
	}
	?>
  </ul>
</section>
</body>
</html>