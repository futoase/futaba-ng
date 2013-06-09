<?php
/** 
 * Delete of user post message.
 *
 * @params integer $no post message number.
 * @params string $pwd post message password.
 * @return void
 */
function usrdel($no,$pwd){
  global $path,$pwdc,$onlyimgdel;
  $host = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
  $delno = array("dummy");
  $delflag = false;
  reset($_POST);
  while ($item = each($_POST)){
    if($item[1]=='delete'){
      array_push($delno,$item[0]);
      $delflag=true;
    }
  }

  if($pwd==""&&$pwdc!=""){
    $pwd=$pwdc;
  }

  $fp=fopen(LOGFILE,"r+");
  set_file_buffer($fp, 0);
  flock($fp, 2);
  rewind($fp);
  $buf=fread($fp,1000000);
  fclose($fp);

  if($buf==''){
    error("error user del");
  }

  $line = explode("\n",$buf);
  $countline=count($line);

  for($i = 0; $i < $countline; $i++){
    if($line[$i]!=""){
      $line[$i].="\n";
    };
  }

  $flag = false;
  $countline=count($line)-1;
  for($i = 0; $i<$countline; $i++){
    list($dno,,,,,,,$dhost,$pass,$dext,,,$dtim,) = explode(",", $line[$i]);
    if(array_search($dno,$delno) && (substr(md5($pwd),2,8) == $pass || $dhost == $host||ADMIN_PASS==$pwd)){
      $flag = true;
      $line[$i] = "";			//パスワードがマッチした行は空に
      $delfile = $path.$dtim.$dext;	//削除ファイル
      if(!$onlyimgdel){
        treedel($dno);
      }
      if(is_file($delfile)){
        unlink($delfile);//削除
      }
      if(is_file(THUMB_DIR.$dtim.'s.jpg')){
        unlink(THUMB_DIR.$dtim.'s.jpg');//削除
      }
    }
  }
  if(!$flag){
    error("該当記事が見つからないかパスワードが間違っています");
  }
}
?>
