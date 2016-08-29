<?php
include('lib/base.php');

$servers = [
	["addr"=>"***REMOVED***", "port"=>34269, "name"=>MILKY_WAY, "link"=>"game-client/"],
	["addr"=>"***REMOVED***", "port"=>44269, "name"=>ANDROMEDA, "link"=>""],
	["addr"=>"***REMOVED***", "port"=>54269, "name"=>MAGELLAN, "link"=>""],
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