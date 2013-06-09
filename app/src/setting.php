<?php
extract($_POST,EXTR_SKIP);
extract($_GET,EXTR_SKIP);
extract($_COOKIE,EXTR_SKIP);
$upfile_name=isset($_FILES["upfile"]["name"]) ? $_FILES["upfile"]["name"] : "";
$upfile=isset($_FILES["upfile"]["tmp_name"]) ? $_FILES["upfile"]["tmp_name"] : "";

define("LOGFILE", 'img.log');		//ログファイル名
define("TREEFILE", 'tree.log');		//ログファイル名
define("IMG_DIR", 'src/');		//画像保存ディレクトリ。futaba.phpから見て
define("THUMB_DIR",'thumb/');		//サムネイル保存ディレクトリ
define("TITLE", '画像掲示板');		//タイトル（<title>とTOP）
define("HOME",  '../');			//「ホーム」へのリンク
define("MAX_KB", '500');			//投稿容量制限 KB（phpの設定により2Mまで
define("MAX_W",  '250');			//投稿サイズ幅（これ以上はwidthを縮小
define("MAX_H",  '250');			//投稿サイズ高さ
define("PAGE_DEF", '5');			//一ページに表示する記事
define("LOG_MAX",  '500');		//ログ最大行数
define("ADMIN_PASS", 'admin_pass');	//管理者パス
define("RE_COL", '789922');               //＞が付いた時の色
define("PHP_SELF", 'futaba.php');	//このスクリプト名
define("PHP_SELF2", 'futaba.html');	//入り口ファイル名
define("PHP_EXT", '.html');		//1ページ以降の拡張子
define("RENZOKU", '5');			//連続投稿秒数
define("RENZOKU2", '10');		//画像連続投稿秒数
define("MAX_RES", '30');		//強制sageレス数
define("USE_THUMB", 1);		//サムネイルを作る する:1 しない:0
define("PROXY_CHECK", 0);		//proxyの書込みを制限する y:1 n:0
define("DISP_ID", 0);		//IDを表示する 強制:2 する:1 しない:0
define("BR_CHECK", 15);		//改行を抑制する行数 しない:0
define("IDSEED", 'idの種');		//idの種
define("RESIMG", 0);		//レスに画像を貼る:1 貼らない:0

$path = realpath("./").'/'.IMG_DIR;
$badstring = array("dummy_string","dummy_string2"); //拒絶する文字列
$badfile = array("dummy","dummy2"); //拒絶するファイルのmd5
$badip = array("addr.dummy.com","addr2.dummy.com"); //拒絶するホスト
$addinfo='';
?>
