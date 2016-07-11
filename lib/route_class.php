<?php
class Route{
    public static function location($site=Opt::SITENAME){
        if(!preg_match('/^'.Opt::SITENAME.'/',$site))$site=Opt::SITENAME.$site;
        header('Location: http://'.$site);
        exit;
    }
    public static function modul404($site=Opt::SITENAME){
        header("HTTP/1.0 404 Not Found");/*header("Status: 404 Not Found");*/
        self::location($site);
    }
}