<?php
/**
 * Query stats
 */

// @TODO: Passer sur une meilleur interface modele
$sqlInterface = new SQLInterface(
	'***REMOVED***',
	'galactae-01',
	'***REMOVED***',
	'***REMOVED***',
	'pgsql',
	5432
);

$results = [];
$results['galactae-01'] = $sqlInterface->getContent(
	'stats',
	0,
	26500, // About 3 months at 1 each 5 min
	'time DESC'
);