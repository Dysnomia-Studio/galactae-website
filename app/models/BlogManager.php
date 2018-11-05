<?php
class BlogManager extends MongoInterface {

	/**
	 * Gets all news referenced as blog articles
	 *
	 * @return     <array>  All blog articles.
	 */
	public function getAllBlogArticles() {
		return $this->getCondContent('galactae','announces',
				['onBlog' => 1]
		);
	}
}