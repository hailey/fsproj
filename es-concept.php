<?php
require ('fsESHandler.php');

$hosts = ['wilma.athnex.com:9200'];
$callid = 'call_records.stage';
$callindex = 'cdr';

$eshandler =  new esCallHandler($hosts,
				$callid,
				$callindex);

$response = $eshandler->getViaUuid('feef66d4-6e7e-11e7-b55c-31f53089cfd0');

var_dump($response); 

echo "\n\n\n";

$response = $eshandler->searchField('switchname','quinn.athnex.com');

foreach ($response["hits"]["hits"] as $hits) {
	echo "Direction: " . $hits['_source']['variables']['direction'] , "\n";
	echo "UUID: ". $hits['_source']['variables']['uuid'];
	echo "\n\n";
}


?>
