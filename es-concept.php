<?php
require 'vendor/autoload.php';

$hosts = ['wilma.athnex.com:9200'];

$client = Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
/*
$params = [
    'index' => 'call_records',
    'type' => 'cdr',
    'body' => [ 'uuid' => 'dd9b128e-6aba-11e7-96e3-31f53089cfd0',
			    'direction' => 'inbound',
				'created' => '2017-07-16 23:40:49',
				'created_epoch' => '1500272364',
				'name' => 'sofia/internal/225500@quinn.athnex.com',
				'state' => 'CS_EXECUTE',
				'cid_name' => 'Hailey Clark',
				'cid_num' => '225500',
				'ip_addr' => '66.63.164.214',
				'dest' => '3055']
];
*/
/*
$params = [
    'index' => 'call_records',
    'type' => 'cdr',
    'body' => [
        'query' => 'match_all'
        ]
];

$response = $client->search($params);*/

$params = [
    'index' => 'call_records.stage',
    'type' => 'cdr',
    'id' => 'feef66d4-6e7e-11e7-b55c-31f53089cfd0',
    'client' => [ 'ignore' => 404 ] 
];

// Get doc at /my_index/my_type/my_id
$response = $client->get($params);

var_dump($response);
?>
