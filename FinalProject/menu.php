
<?php
session_start();
$ROOT = dirname(__FILE__);
require $ROOT.'\config\commen.inc.php';
require $ROOT.'\config\header.inc.php';
$dishArr = array();
if ($_GET['action'] == 'add') {
    $arr = array();
    $arr[0] = $_POST['idDish'];
    $arr[1] = $_POST['numDish'];
    if(!isset($_COOKIE['orderTmp'])){
        setcookie('orderTmp',$arr[0].",",time()+604800); 
        setcookie('numTmp',$arr[1].",",time()+604800);
    } else {
        setcookie('orderTmp',$_COOKIE['orderTmp'].$arr[0].",",time()+604800); 
        setcookie('numTmp',$_COOKIE['numTmp'].$arr[1].",",time()+604800);
    } 
    location(null,'menu.php');
} 
if(isset($_COOKIE['orderTmp'])){
    $idArr = explode(",",$_COOKIE['orderTmp']);
    $numArr = explode(",",$_COOKIE['numTmp']);
    $totalNum = 0;
    for ($x=0; $x<=count($idArr)-1; $x++) {
        $dishArr[$idArr[$x]] = $numArr[$x];
        
    } 
}      
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Restaurant</title>
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap/bootstrap-glyphicons.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="css/menu.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
  </head>
  <body>
    <!-- navbar -->
    <nav class="navbar navbar-dark navbar-fixed-top bg-inverse">
      <a class="navbar-brand" href="#">
        <img src="images/logo.png" height="30" width="40" alt="LOGO"></a>
      <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2">&#9776;</button>
      <div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
        <ul class="nav navbar-nav pull-xs-left">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="#">Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Order.php">Order</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <?php
           if(isset($_COOKIE['guest'])){
                if($_COOKIE['guest'] == '0'){
                    echo '<li class="nav-item"><a class="nav-link" href="myaccount.php">&nbsp;&nbsp;My Account</a></li>';
                }
            } 
         
          ?>
        </ul>
        <ul class="nav navbar-nav pull-xs-right">
            <li class="nav-item">
               <?php 
                echo 'Welcome&nbsp';
                if (isset($_COOKIE['firstName'])){
                    
                    echo $_COOKIE['firstName']."!";
                } else {
                    echo 'guest!';
                }
                
              ?>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalIndex">Sign Up</button>
            </li>
            <li class="nav-item dropdown">
              
               <form id="memberLogin" name="memberLogin" method="post" action="?action=login" onsubmit="return checkLogin();">
                  <button type="button" class="btn btn-primary-outline" id="signinButton" data-toggle="dropdown">Sign in</button>
                  <button type="button" class="btn btn-primary-outline"  id="logoutButton" style="display:none;" data-toggle="" onclick="location.href='index.php?action=logout';">Log out</button>
                  <div class="dropdown-menu dropdown-menu-right formholder">
                    <label class="row" name="emailLabel1">Email</label>
                    <input class="row" type="email" name="emailLogin"placeholder="example@example.com" />      
                    <label class="row" name="passwordLabel1">Password</label>
                    <input class="row" type="password" name="passwordLogin" placeholder="password"/>      
                    <input type="submit" name="submitLogin" value="Log in" class="btn btn-primary" />
                  </div>
               </form>
            </li>
          </ul>
      </div>
    </nav>
    <!-- main -->
    <div class="container-fluid">
     <div class="row">
       <div class="col-sm-2 col-md-2 sidebar">
         <ul class="nav nav-sidebar">
               <?php
                    if(!$_GET['category']){
                       echo '<li class="active">';
                       echo ' <a href="menu.php">Default</a>';
                       echo '</li>';            
                    } else {
                       echo '<li >';
                       echo ' <a href="menu.php">Default</a>';
                       echo '</li>';  
                    }
                    
               ?>
               
               <?php
                
                        $sql = "select * from `menu`"; 
                        $result = _mysql_query($sql);
                        while (!!$data = mysql_fetch_array($result)){
                            if($_GET['category']){
                                if($_GET['category'] == $data['category_id']){
                                    echo '<li class="active">';
                                } else {
                                    echo '<li >';
                                }
                            }else {
                                echo '<li >';
                            }
                            
                            echo '<a href="?category='.$data['category_id'].'">'.$data['category_name'].'</a>';
                            
                            echo '</li >';
                        } 
                
               ?> 
         </ul>
         
       </div>
       <div class="col-sm-10 col-sm-offset-3 col-md-10 col-md-offset-2 main">
         <h1 class="page-header">Hot!!</h1>
         <div class="row placeholders">
<?php

