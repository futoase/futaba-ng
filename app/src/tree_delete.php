<?php
/**
 * Delete of message.
 *
 * @params integer $delno delete message number.
 * @return void
 */
function treedel($delno){
  $fp=fopen(TREEFILE,"r+");
  set_file_buffer($fp, 0);
  flock($fp, 2);
  rewind($fp);
  $buf=fread($fp,1000000);
  if($buf==''){
    error("error tree del");
  }
  $line = explode("\n",$buf);
  $countline=count($line);
  if($countline>2){
    for($i = 0; $i < $countline; $i++){
      if($line[$i]!=""){
        $line[$i].="\n";
      }
    }
    for($i = 0; $i < $countline; $i++){
      $treeline = explode(",", rtrim($line[$i]));
      $counttreeline=count($treeline);
      for($j = 0; $j < $counttreeline; $j++){
        if($treeline[$j] == $delno){
          $treeline[$j]='';
          if($j==0){
            $line[$i]='';
          }
          else{
            $line[$i]=implode(',', $treeline);
            $line[$i]=preg_replace("/,,/",",",$line[$i]);
            $line[$i]=preg_replace("/,$/","",$line[$i]);
            $line[$i].="\n";
          }
          break 2;
        } 
      } 
    }
    ftruncate($fp,0);
    set_file_buffer($fp, 0);
    rewind($fp);
    fputs($fp, implode('', $line));
  }
  fclose($fp);
}
?>
