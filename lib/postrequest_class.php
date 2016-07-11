<?php
class PostRequest{

    public static function issetPostArr(){return(!empty($_POST))?true:false;}

    public static function issetPostKey($keys){
        $err=false;
        foreach($keys as $key){if(!array_key_exists($key,$_POST)){$err=true;}}
        return($err)?false:true;
    }

    public static function answerErrJson($return=false){
        $answer=['err'=>true];
        $answer['errText']=Validator::$ErrorForm;
        if($return){return $answer;}else{echo json_encode($answer);}
    }

    public static function feedback(){
        $err=false;
        if(PostRequest::issetPostKey(['name','mail','theme','sms','captcha'])){

            if(Validator::auditCaptcha($_POST['captcha'])){

                $name=Validator::auditFIO($_POST['name']);
                if(!$name){$err=true;}

                $mail=Validator::auditMail($_POST['mail']);
                if(!$mail){$err=true;}

                $theme=Validator::auditText($_POST['theme'],'тема');
                if(!$theme){$err=true;}

                $sms=Validator::auditTextArea($_POST['sms'],'сообщение');
                if(!$sms){$err=true;}

                if(!$err){
                    //добавить в БД
                    $ip=$_SERVER['REMOTE_ADDR'];
                    $DB=new SQLi(Opt::DB_HOST,Opt::DB_USER,Opt::DB_PASS,Opt::DB_NAME);
                    $sql='SELECT id FROM feedback WHERE captcha=? AND readed IS NULL';
                    $sql=$DB->realEscape($sql,Validator::$captcha);
                    if($DB->intSQL($sql)!=''){
                        //Ошибка капчи
                        $err=true;
                        Validator::$ErrorForm[]='Не верно введена капча';
                    }else{
                        $sql='INSERT INTO feedback(captcha,name,mail,theme,text,ip,data)VALUES(?,?,?,?,?,?,?)';
                        $param=[Validator::$captcha,$name,$mail,$theme,$sms,$ip,time()];
                        $sql=$DB->realEscape($sql,$param);
                        if(!$DB->boolSQL($sql)){
                            $err=true;
                            Validator::$ErrorForm[]='Ошибка соединения, повторите попытку позже...';}
                    }

                }

            }else{$err=true;}

        }else{$err=true;}
        return($err)?false:true;
    }

}