<?php
/**
 * Date: 14.04.2016
 * Time: 1:25
 */
Error_Reporting(E_ALL & ~E_NOTICE);//средний
ini_set('display_errors',1);
//классы в автозагрузке
set_include_path($_SERVER['DOCUMENT_ROOT']."/lib");
spl_autoload_extensions("_class.php");
spl_autoload_register();
$Captcha=new Captcha();
