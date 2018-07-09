<?php
class BansManager extends MongoInterface {
	public function getUserBansOnServer($server, $uid) {
		$data = $this->getCondContent('galactae','bans',[
			'user_id' => $uid,
			'server_name' => $server
		]);

		if(isset($data[0])) {
			$data = (array) $data[0];
		}

		return $data;	
	}
	public function getUserBans($uid) {
		$data = $this->getCondContent('galactae','bans',[
			'user_id' => $uid
		]);
		
		return $data;	
	}
}