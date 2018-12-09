<?php
class BansManager extends MongoInterface {
	/**
	 * Gets all bans of an user on a specific server
	 *
	 * @param      <string>  $server  Server name
	 * @param      <string>  $uid     User id
	 *
	 * @return     <array>  User Bans data
	 */
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
	
	/**
	 * Get all bans of an user
	 *
	 * @param      <string>  $uid    User id
	 *
	 * @return     <array>  User bans data
	 */
	public function getUserBans($uid) {
		return $this->getCondContent('galactae','bans',[
			'user_id' => $uid
		]);	
	}
}