<?php
require ('esHandler.php');
//This is our test dataset.
$testDataSet = ['1'=>23,'2'=>3,'3'=> 12,'4'=> 8,'5' => 2];


$var = new esInsertStats();




foreach ($testDataSet as $key => $keyval) {
    print "Inserting $keyval into $key <br />\n";
    for ($i = 0; $i != $keyval; $i++){
        echo "$key is $i <br />\n";
        $var->increment($key,rand(1,5));
    }
}

echo "\n<h1>Now to dump the object...</h1>\n\n";
$var->debugDump();


class esInsertStats {
    private $totalCounted;
    private $keyArray;
    
    private $statAverage;
    private $statCount;
    private $statSum;
    private $timesInserted;
    
    function __construct() {
        $this->statAverage  = 0;
        $this->statCount    = 0;
        $this->totalCounted = 0;
        
        $this->keyArray      = array();
        $this->timesInserted = array();
    }
    
    function increment($key, $value = 1) {
        $workingKey = &$this->keyArray[(string)$key];
        $workingTI  = &$this->timesInserted[(string)$key];
        if(isset($workingKey)){
            $workingKey++;
        } else {
            $workingKey = $value;
        }
        $this->totalCounted++;
        if(isset($workingTI))
            $workingTI += $value;
        else
            $workingTI = $value;
        //if
        /*
        //Take the Average, 42. Keycount = 27.
        // To calculate new, add X to Average divide by Keycount
        
        Average of what? Key has been inserted 5x times.
        //$this->;
        $this->statCount++;
        */
    }
    //This should be commented out eventually.
    function debugDUMP() {
        var_dump($this->keyArray);
        echo "\n<hr />\n";
        var_dump($this->totalCounted);
        echo "\n<hr />\n";
        var_dump($this->timesInserted);
    }
}
echo "done.";
?> 