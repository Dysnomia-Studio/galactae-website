<?php
/**
 * Query stats
 */

// @ADD: Passer sur une meilleur interface modele
$manager = new MongoDB\Driver\Manager('***REMOVED***');

$filter = array();
$options = [
    'limit' => 26500, // About 3 months at 1 each 5 min
    'sort' => ['_id' => -1],
];

$query = new MongoDB\Driver\Query($filter, $options);

$servers = [
	'galactae-00'
];

$results = [];

foreach ($servers as $key => $server) {
	$cursor = $manager->executeQuery($server.'.stats', $query);
	$results[$server] = $cursor->toArray();
}