<?php
class ServerListManager extends MongoInterface {
	public function getServerByName($name) {
		$data = $this->getCondContent('galactae','servers',
			["server_name" => $name]
		);

		if(isset($data[0])) {
			$data = (array) $data[0];
		}

		return $data;
	}

	public function getAllServers() {
		return $this->getCondContent('galactae','servers', []);
	}
}