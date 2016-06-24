<?php
header('Content-type: text/css; charset: UTF-8');header('Cache-Control: public, max-age=14515200');
//определяем мобильный($mob=1) или нет($mob=0)//$file_part='m';$file_part='pc';
if(!isset($_COOKIE['mob'])){$mob=0;$file_part='pc';$mobile_agent_array=array('ipad','iphone','android','pocket','palm','windows ce','windowsce','cellphone','opera mobi','ipod','small','sharp','sonyericsson','symbian','opera mini','nokia','htc_','samsung','motorola','smartphone','blackberry','playstation portable','tablet browser');$agent=strtolower($_SERVER['HTTP_USER_AGENT']);
foreach($mobile_agent_array as $value){if(strpos($agent,$value)!==false){$mob=1;$file_part='m';}}
setcookie('mob',$mob,time()+28144000,'/','.'.$_SERVER['SERVER_NAME']);
}else{$mob=htmlspecialchars($_COOKIE['mob'],ENT_QUOTES);
if(!preg_match("/[^0-1]+/",$mob)){if($mob)$file_part='m';else $file_part='pc';}else{break;}}
//Далее обработка gzip
$HTTP_ACCEPT_ENCODING=$_SERVER["HTTP_ACCEPT_ENCODING"]; 
if(strpos($HTTP_ACCEPT_ENCODING,'x-gzip')!==false)$encoding='x-gzip';
else if(strpos($HTTP_ACCEPT_ENCODING,'gzip')!==false)$encoding='gzip';
else $encoding=false;
$all_default_css=array('default','frame','common','menu','color','colorbox','form');
$all_special_css=array('frame');

$cache_dir='cache/'.$file_part;
//далее обрабатываем условие по умолчанию баз GET запроса
if(!isset($_GET['add'])){$cache_file='Def';
	if(file_exists($cache_dir.$cache_file.'.tmp')){
	$css=file_get_contents($cache_dir.$cache_file.'.tmp');	
		if($encoding){header('Content-Encoding: '.$encoding);
		echo("\x1f\x8b\x08\x00\x00\x00\x00\x00");
		if($mob)$css=gzcompress($css,6);else $css=gzcompress($css,3);}
	}else{ob_start();
	foreach($all_default_css as $value){include $value.'.css';}	
	foreach($all_special_css as $value){include $value.'_'.$file_part.'.css';}
	$css=ob_get_contents();ob_end_clean();
	$css=preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!','',$css);
	$css=str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),'',$css);
	$css='@charset "utf-8";'.$css;
	$handle=fopen($cache_dir.$cache_file.'.tmp','w');fwrite($handle,$css);fclose($handle);
		if($encoding){header('Content-Encoding: '.$encoding);
		echo("\x1f\x8b\x08\x00\x00\x00\x00\x00");
		if($mob)$css=gzcompress($css,6);else $css=gzcompress($css,3);}
	}
}else{
	$add=htmlspecialchars($_GET['add'],ENT_QUOTES);
	if(!preg_match("/[^a-z]+/",$add)){$cache_file=$add;
		if(file_exists($cache_dir.$cache_file.'.tmp')){
		//выводить если файл есть
		$css=file_get_contents($cache_dir.$cache_file.'.tmp');	
		if($encoding){header('Content-Encoding: '.$encoding);
		echo("\x1f\x8b\x08\x00\x00\x00\x00\x00");
		if($mob)$css=gzcompress($css,6);else $css=gzcompress($css,3);}
		}else{
			$bad_css=0;
			switch($add){//что-б небыло ошибки при отсутствия файла
				case'specialcss':
				$special_css='specialcss';break;
				
				default:
				$bad_css=1;break;
			}//switch
			if(!$bad_css){
			if(file_exists($cache_dir.'Def.tmp')){
				ob_start();
				include $cache_dir.'Def.tmp';
				include $special_css.'.css';
				$css=ob_get_contents();ob_end_clean();
				$css=preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!','',$css);
				$css=str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),'',$css);
				$handle=fopen($cache_dir.$cache_file.'.tmp','w');fwrite($handle,$css);fclose($handle);
				if($encoding){header('Content-Encoding: '.$encoding);
				echo("\x1f\x8b\x08\x00\x00\x00\x00\x00");
				if($mob)$css=gzcompress($css,6);else $css=gzcompress($css,3);}
			}else{//нет tmp вообще
				ob_start();
				foreach($all_default_css as $value){include $value.'.css';}	
				foreach($all_special_css as $value){include $value.'_'.$file_part.'.css';}
				include $special_css.'.css';
				$css=ob_get_contents();ob_end_clean();
				$css=preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!','',$css);
				$css=str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),'',$css);
				$css='@charset "utf-8";'.$css;
				$handle=fopen($cache_dir.$cache_file.'.tmp','w');fwrite($handle,$css);fclose($handle);
				if($encoding){header('Content-Encoding: '.$encoding);
				echo("\x1f\x8b\x08\x00\x00\x00\x00\x00");
				if($mob)$css=gzcompress($css,7);else $css=gzcompress($css,3);}
			}
			}//!$bad_css
		}
	}
}//isset($_GET['add'])
echo $css;?>