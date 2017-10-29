<?php
require ('esHandler.php');
//This is our test dataset.
$testDataSetA = ['1'=>23,'2'=>3,'3'=> 12,'4'=> 8,'5' => 3];
$testDataSetB = ['1'=>37,'2'=>116,'3'=> 15,'4'=> 0,'5' => 52,'6' => 12];

$var = new esInsertStats();
$var2 = new esInsertStats();

runDataset($testDataSetA,$var);
runDataset($testDataSetB,$var,2,12);

runDataset($testDataSetA,$var2,2,7);

function runDataset($dataset, &$var,$min=1,$max=6) {
    echo "\n<h1>Running ($min to $max)</h1>\n";
    foreach ($dataset as $key => $keyval) {
        print "Inserting $key,  $keyval x times.<br />\n";
        for ($i = 0; $i != $keyval; $i++){
            $rval = rand($min,$max);
            //echo "Key = $key [ $i ]  adding $rval <br />\n";
            $var->increment($key,$rval);
        }
            $out = $var->getAverage($key);
            
       // echo "\n<br />Average for '$key' = $out<br />\n";
    }
    $arrayDump = $var->getKeyList();
    foreach ( $arrayDump as $key => $keyval ){
        $keyavg = $var->getAverage($key);
        echo "For $key I got an Average of $keyavg.<br />\n";
    }
}
echo "\n<h1>Now to dump the object...</h1>\n\n";

$var->debugDump();
echo "\n<h2>and</h2>\n";
$var2->debugDump();
echo "done.";
?> 