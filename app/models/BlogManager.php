<?php
class BlogManager extends MongoInterface {
	public function getAllBlogArticles() {
		return $this->getCondContent('galactae','announces',
				['onBlog' => 1]
		);
	}
}