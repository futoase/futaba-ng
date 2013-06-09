<?php
/**
 * Connect to port with reverse proxy. 
 * 
 * @params integer $port target port.
 * @return integer 1 then success.
 *         integer 0 then error.
 */
function proxy_connect($port){
  $a="";$b="";
  $fp = @fsockopen($_SERVER["REMOTE_ADDR"], $port,$a,$b,2);
  if(!$fp){
    return 0;
  }
  else{
    return 1;
  }
}
?>
