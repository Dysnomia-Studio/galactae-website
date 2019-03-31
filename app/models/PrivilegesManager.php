<?php
class PrivilegesManager extends SQLInterface {

	/**
	 * Gets the user privileges on a specific server
	 *
	 * @param      <string>  $server  Server name
	 * @param      <string>  $uid     Global user id
	 *
	 * @return     <array>  User privileges on this server
	 */
	public function getUserPrivilegesOnServer($server, $uid) {
		$data = $this->getCondContent('privileges',[
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
		return $this->getCondContent('privileges',[
			'user_id' => $uid
		]);
	}
}