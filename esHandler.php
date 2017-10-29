<?php
require 'vendor/autoload.php';

class esCallHandler {
    private $handler;
    private $callindex,$calltype;
    
    function __construct($hosts,$callid,$callindex) {
			$this->handler = Elasticsearch\ClientBuilder::create()
											->setHosts($hosts)
											->build();
											
			$this->callindex = $callid;
			$this->calltype = $callindex;				
    }
    
	function getViaUuid($uuid) {
		$params = [
			'index' => $this->callindex,
			'type' => $this->calltype,
			'id' => $uuid,
			'client' => [ 'ignore' => 404 ] 
		];
		try {
			$response = $this->handler->get($params);
		} catch (Exception $e) {
			echo $e->getMessage(),"\n";
			return NULL;
		}

		return $response;
	}
	
	function searchField($field,$data) {
		$params = [
			'index' => $this->callindex,
			'type' => $this->calltype,
			'body' => [
				'query' => [
					'match' => [
						$field => $data
					]
				]
			]
		];
		try {
			$results = $this->handler->search($params);
			return $results;
		} catch (Exception $e) {
			echo $e->getMessage(),"\n";
			return NULL;
		}			
	}
}

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
		$this->keyInsertedC  = array();
    }
    
    function increment($key, $value = 1) {
        $workingKey = &$this->keyArray[(string)$key];
        $workingTI  = &$this->timesInserted[(string)$key];
		$insertCnt  = &$this->keyInsertedC[(string)$key];
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
		
		if(isset($insertCnt))
			$insertCnt++;
		else
			$insertCnt = 1;
        //if
        /*
        //Take the Average, 42. Keycount = 27.
        // To calculate new, add X to Average divide by Keycount
        
        Average of what? Key has been inserted 5x times.
        //$this->;
        $this->statCount++;
        */
    }
	
	function getAverage($key) {
		//$workingKey = &$this->keyArray[(string)$key];
		$workingTI  = &$this->timesInserted[(string)$key];
		$insertCnt  = &$this->keyInsertedC[(string)$key];
		if(isset($workingTI)){
			return $workingTI / $insertCnt;
		} else {
			return false;
		}
	}
	
		//This just returns the damn array.
	function getKeyList (){
		$workingKey = &$this->keyArray;
		return $workingKey;
	}
	function arrayDump(){
		$workingKey = &$this->keyArray;
		$output = "<br />\n";
		foreach ($workingKey as $key => $keyval) {
			$keyavg = $this->getAverage($key);
			$output .= "For $key I got $keyval values averaging $keyavg<br />\n";
		}
		return $output;
	}
    //This should be commented out eventually.
    function debugDUMP() {
        var_dump($this->keyArray);
        echo "\n<hr />\n";
        var_dump($this->totalCounted);
        echo "\n<hr />\n";
        var_dump($this->timesInserted);
		echo "\n<hr />\n";
		var_dump($this->keyInsertedC);
    }
}
?>