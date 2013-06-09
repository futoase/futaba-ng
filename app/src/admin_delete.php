<?php
/**
 * Administration of message log.
 *
 * @params string $pass administration password.
 * @return void
 */
function admindel($pass){
  global $path,$onlyimgdel;

  $all=0;
  $msg="";
  $delno = array("dummy");
  $delflag = false;
  reset($_POST);

  while ($item = each($_POST)){
    if($item[1] == 'delete'){
      array_push($delno,$item[0]);
      $delflag=true;
    }
  }

  if($delflag){
    $fp = fopen(LOGFILE,"r+");
    set_file_buffer($fp, 0);
    flock($fp, 2);
    rewind($fp);
    $buf = fread($fp,1000000);
 
    if($buf==''){
      error("error admin del");
    }

    $line = explode("\n",$buf);
    $countline=count($line)-1;
  
    for($i = 0; $i < $countline; $i++){
      if($line[$i]!=""){
        $line[$i].="\n";
      }
    }

    $find = false;

    for($i = 0; $i < $countline; $i++){
      list($no,$now,$name,$email,$sub,$com,$url,$host,$pw,$ext,$w,$h,$tim,$chk) = explode(",",$line[$i]);
      if($onlyimgdel=="on"){
        if(array_search($no,$delno)){//画像だけ削除
          $delfile = $path.$tim.$ext;	//削除ファイル
          if(is_file($delfile)) unlink($delfile);//削除
          if(is_file(THUMB_DIR.$tim.'s.jpg')) unlink(THUMB_DIR.$tim.'s.jpg');//削除
        }
      }
      else{
        if(array_search($no,$delno)){//削除の時は空に
          $find = true;
          $line[$i] = "";
          $delfile = $path.$tim.$ext;	//削除ファイル
          if(is_file($delfile)){
            unlink($delfile);//削除
          }
          if(is_file(THUMB_DIR.$tim.'s.jpg')){
            unlink(THUMB_DIR.$tim.'s.jpg');//削除
          }
          treedel($no);
        }
      }
    }

    if($find){//ログ更新
      ftruncate($fp,0);
      set_file_buffer($fp, 0);
      rewind($fp);
      fputs($fp, implode('', $line));
    }
    fclose($fp);
  }

  // 削除画面を表示
  echo "<input type=hidden name=mode value=admin>\n";
  echo "<input type=hidden name=admin value=del>\n";
  echo "<input type=hidden name=pass value=\"$pass\">\n";
  echo "<center><P>削除したい記事のチェックボックスにチェックを入れ、削除ボタンを押して下さい。\n";
  echo "<p><input type=submit value=\"削除する\">";
  echo "<input type=reset value=\"リセット\">";
  echo "[<input type=checkbox name=onlyimgdel value=on>画像だけ消す]";
  echo "<P><table border=1 cellspacing=0>\n";
  echo "<tr bgcolor=6080f6><th>削除</th><th>記事No</th><th>投稿日</th><th>題名</th>";
  echo "<th>投稿者</th><th>コメント</th><th>ホスト名</th><th>添付<br>(Bytes)</th><th>md5</th>";
  echo "</tr>\n";
  $line = file(LOGFILE);

  for($j = 0; $j < count($line); $j++){
    $img_flag = false;
    list($no,$now,$name,$email,$sub,$com,$url,
         $host,$pw,$ext,$w,$h,$time,$chk) = explode(",",$line[$j]);
    // フォーマット
    $now=preg_replace('/.{2}\/(.*)$/','\1',$now);
    $now=preg_replace('/\(.*\)/',' ',$now);

    if(strlen($name) > 10){
      $name = substr($name,0,9).".";
    }
    if(strlen($sub) > 10){
      $sub = substr($sub,0,9).".";
    }
    if($email){ 
      $name="<a href=\"mailto:$email\">$name</a>";
    }

    $com = str_replace("<br />"," ",$com);
    $com = htmlspecialchars($com);

    if(strlen($com) > 20){
      $com = substr($com,0,18) . ".";
    }

    // 画像があるときはリンク
    if($ext && is_file($path.$time.$ext)){
      $img_flag = true;
      $clip = "<a href=\"".IMG_DIR.$time.$ext."\" target=_blank>".$time.$ext."</a><br>";
      $size = filesize($path.$time.$ext);
      $all += $size;			//合計計算
      $chk= substr($chk,0,10);
    }else{
      $clip = "";
      $size = 0;
      $chk= "";
    }
    $bg = ($j % 2) ? "d6d6f6" : "f6f6f6";//背景色

    echo "<tr bgcolor=$bg><th><input type=checkbox name=\"$no\" value=delete></th>";
    echo "<th>$no</th><td><small>$now</small></td><td>$sub</td>";
    echo "<td><b>$name</b></td><td><small>$com</small></td>";
    echo "<td>$host</td><td align=center>$clip($size)</td><td>$chk</td>\n";
    echo "</tr>\n";
  }

  echo "</table><p><input type=submit value=\"削除する$msg\">";
  echo "<input type=reset value=\"リセット\"></form>";

  $all = (int)($all / 1024);
  echo "【 画像データ合計 : <b>$all</b> KB 】";
  die("</center></body></html>");
}
?>
