<?php
include_once('./basefiles/connectCheck.php');
include_once('./basefiles/header.php');

$gameData = $mongoDB->getCondContent("galactae","game_ids",
	["_id" => $userData['_id']]
);
?>
<body class="portal-body login-page"">
	<img id="hamburger" src="https://***REMOVED***/website/img/hamburger.png" alt="menu">
	<ul id="menu">
		<li class="menu-logo">
			<a href="index">GALACTAE: SPACE AGE DAWN</a>
		</li>
		<li class="hamSpace"></li>
		<li><a href="forum" class="menu-link"><?php echo FORUM; ?></a></li>
		<li><a href="profil" class="menu-link"><?php echo PROFIL; ?></a></li>
		<li><a href="support" class="menu-link"><?php echo SUPPORT; ?></a></li>
		<li><a href="deconnexion" class="menu-link"><?php echo DISCONNECT; ?></a></li>
	</ul>
	<ul id="server-list">
	<?php
	$servers = [
		["addr"=>"00-srv.galactae.eu", "port"=>42690, "name"=>DEV, "link"=>"https://00-dev.galactae.eu", "playing"=>false, "server_name" => "galactae-00"],
		["addr"=>"01-srv.galactae.eu", "port"=>42691, "name"=>MILKYWAY, "link"=>"https://01-milkyway.galactae.eu", "playing"=>false, "server_name" => "galactae-01"],
		["addr"=>"02-srv.galactae.eu", "port"=>42692, "name"=>ANDROMEDA, "link"=>"https://02-andromeda.galactae.eu", "playing"=>false, "server_name" => "galactae-02"],
		["addr"=>"03-srv.galactae.eu", "port"=>42693, "name"=>PEGASUS, "link"=>"https://03-pegasus.galactae.eu", "playing"=>false, "server_name" => "galactae-03"],
		//["addr"=>"04-srv.galactae.eu", "port"=>42694, "name"=>MAGELLAN, "link"=>"https://04-magellan.galactae.eu", "playing"=>false, "server_name" => "galactae-04"]
	];

	$devPrivileges = $mongoDB->getCondContent("galactae","privileges",[
		"_id" => $userData['_id'],
		"server_name" => "galactae-00"
	]);

	if(count($devPrivileges) > 0 && isset($devPrivileges[0])) {
		$devPrivileges = (array) $devPrivileges[0];
	}

	if(isset($devPrivileges['user_whitelist']) && ((int) $devPrivileges['user_whitelist']==1)) {
		$firstServer=0;
	} else {
		$firstServer=1;
	}

	foreach ($gameData as $key => $value) {
		$value = (array) $value;
		$serverid = (int) explode("-",$value['server_name'])[1];

		$servers[$serverid]["playing"] = true;
	}

	$content_playing = "";
	$content_not_playing = "";

	for($i=$firstServer; $i<count($servers); $i++) {
		$servers[$i]['status'] = @fsockopen($servers[$i]["addr"], $servers[$i]["port"], $errno, $errstr, 0.1);

		$server_status = ($servers[$i]['status'])?'server_on':'server_off';

		if($servers[$i]['status']) {
				$srv_data = $mongoDB->getCondContent("galactae","servers",[
					"server_name" => $servers[$i]['server_name']
				]);

				if(count($srv_data) > 0 && isset($srv_data[0])) {
					$srv_data = (array) $srv_data[0];
				}

				$userPrivileges = $mongoDB->getCondContent("galactae","privileges",[
					"_id" => $userData['_id'],
					"server_name" => $servers[$i]['server_name']
				]);

				if(count($userPrivileges) > 0 && isset($userPrivileges[0])) {
					$userPrivileges = (array) $userPrivileges[0];
				}

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


		if($servers[$i]["playing"]) {
			$content_playing .= '<li id="'.$i.'"><span id="'.$i.'-status" class="'.$server_status.'">•</span> '.$servers[$i]['name'].' '.$server_connect;
		} else {
			$content_not_playing .= '<li id="'.$i.'"><span id="'.$i.'-status" class="'.$server_status.'">•</span> '.$servers[$i]['name'].' '.$server_connect;
		}
		
	}

	$content_playing = ($content_playing=="")?'<li>'.NO_PLAYING_SERVERS.'</li>':$content_playing;
	$content_not_playing = ($content_not_playing=="")?'<li>'.ALL_PLAYING_SERVERS.'</li>':$content_not_playing;

	echo '<li class="title">'.ALREADY_PLAYING_SERVERS.'</li>';

	echo $content_playing;

	echo '<li class="title">'.OTHER_SERVERS.'</li>';

	echo $content_not_playing;

	?>
	</ul>

	<?php
	//Kick message
	if(isset($_GET['kickmsg']) && !empty($_GET['kickmsg']) && $_GET['kickmsg']!="") {
		echo '<div class="system-message" id="kickmsg">'.htmlentities(htmlspecialchars($_GET['kickmsg'])).'</div>';
		?>

		<script type="text/javascript" src="https://***REMOVED***/website/js/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready( function() {
				$("#kickmsg").fadeIn(1000);
				setTimeout(function() {
					$("#kickmsg").fadeOut(1000);
				}, 1000 + 100*$("#kickmsg").text().length);	
			});
		</script>
		<?php
	}
	?>
</body>