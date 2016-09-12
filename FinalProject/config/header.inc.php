<?php 
if(isset($_COOKIE['userID'])){
    $result = _mysql_query("SELECT 
							`user_id`
						FROM 
							`member` 
                        WHERE 
							`user_id`='{$_COOKIE['userID']}'
                       
	");
    if(_affected_rows() < 1){
        
        setcookie('guest',"1",time()+604800); 
        setcookie('firstName',"",time()-604800);                                        
        //setcookie('uniqid',"",time()-604800);
        setcookie('userID',"",time()-604800);  
        setcookie('orderTmp',"",time()+604800); 
        setcookie('numTmp',"",time()+604800);
        location("Error,user does not exist","index.php"); 
    } 
}

if (isset($_COOKIE['firstName'])){
    setcookie('guest',"0",time()+604800);   
} else {
    setcookie('guest',"1",time()+604800); 
}
                
if($_GET['action'] == 'logout'){
    setcookie('guest',"1",time()+604800); 
    setcookie('firstName',"",time()-604800);                                        
    //setcookie('uniqid',"",time()-604800);
    setcookie('userID',"",time()-604800);  
    setcookie('orderTmp',"",time()+604800); 
    setcookie('numTmp',"",time()+604800);
    location(null,'index.php');
}

if ($_GET['action'] == 'login') {
    setcookie('guest',"0",time()+604800); 
    $_info = array();
	$_info['email'] = $_POST['emailLogin'];
   
	$_info['password'] = sha1($_POST['passwordLogin']);
    $result = _mysql_query("SELECT 
							*
						FROM 
							`member` 
                        WHERE 
							`email`='{$_info['email']}'
                        AND
                            `password` ='{$_info['password']}'
					");
                    
    while (!!$data = mysql_fetch_array($result)){
		$html = array();
		$html['id'] = $data['user_id'];
		$html['firstName'] = $data['firstname'];  
	}  
    if($num = mysql_num_rows($result)){  

        setcookie('firstName',$html['firstName'],time()+604800);                                       
        setcookie('userID',$html['id'],time()+604800);  
        close();
        location('Login Successfully','index.php');
    } else {
        close();
		location('The account or password you entered is incorrect.','index.php');
    }
    
}

if ($_GET['action'] == 'signup') {
    
    $_info = array();
	$_info['email'] = $_POST['email'];
    
	$_info['password'] = sha1($_POST['password']);
	$_info['lastName'] = $_POST['lastName'];
    $_info['firstName'] = $_POST['firstName'];
   
    $result = _mysql_query("INSERT INTO `member` (
                                              `email`,
                                              `password`,
                                              `lastname`,
                                              `firstname`
                                                 ) 
                                            VALUES (
                                              '{$_info['email']}',
                                              '{$_info['password']}',
                                              '{$_info['lastName']}',
                                              '{$_info['firstName']}'
                                             )"
                                             );
    if(_affected_rows() == 1){
            close();
            location("Register Successfully.Please sign in","index.php");
    } else {
            close();
            location("Register Fail","index.php");
    }	
    

}


    
          


?>