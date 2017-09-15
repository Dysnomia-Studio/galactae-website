<?php
if(!(isset($_SESSION['username']) &&
	$_SESSION['username'] != "" &&
	isset($_SESSION['id']) &&
	$_SESSION['id'] !=0)) { // Not Connected

	header('Location: index');
}

include_once('./basefiles/header.php');

$sqlDB->updateContent('users',
	[ ["session_id",session_id(),"str"] ],
	[ ["user_id",$_SESSION['id'],"str"] ]);

$userData = $sqlDB->getCondContent("users",[
	["user_name",$_SESSION['username'],"int"],
	],0,1,"user_id");

if($userData!=false && isset($userData[0])) {
	$userData = $userData[0];
}

$gameData = $sqlDB->getCondContent("game_id",[
	["id",$userData['user_id'],"int"],
	],0,1000,"server_name");
?>
<body class="portal-body login-page"">
	<ul id="menu">
		<li class="menu-logo">
			<a href="index">GALACTAE: SPACE AGE DAWN</a>
		</li>
		<li class="hamSpace"></li>
		<li><a href="forum" class="menu-link">Forum</a></li>
		<li><a href="profil" class="menu-link">Profil</a></li>
		<li><a href="support" class="menu-link">Support</a></li>
		<li><a href="disconnect" class="menu-link">Deconnexion</a></li>
	</ul>
	<ul id="server-list">
		<li class="title">Galaxies où vous êtes present</li>
	<?php
	$servers = [
		["addr"=>"00-srv.galactae.eu", "port"=>42690, "name"=>DEV, "link"=>"https://00-dev.galactae.eu", "playing"=>false],
		["addr"=>"01-srv.galactae.eu", "port"=>42691, "name"=>MILKYWAY, "link"=>"https://01-milkyway.galactae.eu", "playing"=>false],
		["addr"=>"02-srv.galactae.eu", "port"=>42692, "name"=>ANDROMEDA, "link"=>"https://02-andromeda.galactae.eu", "playing"=>false],
		["addr"=>"03-srv.galactae.eu", "port"=>42693, "name"=>PEGASUS, "link"=>"https://03-pegasus.galactae.eu", "playing"=>false],
		//["addr"=>"04-srv.galactae.eu", "port"=>42694, "name"=>MAGELLAN, "link"=>"https://04-magellan.galactae.eu"]
	];

	if(isset($userData['whitelisted']) && $userData['whitelisted']) {
		$dev=0;
	} else {
		$dev=1;
	}

	foreach ($gameData as $key => $value) {
		$serverid = (int) explode("-",$value['server_name'])[1];

		$servers[$serverid]["playing"] = true;
	}

	$content_playing = "";
	$content_not_playing = "";

	for($i=$dev; $i<count($servers); $i++) {
		$servers[$i]['status'] = @fsockopen($servers[$i]["addr"], $servers[$i]["port"], $errno, $errstr, 0.1);

		$server_status = ($servers[$i]['status'])?'server_on':'server_off';

		$server_connect = ($servers[$i]['status'])?'<a class="connect" href="'.$servers[$i]['link'].'">'.CONNECT.'</a></li>':'';


		if($servers[$i]["playing"]) {
			$content_playing .= '<li id="'.$i.'"><span id="'.$i.'-status" class="'.$server_status.'">•</span> '.$servers[$i]['name'].' '.$server_connect;
		} else {
			$content_not_playing .= '<li id="'.$i.'"><span id="'.$i.'-status" class="'.$server_status.'">•</span> '.$servers[$i]['name'].' '.$server_connect;
		}
		
	}

	echo $content_playing;

	echo '<li class="title">Autres galaxies</li>';

	echo $content_not_playing;

	?>
	</ul>
</body>