if($_GET['action'] == 'search'){
    //alert($_POST['keywords']); 
    if(isset($_POST['keywords'])){
       $sql = "select * from `food` where `food_name` like '%" .$_POST['keywords']."%'"; 
    } else {
       $sql = "SELECT * FROM `food` ";
       if(_affected_rows() == 0){
            location('No Food','index.php');
       } 
    }
}else if($_GET['category']){
    $category = $_GET['category'];
    $sql = "SELECT * FROM `food` WHERE `category_id` = '{$category}'";
    $result = _mysql_query($sql);
} else {
    $sql = "SELECT * FROM `food` ";
    $result = _mysql_query($sql);
    if(_affected_rows() == 0){
        location('No Food','index.php');
    }    
}
    $count = 0;   
    $result = _mysql_query($sql);
    if(_affected_rows() == 0){
        location('No result','menu.php');
    }        
    while (!!$data = mysql_fetch_array($result)){
		$html = array();
		$html['id'] = $data['food_id'];
        $html['price'] = $data['price'];
		$html['name'] = $data['food_name'];
		$html['description'] = $data['description'];
		$html['img'] = $data['image'];	
        //if($count%3 == 0) echo '<div class="row placeholders">';
        echo '<div class="col-xs-6 col-sm-3 placeholder">';
        echo '<img src="admin/'.$html['img'].'" width="174" height="174" title="'.$html['description'].'" class="img-responsive" alt="Generic placeholder thumbnail">';
        echo '<h4>'.$html['name'].'</h4>';
        echo '<span class="text-muted">$'.$html['price'].'</span>';
        echo '<div class="row itemAdd" style="display: none;">';
        echo '<form id="dishSubmit" name="dishSubmit" method="post" action="?action=add" onsubmit="return">
        <input class="col-sm-4" name="numDish" id="dish'.$html['id'].'" placeholder="number" value="';
        if($dishArr[$html['id']]){
            
            $totalNum += $dishArr[$html['id']];
            echo $dishArr[$html['id']];
        }
        else echo '0';
        echo '">';
        echo '<input type="text" value="'.$html['id'].'" name="idDish" hidden="true">';
        echo '<button type="button" id="'.$html['id'].'" class="add col-sm-2 iconbutton" onclick="addDish('.$html['id'].');"><span class="glyphicon glyphicon-plus"></span></button><button type="button" id="'.$html['id'].'" onclick="minusDish('.$html['id'].');" class="minus col-sm-2 iconbutton"><span class="glyphicon glyphicon-minus"></span></button>
        <input type="submit" value="submit" name="submit" class="btn btn-warning col-sm-4"></form>';
        echo '</div></div>  ';
        //if($count%3 == 0) echo '</div>';
        $count++;
	} 
    close();                    

?> 
            </div>
         </div>
       </div>
     </div>
    </div>
    <!-- footer navbar -->
    <footer  class="navbar-fixed-bottom">
    <p class="col-xs-9" style="width:850px;">Restaurant database | UNCC | Computer Science @2016</p>
    <?php
        if($_GET['category']){
            echo '<a style="float:left;margin:14px 0 0 0;color:white;">Item number:</a>';
        } else {
            echo '<a style="float:left;margin:14px 0 0 0;color:white;">Total number:</a>';
        }
    
    ?>
    
    <a id="itemNum" style="float:left;margin:14px 0 0 0;color:white;"><?php echo $totalNum; ?></a>
    <form style="margin:10px 10px 0 0;" id="searchForm" name="searchForm" method="post" action="?action=search" onsubmit="return">
      <div class="nav navbar-nav  pull-xs-right">
        <a class="nav-item nav-link" >Search&nbsp;&nbsp;</a>
        <input type="text" value="" name="keywords" style="color:black;" />  
        <input  type="submit" name="searchButton" value="Submit" class="btn btn-success-outline" />
      </div>
    </form>
    </footer>
    <!-- Modal -->          
    <div id="myModalIndex" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Sign up</h4>
            </div>
            <form id="memberSignUp" name="memberSignUp" method="post" action="?action=signup" onsubmit="return checkSignUp();">
                <div class="modal-body">
                  <div class="container">
                    <label name="emailLabel" >Email</label>
                    <br>      
                    <input type="email" id="email" name="email" placeholder="example@example.com" />      
                    <br>      
                    <label name="passwordLabel" >Password</label>
                    <br>      
                    <input type="password" id="password" name="password" placeholder="password"/> 
                    <br>                     
                    <label name="passwordLabel2" >Retype Password</label>
                    <br>      
                    <input type="password" id="password2" name="password2" placeholder="password"/>  
                    <br>   
                    <label name="First Name" >First Name</label>
                    <br>      
                    <input type="text" id="firstName" name="firstName"/>      
                    <br>      
                    <label name="Last Name" >Last Name</label>
                    <br>      
                    <input type="text" id="lastName" name="lastName"/>

                        
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                  <input type="submit" class="btn btn-primary" name="submit" value="Sign up" />
                </div>
            </form>
          </div>
        </div>
      </div>

   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/menu.js" type="text/javascript"></script>
    <script src="js/basic.js"></script>
    <script  type="text/javascript">
        function addDish(id){
            var inputID = 'dish'+id;
            var inputObj = document.getElementById(inputID);
            var itemNum = document.getElementById("itemNum");
            var num = parseInt(inputObj.value);
            
            //var num2 = 0;
            var num2 = parseInt(itemNum.innerHTML);
            if(isNaN(num2)){
                num2 = 0;
            }
            //var num2 = parseInt(itemNum.innerHTML);
            inputObj.value = num+1;
            itemNum.innerHTML = num2+1;
        }
        function minusDish(id){
            var inputID = 'dish'+id;
            var inputObj = document.getElementById(inputID);
            var itemNum = document.getElementById("itemNum");
            var num = parseInt(inputObj.value);
            var num2 = parseInt(itemNum.innerHTML);
            if(num-1 <0){
                inputObj.value = 0;
                
            } else {
                inputObj.value = num-1;
                itemNum.innerHTML = num2-1;
            }
            if(num2-1<0){
                itemNum.innerHTML = 0;
            }
            
        }
        
    </script>

    <?php 
        require $ROOT.'\config\footer.inc.php';
    ?>
  </body>
</html>
