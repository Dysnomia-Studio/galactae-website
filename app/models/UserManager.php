<?php
class UserManager extends MongoInterface {
	public function getUserBySession($id) {
		$data = $this->getCondContent('galactae','sessions',
			['user_session_uid' => $id]
		);

		if(isset($data[0])) {
			$data = (array) $data[0];
		}

		return $data;
	}

	public function updateUserSession() {
		$this->updateContent('galactae','sessions',
			['user_session_uid' => $_COOKIE['galactae-phpsessid']],
			[ '$set' => [
				 	'user_session_expiration' => (time()+2678400)
				]
			]		
		);
	}

	public function addSession($uid, $sessid, $browser) {
		$this->addContent('galactae','sessions',[
			'user_id' => $uid,
			'user_session_uid' => $sessid,
			'user_session_expiration' => (time()+2678400),
			'user_agent' => $browser
		]);
	}

	public function removeSessionByIds($uid, $sessid) {
		$this->removeContent('galactae','sessions',[
			'user_id' => $uid,
			'user_session_uid' => $sessid
		]);
	}

	public function getGlobalUserById($id) {
		$data = $this->getCondContent('galactae','users',
			["_id" => $id]
		);

		if(isset($data[0])) {
			$data = (array) $data[0];
		}

		return $data;
	}

	public function getGlobalUserByCaseInsensitiveName($name) {
		$data = $this->getCondContent('galactae','users',
			['user_name' => new \MongoDB\BSON\Regex('^'.preg_quote($name).'$', 'i')]
		);

	    if(count($data)==0) { // Test avec le mail
			$data = $this->getCondContent('galactae','users',
				['user_mail' => new \MongoDB\BSON\Regex('^'.preg_quote($name).'$', 'i')]
			);
	    }

		if(isset($data[0])) {
			$data = (array) $data[0];
		}

		return $data;
	}

	public function addGlobalUser($name, $mail, $passwd, $misc, $updates) {

		$this->addContent('galactae','users',[
			'user_name' => $name,
			'user_mail' => $mail,
			'user_passwd' => $passwd,
			'newsletter_misc' => $misc,
			'newsletter_updates' => $updates
		]);

		$conf_link = Security::hashPassword(time().$name);

		$mongoDB->addContent('galactae','mailconfirmations',[
			'user_name' => $data['user_name'],
			'mailconfirm_uid' => $conf_link
		]);

		$conf_link = 'https://galactae.eu/mailconf?mid='.$conf_link.'&username='.$user_name;

		
		return $conf_link;
	}

	public function getUserPrivileges($id, $servName) {
		$data = $this->getCondContent('galactae','privileges',[
			"user_id" => $id,
			"server_name" => $servName
		]);

		if(isset($data[0])) {
			$data = (array) $data[0];
		}

		return $data;
	}

	public function getAllUserGameData($id) {
		$data = $this->getCondContent('galactae','game_ids',[
			"user_id" => (string) $id
		]);

		if(isset($data[0])) {
			$data = (array) $data[0];
		}

		return $data;
	}

	public function getUserGameData($id, $servName) {
		$data = $this->getCondContent('galactae','game_ids',[
			"user_id" => (string) $id,
			"server_name" => $servName
		]);

		if(isset($data[0])) {
			$data = (array) $data[0];
		}

		return $data;
	}

	public function updateUserGameData($uid, $gid) {
		$this->updateContent('galactae','game_ids', 
			["user_id" => $uid], 
			["game_id" => $gid]);
	}

	public function updateUserLastNews($uid, $newsId) {
		$this->updateContent('galactae','users',
			['_id' => $uid],
			[ '$set' => [
				 	'lastViewedNews' => $newsId
				]
			]		
		);
	}
}