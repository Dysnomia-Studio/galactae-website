<?php
class BlogManager extends MongoInterface {
	public function getAllBlogArticles() {
		$articles = $this->getCondContent('galactae','announces',
				['onBlog' => 1]
		);
		
		return $articles;
	}
}