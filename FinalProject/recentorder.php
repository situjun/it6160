
<?php
session_start();

$ROOT = dirname(__FILE__);
require $ROOT.'\config\commen.inc.php';
require $ROOT.'\config\header.inc.php';

$dishArr = array();
$arrTmp = array();
if(isset($_COOKIE['guest'])){
    if($_COOKIE['guest'] == '1'){
        location('error','order.php');
    }
}

if (isset($_COOKIE['guest'])){        
    if($_COOKIE['guest'] == '1'){
        if(isset($_COOKIE['orderTmp'])){
            $idArr = explode(",",$_COOKIE['orderTmp']);
            $numArr = explode(",",$_COOKIE['numTmp']);
            for ($x=0; $x<=count($idArr)-1; $x++) {
                $dishArr[$idArr[$x]] = $numArr[$x];
            } 
            
            $str = "";
            foreach(array_unique($idArr) as $val){
                if(trim($val) != ""){
                    $str .= $val.",";
                }
            }
        }
        
    }   
}        
$str = substr($str,0,-count($str));            

        
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

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap/bootstrap-glyphicons.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/order.css" rel="stylesheet">
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
          <li class="nav-item ">
            <a class="nav-link" href="Menu.php">Menu</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="#">Order</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
          <?php
           if(isset($_COOKIE['guest'])){
                if($_COOKIE['guest'] == '0'){
                    echo '<li class="nav-item"><a class="nav-link" href="myaccount.php">&nbsp;&nbsp;My Account</a></li>';
                }
            } 
         
          ?>
          </li>
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
           <li >
             <a href="order.php">My Order&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
           </li >
           <li class="active">
             <a href="#">Recent Orders</a>
           </li>
           
         </ul>
        
       </div>
       <div class="col-sm-10 col-sm-offset-3 col-md-10 col-md-offset-2 main">
         <h1 class="page-header">Rcent Orders</h1>

         <!-- table -->         
         <!--  <h2 class="sub-header">Place Order</h2>   -->
         <div class="table-responsive">
           <table class="table table-striped">
             <thead>
               <tr>
                 <th>#Order</th>
                 <th>Total</th>
                 <th>Addr</th>
                 <th>Phone</th>
                 <th>Quantity</th>
                 <th>Time</th>
               </tr>
             </thead>
             <tbody>
             
             <?php
                 //if(trim($_COOKIE['orderTmp']) != ''){
                    $sql = "SELECT * FROM `orders` WHERE `user_id` = ";
                    $sql .= $_COOKIE['userID'].";";
                  
                    //alert($sql);
                    $result = _mysql_query($sql);        
                    while (!!$data = mysql_fetch_array($result)){

                            $html = array();
                            $html['id'] = $data['order_id'];
                            $html['orderNum'] = $data['orderNum'];
                            $html['price'] = $data['total_price'];
                            $html['addr'] = $data['address'];
                            $html['phone'] = $data['phone'];
                            $html['amount'] = $data['quantity'];
                            $html['time'] = $data['time'];
                        if($dishArr[$html['id']] != '0'){  
                            echo '<tr>';
                            echo '<td>'.$html['orderNum'].'</td>';
                            echo '<td>$'.$html['price'].'</td>';
                            echo '<td>'.$html['addr'].'</td>';
                            echo '<td>'.$html['phone'].'</td>';
                            echo '<td>'.$html['amount'].'</td>';
                            echo '<td>'.$html['time'].'</td>';
                            echo '</tr>'; 
                        }
                        
                    }
                    close();
                 //}
                
             ?>
             </tbody>
           </table>
         </div>

         </div>
     </div>
    </div>
    <!-- footer navbar -->
    <footer  class="navbar-fixed-bottom">
    <p class="col-xs-9">Restaurant database | UNCC | Computer Science @2016</p>
      <div class="nav navbar-nav  pull-xs-right">
        <!--    <a class="nav-item nav-link" >Price</a>
                     -->
        <form style="margin:10px 10px 0 0;" id="checkOutForm" name="checkOutForm" method="post" action="?action=checkout" onsubmit="return">
            <a href="menu.php" class="btn btn-success" style="background-color:gray;" >GOTO Menu</a>
        </form>
      </div>
    </footer>
    <!-- Modal -->          
    <div class="modal fade" id="myModalMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Sign up</h4>
          </div>
          <div class="modal-body">
            <div class="container">
              <label class="row" name="email">Email</label>
              <br>    
              <input class="row" type="email" placeholder="example@example.com" />    
              <br>    
              <label class="row" name="password">Password</label>
              <br>    
              <input class="row" type="password" placeholder="password"/>    
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Sign up</button>
          </div>
        </div>
      </div>
    </div>
    <!-- jQuery first and then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/order.js" type="text/javascript"></script>
    <script src="js/basic.js"></script>
    <?php 
        require $ROOT.'\config\footer.inc.php';
    ?>
  </body>
</html>
