<?php
/**
 * prettify of message.
 * 
 * @params string $message message.
 * @return string Finished special charactor the replacement.
 */
function CleanStr($message){
  global $admin;
  $trimed_message = trim($message);//先頭と末尾の空白除去
  if (get_magic_quotes_gpc()) {//¥を削除
    $strip_slashed_message = stripslashes($trimed_message);
  }
  else{
    $strip_slashed_message = $trimed_message;
  }

  if($admin != ADMIN_PASS){//管理者はタグ可能
    $trimed_tag_message = htmlspecialchars($strip_slashed_message);//タグっ禁止
    $replace_ampersand_message = str_replace("&amp;", "&", $trimed_tag_message);//特殊文字
    $replace_comma_message = str_replace(",", "&#44;", $replace_ampersand_message);//カンマを変換
    return $replace_ampersand_message;
  }
  else{
    return str_replace(",", "&#44;", $strip_slashed_message);//カンマを変換
  }
}
?>
