<?php
include_once('./basefiles/header.php');
include_once('./basefiles/menu.php');

echo "<section class=\"devblog\">";

$data = $mongoDB->getCondContent("galactae","announces",
		["onBlog" => 1]
);

foreach ($data as $key => $value) {
 	echo "<article>
			<h2>".$value['blog_title_'.$_SESSION['lang']]."</h2>
			<i>".date("d/m/Y",$value['blog_time'])."</i>
			<br/>
			<br/>
			<div class=\"devblog-description\">
				".$value['blog_desc_'.$_SESSION['lang']]."
			</div>
		</article>";
}

echo "</section>";

include_once('./basefiles/footer.php');
?>