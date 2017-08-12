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
?>