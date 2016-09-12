<?php 

	function back_result($info){
		echo "<script type='text/javascript'>alert('".$info."');history.back(); </script>";
		exit();
	}
	function location ($info,$href){
		if (!empty($info)){
			echo "<script type='text/javascript'>alert('$info');location.href='$href';</script>";
		} else {
			echo "<script type='text/javascript'>location.href='$href';</script>";
		}
	}
	


	function sexCheck($string){
		return mysql_string($string);
	}
	function shaq_uniqid(){
		return mysql_string(sha1(uniqid(rand())));
	}

	function sessionDestory(){
		if (session_start()){
			session_destroy();
		}
	}

	function cookieDestory(){
		setcookie('username',123,time()-1000);
		setcookie('uniqid',123,time()-1000);
		sessionDestory();
		location('', 'index.php');
	}

	function _htmlSpecialChars($string){
		if (is_array($string)){
			foreach ($string as $key => $value){
				$string[$key] = _htmlSpecialChars($value);
			}
		} else {
			$string = htmlspecialchars($string);
		}
		return $string;
	}
	function alert_close($info){
		echo "<script type='text/javascript'>alert('".$info."');window.close(); </script>";
		exit();
	}
    function alert($info){
		echo "<script type='text/javascript'>alert('".$info."');</script>";
		exit();
	}
?>