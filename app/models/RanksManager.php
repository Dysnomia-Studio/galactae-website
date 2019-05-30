<?php
class RanksManager extends SQLInterface {
	public function getGlobalListByName($player) {
		global $dbname;
		
		return $this->selectQuery('SELECT name, points, planets, ROW_NUMBER() OVER(ORDER BY points DESC) AS rank
			FROM "globalRanks"
			WHERE server_name = :serverName
			OFFSET GREATEST((
				SELECT rank FROM (
					SELECT name, ROW_NUMBER() OVER(ORDER BY points DESC) AS rank
					FROM "globalRanks"
					WHERE server_name = :serverName
				) ranksList WHERE name = :userName
			) - 5, 0) LIMIT 10', 
		[
			'serverName' => $dbname,
			'userName' => $player
		]);
	}

	public function getGlobalListByGameIdAndServer($gameId, $serverName) {
		
		return $this->selectQuery('SELECT name, points, planets, server_name, (
				SELECT rank FROM (
					SELECT game_id, ROW_NUMBER() OVER(ORDER BY points DESC) AS rank
					FROM "globalRanks"
					WHERE server_name = :serverName
				) ranksList WHERE game_id = :game_id
			) AS rank
			FROM "globalRanks"
			WHERE server_name = :serverName
			AND game_id = :game_id', 
		[
			'serverName' => $serverName,
			'game_id' => $gameId
		]);
	}

	public function getSectorListByNameAndSector($userName, $sector) {
		global $dbname;
		
		return $this->selectQuery('SELECT name, points, planets, ROW_NUMBER() OVER(ORDER BY points DESC) AS rank
			FROM "sectorRanks"
			WHERE server_name = :serverName
			AND sector = :sector
			OFFSET GREATEST((
				SELECT rank FROM (
					SELECT name, ROW_NUMBER() OVER(ORDER BY points DESC) AS rank
					FROM "sectorRanks"
					WHERE server_name = :serverName
					AND sector = :sector
				) ranksList WHERE name = :userName
			) - 5, 0) LIMIT 10', 
		[
			'serverName' => $dbname,
			'userName' => $player,
			'sector' => $sector
		]);
	}

	public function getSectorListByGameIdAndServer($gameId, $serverName) {
		
		return $this->selectQuery('SELECT name, points, planets, server_name, sector, (
				SELECT rank FROM (
					SELECT game_id, ROW_NUMBER() OVER(ORDER BY points DESC) AS rank
					FROM "sectorRanks"
					WHERE server_name = :serverName AND sector = SR.sector
				) ranksList WHERE game_id = :game_id
			) AS rank
			FROM "sectorRanks" as SR
			WHERE server_name = :serverName
			AND game_id = :game_id', 
		[
			'serverName' => $serverName,
			'game_id' => $gameId
		]);
	}
}