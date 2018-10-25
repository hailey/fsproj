<?php
// status proof of concept

include('fsRPCHandler.php');

$fsUser       = "freeswitch";
$fsPass       = "fs";
$fsHost       = "107.170.213.226";
$fsPort       = 9366;

$handle = new fsRPCHandler($fsHost,$fsPort,$fsUser,$fsPass);
$registrationList   = $handle->getFSregistrations();
$statusOutput       = $handle->getFSstatus();
$callList           = $handle->getFScalldetails();

$callCount = count($callList);
if($callCount > 0) {
    $htmlCallList = "<div class='callEnv'>
    <div class='callTitle'>$callCount &#9742; Sessions</div>";
    foreach ($callList as $callEntry) {
        switch ($callEntry['callstate']) {
            case 'RINGING':
                 $callExtra = "&#128365;";
                 break;
            case 'DOWN':
                $callExtra = "&#8595;";
                break;
            case 'ACTIVE':
                $callExtra = "&#8644;";
                break;
            default:
                $callExtra = "";
                break;
        }

        if($callEntry['direction'] == 'inbound')
            $callOrder = $callEntry['dest'] .' &#8672 '.$callEntry['name'];
        else
            $callOrder = $callEntry['name'] .' &#8674 '.$callEntry['dest'];
            
       $htmlCallList .= <<<EOU
    <div class='callInfo'>
        <div class='callIDInfo'>Caller Name (Caller ID): {$callEntry['cid_name']}({$callEntry['cid_num']})</div>
        <div class='callEntry'>Call UUID: {$callEntry['uuid']}
                STATE: {$callEntry['callstate']} {$callExtra}({$callEntry['state']})</div>
        <div class='callDialplan'>Dialplan: {$callEntry['dialplan']} {$callEntry['context']} {$callEntry['dest']}</div>
        <div class='callCodecs'>Codec: {$callEntry['write_codec']}@{$callEntry['write_rate']}</div>
        <div class='callOrder'>{$callOrder}</div>
        <div class='callTS'>Created: {$callEntry['created']}</div>
        <div class='callIP'>IP: {$callEntry['ip_addr']}</div>
    </div>
EOU;
    }
    $htmlCallList .= "</div>";
} else {
    $htmlCallList = "<div class='callEnv'><div class='callTitle'>No Current Sessions</div></div>";        
}

$regCount = count($registrationList);
/*
 * HTML Construct for getFSregistrations
 */
if ($regCount > 0) {
    $htmlRegList    = "<div class='infoRegList'>
        <div class='regClass'>
        <div class='regClassTitle'>$regCount Registered Extension(s)</div>";
    
        foreach($registrationList as $regListItem) {
            switch ($regListItem['network_proto']) {
                case 'tls':
                    $protoCheck = 'TLS &#10003;';
                    break;
                case 'udp':
                    $protoCheck = 'UDP';
                    break;
                case 'tcp':
                    $protoCheck = 'TCP &#129309;';
                    break;
                default:
                    $protoCheck = '???';
                    break;
            }
$htmlRegList .= <<<EOG
        <div class='regClassEntry'>
            <div class='regClassItem'>{$regListItem['reg_user']}<!--@{$regListItem['realm']}--> via {$protoCheck}</div>
            <div class='regClassUrl'>{$regListItem['url']}</div>
            <div class='regClassNetInf'>{$regListItem['network_ip']}:{$regListItem['network_port']}</div>
        </div>
EOG;
        }
$htmlRegList    .= "</div>";
} else {
    $htmlRegList = "<div class='regClassTitle'>No Registered Extensions</div>";
}


/*    echo
 */   $outputHTML = <<<EOT
<html>
<head>
<title>Freeswitch Status Screen</title>
<link rel="stylesheet" type="text/css" href="css/dark.css">
</head>
<body>
<h1 class="infoTitle">Freeswitch ($fsHost) INFO</h1>
<div class="infoClassList">
 <div class='regClassTitle'>Status</div>
    <div class="infoClass">Uptime
        <div class="infoClassEntry">{$statusOutput['uptime'][2]} days {$statusOutput['uptime'][3]}:{$statusOutput['uptime'][4]}:{$statusOutput['uptime'][5]}</div>
    </div>
    <div class="infoClass">Sessions since startup
        <div class="infoClassEntry">{$statusOutput['session-count']}</div>
    </div>
    <div class="infoClass">Current sessions
        <div class="infoClassEntry">{$statusOutput['session-current']}</div>
    </div>
</div>

$htmlRegList

$htmlCallList
</body>
</html>
EOT;
    
//Lets echo our output! yay!
    echo $outputHTML;

?>
