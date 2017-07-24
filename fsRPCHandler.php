<?php

include('lib/xmlrpc.inc');

class fsRPCHandler {
    private $handler;
    function __construct($host,$port,$user,$pass) {
        $chandler =new xmlrpc_client("/RPC2", $host, $port);
        $chandler->setCredentials($user,$pass,NULL);
        $this->handler = $chandler;
    }
    /*
     *  This shows `show calls`
     **/
    function getFScalls() {
        $rpcmsg=new xmlrpcmsg('freeswitch.api',
            array(
                  new xmlrpcval("show", "string"),
                  new xmlrpcval("calls", "string")
                )
            );
        $result=&$this->handler->send($rpcmsg);
        if(!$result->faultCode())
        {       
                $v=$result->value();
                $clList = explode("\n" , $v->scalarval());

                unset($clList[0]); //Remove first entry list.
                //Construct array of registration arrays.
                if(!preg_match('/0 total/',$clList[1])) {
                    foreach($clList as $callItem) {
                        $callArray = explode(',',$callItem,41);
                        if(count($callArray) == 41) {
                            //var_dump($callArray);
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
                            $returnConstArray['presence_id']    = $callArray[10];
                            $returnConstArray['presence_data']  = $callArray[11];
                            $returnConstArray['accountcode']    = $callArray[12];
                            $returnConstArray['callstate']      = $callArray[13];
                            $returnConstArray['callee_name']    = $callArray[14];
                            $returnConstArray['callee_num']     = $callArray[15];
                            $returnConstArray['callee_direction'] = $callArray[16];
                            $returnConstArray['call_uuid']      = $callArray[17];
                            $returnConstArray['hostname']       = $callArray[18];
                            $returnConstArray['sent_callee_name'] = $callArray[19];
                            $returnConstArray['sent_callee_num']  = $callArray[20];
                            $returnConstArray['b_uuid']         = $callArray[21];
                            $returnConstArray['b_direction']    = $callArray[22];
                            $returnConstArray['b_created']      = $callArray[23];
                            $returnConstArray['b_created_epoch']  = $callArray[24];
                            $returnConstArray['b_name']         = $callArray[25];
                            $returnConstArray['b_state']        = $callArray[26];
                            $returnConstArray['b_cid_name']     = $callArray[27];
                            $returnConstArray['b_cid_num']      = $callArray[28];
                            $returnConstArray['b_ip_addr']      = $callArray[29];
                            $returnConstArray['b_dest']         = $callArray[30];
                            $returnConstArray['b_presence_id']  = $callArray[31];
                            $returnConstArray['b_presence_data']= $callArray[32];
                            $returnConstArray['b_accountcode']  = $callArray[33];
                            $returnConstArray['b_callstate']    = $callArray[34];
                            $returnConstArray['b_callee_name']  = $callArray[35];
                            $returnConstArray['b_callee_num']   = $callArray[36];
                            $returnConstArray['b_callee_direction'] = $callArray[37];
                            $returnConstArray['b_sent_callee_name'] = $callArray[38];
                            $returnConstArray['b_sent_callee_num']  = $callArray[39];
                            $returnConstArray['call_created_epoch'] = $callArray[40];
                            $returnResult[] = $returnConstArray;
                        }
                    }
                    return $returnResult;
                }
        }
    }
    
    function getFScalldetails() {
        $rpcmsg=new xmlrpcmsg('freeswitch.api',
            array(
                  new xmlrpcval("show", "string"),
                  new xmlrpcval("detailed_calls", "string")
                )
            );
        $result=$this->handler->send($rpcmsg);
        if(!$result->faultCode())
        {       
                $v=$result->value();
                $clList = explode("\n" , $v->scalarval());

                unset($clList[0]); //Remove first entry list.
                //Construct array of registration arrays.
                if(!preg_match('/0 total/',$clList[1])) {
                    $returnResult = array();
                    foreach($clList as $callItem) {
                        $callArray = explode(',',$callItem,65);
                        if(count($callArray) == 65) {
                            //var_dump($callArray);
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
                            $returnResult[] = $returnConstArray;
                        }
                    }
                    return $returnResult;
                }
        }
    }
    
