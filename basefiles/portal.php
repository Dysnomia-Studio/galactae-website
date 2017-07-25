<?php
if(!isset($_COOKIE['galactae-account-username'])) {
setcookie ( "galactae-account-username", $_SESSION['username'], time()+60*60*24*7,"/", ".galactae.elanis.eu",true, false);
setcookie ( "galactae-account-username", $_SESSION['username'], time()+60*60*24*7,"/", "galactae.elanis.eu",true, false);
setcookie ( "galactae-account-id", $_SESSION['game_id'], time()+60*60*24*7,"/", ".galactae.elanis.eu",true, false);
setcookie ( "galactae-account-id", $_SESSION['game_id'], time()+60*60*24*7,"/", "galactae.elanis.eu",true, false);
setcookie ( "galactae-account-bid", $_SESSION['id'], time()+60*60*24*7,"/", ".galactae.elanis.eu",true, false);
setcookie ( "galactae-account-bid", $_SESSION['id'], time()+60*60*24*7,"/", "galactae.elanis.eu",true, false);
}

if((!isset($_SESSION['username']) || !isset($_SESSION['id']))&&(!isset($_COOKIE['galactae-account-username']) ||$_COOKIE['galactae-account-username']=="" || !isset($_COOKIE['galactae-account-bid']) ||$_COOKIE['galactae-account-bid']=="")) {
	header('Location: ../index.php');
}

include_once('./basefiles/header.php');
?>
<body class="login-page">
	<ul>
		<li style="text-align: center;"><a href="index.html" style="color: white; text-decoration: none; font-weight: bold;">GALACTAE: SPACE AGE RISING</a></li>
	</ul>

	<?php
	$servers = [
		["addr"=>"01-srv.galactae.elanis.eu", "port"=>42690, "name"=>MILKYWAY, "link"=>"https://01-milkyway.galactae.elanis.eu"],
		["addr"=>"02-srv.galactae.elanis.eu", "port"=>42691, "name"=>ANDROMEDA, "link"=>"https://02-andromeda.galactae.elanis.eu"],
		["addr"=>"03-srv.galactae.elanis.eu", "port"=>42692, "name"=>MAGELLAN, "link"=>"https://03-magellan.galactae.elanis.eu"],
		["addr"=>"04-srv.galactae.elanis.eu", "port"=>42693, "name"=>PEGASUS, "link"=>"https://04-pegasus.galactae.elanis.eu"]
	];

	echo'<div class="server-choice">
		<p>'.WELCOME_MESSAGE.' :</p>

		<table>
			<tr>
				<th>'.GALAXY.'</th>
				<th>'.STATUS.'</th>
				<th></th>
			</tr>';

	for($i=0; $i<count($servers); $i++) {
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