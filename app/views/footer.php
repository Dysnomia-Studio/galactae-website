<?php
if($pageData['pageName'] == "footer.php") {
	http_response_code(404);
	include_once('errors/404.html');
	die();
}
?>
	<footer>
		<table aria-describedby="First footer">
			<tr class="first-footer">
				<td>
					<ul>
						<li><h3><?php echo THE_GAME; ?></h3></li>
						<li><a href="medias#gameEvolution"><?php echo MEDIAS_EVOLUTION; ?></a></li>
						<li><a href="medias#backgrounds"><?php echo MEDIAS_BACKGROUNDS; ?></a></li>
						<li><a href="blog"><?php echo MENU_BLOG; ?></a></li>
						<li><a href="https://bugs.dysnomia.studio/projects/galactae"><?php echo MENU_BUGTRACKER; ?></a></li>
						<li><a href="https://play.google.com/store/apps/details?id=com.dysnomia.galactae">Android</a></li>
					</ul>
				</td>
				<td>
					<ul>
						<li><h3><?php echo LEGAL_NOTICES; ?></h3></li>
						<li><a href="https://cdn.galactae.eu/website/pdf/cgu.pdf"><?php echo LEGAL_NOTICES_CGU; ?></a></li>
						<li><a href="https://cdn.galactae.eu/website/pdf/cgv.pdf"><?php echo LEGAL_NOTICES_CGV; ?></a></li>
						<li><a href="faq"><?php echo LEGAL_NOTICES_FAQ; ?></a></li>
						<li><a href="contact"><?php echo LEGAL_NOTICES_CONTACT; ?></a></li>
					</ul>
				</td>
				<td>
					<ul>
						<li><h3><?php echo SOCIAL_NETWORKS; ?></h3></li>
						<li><a href="redir/facebook.php">Facebook</a></li>
						<li><a href="redir/itchio.php">Itch.io</a></li>
						<li><a href="redir/twitter.php">Twitter</a></li>
						<li><a href="redir/reddit.php">Reddit</a></li>
						<li><a href="redir/youtube.php">Youtube</a></li>
					</ul>
				</td>
				<td>
					<ul>
						<li><h3><?php echo OTHER_LINKS; ?></h3></li>
						<li><a href="partners"><?php echo OTHER_LINKS_PARTNERS; ?></a></li>
						<li><a href="theteam"><?php echo OTHER_LINKS_THETEAM; ?></a></li>
					</ul>
				</td>
			</tr>
		</table>
		<table aria-describedby="Second footer">
			<tr class="second-footer">
				<td>Galactae: Space Age Dawn - <?php echo COPYRIGHT_NOTICE_01; ?> <a href="https://dysnomia.studio">Dysnomia</a> - Copyright 2016-<?php echo date('Y'); ?> - <?php echo COPYRIGHT_NOTICE_02; ?></td>
			</tr>
		</table>
	</footer>