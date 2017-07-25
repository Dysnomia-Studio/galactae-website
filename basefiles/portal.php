<?php
setcookie ( "galactae-account-username", $_SESSION['username'], time()+60*60*24*7,"/", ".***REMOVED***",true, false);
setcookie ( "galactae-account-username", $_SESSION['username'], time()+60*60*24*7,"/", "***REMOVED***",true, false);
setcookie ( "galactae-account-id", $_SESSION['game_id'], time()+60*60*24*7,"/", ".***REMOVED***",true, false);
setcookie ( "galactae-account-id", $_SESSION['game_id'], time()+60*60*24*7,"/", "***REMOVED***",true, false);
setcookie ( "galactae-account-bid", $_SESSION['id'], time()+60*60*24*7,"/", ".***REMOVED***",true, false);
setcookie ( "galactae-account-bid", $_SESSION['id'], time()+60*60*24*7,"/", "***REMOVED***",true, false);

if(!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
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
		["addr"=>"01-srv.***REMOVED***", "port"=>34269, "name"=>"[EU] ".MILKY_WAY, "link"=>"https://01-milkyway.***REMOVED***"],
		["addr"=>"02-srv.***REMOVED***", "port"=>44269, "name"=>"[NA] ".ANDROMEDA, "link"=>"https://02-andromeda.***REMOVED***"],
		//["addr"=>"03-srv.***REMOVED***", "port"=>54269, "name"=>MAGELLAN, "link"=>"https://03-magellan.***REMOVED***"],
		//["addr"=>"04-srv.***REMOVED***", "port"=>64269, "name"=>PEGASUS, "link"=>"https://04-pegasus.***REMOVED***"],
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