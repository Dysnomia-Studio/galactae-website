<?php
echo '<section class="devblog">';

foreach (array_reverse($pageData['blogArticles']) as $key => $value) {
	$value = (array) $value;

	if($value['blog_title'] == NULL) {
		$value['blog_title'] = NOT_TRANSLATED_YET;
	}
	if($value['blog_desc'] == NULL) {
		$value['blog_desc'] = NOT_TRANSLATED_YET;
	}

 	echo '<article>
			<h2>'.$value['blog_title'].'</h2>
			<i>'.date('d/m/Y',$value['blog_time']).'</i>
			<br/>
			<br/>
			<div class="devblog-description">
				'.$value['blog_desc'].'
			</div>
		</article>';
}

echo '</section>';