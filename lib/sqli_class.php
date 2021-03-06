<?php
class SQLi{public static $mysql_link=null;
function __construct($host=Opt::DB_HOST,$user=Opt::DB_USER,$pass=Opt::DB_PASS,$db_name=Opt::DB_NAME,$charset=Opt::DB_CHARSET){self::connectDB($host,$user,$pass,$db_name,$charset);}
protected static function connectDB($host=Opt::DB_HOST,$user=Opt::DB_USER,$pass=Opt::DB_PASS,$db_name=Opt::DB_NAME,$charset=Opt::DB_CHARSET){if(self::$mysql_link==null){self::$mysql_link=mysqli_connect($host,$user,$pass,$db_name);if(self::$mysql_link){return(self::$mysql_link->set_charset($charset))?true:false;}}else{return true;}}
public function queryProcedure($sql){$res=mysqli_query(self::$mysql_link,$sql);return $res;}
public function boolSQL($sql){if(mysqli_query(self::$mysql_link,$sql)===TRUE){return 1;}else{return 0;}}
public function intSQL($sql){$result=mysqli_query(self::$mysql_link,$sql);$row=$result->fetch_row();return $row[0];}
public function strSQL($sql){$result=mysqli_query(self::$mysql_link,$sql);$res=$result->fetch_array(MYSQLI_ASSOC);$result->close();return $res;}
public function arrSQL($sql){$columns=[];$result=mysqli_query(self::$mysql_link,$sql);while($res=$result->fetch_array(MYSQLI_ASSOC)){$columns[]=$res;}$result->free();return $columns;}
public function realEscapeStr($part_sql){if(is_array($part_sql)){$res=[];foreach($part_sql as $val){if($val==''){$res[]='NULL';}else{$res[]='\''.mysqli_real_escape_string(self::$mysql_link, $val).'\'';}}return $res;}else{if($part_sql=='')$arg='NULL';else $arg='\''.mysqli_real_escape_string(self::$mysql_link, $part_sql).'\'';return $arg;}}
public function realEscape($sql,$params){$len_sq=strlen('?');$offset=0;if(is_array($params)){for($i=0;$i<count($params);$i++){$pos=strpos($sql,'?',$offset);if($params[$i]=='')$arg="NULL";else $arg='\''.mysqli_real_escape_string(self::$mysql_link,$params[$i]).'\'';$sql=substr_replace($sql,$arg,$pos,$len_sq);$offset=$pos+strlen($arg);}}else{$pos=strpos($sql,'?',$offset);if($params=='')$arg='NULL';else $arg='\''.mysqli_real_escape_string(self::$mysql_link,$params).'\'';$sql=substr_replace($sql,$arg,$pos,$len_sq);}return $sql;}
public function lastId(){return mysqli_insert_id(self::$mysql_link);}}