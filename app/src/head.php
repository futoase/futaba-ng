<?php
/**
 * Rendering of header. 
 * 
 * @params string $dat message log.
 * @return void
 */
function head(&$dat){
  $dat.='<html><head>
<meta charset="UTF-8"/>
<!-- meta HTTP-EQUIV="pragma" CONTENT="no-cache" -->
<STYLE TYPE="text/css">
<!--
body,tr,td,th { font-size:12pt }
a:hover { color:#DD0000; }
span { font-size:20pt }
small { font-size:10pt }
-->
</STYLE>
<title>'.TITLE.'</title>
<script language="JavaScript"><!--
function l(e){var P=getCookie("pwdc"),N=getCookie("namec"),i;with(document){for(i=0;i<forms.length;i++){if(forms[i].pwd)with(forms[i]){pwd.value=P;}if(forms[i].name)with(forms[i]){name.value=N;}}}};onload=l;function getCookie(key, tmp1, tmp2, xx1, xx2, xx3) {tmp1 = " " + document.cookie + ";";xx1 = xx2 = 0;len = tmp1.length;	while (xx1 < len) {xx2 = tmp1.indexOf(";", xx1);tmp2 = tmp1.substring(xx1 + 1, xx2);xx3 = tmp2.indexOf("=");if (tmp2.substring(0, xx3) == key) {return(unescape(tmp2.substring(xx3 + 1, xx2 - xx1 - 1)));}xx1 = xx2 + 1;}return("");}
//--></script>
</head>
<body bgcolor="#FFFFEE" text="#800000" link="#0000EE" vlink="#0000EE">
<p align=right>
[<a href="'.HOME.'" target="_top">ホーム</a>]
[<a href="'.PHP_SELF.'?mode=admin">管理用</a>]
<p align=center>
<font color="#800000" size=5>
<b><SPAN>'.TITLE.'</SPAN></b></font>
<hr width="90%" size=1>
';
}
?>
