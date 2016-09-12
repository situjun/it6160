<?php 
session_start();
$ROOT = dirname(__FILE__);
require $ROOT.'\..\config\commen.inc.php';
//require $ROOT.'\..\config\admin.inc.php';
if(isset($_SESSION['admin'])){
    location(null,'admin.php');
}
if ($_GET['action'] == 'login') {
    $_info = array();
	$_info['admin_user'] = $_POST['admin_user'];
	$_info['admin_pass'] = sha1($_POST['admin_pass']);
    $result = _mysql_query("SELECT 
							*
						FROM 
							`admin` 
                        WHERE 
							`name`='{$_info['admin_user']}'
                        AND
                            `password` ='{$_info['admin_pass']}'
					");
                    
    while (!!$data = mysql_fetch_array($result)){
		$html = array();
		$html['id'] = $data['id'];
		$html['name'] = $data['name'];
		$html['password'] = $data['password'];
		$html['admin_type'] = $data['admin_type'];	
	}
    if($num = mysql_num_rows($result)){
        $_SESSION['admin'] = $html['admin_type'];
        close();
        location(null,'admin.php');
    } else {
        close();
		location('The account or password you entered is incorrect.','index.php');
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="../css/admin.css" />
<script type="text/javascript" src="../js/admin_login.js"></script>
</head>
<body>

<form id="adminLogin" name="login" method="post" action="?action=login">
	<fieldset>
		<legend>Administartor Login</legend>
		<label>Account: &nbsp;<input type="text" name="admin_user" class="text" /></label>
		<label>Password:<input type="password" name="admin_pass" class="text" /></label>
		<input type="submit" value="Login" class="submit" onclick="return checkLogin();" name="send" />
	</fieldset>
</form>
</body>
</html>