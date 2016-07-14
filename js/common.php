<?php
header("Content-type: text/javascript; charset=UTF-8");header('Cache-Control: public, max-age=14515200');
ob_start();include('common.js');
$main_content=ob_get_contents();ob_end_clean();
$HTTP_ACCEPT_ENCODING = $_SERVER["HTTP_ACCEPT_ENCODING"]; 
if(strpos($HTTP_ACCEPT_ENCODING,'x-gzip')!==false)$encoding='x-gzip';
else if(strpos($HTTP_ACCEPT_ENCODING,'gzip')!==false)$encoding='gzip';else $encoding=false;
if($encoding){$l_str=strlen($main_content);
if($l_str>2048){header('Content-Encoding: '.$encoding);echo("\x1f\x8b\x08\x00\x00\x00\x00\x00");$main_content=gzcompress($main_content,3);
}}echo $main_content;