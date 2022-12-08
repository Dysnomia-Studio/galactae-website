<section class="login-page">
	<ul id="server-list">
		<?php
		$content_playing = ($content_playing=='')?'<li>'.NO_PLAYING_SERVERS.'</li>':$content_playing;
		$content_not_playing = ($content_not_playing=='')?'<li>'.ALL_PLAYING_SERVERS.'</li>':$content_not_playing;

		echo '<li class="title">'.ALREADY_PLAYING_SERVERS.'</li>';

		echo $content_playing;

		echo '<li class="title">'.OTHER_SERVERS.'</li>';

		echo $content_not_playing;

		?>
	</ul>

	<?php
	//Kick message
	if(isset($_GET['kickmsg']) && !empty($_GET['kickmsg']) && $_GET['kickmsg']!='') {
		echo '<div class="system-message" id="kickmsg">'.htmlentities(htmlspecialchars($_GET['kickmsg'])).'</div>';
		?>

		<script type="text/javascript" src="https://cdn.galactae.eu/website/js/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready( function() {
				$('#kickmsg').fadeIn(1000);
				setTimeout(function() {
					$('#kickmsg').fadeOut(1000);
				}, 1000 + 100*$('#kickmsg').text().length);
			});
		</script>
		<?php
	}
	?>
</section>