<?php
define('ROOT',$_SERVER['DOCUMENT_ROOT']);

set_include_path(ROOT.PATH_SEPARATOR.ROOT.'/lib'.PATH_SEPARATOR.ROOT.'/include');
spl_autoload_extensions('_class.php');
spl_autoload_register();

if(PostRequest::issetPostArr()){
    if(!empty($_POST['feedback'])){
        if(PostRequest::feedback()){
            echo json_encode(['err'=>false,'answer'=>'Спасибо! Ваше сообщение отправлено...']);
        }else{PostRequest::answerErrJson();}
    }
    if(!empty($_POST['babywords'])){
        if(DpPost::babywords()){
            echo json_encode(['err'=>false,'answer'=>'Ваш комментарий добавлен.
Благодарим за проявленный интерес...']);
        }else{PostRequest::answerErrJson();}
    }
}