<?php
/**
 * Validatio of password. 
 * ...And rendering form.
 *
 * @params string $pass password.
 * @return void
 */
function valid($pass){
  if($pass && $pass != ADMIN_PASS){
    error("パスワードが違います");
  }

  head($dat);
  echo $dat;
  echo "[<a href=\"".PHP_SELF2."\">掲示板に戻る</a>]\n";
  echo "[<a href=\"".PHP_SELF."\">ログを更新する</a>]\n";
  echo "<table width='100%'><tr><th bgcolor=#E08000>\n";
  echo "<font color=#FFFFFF>管理モード</font>\n";
  echo "</th></tr></table>\n";
  echo "<p><form action=\"".PHP_SELF."\" method=POST>\n";

  // ログインフォーム
  if(!$pass){
    echo "<center><input type=radio name=admin value=del checked>記事削除 ";
    echo "<input type=radio name=admin value=post>管理人投稿<p>";
    echo "<input type=hidden name=mode value=admin>\n";
    echo "<input type=password name=pass size=8>";
    echo "<input type=submit value=\" 認証 \"></form></center>\n";
    die("</body></html>");
  }
}
?>