    //This calls and parses `show registrations`
    function getFSregistrations() {
        $rpcmsg=new xmlrpcmsg('freeswitch.api',
            array(
                  new xmlrpcval("show", "string"),
                  new xmlrpcval("registrations", "string")
                )
            );
        $result=$this->handler->send($rpcmsg);
        if(!$result->faultCode())
        {       
                $v=$result->value();
                $regList = explode("\n" , $v->scalarval());
                unset($regList[0]); //Remove first entry list.
                //Construct array of registration arrays.
                foreach($regList as $callItem) {
   /*
    *Array list is...
    * reg_user,realm,token,url,expires,network_ip,network_port,network_proto,hostname,metadata
    */
                    $callArray = explode(',',$callItem,10);
                    if(count($callArray) == 10) {
                        $returnConstArray['reg_user']       = $callArray[0];
                        $returnConstArray['realm']          = $callArray[1];
                        $returnConstArray['token']          = $callArray[2];
                        $returnConstArray['url']            = $callArray[3];
                        $returnConstArray['expires']        = $callArray[4];
                        $returnConstArray['network_ip']     = $callArray[5];
                        $returnConstArray['network_port']   = $callArray[6];
                        $returnConstArray['network_proto']  = $callArray[7];
                        $returnConstArray['hostname']       = $callArray[8];
                        $returnConstArray['metadata']       = $callArray[9];
                        
                        $returnResult[] = $returnConstArray;
                    }
                }
                return $returnResult;
        } else {
                print "An error occurred: ";
                print "Code: " . htmlspecialchars($result->faultCode())
                        . " Reason: '" . htmlspecialchars($result->faultString());   
        }
    }

    //Parses and returns `show status`.
    function getFSstatus() {
        $uptimeRegex        = "/^UP (\d{1,4}) years?, (\d{1,3}) days?, (\d{1,2}) hours?, (\d{1,2}) minutes?, (\d{1,2}) seconds?, (\d{1,3}) milliseconds?, (\d{1,3}) microseconds?/";
        $sessionRegex       = "/^(\d{1,6}) session\(s\) since startup$/";
        $sessionCountRegex  = "/^(\d{1,3}) session\(s\) - peak (\d{1,6}), last 5min (\d{1,6}) $/";
        $sessionLoadRegex   = "/^(\d{1,6}) session\(s\) per Sec out of max (\d{1,4}), peak (\d{1,4}), last 5min (\d{1,4}) $/";
        $sessionMaxRegex    = "/^(\d{1,6}) session\(s\) max$/";
        
        $rpcmsg=new xmlrpcmsg('freeswitch.api',
            array(
                  new xmlrpcval("show", "string"),
                  new xmlrpcval("status", "string")
                )
            );
        $result=$this->handler->send($rpcmsg);
        if(!$result->faultCode())
        {       
                $v=$result->value();
                $foo = explode("\n" , $v->scalarval());

                if(!preg_match($uptimeRegex,$foo[0],$uptimeMatch)){
                    echo "UNMATCHED: " .$foo[0];
                }
                preg_match($sessionRegex,$foo[2],$sessionCount);
                preg_match($sessionCountRegex,$foo[3],$sessionLoad);
                preg_match($sessionLoadRegex,$foo[4],$sessionSys);
                preg_match($sessionMaxRegex,$foo[5],$sessionMax);

                $returnResult = [
                    'uptime' => $uptimeMatch,
                    'version' => $foo[1],
                    'session-count' => $sessionCount[1],
                    'session-current' => $sessionLoad[1],
                    'session-load' => $sessionSys,
                    'session-max' => $sessionMax[1]
                ];
                return $returnResult;
        } else {
                print "An error occurred: ";
                print "Code: " . htmlspecialchars($result->faultCode())
                        . " Reason: '" . htmlspecialchars($result->faultString());
        }
    }
}