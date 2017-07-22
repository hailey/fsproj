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

$params = [
    'index' => 'call_records',
    'type' => 'cdr',
    'body' => [
        'query' => [
            'match' => [
                'direction' => 'inbound'
            ]
        ]
    ]
];

$response = $client->search($params);
var_dump($response);

$arraystr = "d9dc1a22-6ab4-11e7-9664-31f53089cfd0,inbound,2017-07-16 22:57:44,1500271064,sofia/internal/229051@quinn.athnex.com,CS_EXECUTE,229051,229051,66.63.164.214,3055,conference,3055-quinn.athnex.com@default,XML,default,L16,8000,128000,G729,8000,8000,,quinn.athnex.com,229051@quinn.athnex.com,,2259,ACTIVE,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,";
$callArray = explode(',',$arraystr,65);
$params = [
    'index' => 'call_records',
    'type' => 'cdr',
    'body' => [ 'uuid' => $callArray[0],
			    'direction' => $callArray[1],
				'created' => $callArray[2],
				'created_epoch' => $callArray[3],
				'name' => $callArray[4],
				'state' => 'CS_EXECUTE',
				'cid_name' => $callArray[6],
				'cid_num' => $callArray[7],
				'ip_addr' =>  $callArray[8],
				'dest' => $callArray[9]]
];
$response = $client->index($params);
echo "-------------
";
var_dump($response);
/*
                            $returnConstArray['uuid']           = $callArray[0];
                            $returnConstArray['direction']      = $callArray[1];
                            $returnConstArray['created']        = $callArray[2];
                            $returnConstArray['created_epoch']  = $callArray[3];
                            $returnConstArray['name']           = $callArray[4];
                            $returnConstArray['state']          = $callArray[5];
                            $returnConstArray['cid_name']       = $callArray[6];
                            $returnConstArray['cid_num']        = $callArray[7];
                            $returnConstArray['ip_addr']        = $callArray[8];
                            $returnConstArray['dest']           = $callArray[9];
                            $returnConstArray['application']    = $callArray[10];
                            $returnConstArray['application_data']  = $callArray[11];
                            $returnConstArray['dialplan']    = $callArray[12];
                            $returnConstArray['context']      = $callArray[13];
                            $returnConstArray['read_codec']    = $callArray[14];
                            $returnConstArray['read_rate']     = $callArray[15];
                            $returnConstArray['read_bit_rate'] = $callArray[16];
                            $returnConstArray['write_codec']      = $callArray[17];
                            $returnConstArray['write_rate']       = $callArray[18];
                            $returnConstArray['write_bit_rate'] = $callArray[19];
                            $returnConstArray['secure']  = $callArray[20];
                            $returnConstArray['hostname']         = $callArray[21];
                            $returnConstArray['presence_id']    = $callArray[22];
                            $returnConstArray['presence_data']      = $callArray[23];
                            $returnConstArray['accountcode']  = $callArray[24];
                            $returnConstArray['callstate']         = $callArray[25];
                            $returnConstArray['callee_name']        = $callArray[26];
                            $returnConstArray['callee_num']     = $callArray[27];
                            $returnConstArray['callee_direction']      = $callArray[28];
                            $returnConstArray['call_uuid']      = $callArray[29];
                            $returnConstArray['sent_callee_name']         = $callArray[30];
                            $returnConstArray['sent_callee_num']  = $callArray[31];
                            $returnConstArray['b_uuid']= $callArray[32];
                            $returnConstArray['b_direction']  = $callArray[33];
                            $returnConstArray['b_created']    = $callArray[34];
                            $returnConstArray['b_created_epoch']  = $callArray[35];
                            $returnConstArray['b_name']   = $callArray[36];
                            $returnConstArray['b_state'] = $callArray[37];
                            $returnConstArray['b_cid_name'] = $callArray[38];
                            $returnConstArray['b_cid_num']  = $callArray[39];
                            $returnConstArray['b_ip_addr'] = $callArray[40];
                            $returnConstArray['b_dest']         = $callArray[41];
                            $returnConstArray['b_application']  = $callArray[42];
                            $returnConstArray['b_application_data']= $callArray[43];
                            $returnConstArray['b_dialplan']= $callArray[44];
                            $returnConstArray['b_context']  = $callArray[45];
                            $returnConstArray['b_read_codec']    = $callArray[46];
                            $returnConstArray['b_read_rate']  = $callArray[47];
                            $returnConstArray['b_read_bit_rate']   = $callArray[48];
                            $returnConstArray['b_write_codec'] = $callArray[49];
                            $returnConstArray['b_write_rate'] = $callArray[50];
                            $returnConstArray['b_write_bit_rate']  = $callArray[51];
                            $returnConstArray['b_secure'] = $callArray[52];
                            $returnConstArray['b_hostname']         = $callArray[53];
                            $returnConstArray['b_presence_id']  = $callArray[54];
                            $returnConstArray['b_presence_data']= $callArray[55];
                            $returnConstArray['b_accountcode']  = $callArray[56];
                            $returnConstArray['b_callstate']    = $callArray[57];
                            $returnConstArray['b_callee_name']  = $callArray[58];
                            $returnConstArray['b_callee_num']   = $callArray[59];
                            $returnConstArray['b_callee_direction'] = $callArray[60];
                            $returnConstArray['b_call_uuid'] = $callArray[61];
                            $returnConstArray['b_sent_callee_name']  = $callArray[62];
                            $returnConstArray['b_sent_callee_num'] = $callArray[63];
                            $returnConstArray['call_created_epoch'] = $callArray[64];
*/
?>
