<?php
// status proof of concept

include('lib/xmlrpc.inc');

$fsUser       = "freeswitch";
$fsPass       = "fs";
$fsHost       = "quinn.athnex.com";
$fsPort       = 8080;

$f=new xmlrpcmsg('freeswitch.api',
        array(
              new xmlrpcval("show", "string"),
              new xmlrpcval("status", "string")
            )
        );
$c=new xmlrpc_client("/RPC2", $fsHost, $fsPort);
$c->setCredentials($fsUser,$fsPass,NULL);

    echo "<PRE>";
$output = getFSstatus($c);
    echo "</PRE>";
    
    echo"<h2> OUTPUT </h2>";
    echo "<PRE>";
var_dump($output);
echo "</PRE>";
    echo "ARRR";
    
    
function getFSstatus(&$rpcClient) {
    $uptimeRegex        = "/^UP (\d{1,2}) years, (\d{1,3}) days, (\d{1,2}) hours, (\d{1,2}) minutes, (\d{1,2}) seconds, (\d{1,3}) milliseconds, (\d{1,3}) microseconds/";
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
    $result=&$rpcClient->send($rpcmsg);
    if(!$result->faultCode())
    {       
            $v=$result->value();
            $foo = explode("\n" , $v->scalarval());
            
            preg_match($uptimeRegex,$foo[0],$uptimeMatch);
            preg_match($sessionRegex,$foo[2],$sessionCount);
            preg_match($sessionCountRegex,$foo[3],$sessionLoad);
            preg_match($sessionLoadRegex,$foo[4],$sessionSys);
            preg_match($sessionMaxRegex,$foo[5],$sessionMax);
            
            //var_dump($sessionLoad);
            
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
            print "Code: " . htmlspecialchars($r->faultCode())
                    . " Reason: '" . htmlspecialchars($r->faultString());
    }
}
?>