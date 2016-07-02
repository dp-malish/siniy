<?php
if(isset($_GET['img'])){$img=htmlspecialchars($_GET['img'],ENT_QUOTES);
if(preg_match("/[A-z0-9_\-]+/",$img)){$search=0;
if(file_exists($img.'.jpg')){$ext='.jpg';$search=1;}
else{if(file_exists($img.'.jpeg')){$ext='.jpeg';$search=1;}}
if($search){header("Content-type: image/jpeg");header('Cache-Control: public, max-age=29030400');
if(!isset($_COOKIE['mob'])){$mob=0;$file_part='pc';$mobile_agent_array=array('ipad','iphone','android','pocket','palm','windows ce','windowsce','cellphone','opera mobi','ipod','small','sharp','sonyericsson','symbian','opera mini','nokia','htc_','samsung','motorola','smartphone','blackberry','playstation portable','tablet browser');$agent=strtolower($_SERVER['HTTP_USER_AGENT']);
foreach($mobile_agent_array as $value){if(strpos($agent,$value)!==false){$mob=1;$file_part='m';}}
setcookie('mob',$mob,time()+28144000,'/','.'.$_SERVER['SERVER_NAME']);
}else{$mob=htmlspecialchars($_COOKIE['mob'],ENT_QUOTES);
if(!preg_match("/[^0-1]+/",$mob)){($mob)?$file_part='m':$file_part='pc';}else{break;}}

$im=imagecreatefromjpeg($img.$ext);
($mob)?imagejpeg($im,NULL,49):imagejpeg($im,NULL,70);
imagedestroy($im);
}}//preg_match
}
?>