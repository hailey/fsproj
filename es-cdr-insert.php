<?php
/*
 *This should read json objects stored in 
 */

$working_dir = 'working/json-xml-cdr';
$hosts = ['wilma.athnex.com:9200'];

require 'vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();

// Lets start the directory read loop.
$dh = opendir($working_dir);
while ($entry = readdir($dh)) {
    if(is_dir($entry)){
        continue;
    }
    $json_contents = file_get_contents($working_dir.'/'.$entry);
    $uuid = str_replace('.cdr.json','',$entry);
    
    $params = [
     'index' => 'call_records.stage',
     'type' => 'cdr',
     'id'   => $uuid,
     'body' => $json_contents
    ];
    
    echo "Inserting $entry into elasticsearch\n";
    $response = $client->index($params);
    if ($response['result'] == 'updated' OR $response['result'] == 'created') {
        echo "Done with $uuid!\n Entry version [". $response['_version']."]\n";
        echo "Deleting file ". $working_dir.'/'.$entry ."\n"; // Kidding, not actually doing this.
    } else {
        echo "Error processing ". $working_dir.'/'.$entry ."\n";
    }
    continue;
}
?>