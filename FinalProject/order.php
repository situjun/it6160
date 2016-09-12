
<?php
session_start();

$ROOT = dirname(__FILE__);
require $ROOT.'\config\commen.inc.php';
require $ROOT.'\config\header.inc.php';

$dishArr = array();
$arrTmp = array();


//if (isset($_COOKIE['guest'])){        
    //if($_COOKIE['guest'] == '1'){
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
        
    //}   
//}        
  //alert($_COOKIE['orderTmp']);          
if($_GET['action'] == 'checkout'){
    $sqli = "CREATE VIEW 
                            orderD(user_id,food_id) 
                       AS SELECT 
                            user_id,food_id 
                       FROM 
                            orders,order_details 
                       WHERE 
                            orders.order_id=order_details.order_id;";   
    
    $sql = "SELECT * FROM `member` WHERE `user_id` = '{$_COOKIE['userID']}'";
    $result = _mysql_query($sql);
                     
    while (!!$data = mysql_fetch_array($result)){
       
        $address = $data['address'];
        $phone = $data['phone'];
    }
    
    if($_COOKIE['guest'] == '1'){
        if($_POST['guestAddr'] == ""){
            location('Guest,please input your address.','order.php');  
            exit(0);
        } else {
            $address = $_POST['guestAddr'];
            
            $phone = '00000000';
        }
    } else {
        if(trim($address) == ""){
            if($_COOKIE['guest'] == '0'){
                location('Complete Basic Info please','myaccount.php');  
                exit(0);
            }
        
        }
    }
    
    
    
    
    //create orderNum
    $orderNum = time()+count($idArr);
    
    $_info = array();
    $_info['orderNum'] = $orderNum;
    $_info['price'] = $_POST['total'];
    $_info['amount'] = $_POST['totalAmount'];
	$sqlGuest = "INSERT INTO `orders` (
                                              `orderNum`,
                                              `user_id`,
                                              `phone`,
                                              `address`,
                                              `total_price`,
                                              `quantity`,
                                              `time`   
                                                   ) 
                                            VALUES (
                                              '{$_info['orderNum']}',
                                              '000',
                                              '{$phone}',
                                              '{$address}',
                                              '{$_info['price']}',
                                              '{$_info['amount']}',
                                              NOW()
                                                            )";
    $sqlMember = "INSERT INTO `orders` (
                                              `orderNum`,
                                              `user_id`,
                                              `phone`,
                                              `address`,
                                              `total_price`,
                                              `quantity`,
                                              `time`   
                                                   ) 
                                            VALUES (
                                              '{$_info['orderNum']}',
                                              '{$_COOKIE['userID']}',
                                              '{$phone}',
                                              '{$address}',
                                              '{$_info['price']}',
                                              '{$_info['amount']}',
                                              NOW()
                                                            )";
    
   
    
    if(isset($_COOKIE['guest'])){
        if($_COOKIE['guest'] == '1'){
            $result = _mysql_query($sqlGuest);
        } else {
            $result = _mysql_query($sqlMember);
        }
    }
    if(_affected_rows() == 1){
            close();
             setcookie('orderTmp',"",time()+604800); 
             setcookie('numTmp',"",time()+604800);
            if($_COOKIE['guest'] == '1'){
                location('Order Successfully','menu.php');
            } else {
                location('Order Successfully','recentOrder.php');
            }
    } else {
            close();
            location('Order Fail','recentOrder.php');
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
    <link href="css/global.css" rel="stylesheet">
    <link href="css/order.css" rel="stylesheet">
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
           <li class="active">
             <a href="#">My Order&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
           </li>
           <?php
                if(isset($_COOKIE['guest'])){
                    if($_COOKIE['guest'] == '0'){
                        echo '<li><a href="recentOrder.php">Recent Orders</a></li>';
                    }
                }
           ?>           
         </ul>       
       </div>
       <div class="col-sm-10 col-sm-offset-3 col-md-10 col-md-offset-2 main">
         <h1 class="page-header">Order</h1>

         <!-- table -->         
         <!--  <h2 class="sub-header">Place Order</h2>   -->
         <div class="table-responsive">
           <table class="table table-striped">
             <thead>
               <tr>
                 <th>#Dish</th>
                 <th>Name</th>
                 <th>Img</th>
                 <th>Price</th>
                 <th>Amount</th>
               </tr>
             </thead>
             <tbody>
             
             <?php
                 if(trim($_COOKIE['orderTmp']) != ''){
                    $sql = "SELECT * FROM `food` WHERE `food_id` IN (";
                    $str = substr($str,0,-count($str));
                    $sql .= $str;
                    $sql .= ");";
                    
                    $result = _mysql_query($sql);        
                    $totalAmount = 0;
                    $total = 0;
                    while (!!$data = mysql_fetch_array($result)){                  
                            $html = array();
                            $html['id'] = $data['food_id'];
                            $html['price'] = $data['price'];
                            $html['name'] = $data['food_name'];
                            
                            $html['img'] = $data['image'];
                        if($dishArr[$html['id']] != '0'){  
                            echo '<tr>';
                            echo '<td>'.$html['id'].'</td>';
                            echo '<td>'.$html['name'].'</td>';
                            echo '<td><img src="admin/'.$html['img'].'" alt="img"  width="100px" height="50px"/></td>';
                            echo '<td>'.$html['price'].'</td>';
                            echo '<td>'.$dishArr[$html['id']].'</td>';
                            echo '</tr>';
                            
                            $total += $html['price']*$dishArr[$html['id']];
                            $totalAmount += $dishArr[$html['id']];
                        }
                        
                    }
                    close();
                 }
                
             ?>
             </tbody>
           </table>
         </div>

         </div>
     </div>
    </div>
    <!-- footer navbar -->
    <footer  class="navbar-fixed-bottom">
    <p class="col-xs-9" style="width:850px;">Restaurant database | UNCC | Computer Science @2016</p>
      <div class="nav navbar-nav  pull-xs-right">
        <!--    <a class="nav-item nav-link" >Price</a>
                     -->
        <form style="margin:10px 10px 0 0;" id="checkOutForm" name="checkOutForm" method="post" action="?action=checkout" onsubmit="return checkOut()">
            
            <input type="text" hidden="true" id="totalVal" name="total" value="<?php echo $total; ?>"/>
            <a class="nav-item nav-link" >$<?php echo $total; ?>&nbsp;&nbsp;</a>
            <input type="text" hidden="true" id="totalVal" name="total" value="<?php echo $total; ?>"/>
            <input type="text" hidden="true" name="totalAmount" value="<?php echo $totalAmount; ?>"/>
            <?php
                if($_COOKIE['guest'] == '1'){
            ?>
                    <a style="float:left;color:green;" class="nav-item nav-link" >Addr:</a>
                    <input type="text"  name="guestAddr" style="width:200px;" value=""/>
            <?php            
                }
                
            ?>
            
            <input type="submit" name="submit" value="Check Out" class="btn btn-success" style="background-color:orange;" />
        </form>
      </div>
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
    <!-- jQuery first and then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/order.js" type="text/javascript"></script>
    <script src="js/basic.js"></script>
    <script type="text/javascript">
        function checkOut(){
            if(document.getElementById("totalVal").value == '') return false;
        }
    </script>
    <?php 
        require $ROOT.'\config\footer.inc.php';
    ?>
  </body>
</html>
