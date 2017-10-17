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
	$sqlDB->updateContent('user_session',
		[ ["user_session_expiration",time()+2678400,"int"] ],
		[ ["user_session_uid",$_COOKIE['galactae-phpsessid'],"str"] ]);
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

$admin_user = "***REMOVED***";
$admin_passwd = "***REMOVED***";

$serverList = [
	["addr"=>"00-srv.galactae.eu", "port"=>42690, "name"=>DEV, "link"=>"https://00-dev.galactae.eu"],
	["addr"=>"01-srv.galactae.eu", "port"=>42691, "name"=>MILKYWAY, "link"=>"https://01-milkyway.galactae.eu"],
	["addr"=>"02-srv.galactae.eu", "port"=>42692, "name"=>ANDROMEDA, "link"=>"https://02-andromeda.galactae.eu"],
	["addr"=>"03-srv.galactae.eu", "port"=>42693, "name"=>PEGASUS, "link"=>"https://03-pegasus.galactae.eu"],
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
		position: fixed;
		left: 0;
		bottom: 0;

		width: 13vw;
		/* 100% (Window) - 3.5em (Top) - 1em (Padding) - 2px (Border) */
		height: calc(100vh - 4.5em - 2px) !important;
		max-height: calc(100vh - 4.5em - 2px) !important;
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
		bottom: 0;
		right: 0;

		border: 1px solid #0EC6C6;
		color: #93fcfb;

		padding: 0.5em;

		width: calc(22% - 1.5em);	
		/* 100% (Window) - 3.5em (Top) - 1em (Padding) - 2px (Border) */
		height: calc(100vh - 4.5em - 2px) !important;
		max-height: calc(100vh - 4.5em - 2px) !important;
	}
	#server-panel img {
		max-width: calc(((100% - 1.5em) / 3) - 0.5em); /* (Width of parent - margin of parent) / 3 - padding of img */
		max-height: 2em;
		margin: 1em 0.25em;

		cursor: pointer;
	}

	/* The switch - the box around the slider */
	.switch {
		position: relative;
		display: inline-block;
		width: 55px;
		height: 30px;
	}
	/* Hide default HTML checkbox */
	.switch input { display:none; }
	/* The slider */
	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #0B1012;
		-webkit-transition: .4s;
		transition: .4s;
		border: 2px solid #0EC6C6;
	}
	.slider:before {
		position: absolute;
		content: "";
		height: 18px;
		width: 18px;
		left: 4px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}
	input:checked + .slider {
		background-color: #0EC6C6;
	}
	input:checked + .slider:before {
		-webkit-transform: translateX(26px);
		-ms-transform: translateX(26px);
		transform: translateX(26px);
	}
	/* Rounded sliders */
	.slider.round {
		border-radius: 25px;
	}
	.slider.round:before {
		border-radius: 50%;
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
			if($(this).attr('id')!=currServer) {
				loadServerUI($(this).attr('id'));
			}
		});

		connectAllSockets();

		// Server Admin Commands
		$("#server-start").click(function() {
			socketList[currServer].emit('admin-request-cmd', { cmd: "start" });
		});
		$("#server-stop").click(function() {
			socketList[currServer].emit('admin-request-cmd', { cmd: "stop" });
		});
		$("#server-restart").click(function() {
			socketList[currServer].emit('admin-request-cmd', { cmd: "restart" });
		});
		$("#server-maintenance").click(function() {
			if($("#server-maintenance").is(':checked')) {
				socketList[currServer].emit('admin-request-cmd', { cmd: "maintenanceOn" });
			} else {
				socketList[currServer].emit('admin-request-cmd', { cmd: "maintenanceOff" });
			}
		});
	});
</script>
<section>
	<ul id="tool-list">
		<li><img id="tool-console" alt="console" src="https://***REMOVED***/website/img/icons/console.png"></li>
		<li><img id="tool-privileges" alt="privileges" src="https://***REMOVED***/website/img/icons/privileges.png"></li>
		<li><img id="tool-bans" alt="bans" src="https://***REMOVED***/website/img/icons/bans.png"></li>
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
		<p style="text-align: center;">Status<br/>
			<img id="server-start"	 alt="start"	 src="https://***REMOVED***/website/img/icons/start.png">
			<img id="server-stop"		alt="stop"		src="https://***REMOVED***/website/img/icons/stop.png">
			<img id="server-restart" alt="restart" src="https://***REMOVED***/website/img/icons/restart.png">
		</p>
		<p style="text-align: center;">Maintenance<br/><br/>
			<label class="switch">
				<input id="server-maintenance" type="checkbox">
				<span class="slider round"></span>
			</label>
		</p>
	</div>
</section>
