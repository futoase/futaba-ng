<?php
/**
 * Update message.
 * 
 * @params integer $resno target message number.
 * @return void
 */
function updatelog($resno=0){
  global $path;$p=0;

  $tree = file(TREEFILE);
  $find = false;
  if($resno){
    $counttree=count($tree);
    for($i = 0;$i<$counttree;$i++){
      list($artno,)=explode(",",rtrim($tree[$i]));
      if($artno==$resno){ //レス先検索
        $st=$i;$find=true;break;
      }
    }
    if(!$find){
      error("該当記事がみつかりません");
    }
  }
  $line = file(LOGFILE);
  $countline=count($line);
  for($i = 0; $i < $countline; $i++){
    list($no,) = explode(",", $line[$i]);
    $lineindex[$no]=$i + 1; //逆変換テーブル作成
  }

  $counttree = count($tree);
  for($page=0;$page<$counttree;$page+=PAGE_DEF){
    $dat='';
    head($dat);
    form($dat,$resno);
    if(!$resno){
      $st = $page;
    }
    $dat.='<form action="'.PHP_SELF.'" method=POST>';

  for($i = $st; $i < $st+PAGE_DEF; $i++){
    if(empty($tree[$i])){
      continue;
    }
    $treeline = explode(",", rtrim($tree[$i]));
    $disptree = $treeline[0];
    $j=$lineindex[$disptree] - 1; //該当記事を探して$jにセット
    if(empty($line[$j])){
      continue;
    } //$jが範囲外なら次の行
    
    list($no,$now,$name,$email,$sub,$com,$url,
         $host,$pwd,$ext,$w,$h,$time,$chk) = explode(",", $line[$j]);
    // URLとメールにリンク
    if($email){
      $name = "<a href=\"mailto:$email\">$name</a>";
    }
    $com = auto_link($com);
    $com = preg_replace("/(^|>)(&gt;[^<]*)/i", "\\1<font color=".RE_COL.">\\2</font>", $com);
    // 画像ファイル名
    $img = $path.$time.$ext;
    $src = IMG_DIR.$time.$ext;
    // <imgタグ作成
    $imgsrc = "";
    if($ext && is_file($img)){
      $size = filesize($img);//altにサイズ表示
      if($w && $h){//サイズがある時
        if(@is_file(THUMB_DIR.$time.'s.jpg')){
          $imgsrc = "<small>サムネイルを表示しています.クリックすると元のサイズを表示します.</small><br><a href=\"".$src."\" target=_blank><img src=".THUMB_DIR.$time.'s.jpg'.
      " border=0 align=left width=$w height=$h hspace=20 alt=\"".$size." B\"></a>";
        }
        else{
          $imgsrc = "<a href=\"".$src."\" target=_blank><img src=".$src.
      " border=0 align=left width=$w height=$h hspace=20 alt=\"".$size." B\"></a>";
        }
      }
      else{//それ以外
        $imgsrc = "<a href=\"".$src."\" target=_blank><img src=".$src.
      " border=0 align=left hspace=20 alt=\"".$size." B\"></a>";
      }
      $dat.="画像タイトル：<a href=\"$src\" target=_blank>$time$ext</a>-($size B)<br>$imgsrc";
    }

    // メイン作成
    $dat.="<input type=checkbox name=\"$no\" value=delete><font color=#cc1105 size=+1><b>$sub</b></font> \n";
    $dat.="Name <font color=#117743><b>$name</b></font> $now No.$no &nbsp; \n";
    if(!$resno) $dat.="[<a href=".PHP_SELF."?res=$no>返信</a>]";
    $dat.="\n<blockquote>$com</blockquote>";

     // そろそろ消える。
     if($lineindex[$no]-1 >= LOG_MAX*0.95){
      $dat.="<font color=\"#f00000\"><b>このスレは古いので、もうすぐ消えます。</b></font><br>\n";
     }

    //レス作成
    if(!$resno){
      $s=count($treeline) - 10;
      if($s<1){
        $s=1;
      }
      elseif($s>1){
       $dat.="<font color=\"#707070\">レス".
              ($s - 1)."件省略。全て読むには返信ボタンを押してください。</font><br>\n";
      }
    }
    else{
      $s=1;
    }

    for($k = $s; $k < count($treeline); $k++){
      $disptree = $treeline[$k];
      $j=$lineindex[$disptree] - 1;
      if($line[$j]==""){
        continue;
      }
      list($no,$now,$name,$email,$sub,$com,$url,
           $host,$pwd,$ext,$w,$h,$time,$chk) = explode(",", $line[$j]);
      // URLとメールにリンク
      if($email) $name = "<a href=\"mailto:$email\">$name</a>";
      $com = auto_link($com);
      $com = preg_replace("/(^|>)(&gt;[^<]*)/i", "\\1<font color=".RE_COL.">\\2</font>", $com);

      // 画像ファイル名
      $img = $path.$time.$ext;
      $src = IMG_DIR.$time.$ext;
      // <imgタグ作成
      $imgsrc = "";
      if($ext && is_file($img)){
        $size = filesize($img);//altにサイズ表示
        if($w && $h){//サイズがある時
          if(@is_file(THUMB_DIR.$time.'s.jpg')){
            $imgsrc = "<small>サムネイル表示</small><br><a href=\"".$src."\" target=_blank><img src=".THUMB_DIR.$time.'s.jpg'.
        " border=0 align=left width=$w height=$h hspace=20 alt=\"".$size." B\"></a>";
          }
          else{
            $imgsrc = "<a href=\"".$src."\" target=_blank><img src=".$src.
        " border=0 align=left width=$w height=$h hspace=20 alt=\"".$size." B\"></a>";
          }
        }
        else{//それ以外
          $imgsrc = "<a href=\"".$src."\" target=_blank><img src=".$src.
        " border=0 align=left hspace=20 alt=\"".$size." B\"></a>";
        }
        $imgsrc="<br> &nbsp; &nbsp; <a href=\"$src\" target=_blank>$time$ext</a>-($size B) $imgsrc";
      }

        // メイン作成
        $dat.="<table border=0><tr><td nowrap align=right valign=top>…</td><td bgcolor=#F0E0D6 nowrap>\n";
        $dat.="<input type=checkbox name=\"$no\" value=delete><font color=#cc1105 size=+1><b>$sub</b></font> \n";
        $dat.="Name <font color=#117743><b>$name</b></font> $now No.$no &nbsp; \n";
        $dat.="$imgsrc<blockquote>$com</blockquote>";
        $dat.="</td></tr></table>\n";
      }
      $dat.="<br clear=left><hr>\n";
      clearstatcache();//ファイルのstatをクリア
      $p++;
      if($resno){
        break;
      } //res時はtree1行だけ
    }

    $dat.='<table align=right><tr><td nowrap align=center>
<input type=hidden name=mode value=usrdel>【記事削除】[<input type=checkbox name=onlyimgdel value=on>画像だけ消す]<br>
削除キー<input type=password name=pwd size=8 maxlength=8 value="">
<input type=submit value="削除"></form></td></tr></table>';

    if(!$resno){ //res時は表示しない
      $prev = $st - PAGE_DEF;
      $next = $st + PAGE_DEF;
      // 改ページ処理
      $dat.="<table align=left border=1><tr>";
      if($prev >= 0){
        if($prev==0){
          $dat.="<form action=\"".PHP_SELF2."\" method=get><td>";
        }
        else{
          $dat.="<form action=\"".$prev/PAGE_DEF.PHP_EXT."\" method=get><td>";
        }
        $dat.="<input type=submit value=\"前のページ\">";
        $dat.="</td></form>";
      }
      else{
        $dat.="<td>最初のページ</td>";
      }

      $dat.="<td>";
      for($i = 0; $i < count($tree) ; $i+=PAGE_DEF){
        if($st==$i){
          $dat.="[<b>".($i/PAGE_DEF)."</b>] ";
        }
        else{
          if($i==0){
            $dat.="[<a href=\"".PHP_SELF2."\">0</a>] ";
          }
          else{
            $dat.="[<a href=\"".($i/PAGE_DEF).PHP_EXT."\">".($i/PAGE_DEF)."</a>] ";
          }
        }
      }

      $dat.="</td>";

      if($p >= PAGE_DEF && count($tree) > $next){
        $dat.="<form action=\"".$next/PAGE_DEF.PHP_EXT."\" method=get><td>";
        $dat.="<input type=submit value=\"次のページ\">";
        $dat.="</td></form>";
      }
      else{
        $dat.="<td>最後のページ</td>";
      }
        $dat.="</tr></table><br clear=all>\n";
    }
    
    foot($dat);
    if($resno){
      echo $dat;break;
    }
    if($page==0){
      $logfilename=PHP_SELF2;
    }
    else{
      $logfilename=$page/PAGE_DEF.PHP_EXT;
    }

    $fp = fopen($logfilename, "w");
    set_file_buffer($fp, 0);
    rewind($fp);
    fputs($fp, $dat);
    fclose($fp);
    chmod($logfilename,0666);
  }

  if(!$resno&&is_file(($page/PAGE_DEF+1).PHP_EXT)){
    unlink(($page/PAGE_DEF+1).PHP_EXT);
  }
}
?>
