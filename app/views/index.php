	<section class="top-image" id="top-image">
		<div id="above-top-image">
			<p id="top-images-punchlines"></p>
			<div id="join">
				<a href="login.html#register"><?= BETA_TEST ?></a>
			</div>
		</div>
	</section>
	
	<div id="image-full-div">
		<img src="?" id="image-full">
	</div>

	<section class="index-desc">
		<table class="computer-table">
			<tr>
				<td><h2><?= INDEX_TITLE_1 ?></h2></td>
				<td><h2><?= INDEX_TITLE_2 ?></h2></td>
				<td><h2><?= INDEX_TITLE_3 ?></h2></td>
			</tr>
			<tr>
				<td><img src="https://***REMOVED***/website/img/officialPosts/gvt-choice-min.jpg"  onclick="FullPictureShow(this.src)" alt="how to govern"></td>
				<td><img src="https://***REMOVED***/website/img/officialPosts/ship-create-min.jpg" onclick="FullPictureShow(this.src)" alt="create your own fleet"></td>
				<td><img src="https://***REMOVED***/website/img/officialPosts/galaxy-map-min.jpg"  onclick="FullPictureShow(this.src)" alt="beat for galaxy control"></td>
			</tr>
			<tr>
				<td><p><?= INDEX_DESC_1 ?></p></td>
				<td><p><?= INDEX_DESC_2 ?></p></td>
				<td><p><?= INDEX_DESC_3 ?></p></td>
			</tr>
		</table>

		<table class="mobile-table">
			<tr><td><h2><?= INDEX_TITLE_1 ?></h2></td></tr>
			<tr><td><img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=355×200&w=355&h=200" alt="how to govern"></td></tr>
			<tr><td><p><?= INDEX_DESC_1 ?></p></td></tr>
		</table>
		<table class="mobile-table">
			<tr><td><h2><?= INDEX_TITLE_2 ?></h2></td></tr>
			<tr><td><img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=355×200&w=355&h=200" alt="create your own fleet"></td></tr>
			<tr><td><p><?= INDEX_DESC_2 ?></p></td></tr>
		</table>
		<table class="mobile-table">
			<tr><td><h2><?= INDEX_TITLE_3 ?></h2></td></tr>
			<tr><td><img src="https://placeholdit.imgix.net/~text?txtsize=33&txt=355×200&w=355&h=200" alt="beat for galaxy control"></td></tr>
			<tr><td><p><?= INDEX_DESC_3 ?></p></td></tr>
		</table>
	</section>

	<script type="text/javascript">
		var count=0;
		// Script pour texte aleatoire dans la "top-image"
		function changePunchline() {
			document.getElementById('top-images-punchlines').innerHTML = indexPunchlines[count];
				count++;
				if(count>indexPunchlines.length - 1) { count = 0; }
		}
		window.addEventListener('load',function() {	setInterval(function() { changePunchline(); },5000); });
		changePunchline();
	</script>
	<script type="text/javascript" src="https://***REMOVED***/website/js/medias-pictureShow.js"></script>