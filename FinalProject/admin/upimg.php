<?php
define('IN_TG',true);
define('SCRIPT','upimg');
$ROOT = dirname(__FILE__);
require $ROOT.'\..\config\commen.inc.php';
//require $ROOT.'\..\config\admin.inc.php';
    if ($_GET['action'] == 'up') {
	
		$_files = array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif');
		
		$_n = explode('.',$_FILES['userfile']['name']);
		$_name = 'photo'.'/'.time().'.'.$_n[1];
		$destination_folder="uploadimg/";
		
		if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
			if	(!@move_uploaded_file($_FILES['userfile']['tmp_name'],$_name)) {
				
			} else {
				
				echo "<script>alert('upload succ！');window.opener.document.getElementById('url').value='$_name';window.close();</script>";
				exit();
			}
		} else {
			_alert_back('error');
		}
		
	} 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	
?>
</head>
<body>

<div id="upimg" style="padding:20px;">
	<form enctype="multipart/form-data" action="upimg.php?action=up" method="post">
		<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
		choose pic: <input type="file" name="userfile" />
		<input type="submit" value="upload" />
	</form>
</div>
</body>
</html>
