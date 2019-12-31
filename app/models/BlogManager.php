<?php
class BlogManager extends SQLInterface {
	/**
	 * Gets the latest news number.
	 *
	 * @return     integer  The last news number.
	 */
	public function getLastNewsNumber() {
		$lastNews = $this->getCondContent('announces',
			['onGame' => true]
		);

		$lastNewsNumber = 0;
		if(isset($lastNews[0])) {
			foreach($lastNews as $value) {
				$value = (array) $value;
				if($value['id'] > $lastNewsNumber) {
					$lastNewsNumber = $value['id'];
				}
			}
		}

		return $lastNewsNumber;
	}

	/**
	 * Gets all games news.
	 *
	 * @return     <array>  All games news.
	 */
	public function getAllGamesNews() {
		global $lang;

        return $this->selectQuery('SELECT * FROM announces LEFT JOIN announces_text ON announces.id = announces_text.blog_id WHERE "onGame" = :onGame AND blog_language = :blog_language',
				['onGame' => 'true',
                 'blog_language' => $lang->getLanguage()]
		);
	}

	/**
	 * Gets all news referenced as blog articles
	 *
	 * @return     <array>  All blog articles.
	 */
	public function getAllBlogArticles() {
		global $lang;

        return $this->selectQuery('SELECT * FROM announces LEFT JOIN announces_text ON announces.id = announces_text.blog_id AND blog_language = :blog_language WHERE "onBlog" = :onBlog',
				['onBlog' => 'true',
                 'blog_language' => $lang->getLanguage()]
		);
	}
}