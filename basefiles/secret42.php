<?php
if(!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
	http_response_code(404);
	include_once('errors/404.html');
	die();
}

$admin_user = "***REMOVED***";
$admin_passwd = "***REMOVED***";

$data = $db->getCondContent("users",[
	["user_name",strtolower($_SESSION['username']),"str"],
	["user_id",intval($_SESSION['id']),"int"]
	],0,1,"user_id");

if($data!=false&&isset($data[0])) {
	$data = $data[0];
}

if(!isset($data['user_lvl']) || $data['user_lvl']<5) {
	http_response_code(404);
	include_once('errors/404.html');
	die();
}

$serverList = [
	["addr"=>"00-srv.galactae.elanis.eu", "port"=>42690, "name"=>DEV, "link"=>"https://00-dev.galactae.elanis.eu"],
	["addr"=>"01-srv.galactae.elanis.eu", "port"=>42691, "name"=>MILKYWAY, "link"=>"https://01-milkyway.galactae.elanis.eu"],
	["addr"=>"02-srv.galactae.elanis.eu", "port"=>42692, "name"=>ANDROMEDA, "link"=>"https://02-andromeda.galactae.elanis.eu"],
	["addr"=>"03-srv.galactae.elanis.eu", "port"=>42693, "name"=>PEGASUS, "link"=>"https://03-pegasus.galactae.elanis.eu"],
];
?>
<script type="text/javascript" src="https://***REMOVED***/website/js/jquery.min.js"></script>
<script type="text/javascript" src="https://***REMOVED***/game/js/socket.min.js"></script>
<style type="text/css">
	body {
		background-color: #0b1012;
	}

	#tool-list {
		width: 100vw;
		height: 3em;

		background-color: #0f1416;
		border-bottom: 1px solid #0EC6C6;

		position: fixed;
		top: 0;
		left: 0;

		padding: 0;
		margin: 0;

		list-style: none;
	}
	#tool-list li {
		display: inline-block;
		float: right;
	}
	#tool-list li img {
		height: 2.5em;
		margin: 0.25em;
	}

	#server-list {
		width: 14vw;
		height: calc(100vh - 3em);
		list-style: none;
		margin: 0;
		padding: 0;

		position: fixed;
		left: 0;
		bottom: 0;

		background-color: #0f1416;
		border-right: 1px solid #0EC6C6;

		overflow-x: auto;
	}
	#server-list li {
		padding: 0.8em;
		padding-top: 0;
		color: #93fcfb;	
		cursor: pointer;
	}
	#server-list li .server_on, #server-list li .server_off, #server-list li .server_maintenance, #server-list li .server_unknown {
		font-size: 2em;
		position: relative;
		bottom: -0.15em;
	}
	#server-list li .server_on {
		color: green;
	}
	#server-list li .server_off {
		color: red;
	}
	#server-list li .server_maintenance {
		color: orange;
	}
	#server-list li .server_unknown {
		color: grey;
	}		
	#server-list li:hover {
		background-color: #1f2426;
	}
	#server-infos {
		position: fixed;
		top: 3em;
		left: 14vw;

		width: calc(100vw - 14vw);
		height: calc(100vh - 3em);
	}
	#server-infos-logs {
		width: calc(75% - 2em);
		height: calc(100% - 4em);

		margin: 0.5em;
		padding: 0.5em;

		color: #93fcfb;
		border: 1px solid #0EC6C6;

		overflow-y: auto;
	}
	#server-infos-cmd {
		position: fixed;
		bottom: 0.5em;
		left: calc(14vw + 0.5em);

		width: calc(64.6% - 1em - 2px);
		height: 1.5em;

		background-color: #0f1416;
		color: #93fcfb;
		border: 1px solid #0EC6C6;
	}
	#server-panel {
		position: fixed;
		top: 0;
		right: 0;
		width: 22%;
		height: 100vh;
	}
</style>
<script type="text/javascript">
	var serverList = <?php echo json_encode($serverList); ?>;
	var serverLogs = [];

	var userData = { 
		username: "<?php echo $admin_user; ?>",
		password: "<?php echo $admin_passwd; ?>",
	};

	var currServer = 0;

	function loadServerUI(id) {
		currServer = id;

		// Load logs
		$('#server-infos-logs').html("");
		for(var i=0; i<serverLogs[id].length; i++) {
			$('#server-infos-logs').append('<li>' + serverLogs[id][i] + '</li>');
		}
		$('#server-infos-logs').scrollTop($('#server-infos-logs').height());
	}

	function drawServerStatus(id,status) {
		$('#' + id + '-status').removeClass();

		switch(status) {
			case "on":
				$('#' + id + '-status').addClass("server_on");
				break;
			case "off":
				$('#' + id + '-status').addClass("server_off");
				break;
			case "maintenance":
				$('#' + id + '-status').addClass("server_maintenance");
				break;
			default:
				$('#' + id + '-status').addClass("server_unknown");
		}
	}

	var socketList = [];
	function connectAllSockets() {
		for(var i=0; i<serverList.length; i++) {
			let id = i; // Variable locale a la boucle
			socketList[id] = io.connect('https://'+serverList[id]['addr'], {secure: true, 'connect timeout': 10000 });

			socketList[id].on('connect_failed', function() {
				drawServerStatus(id,"off");
			});
			socketList[id].on('connect_error', function() {
				drawServerStatus(id,"off");
			});
			socketList[id].on('connect', function() {
				drawServerStatus(id,"on");
				
				socketList[id].emit('server-monitore-connect', userData);
			});
			socketList[id].on('server-maintenance', function() {
				drawServerStatus(id,"maintenance");
			});	

			socketList[id].on('server-log', function(msg) {
				console.log("MESSAGE: " + msg);
				if(id==currServer) {
					$('#server-infos-logs').append('<li>' + msg + '</li>');
					$('#server-infos-logs').scrollTop($('#server-infos-logs').height());
				}
				serverLogs[id].push(msg);
			});

			serverLogs[id] = [];
		}
	}

	$(document).ready(function() {
		$('#server-list li').click(function() {
			loadServerUI($(this).attr('id'));
		});

		connectAllSockets();
	});	
</script>
<section>
	<ul id="tool-list">
		<li><img id="tool-console" alt="console" src="https://***REMOVED***/website/img/icons/console.png"></li>
		<li><img id="tool-news" alt="news" src="https://***REMOVED***/website/img/icons/news.png"></li>
	</ul>
	<ul id="server-list">
		<?php 
		for($i=0; $i<count($serverList); $i++) {
			echo '<li id="'.$i.'"><span  id="'.$i.'-status" class="server_unknown">•</span> '.$serverList[$i]['name'].'</li>';
		}
		?>
	</ul>
	<div id="server-infos">
		<ul id="server-infos-logs">
			
		</ul>
		<input id="server-infos-cmd" type="text">
	</div>
	<div id="server-panel">

	</div>
</section>
