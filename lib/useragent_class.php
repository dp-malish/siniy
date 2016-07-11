<?php
class UserAgent{
    public static $HTTP_USER_AGENT;
    function __construct(){self::$HTTP_USER_AGENT=Validator::html_cod($_SERVER['HTTP_USER_AGENT']);}

    public function insertUserAgent($DB){
        if(!is_null(SQLi::$mysql_link)){
            $ip=$_SERVER['REMOTE_ADDR'];
            $sql='INSERT INTO bot VALUES(NULL,?,\''.$ip.'\',?)';
            $sql=$DB->realEscape($sql,[self::$HTTP_USER_AGENT,time()]);
            $DB->boolSQL($sql);
        }
    }
    public function isBot(){
        $is_bot=false;
        $bots=['rambler','googlebot','aport','yahoo','msnbot','mail.ru',
            'yetibot','ask.com','liveinternet.ru','yandexbot','google page speed','bing.com'];
        foreach($bots as $bot){if(mb_stripos(self::$HTTP_USER_AGENT,$bot)!==false){$is_bot=true;}}
        return $is_bot;
    }
}