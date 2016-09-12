<?php 

error_reporting(0);
$path = dirname(__FILE__);
require $path.'/global.fuc.php';
require $path.'/mysql.func.php';
define("mysql_string_status", get_magic_quotes_gpc());
?>