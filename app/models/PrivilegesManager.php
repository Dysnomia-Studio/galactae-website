<?php
class PrivilegesManager extends MongoInterface {
	public function getUserPrivilegesOnServer($server, $uid) {
		$data = $this->getCondContent('galactae','privileges',[
			'user_id' => $uid,
			'server_name' => $server
		]);

		if(isset($data[0])) {
			$data = (array) $data[0];
		}

		return $data;	
	}
	public function getUserPrivileges($uid) {
		$data = $this->getCondContent('galactae','privileges',[
			'user_id' => $uid
		]);
		
		return $data;	
	}
}