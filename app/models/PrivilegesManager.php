<?php
class PrivilegesManager extends MongoInterface {

	/**
	 * Gets the user privileges on a specific server
	 *
	 * @param      <string>  $server  Server name
	 * @param      <string>  $uid     Global user id
	 *
	 * @return     <array>  User privileges on this server
	 */
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


	/**
	 * Gets the user privileges on all servers
	 *
	 * @param      <string>  $uid    Global user id
	 *
	 * @return     <array>  User privileges on all server
	 */
	public function getUserPrivileges($uid) {
		$data = $this->getCondContent('galactae','privileges',[
			'user_id' => $uid
		]);
		
		return $data;	
	}
}