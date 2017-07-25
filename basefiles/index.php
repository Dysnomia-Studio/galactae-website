<?php
include_once('./basefiles/header.php');
include_once('./basefiles/menu.php');
?>
	<section class="top-image" id="top-image">
		<div id="above-top-image">
			<p id="top-images-punchlines">Choose your own government system and control the Universe !</p>
			<div id="join">
				<a href="login.html#register">Join our alpha test for free !</a>
			</div>
		</div>
	</section>
	<section class="index-desc">
		<table>
			<tr>
				<td><h2>Choisissez comment gouverner</h2></td>
				<td><h2>Creez vos propres flottes</h2></td>
				<td><h2>Battez vous pour le controle de la galaxie</h2></td>
			</tr>
			<tr>
				<td><img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=350×200&w=350&h=200" alt="desc1"></td>
				<td><img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=350×200&w=350&h=200" alt="desc2"></td>
				<td><img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=350×200&w=350&h=200" alt="desc3"></td>
			</tr>
			<tr>
				<td><p>Empereur, PDG ou President elu "democratiquement" ? Vous pouvez chosir comment gouverner votre peuple, et c'est de cette decision que decoulera le fonctionnement de votre empire ...</p></td>
				<td><p>Controlez et formez vos flottes afin de defendre vos planetes et attaquer les autres empires !</p></td>
				<td><p>Il faut toujours etendre votre domination chez vos voisins, et pour cela, il va falloir se battre !</p></td>
			</tr>
		</table>
	</section>
	<script type="text/javascript">
		// Script pour texte aleatoire dans la "top-image"
		window.addEventListener("load",function() {
			var count= 1; //Pour eviter d'avoir pendant 10 secondes la phrase de départ
			var phrases = ["Choose your own government system and control the Universe !","Fight your ennemies throught the galaxies !","Expand your empire to make other fear you !"];

			setInterval(function() {
				document.getElementById('top-images-punchlines').innerHTML = phrases[count];
				count++;
				if(count>phrases.length - 1) { count = 0; }
			},5000);
		});
	</script>
<?php
include_once('./basefiles/footer.php');
?>