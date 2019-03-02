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
		padding: 0;

		width: 14vw;
		/* 100% (Window) - 3.5em (Top) - 2px (Border) */
		height: calc(100vh - 3.5em - 2px) !important;
		max-height: calc(100vh - 3.5em - 2px) !important;
	}
	#server-list li {
		cursor: pointer;
		padding: 0.4em 0.8em;
	}
	#server-list li:hover {
		background-color: #161e21;
	}
	#server-list li.active {
		background-color: #1b282d;
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

	.tab {
		position: fixed;
		bottom: 0;
		right: 0;

		width: 100%;
		height: calc(100vh - 3em);
		display: none;
	}
	.tab iframe {
		width: 100%;
    	height: 100%;
	}
	#tab-console {
		display: block;
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
	/* Privileges */
	#player-search {
		width: calc(20% - 1em);
		
		margin: 0;
		padding: 0.5em;

		height: calc(100% - 1em);
		overflow-y: scroll;
		overflow-x: hidden;

		display: inline-block;
	}
	#player-list {
		color: white;

		margin: 0;
		margin-top: 1em;
		padding: 0 0.2em;

		list-style: none;
	}
	#player-list li:hover {
		text-decoration: underline;
		font-weight: bold;
		cursor: pointer;
	}
	#player-search-input {
		width: calc(100% - 4px); /* Width - Border */

		background-color: rgba(0,0,0,0);
		border: 1px solid #0ec6c6;
		color: #DDDDDD;
		height: 15px;
		padding: 2px;
	}
	#player-edit-frame {
		display: inline-block;

		width: calc(80% - 0.5em);
		height: 100%;

		border: 0;
	}
</style>
<script type="text/javascript">
	var serverList = <?= json_encode($serverList); ?>;
	var serverLogs = [];

	var userData = { 
		username: '<?= $admin_user; ?>',
		password: '<?= $admin_passwd; ?>',
	};

	var currServer = 0;

	function loadServerUI(id) {
		currServer = id;

		$('#server-list .active').removeClass("active");
		$('#server-list #'+id).addClass("active");

		// Load logs
		$('#server-infos-logs').html('');
		for(var i=0; i<serverLogs[id].length; i++) {
			$('#server-infos-logs').append('<li>' + serverLogs[id][i] + '</li>');
		}
		$('#server-infos-logs').scrollTop($('#server-infos-logs').height());

		$('#server-maintenance').prop('checked', serverList[id].server_maintenance);
	}

	function drawServerStatus(id,status) {
		$('#' + id + '-status').removeClass();

		if(serverList[id].server_maintenance) {
			$('#' + id + '-status').addClass('server_maintenance');
			return;
		}

		switch(status) {
			case 'on':
				$('#' + id + '-status').addClass('server_on');
				break;
			case 'off':
				$('#' + id + '-status').addClass('server_off');
				break;
			default:
				$('#' + id + '-status').addClass('server_unknown');
		}
	}

	var socketList = [];
	function connectAllSockets() {
		for(var i=0; i<serverList.length; i++) {
			let id = i; // Variable locale a la boucle
			socketList[id] = io.connect('https://'+serverList[id]['addr'], {secure: true, 'connect timeout': 10000 });

			socketList[id].on('connect_failed', function() {
				drawServerStatus(id,'off');
			});
			socketList[id].on('connect_error', function() {
				drawServerStatus(id,'off');
			});
			socketList[id].on('connect', function() {
				drawServerStatus(id,'on');
				
				socketList[id].emit('server-monitore-connect', userData);
			});
			socketList[id].on('server-maintenance', function() {
				serverList[id].server_maintenance = true,
				drawServerStatus(id);
			});
			socketList[id].on('server-maintenance-off', function() {
				serverList[id].server_maintenance = false,
				drawServerStatus(id,'on'); // Fallback
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

		setInterval(function() {
			document.getElementById('tab-stats-iframe').contentDocument.location.reload(true);
		},1000000) // Refresh each 1000s (~16min)

		$('#tool-list li').click(function() {
			$('.tab').css('display','none');
			$('#tab-' + $(this).attr('id').split('-')[1]).css('display','block');
		});

		connectAllSockets();

		// Server Admin Commands
		$('#server-start').click(function() {
			socketList[currServer].emit('admin-request-cmd', { cmd: 'start' });
		});
		$('#server-stop').click(function() {
			socketList[currServer].emit('admin-request-cmd', { cmd: 'stop' });
		});
		$('#server-restart').click(function() {
			socketList[currServer].emit('admin-request-cmd', { cmd: 'restart' });
		});
		$('#server-maintenance').click(function() {
			if($('#server-maintenance').is(':checked')) {
				socketList[currServer].emit('admin-request-cmd', { cmd: 'maintenanceOn' });
			} else {
				socketList[currServer].emit('admin-request-cmd', { cmd: 'maintenanceOff' });
			}
		});

		$('#server-maintenance').prop('checked', serverList[currServer].server_maintenance);
		$('#server-list #0').addClass("active");
	});
</script>
<section>
	<ul id="tool-list">
		<li id="tool-console"><img alt="console" src="https://***REMOVED***/website/img/icons/console.png"></li>
		<li id="tool-stats"><img alt="stats" src="https://***REMOVED***/website/img/icons/stats.png"></li>
		<li id="tool-users"><img alt="users" src="https://***REMOVED***/website/img/icons/users.png"></li>
		<li id="tool-news"><img alt="news" src="https://***REMOVED***/website/img/icons/news.png"></li>
	</ul>
	<div id="tab-console" class="tab">
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
				<img id="server-start"	 alt="start"	src="https://***REMOVED***/website/img/icons/start.png">
				<img id="server-stop"	 alt="stop"		src="https://***REMOVED***/website/img/icons/stop.png">
				<img id="server-restart" alt="restart"	src="https://***REMOVED***/website/img/icons/restart.png">
			</p>
			<p style="text-align: center;">Maintenance<br/><br/>
				<label class="switch">
					<input id="server-maintenance" type="checkbox">
					<span class="slider round"></span>
				</label>
			</p>
		</div>
	</div>
	<div id="tab-stats" class="tab">
		<iframe id="tab-stats-iframe" src="stats42" title="stats"></iframe>
	</div>
	<div id="tab-users" class="tab">
		<div id="player-search">
			<input id="player-search-input" placeholder="Nom de l'utilisateur">
			<ul id="player-list">
			</ul>
		</div>
		<iframe id="player-edit-frame" src="adminedituser" title="player edit"></iframe>
		<iframe id="player-search-frame" src="adminsearchuser" title="player search" style="display: none;"></iframe>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#player-search-input').keyup(function() {
				var url = "adminsearchuser?u=" + $('#player-search-input').val();

				if($('#player-search-frame').attr("src") != url) {
					$('#player-search-frame').attr("src", url);
				}
			});

			var lastDate = 0;
			$('#player-search-frame').on("load", function() {
				var content = "";
				var users = $('#player-search-frame').contents().find('.user');
				let currDate = Date.now();
				lastDate = currDate;

				for(var u=0; u<users.length; u++) {
					content += "<li>" + users[u].innerText + "</li>";
				}

				if(currDate <= lastDate) { // Prevent writing on most recent content
					$('#player-list').html(content);
				
					$('#player-list li').click(function() {
						var url = "adminedituser?u=" + $(this).text();

						if($('#player-edit-frame').attr("src") != url) {
							$('#player-edit-frame').attr("src", url);
						}
					});
				}			
			});
		});
	</script>
	<div id="tab-news" class="tab">

	</div>
</section>
