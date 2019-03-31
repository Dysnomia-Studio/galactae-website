<?php
$gameData = $userMngr->getAllUserGameData($userData['id']);

$privMngr = new PrivilegesManager();

$servers = [
	['addr'=>'00-srv.galactae.eu', 'port'=>42690, 'name'=>DEV, 'link'=>'https://00-dev.galactae.eu', 'playing'=>false, 'server_name' => 'galactae-00'],
	['addr'=>'01-srv.galactae.eu', 'port'=>42691, 'name'=>MILKYWAY, 'link'=>'https://01-milkyway.galactae.eu', 'playing'=>false, 'server_name' => 'galactae-01'],
	['addr'=>'02-srv.galactae.eu', 'port'=>42692, 'name'=>ANDROMEDA, 'link'=>'https://02-andromeda.galactae.eu', 'playing'=>false, 'server_name' => 'galactae-02'],
	//['addr'=>'03-srv.galactae.eu', 'port'=>42693, 'name'=>PEGASUS, 'link'=>'https://03-pegasus.galactae.eu', 'playing'=>false, 'server_name' => 'galactae-03'],
	//['addr'=>'04-srv.galactae.eu', 'port'=>42694, 'name'=>MAGELLAN, 'link'=>'https://04-magellan.galactae.eu', 'playing'=>false, 'server_name' => 'galactae-04']
];

$devPrivileges = $privMngr->getUserPrivilegesOnServer(
	'galactae-00',
	$userData['id']
);

if(isset($devPrivileges['user_whitelist']) && ((int) $devPrivileges['user_whitelist']==1)) {
	$firstServer=0;
} else {
	$firstServer=1;
}

foreach ($gameData as $key => $value) {
	$value = (array) $value;
	$serverid = (int) explode('-',$value['server_name'])[1];

	$servers[$serverid]['playing'] = true;
}

$content_playing = '';
$content_not_playing = '';

for($i=$firstServer; $i<count($servers); $i++) {
	//$servers[$i]['status'] = @fsockopen('localhost', $servers[$i]['port'], $errno, $errstr, 0.1);
	$servers[$i]['status'] = true;

	$server_status = ($servers[$i]['status'])?'server_on':'server_off';

	if($servers[$i]['status']) {
			$srvMngr = new ServerListManager();
			$srv_data = $srvMngr->getServerByName($servers[$i]['server_name']);

			$userPrivileges = $privMngr->getUserPrivilegesOnServer(
				$servers[$i]['server_name'],
				$userData['id']
			);

			if((!isset($srv_data['server_maintenance']) || $srv_data['server_maintenance']==1) && (!isset($userPrivileges['user_whitelist']) || ((int) $userPrivileges['user_whitelist']!=1))) {
				$server_status = 'server_maintenance';
				$server_connect = '<span class="connect">'.MAINTENANCE.'</span>';
			} else {
				$server_status = 'server_on';
				$server_connect = '<a class="connect" href="'.$servers[$i]['link'].'">'.CONNECT.'</a></li>';
			}

	} else {
		$server_status = 'server_off';
		$server_connect = '<span class="connect">'.OFFLINE.'</span>';
	}

	if($servers[$i]['playing']) {
		$content_playing .= '<li id="'.$i.'"><span id="'.$i.'-status" class="'.$server_status.'">•</span> '.$servers[$i]['name'].' '.$server_connect;
	} else {
		$content_not_playing .= '<li id="'.$i.'"><span id="'.$i.'-status" class="'.$server_status.'">•</span> '.$servers[$i]['name'].' '.$server_connect;
	}
	
}