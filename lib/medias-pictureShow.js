/* Code d'affichage/masquage de l'apercu d'une image dans la gallerie.
L'animation est faite en CSS directement */
function FullPictureHide() {
	document.getElementById("image-full-div").className = "hidenShow";

	/* Remove class just before animation end */
	setTimeout(function() {
		document.getElementById("image-full-div").className = "";
	}, 490);
}
function FullPictureShow(newsrc) {
	document.getElementById("image-full").src = newsrc.replace("-min.jpg", ".png");

	document.getElementById("image-full-div").className = "showedShow";
}

/* Pour retirer l'image */
window.addEventListener('load',function() {
	document.getElementById('image-full-div').addEventListener('click',FullPictureHide);
});