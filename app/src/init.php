<?php
/**
 * Bootstrap setting.
 *
 * @return void
 */
function init(){
  $err="";
  $chkfile=array(LOGFILE,TREEFILE);
  if(!is_writable(realpath("./"))){
    error("カレントディレクトリに書けません<br>");
  }

  foreach($chkfile as $value){
    if(!file_exists(realpath($value))){
      $fp = fopen($value, "w");
      set_file_buffer($fp, 0);
      if($value==LOGFILE){
        fputs($fp,"1,2002/01/01(月) 00:00,名無し,,無題,本文なし,,,,,,,,\n");
      }
      if($value==TREEFILE){
        fputs($fp,"1\n");
      }
      fclose($fp);
      if(file_exists(realpath($value))){
        @chmod($value,0666);
      }
    }
    if(!is_writable(realpath($value))){
      $err.=$value."を書けません<br>";
    }
    if(!is_readable(realpath($value))){
      $err.=$value."を読めません<br>";
    }
  }
  @mkdir(IMG_DIR,0777);
  @chmod(IMG_DIR,0777);
  if(!is_dir(realpath(IMG_DIR))){
    $err.=IMG_DIR."がありません<br>";
  }
  if(!is_writable(realpath(IMG_DIR))){
    $err.=IMG_DIR."を書けません<br>";
  }
  if(!is_readable(realpath(IMG_DIR))){
    $err.=IMG_DIR."を読めません<br>";
  }
  if(USE_THUMB){
    @mkdir(THUMB_DIR,0777);
    @chmod(THUMB_DIR,0777);
    if(!is_dir(realpath(IMG_DIR))){
      $err.=THUMB_DIR."がありません<br>";
    }
    if(!is_writable(realpath(THUMB_DIR))){
      $err.=THUMB_DIR."を書けません<br>";
    }
    if(!is_readable(realpath(THUMB_DIR))){
      $err.=THUMB_DIR."を読めません<br>";
    }
  }
  if($err){
    error($err);
  }
}
?>
