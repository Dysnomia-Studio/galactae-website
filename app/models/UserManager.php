<?php
class UserManager extends SQLInterface {
	/**
	 * Gets the user by session id
	 *
	 * @param      <string>  $id     The session id
	 *
	 * @return     <array>  User session data
	 */
	public function getUserBySession($id) {
		$data = $this->getCondContent('sessions',
			['user_session_uid' => $id]
		);

		if(isset($data[0])) {
			$data = (array) $data[0];
		}

		return $data;
	}

	/**
	 * Updates user session data
	 */
	public function updateUserSession() {
		$this->updateContent('sessions',
			['user_session_expiration' => (time()+2678400)],
            ['user_session_uid' => $_COOKIE['galactae-phpsessid']]
		);
	}

	/**
	 * Adds a session to database
	 *
	 * @param      <string>  $uid      User id
	 * @param      <string>  $sessid   Session Id
	 * @param      <string>  $browser  Browser simplified user agent
	 */
	public function addSession($uid, $sessid, $browser) {
		$this->addContent('sessions',[[
			'user_id' => $uid,
			'user_session_uid' => $sessid,
			'user_session_expiration' => (time()+2678400),
			'user_agent' => $browser
		]]);
	}

	/**
	 * Removes session by a session id
	 *
	 * @param      <string>  $uid      User id
	 * @param      <string>  $sessid   Session Id
	 */
	public function removeSessionByIds($uid, $sessid) {
		$this->removeContent('sessions',[
			'user_id' => $uid,
			'user_session_uid' => $sessid
		]);
	}

	/**
	 * Gets the global user by its id
	 *
	 * @param      <string>  $id     User id
	 *
	 * @return     <array>  User data
	 */
	public function getGlobalUserById($id) {
		$data = $this->getCondContent('users',
			['id' => $id]
		);

		if(isset($data[0])) {
			$data = (array) $data[0];
		}

		return $data;
	}

	/**
	 * Gets a global user by its name or mail (case insensitive)
	 *
	 * @param      <string>  $name   User name or mail
	 *
	 * @return     <array>  User data
	 */
	public function getGlobalUserByCaseInsensitiveName($name) {
		$data = $this->getILIKECondContent('users',
			['user_name' => preg_quote($name)]
		);

	    if(count($data)==0) { // Test avec le mail
			$data = $this->getILIKECondContent('users',
				['user_mail' => preg_quote($name)]
			);
	    }

		if(isset($data[0])) {
			$data = (array) $data[0];

			if(strtolower($data['user_name']) !== strtolower($name) &&
				strtolower($data['user_mail']) !== strtolower($name)) {
				$data = [];
			}
		}

		return $data;
	}

	/**
	 * Gets a global user by its name (case insensitive)
	 *
	 * @param      <string>  $name   User name
	 *
	 * @return     <array>  User data
	 */
	public function getAllGlobalUsersByCaseInsensitiveName($name) {
		return $this->getILIKECondContent('users',
			['user_name' => preg_quote($name)]
		);
	}

	/**
	 * Adds a global user.
	 *
	 * @param      <string>  $name     User name
	 * @param      <string>  $mail     User mail
	 * @param      <string>  $passwd   User hashed password
	 * @param      <int>     $misc     Misc newsletter choice
	 * @param      <int>     $updates  Updates newsletter choice
	 *
	 * @return     string    Confirmation URL
	 */
	public function addGlobalUser($name, $mail, $passwd, $misc, $updates) {
		$this->addContent('users',[[
			'user_name' => $name,
			'user_mail' => $mail,
			'user_passwd' => $passwd,
			'newsletter_misc' => $misc,
			'newsletter_updates' => $updates,
			'lastViewedNews' => (new BlogManager())->getLastNewsNumber()
		]]);

		$conf_link = Security::hashPassword(time().$name);

		$this->addContent('mailconfirmations',[[
			'user_name' => $name,
			'mailconfirm_uid' => $conf_link
		]]);

		return 'https://galactae.eu/mailconf?mid='.$conf_link.'&username='.$name;
	}

	/**
	 * Gets the user privileges.
	 *
	 * @param      <string>  $id        User id
	 * @param      <string>  $servName  Server name
	 *
	 * @return     <array>   The user privileges.
	 */
	public function getUserPrivileges($id, $servName) {
		$data = $this->getCondContent('privileges',[
			'user_id' => $id,
			'server_name' => $servName
		]);

		if(isset($data[0])) {
			$data = (array) $data[0];
		}

		return $data;
	}

	/**
	 * Gets a list of all user game data
	 *
	 * @param      <string>  $id     User global id
	 *
	 * @return     <array>   All user game data.
	 */
	public function getAllUserGameData($id) {
		return $this->getCondContent('userGameIds',[
			'user_id' => $id
		]);
	}

	/**
	 * Gets the user game data on a specific serer
	 *
	 * @param      <string>  $id        User global id
	 * @param      <string>  $servName  Server name
	 *
	 * @return     <array>  The user game data.
	 */
	public function getUserGameData($id, $servName) {
		$data = $this->getCondContent('userGameIds',[
			'user_id' => (string) $id,
			'server_name' => $servName
		]);

		if(isset($data[0])) {
			$data = (array) $data[0];
		}

		return $data;
	}

	/**
	 * Updates user game data
	 *
	 * @param      <string>  $uid       User global id
	 * @param      <string>  $gid       User game id
	 * @param      <string>  $servName  Server name
	 */
	public function updateUserGameData($uid, $gid, $servName) {
		$this->updateContent('userGameIds',
            [ 'game_id' => $gid ],
			[
				'user_id' => $uid,
				'server_name' => $servName
			]);
	}

	/**
	 * Adds user game data
	 *
	 * @param      <string>  $uid       User global id
	 * @param      <string>  $gid       User game id
	 * @param      <string>  $servName  Server name
	 */
	public function addUserGameData($uid, $gid, $dbname) {
		$this->addContent('userGameIds',[[
			'user_id' => (string) $uid,
			'game_id' => (string) $gid,
			'server_name' => $dbname
		]]);
	}

	/**
	 * Updates the user latest viewed news
	 *
	 * @param      <string>  $uid     User global id
	 * @param      <int>  $newsId  The news identifier
	 */
	public function updateUserLastNews($uid, $newsId) {
		$this->updateContent('users',
            [ 'lastViewedNews' => $newsId ],
			['id' => $uid],
		);
	}
}