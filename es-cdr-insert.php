<?php
/*
 *This should read json objects stored in 
 */
$start = microtime(true);
 
 
$working_dir = 'working/json-xml-cdr';
$hosts = ['alison.athnex.com:9200'];
$esIndex = 'call_records.stage';
$esType  = 'cdr';
$verbose = 0;
$esTotalCnt = 0;
$esTotalFail = 0;
require 'vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
if (!is_dir($working_dir)){
    echo "Unable to locate $working_dir as a valid working dir.\n";
    exit;
}
// Lets start the directory read loop.
$dh = opendir($working_dir);
while ($entry = readdir($dh)) {
    if(is_dir($entry)){
        continue;
    }
    if($entry == '.' OR $entry == '..'){
        continue;
    }
    $json_contents = file_get_contents($working_dir.'/'.$entry);
    $uuid = str_replace('.cdr.json','',$entry);
    
    $params = [
     'index' => $esIndex,
     'type' => $esType,
     'id'   => $uuid,
     'body' => $json_contents
    ];
    
    echo "Inserting $entry into elasticsearch\n";
    $response = $client->index($params);
    if ($response['result'] == 'updated' OR $response['result'] == 'created') {
        if ($verbose != 0) {
            echo "Done with $uuid!\n Entry version [". $response['_version']."]\n";
            echo "Deleting file ". $working_dir.'/'.$entry ."\n"; // Kidding, not actually doing this.
        }
        unlink ($working_dir.'/'.$entry); // maybe I wasnt.        
        $esTotalCnt++;
    } else {
        $esTotalFail++;
        echo "Error processing ". $working_dir.'/'.$entry ."\n";
    }
    continue;
}
echo "Total inserted is ". $esTotalCnt ." and total Failures is ". $esTotalFail ."\n";
$timeElapsed = microtime(true) - $start;
echo "Total time taken $timeElapsed\n";
?>
