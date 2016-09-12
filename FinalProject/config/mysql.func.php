<?php

error_reporting(0);
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PW', '');
define('DB_NAME', 'onlinerestaurant');

function mysqlConnect(){
	global $flag1;
	if (!$flag1 = mysql_connect(DB_HOST,DB_USER,DB_PW)){
		exit('mysql connect error');
	}
}

function selectDB($flag){
	if (!mysql_select_db(DB_NAME,$flag)){
		exit('select db error');
	}
}
function setUTF8(){
	if (!mysql_query("SET NAMES UTF8")){
		exit('error');
	}
}

function mysql_string ($string){
	if (!mysql_string_status){
	//	return mysql_real_escape_string($string);
		if (is_array($string)){
			foreach ($string as $key => $value){
				$string[$key] = mysql_string($value);
			}
		} else {
			$string = mysql_real_escape_string($string);
		}
	}
	return $string;
}

function _affected_rows(){
	return mysql_affected_rows();
}

function _mysql_fetch($sql){
	$data = _mysql_query($sql);
	return  mysql_fetch_array($data);
}

function _mysql_query($sql){
	$data = mysql_query($sql);
	if (!$data){
		exit(mysql_error());
	} else {
		return $data;
	}
}

function close(){
	if (!mysql_close()){
		exit('error');
	}
}

function _isArray($sql){
	$result = _mysql_fetch($sql);
	if (is_array($result)){
		return true;
	} else {
		return false;
	}
}
mysqlConnect();
selectDB($flag1);
setUTF8();
?>