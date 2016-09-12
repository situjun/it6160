<?php
session_start();
$ROOT = dirname(__FILE__);
require $ROOT.'\config\commen.inc.php';
require $ROOT.'\config\header.inc.php';
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
    <!-- Custom styles for this template -->
    <link href="css/index.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">    
  </head>
  <body>
      <!-- navbar -->
      <nav class="navbar navbar-dark bg-inverse navbar-fixed-top">
        <a class="navbar-brand" href="#">
          <img src="images/logo.png" height="30" width="40" alt="LOGO"></a>
        <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#exCollapsingNavbar2">&#9776;</button>
        <div class="collapse navbar-toggleable-xs" id="exCollapsingNavbar2">
          <ul class="nav navbar-nav pull-xs-left">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="Menu.php">Menu</a>
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
      
      <!-- carousel -->
      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
          <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          <div class="carousel-item active">
            <img src="images/food0.jpg" alt="First slide">          
            <div class="container">
              <div class="carousel-caption">
                <h3>Introduction</h3>
                <p>little introduction and a learn more button</p>
                <p><a href="Menu.php" class="btn btn-lg btn-primary">Learn More</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="images/members.png" alt="Second slide">
            <div class="container">
              <div class="carousel-caption">
                <h3>advantage of signing up</h3>
                <p>advantage of signing up and a sign up button</p>
                <p><button type="button" class="btn btn-lg btn-primary" data-toggle="modal" data-target="#myModalIndex">Sign Up</button></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="images/comments.png" alt="Third slide">
            <div class="container">
              <div class="carousel-caption">
                <h3>Comments</h3>
                <p>balabalabala</p>
                <p><a href="" class="btn btn-lg btn-primary">Comments</a></p>
              </div>
            </div>
          </div>
        </div>
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
          <span class="icon-prev" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
          <span class="icon-next" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
      
      <!-- detail -->
      <div class="detail">
        <div class="row">
<?php


    $result = _mysql_query("SELECT 
							*
						FROM 
							`food` 
                        
					");
                    
    while (!!$data = mysql_fetch_array($result)){
		$html = array();
		$html['id'] = $data['id'];
        $html['price'] = $data['price'];
		$html['name'] = $data['food_name'];
		$html['description'] = $data['description'];
		$html['img'] = $data['image'];
		
        echo '<div class="col-lg-4">';
        echo '<img src="admin/'.$html['img'].'" alt="img" class="img-circle" width="140" height="140">';
        echo '<h2>'.$html['name'].'</h2>';
        echo '<p>';
        echo $html['description'];
        echo '</p><p>';
        echo '<a href="menu.php" class="btn btn-info-outline">&nbsp;&nbsp;Order&nbsp;&nbsp;</a>';
        echo '</p></div>';
     
	}
    close();                    

?>        
        </div>
      </div>
    <!-- footer -->
      <footer class="navbar-fixed-bottom">
        <div class="row">
          <p style="padding: 10px 30px;color:#eceeef;">Restaurant database | UNCC | Computer Science @2016</p>
        </div>
      </footer>
    
    
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
    <script src="js/basic.js"></script>
    <?php 
        require $ROOT.'\config\footer.inc.php';
    ?>
  </body>
</html>
