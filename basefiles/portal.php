<?php
include_once('./basefiles/connectCheck.php');
include_once('./basefiles/header.php');

$gameData = $sqlDB->getCondContent("user_game_id",[
	["user_id",$userData['user_id'],"int"],
	],0,1000,"server_name");
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
		["addr"=>"00-srv.galactae.eu", "port"=>42690, "name"=>DEV, "link"=>"https://00-dev.galactae.eu", "playing"=>false],
		["addr"=>"01-srv.galactae.eu", "port"=>42691, "name"=>MILKYWAY, "link"=>"https://01-milkyway.galactae.eu", "playing"=>false],
		["addr"=>"02-srv.galactae.eu", "port"=>42692, "name"=>ANDROMEDA, "link"=>"https://02-andromeda.galactae.eu", "playing"=>false],
		["addr"=>"03-srv.galactae.eu", "port"=>42693, "name"=>PEGASUS, "link"=>"https://03-pegasus.galactae.eu", "playing"=>false],
		//["addr"=>"04-srv.galactae.eu", "port"=>42694, "name"=>MAGELLAN, "link"=>"https://04-magellan.galactae.eu"]
	];

	$devPrivileges = $sqlDB->getCondContent("user_privileges",[
	["user_id",$userData['user_id'],"int"],
	["server_name","galactae-00","str"]
	],0,1000,"server_name");

	var_dump($devPrivileges);

	if(isset($devPrivileges['user_whitelist']) && ((int) $devPrivileges['user_whitelist']==1)) {
		$firstServer=0;
	} else {
		$firstServer=1;
	}

	foreach ($gameData as $key => $value) {
		$serverid = (int) explode("-",$value['server_name'])[1];

		$servers[$serverid]["playing"] = true;
	}

	$content_playing = "";
	$content_not_playing = "";

	for($i=$firstServer; $i<count($servers); $i++) {
		$servers[$i]['status'] = @fsockopen($servers[$i]["addr"], $servers[$i]["port"], $errno, $errstr, 0.1);

		$server_status = ($servers[$i]['status'])?'server_on':'server_off';

		$server_connect = ($servers[$i]['status'])?'<a class="connect" href="'.$servers[$i]['link'].'">'.CONNECT.'</a></li>':'<span class="connect">'.OFFLINE.'</span>';


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
</body>