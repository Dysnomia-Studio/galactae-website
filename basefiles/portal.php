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
?>
<body class="login-page">
	<ul>
		<li style="text-align: center;"><a href="index.html" style="color: white; text-decoration: none; font-weight: bold;"><img src="https://***REMOVED***/website/img/bannersAndLogos/logo-large-white.png" style="max-height: 6em;"></a></li>
	</ul>

	<?php
	$servers = [
		["addr"=>"00-srv.galactae.eu", "port"=>42690, "name"=>DEV, "link"=>"https://00-dev.galactae.eu"],
		["addr"=>"01-srv.galactae.eu", "port"=>42691, "name"=>MILKYWAY, "link"=>"https://01-milkyway.galactae.eu"],
		["addr"=>"02-srv.galactae.eu", "port"=>42692, "name"=>ANDROMEDA, "link"=>"https://02-andromeda.galactae.eu"],
		["addr"=>"03-srv.galactae.eu", "port"=>42693, "name"=>PEGASUS, "link"=>"https://03-pegasus.galactae.eu"],
		//["addr"=>"04-srv.galactae.eu", "port"=>42694, "name"=>MAGELLAN, "link"=>"https://04-magellan.galactae.eu"]
	];

	echo'<div class="server-choice">
		<p>'.WELCOME_MESSAGE.'</p>

		<table>
			<tr>
				<th>'.GALAXY.'</th>
				<th>'.STATUS.'</th>
				<th></th>
			</tr>';

	if(isset($userData['whitelisted']) && $userData['whitelisted']) {
		$dev=0;
	} else {
		$dev=1;
	}

	for($i=$dev; $i<count($servers); $i++) {
		$servers[$i]['status'] = @fsockopen($servers[$i]["addr"], $servers[$i]["port"], $errno, $errstr, 0.1);

		echo'<tr>
				<td>'.$servers[$i]['name'].'</td>';
		if($servers[$i]['status'])
		{
			echo'
				<td><span class="server-online">'.ONLINE.'</span></td>
				<td><a href="'.$servers[$i]['link'].'">'.CONNECT.'</a></td>';
		} else {
			echo'
				<td><span class="server-offline">'.OFFLINE.'</span></td>
				<td>-</td>
			</tr>';
		}
	}

	?>
		</table>
	</div>
</body>