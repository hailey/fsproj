<?php
/*
 *This should read json objects stored in 
 */
$start = microtime(true);
 
 
$working_dir = 'working/json-xml-cdr';
$hosts = ['alison.athnex.com:9200'];
$esIndex = 'call_records.stage';
$esType  = 'cdr';
$verbose = 1;
$esTotalCnt = 0;
$esTotalFail = 0;
require 'vendor/autoload.php';
require 'esHandler.php';
$statHdlr = new esInsertStats();

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
       // unlink ($working_dir.'/'.$entry); // maybe I wasnt.
        if($response['result'] == 'created')
            $statHdlr->increment('1');
        else
            $statHdlr->increment($response['_version']);
            
        echo "gpt ".  $response['_version'] ." gpt\n";
        $esTotalCnt++;
    } else {
        $esTotalFail++;  
        $statHdlr->increment('error');
        echo "Error processing ". $working_dir.'/'.$entry ."\n";
    }
    continue;
}
    $arrayDump = $statHdlr->getKeyList();
    //var_dump($arrayDump);
    foreach ( $arrayDump as $key => $keyval ){
        $keyavg = $statHdlr->getAverage($key);
        echo "For $key I got an Average of $keyavg from $keyval.\n";
    }
echo "Total inserted is ". $esTotalCnt ." and total Failures is ". $esTotalFail ."\n";
$timeElapsed = (microtime(true) - $start) / 60;
$accurateTime = microtime(true) - $start;
echo "Total time taken $timeElapsed  ( $accurateTime ) seconds.\n";
//$out = $statHdlr->debugDump();
//echo $out;
?>
