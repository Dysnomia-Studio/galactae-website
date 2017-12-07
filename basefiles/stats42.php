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
<select id="days-range" onchange="genReport(parseInt($('#days-range').val()));" style="width: 200px; margin: 0 auto; display: block;">
	<option value="7">7 derniers jours</option>
	<option value="30" selected>30 derniers jours</option>
	<option value="90">3 derniers mois</option>
	<option value="183">6 derniers mois</option>
	<option value="365">12 derniers mois</option>
	<option value="100000">Toute la periode</option>
</select>

<div id="stats" class="graphs"></div>

<script src="https://***REMOVED***/website/js/chartkick.js"></script>
<script src="https://***REMOVED***/website/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
<script type="text/javascript">
	var rawStats = <?php echo json_encode($results); ?>;
	var outStats = [];

	function convertDate(inputFormat) {
		function pad(s) { return (s < 10) ? '0' + s : s; }
		var d = new Date(inputFormat);
		return [pad(d.getFullYear()), pad(d.getMonth()+1), d.getDate()].join('-') + ' ' + [pad(d.getHours()), pad(d.getMinutes()), d.getSeconds()].join(':');
	}


	function genReport(dTime) {
		var minDate = Date.now() - (dTime * 24 * 60 * 60 * 1000);

		for(var server in rawStats) {
			outStats[server] = [];
			for(var i=0; i<rawStats[server].length; i++) {
				if(rawStats[server][i].time < minDate) { continue; } // Keep only what we need

				if(rawStats[server][i-1] == undefined || 
					rawStats[server][i+1] == undefined || 
					rawStats[server][i-1].plCount != rawStats[server][i].plCount ||
					rawStats[server][i+1].plCount != rawStats[server][i].plCount) {

					outStats[server].push([convertDate(rawStats[server][i].time),rawStats[server][i].plCount]);
				}
			}
		}

		var data4Charts = [];

		// Each server
		for(var i in outStats) {
			data4Charts.push({name: i, data: outStats[i]});
		}

		// Then generate full report
		// @ADD: sum

		var visitsChart = new Chartkick.AreaChart("stats", data4Charts);
	}

	genReport(7);
</script>