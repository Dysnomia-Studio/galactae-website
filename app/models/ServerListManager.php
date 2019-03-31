<?php
class ServerListManager extends SQLInterface {


	/**
	 * Gets the server informations by its name.
	 *
	 * @param      <string>  $name   The server name
	 *
	 * @return     <array>  Server informations
	 */
	public function getServerByName($name) {
		$data = $this->getCondContent('servers',
			["server_name" => $name]
		);

		if(isset($data[0])) {
			$data = (array) $data[0];
		}

		return $data;
	}

	/**
	 * Gets all servers data
	 *
	 * @return     <type>  All servers data
	 */
	public function getAllServers() {
		return $this->getContent('servers');
	}
}