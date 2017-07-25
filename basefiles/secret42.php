<?php
if((!isset($_SESSION['username']) || !isset($_SESSION['id']))&&(!isset($_COOKIE['galactae-account-username']) ||$_COOKIE['galactae-account-username']=="" || !isset($_COOKIE['galactae-account-bid']) ||$_COOKIE['galactae-account-bid']=="")) {
	include_once('errors/404.html');
	exit();
}

$data = $db->getCondContent("users",[
	["user_name",strtolower($_COOKIE['galactae-account-username']),"str"],
	["user_id",intval($_COOKIE['galactae-account-bid']),"int"]
	],0,1,"user_id");

if($data!=false&&isset($data[0])) {
	$data = $data[0];
}

if(!isset($data['user_lvl']) || $data['user_lvl']<5) {
	include_once('errors/404.html');
	exit();
}
?>
<style type="text/css">
	.admin-panel-main {
		width: 460px;
		height: 400px;
		position: fixed;
		top: 50%;
		left: 50%;
		margin-left: -215px;
		margin-top: -200px;
		background-image: url(../../img/server-list.png);
		color: #DDDDDD;
		border-radius: 5px;
		padding: 5px;
		text-align: center;
	}
	.admin-panel-main p {
		text-align: center;
	}
	.admin-panel-main ul {
		list-style: none;
	}
	.ul-prim li {
		text-align: center;
		margin: 1em 0;
	}
	.ul-second li {
		text-align: left;
		margin: 0;
	}
	#admin-panel-back {
		display: none;
	}
	#admin-panel-back:hover, .ul-second li:hover {
		text-decoration: underline;
		cursor: pointer;
	}
	#server-status {
		display: none;
	}
	#server-status table {
		width: 100%;
	}
	#server-status table tr td a {
		text-decoration: none;
		font-weight: bold;
		color: #EEEEEE;
	}
	#server-status table tr td a:hover {
		text-decoration: underline;
		color: #CCCCCC;
	}
</style>

<body class="login-page">
	<ul style="list-style: none;">
		<li style="text-align: center; color: white; font-weight: bold;">PAGE ADMIN</li>
	</ul>

	<div class="admin-panel-main">
		<p id="admin-panel-back">Retour au menu</p>
		<ul class="ul-prim" id="admin-panel-choice-menu">
			<li><h4>Utilisateurs</h4>
				<ul class="ul-second">
					<li id="admin-user-ban">Gerer les bannissements</li>
					<li id="admin-user-modo">Gerer les moderateurs</li>
					<li id="admin-user-connected">Liste des connectés en jeu</li>
				</ul>
			</li>
			<li><h4>Serveurs</h4>
				<ul class="ul-second">
					<li id="admin-server-status">Statut et redemarrage des serveurs</li>
					<li id="admin-server-maintenance">Maintenance des serveurs</li>
					<li id="admin-server-update">Mise a jour des serveurs en production</li>
				</ul>
			</li>
			<li><h4>Site</h4>
				<ul class="ul-second">
					<li id="admin-site-devblog">Gerer le devblog</li>
					<li id="admin-site-newsletter">Envoyer une newsletter</li>
				</ul>
			</li>
		</ul>

		<?php
		$servers = [
			["addr"=>"01-srv.***REMOVED***", "port"=>42690, "name"=>MILKYWAY, "link"=>"https://01-milkyway.***REMOVED***"],
			["addr"=>"02-srv.***REMOVED***", "port"=>42691, "name"=>ANDROMEDA, "link"=>"https://02-andromeda.***REMOVED***"],
			["addr"=>"03-srv.***REMOVED***", "port"=>42692, "name"=>MAGELLAN, "link"=>"https://03-magellan.***REMOVED***"],
			["addr"=>"04-srv.***REMOVED***", "port"=>42693, "name"=>PEGASUS, "link"=>"https://04-pegasus.***REMOVED***"]
		];

		echo'<div id="server-status">
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
				if($servers[$i]['status']) {
					echo'
						<td><span class="server-online">'.ONLINE.'</span></td>
						<td><a href="#">Redemarrer</a></td>
					</tr>';
				} else {
					echo'
						<td><span class="server-offline">'.OFFLINE.'</span></td>
						<td><a href="#">Demarrer</a></td>
					</tr>';
				}
			}
		?>
		</div>
	</div>
</body>

<script type="text/javascript" src="./lib/js/jquery.min.js"></script>
<script type="text/javascript">
$(".ul-second li").click(function() {
	$('#admin-panel-choice-menu').css('display','none');
	$('#admin-panel-back').css('display','block');
});
$("#admin-server-status").click(function() {
	$('#server-status').css('display','block');
});
$("#admin-panel-back").click(function() {
	$('#admin-panel-choice-menu').css('display','block');
	$('#admin-panel-back').css('display','none');

	$('#server-status').css('display','none');
});
</script>