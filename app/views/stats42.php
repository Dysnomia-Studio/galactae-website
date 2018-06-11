<select id="days-range" onchange="genReport(parseInt($('#days-range').val()));" style="width: 200px; margin: 0 auto; display: block;">
	<option value="1">Dernieres 24h</option>
	<option value="7" selected>7 derniers jours</option>
	<option value="30">30 derniers jours</option>
	<option value="90">3 derniers mois</option>
	<option value="183">6 derniers mois</option>
	<option value="365">12 derniers mois</option>
	<option value="100000">Toute la periode</option>
</select>

<div id="stats" class="graphs"></div>

<script src="https://***REMOVED***/website/js/chartkick.js"></script>
<script src="https://***REMOVED***/website/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
<script type="text/javascript">
	var rawStats = <?= json_encode($results); ?>;
	var outStats = [];

	function convertDate(inputFormat) {
		function pad(s) { return (s < 10) ? '0' + s : s; }
		var d = new Date(inputFormat);
		return [pad(d.getFullYear()), pad(d.getMonth()+1), d.getDate()].join('-') + ' ' + d.toLocaleTimeString();
	}


	function genReport(dTime) {
		var minDate = Date.now() - (dTime * 24 * 60 * 60 * 1000);

		for(var server in rawStats) {
			outStats[server] = [];
			for(var i=0; i<rawStats[server].length; i++) {
				if(rawStats[server][i].time < minDate) { continue; } // Keep only what we need

				if(rawStats[server][i-1] == undefined || // Ajoute le premier (total)
					rawStats[server][i+1] == undefined || // Ajoute le dernier
					rawStats[server][i+1].time < minDate || // Ajoute le premier (selon l'intervalle)
					rawStats[server][i-1].plCount != rawStats[server][i].plCount || // Ajoute le debut d'un changement
					rawStats[server][i+1].plCount != rawStats[server][i].plCount) { // Ajoute la fin d'in changement

					outStats[server].push([convertDate(rawStats[server][i].time),rawStats[server][i].plCount]);
				}
			}
		}

		var data4Charts = [];

		// Each server
		for(var i in outStats) {
			data4Charts.push({name: i, data: outStats[i]});
		}

		// Then generate full report
		// @ADD: sum

		var visitsChart = new Chartkick.AreaChart('stats', data4Charts);
	}

	genReport(7);
</script>