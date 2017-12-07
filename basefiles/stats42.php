<?php
if(!(isset($_COOKIE['galactae-phpsessid']) &&
	$_COOKIE['galactae-phpsessid'] != "")) { // Not Connected
	http_response_code(404);
	include_once('errors/404.html');
	die();
}

$sess_data = $sqlDB->getCondContent("user_session",[
	["user_session_uid",$_COOKIE['galactae-phpsessid'],"str"]
	],0,1,"user_id");

if($sess_data!=false && isset($sess_data[0])) {
	$sess_data = $sess_data[0];
}

if(isset($sess_data['user_id']) && isset($sess_data['user_session_expiration']) && ((int) $sess_data['user_session_expiration'] > time())) {
	if(!isset($sess_data['user_agent']) || $sess_data['user_agent'] != $_SERVER['HTTP_USER_AGENT']) {
		http_response_code(404);
		include_once('errors/404.html');
		die();
	}

	if($lang->getLanguage() != $sess_data['user_session_lang']) {
		$sqlDB->updateContent('user_session',
			[
			 	["user_session_expiration",time()+$expTime,"int"],
				["user_session_lang",$sess_data['user_session_lang'],"str"] 
			],
			[ ["user_session_uid",$_COOKIE['galactae-phpsessid'],"str"] ]
		);
	} else {
		$sqlDB->updateContent('user_session',
			[ ["user_session_expiration",time()+$expTime,"int"] ],
			[ ["user_session_uid",$_COOKIE['galactae-phpsessid'],"str"] ]);
	}
} else {
	http_response_code(404);
	include_once('errors/404.html');
	die();
}

$userData = $sqlDB->getCondContent("user_list",[
	["user_id",$sess_data['user_id'],"int"],
	],0,1,"user_id");

if($userData!=false && isset($userData[0])) {
	$userData = $userData[0];
}

if(!isset($userData['user_name']) || !isset($userData['user_id'])) {
	http_response_code(404);
	include_once('errors/404.html');
	die();
}

if(!isset($userData['user_adminPanelAccess']) || $userData['user_adminPanelAccess']!=1) {
	http_response_code(404);
	include_once('errors/404.html');
	die();
}

if(!isset($_SESSION['lang'])) {
	$_SESSION['lang'] = $sess_data['user_session_lang'];
}

/**
 * Query stats
 */
$manager = new MongoDB\Driver\Manager("***REMOVED***");

$filter = array();
$options = [
    'limit' => 26500, // About 3 months at 1 each 5 min
    'sort' => ['_id' => -1],
];

$query = new MongoDB\Driver\Query($filter, $options);

$servers = [
	"galactae-00"
];

$results = [];

foreach ($servers as $key => $server) {
	$cursor = $manager->executeQuery($server.'.stats', $query);
	$results[$server] = $cursor->toArray();
}
?>

<div id="visits" class="graphs"></div>

<script src="https://***REMOVED***/website/js/chartkick.js"></script>
<script src="https://***REMOVED***/website/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
<script type="text/javascript">
	var stats = <?php echo json_encode($results); ?>;
	var visitsChart = new Chartkick.AreaChart("visits", [ { name: "Visites", data: stats } ]);
</script>