<?php

$arraystr = "d9dc1a22-6ab4-11e7-9664-31f53089cfd0,inbound,2017-07-16 22:57:44,1500271064,sofia/internal/229051@quinn.athnex.com,CS_EXECUTE,229051,229051,66.63.164.214,3055,conference,3055-quinn.athnex.com@default,XML,default,L16,8000,128000,G729,8000,8000,,quinn.athnex.com,229051@quinn.athnex.com,,2259,ACTIVE,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,";

$header = "uuid,direction,created,created_epoch,name,state,cid_name,cid_num,ip_addr,dest,application,application_data,dialplan,context,read_codec,read_rate,read_bit_rate,write_codec,write_rate,write_bit_rate,secure,hostname,presence_id,presence_data,accountcode,callstate,callee_name,callee_num,callee_direction,call_uuid,sent_callee_name,sent_callee_num,b_uuid,b_direction,b_created,b_created_epoch,b_name,b_state,b_cid_name,b_cid_num,b_ip_addr,b_dest,b_application,b_application_data,b_dialplan,b_context,b_read_codec,b_read_rate,b_read_bit_rate,b_write_codec,b_write_rate,b_write_bit_rate,b_secure,b_hostname,b_presence_id,b_presence_data,b_accountcode,b_callstate,b_callee_name,b_callee_num,b_callee_direction,b_call_uuid,b_sent_callee_name,b_sent_callee_num,call_created_epoch";
$head = explode(',',$header,65);
$output = explode(',',$arraystr,65);
var_dump($output);
echo "\n\n";
var_dump($head);
?>