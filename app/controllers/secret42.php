<?php
/**
 * Admin Credientals
 */
$admin_user = '***REMOVED***';
$admin_passwd = '***REMOVED***';

$serverList = [
	['addr'=>'00-srv.galactae.eu', 'port'=>42690, 'name'=>DEV, 'link'=>'https://00-dev.galactae.eu'],
	['addr'=>'01-srv.galactae.eu', 'port'=>42691, 'name'=>MILKYWAY, 'link'=>'https://01-milkyway.galactae.eu'],
	['addr'=>'02-srv.galactae.eu', 'port'=>42692, 'name'=>ANDROMEDA, 'link'=>'https://02-andromeda.galactae.eu'],
	//['addr'=>'03-srv.galactae.eu', 'port'=>42693, 'name'=>PEGASUS, 'link'=>'https://03-pegasus.galactae.eu']
	//['addr'=>'04-srv.galactae.eu', 'port'=>42694, 'name'=>MAGELLAN, 'link'=>'https://04-magellan.galactae.eu']
];

/**
 * Get Server data
 */
$serverMngr = new ServerListManager();
$serversDbData = $serverMngr->getAllServers();
for ($i=0; $i < count($serverList); $i++) { 
	$server = json_decode(json_encode($serversDbData[$i]), true);

	foreach ($server as $key => $value) {
		$serverList[$i][$key] = $value;
	}
}