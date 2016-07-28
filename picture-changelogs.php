<html>
<head>
	<title>Changelogs</title>
	<link rel="stylesheet" type="text/css" href="lib/css/flexslider.css">

	<!-- jQuery -->
	<script src="lib/js/jquery.min.js"></script>

	<!-- FlexSlider -->
	<script defer src="lib/js/flexslider.js"></script>
	<script type="text/javascript">
		$(window).load(function() {
		  $('.flexslider').flexslider({
		    animation: "slide"
		  });
		});
	</script>
</head>
	<?php
	$scan = array();
	$scan['planet'] = array_reverse(scandir('img/archives/planet'));
	$scan['gameIndex'] = array_reverse(scandir('img/archives/index'));
	?>
<body>
<section id="planet" class="flexslider" style="width: 80%; margin: 0 auto; text-align: center;">
	<h1>Planet</h1>
	<ul class="slides">
	<?php
  	for($i=0; $i<count($scan['planet']); $i++) {
  		$words = explode(".",$scan['planet'][$i]);
  		if($words[3]=="jpg"||$words[3]=="jpeg"||$words[3]=="png"||$words[3]=="bmp") { // Then it's a picture file.
			echo '<li><h3>'.$words[0].'.'.$words[1].'.'.$words[2].'</h3><img src="img/archives/planet/'.$scan['planet'][$i].'"></li>';
		}
	}
	?>
  	</ul>
</section>
<section id="gameIndex" class="flexslider" style="width: 80%; margin: 0 auto; text-align: center;">
	<h1>Game Index</h1>
  <ul class="slides">
	<?php
  	for($i=0; $i<count($scan['gameIndex']); $i++) {
  		$words = explode(".",$scan['gameIndex'][$i]);
  		if($words[3]=="jpg"||$words[3]=="jpeg"||$words[3]=="png"||$words[3]=="bmp") { // Then it's a picture file.
			echo '<li><h3>'.$words[0].'.'.$words[1].'.'.$words[2].'</h3><img src="img/archives/index/'.$scan['gameIndex'][$i].'"></li>';
		}
	}
	?>
  </ul>
</section>
</body>
</html>