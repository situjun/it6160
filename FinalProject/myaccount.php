
<?php
session_start();
$ROOT = dirname(__FILE__);
require $ROOT.'\config\commen.inc.php';
require $ROOT.'\config\header.inc.php';
if($_GET['action'] == 'update'){
    $_info = array();
    $_info['email'] = $_POST['email'];
    $_info['address'] = $_POST['address'];
    $_info['phone'] = $_POST['phone'];
    $_info['birthday'] = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
    
    $sql = "UPDATE `member` SET 
                                `email` = '{$_info['email']}',
                                `address` = '{$_info['address']}',
                                `phone` = '{$_info['phone']}',
                                `dob` = '{$_info['birthday']}'
                            WHERE
                                `user_id` = '{$_COOKIE['userID']}'";
    $result = _mysql_query($sql);
    location(null,'myaccount.php');
}  else {
    $sql = "SELECT * FROM `member` WHERE `user_id` = '{$_COOKIE['userID']}'";
    $result = _mysql_query($sql);
                     
    while (!!$data = mysql_fetch_array($result)){
        $html = array();
        $html['id'] = $data['user_id'];
        $html['email'] = $data['email'];
        $html['address'] = $data['address'];
        $html['phone'] = $data['phone'];
        $html['firstName'] = $data['firstname'];
        $html['lastName'] = $data['lastname'];
        $html['birthday'] = $data['dob'];
        $dob = array();
        $dob = explode('-',$html['birthday']);
        
    }
    close();
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
    <link href="css/account.css" rel="stylesheet">
  </head>

  <body style="text-align:center">
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
            <a class="nav-link" href="menu.php">Menu</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="order.php">Order</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <?php
           if(isset($_COOKIE['guest'])){
                if($_COOKIE['guest'] == '0'){
                    echo '<li class="nav-item active"><a class="nav-link" href="myaccount.php">&nbsp;&nbsp;My Account</a></li>';
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
    <div class="accountContainer" style="width: 800px;margin-left: auto;margin-right: auto;">
     <h2 style="width:400px;margin:30px auto;text-align:center;">Basic Info</h2>
    <form method="post" name="register" action="?action=update" onsubmit="return ">
		<dl>
			<dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;">E-mail:</dd>
            <dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;"><input class="accountInput" type="text" name="email" class="text" value="<?php echo $html['email']; ?>"/> <span style="color:red;">(* Necessary)</span></dd>
			<dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;">First Name:</dd>
			<dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;"><input value="<?php echo $html['firstName']; ?>" disabled="true" type="text" name="firstname" class="text" /><span style="color:red;">(* Necessary)</span></dd>
            <dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;">Last Name:</dd>
            <dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;"><input value="<?php echo $html['lastName']; ?>" disabled="true" type="text" name="lastname" class="text" /><span style="color:red;">(* Necessary)</span></dd>
            <dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;">Address:</dd>
            <dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;"><input value="<?php echo $html['address']; ?>" type="text" name="address" class="text" /><span style="color:red;">(* Necessary)</span></dd>
            <dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;">Phone:</dd>
            <dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;"><input type="text" value="<?php echo $html['phone']; ?>" name="phone" class="text" /><span style="color:red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></dd>
            <dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;">Birthday:</dd>
            <dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;">
            <select name="year" class="select">
                <option value="0">Year </option>               
                <?php
                    for($x=2010;$x>=1930;$x--){
                        if($x == $dob[0]){
                            echo '<option selected="selected" value="'.$x.'">'.$x.'</option>';
                        } else {
                            echo '<option value="'.$x.'">'.$x.'</option>';
                        }
                       
                    }                
                ?>
            </select>
            <select name="month" class="select">
                <option value="0">Month</option>               
                <?php                  
                    for($x=1;$x<=12;$x++){
                        if($x == $dob[1]){
                            echo '<option selected="selected" value="'.$x.'">'.$x.'</option>';
                        } else {
                            echo '<option value="'.$x.'">'.$x.'</option>';
                        }
                    }               
                ?>
            </select>
            <select name="day" class="select">
                <option value="0">day </option>                
                <?php                 
                    for($x=1;$x<=31;$x++){
                        if($x == $dob[2]){
                            echo '<option selected="selected" value="'.$x.'">'.$x.'</option>';
                        } else {
                            echo '<option value="'.$x.'">'.$x.'</option>';
                        }
                    }              
                ?>
            </select>
            <span style="color:red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></dd>
			<dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;"><input type="submit" class="submit" value="Update" /></dd>
		</dl>
	</form>
    <form method="post" name="register" action="?action=updatePW" onsubmit="return checkUpdate()">
        <h2 style="width:400px;margin:30px auto;text-align:center;">Change Password</h2>
        <dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;">Password:</dd>
        <dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;"><input id="passwordUpdate" class="accountInput"  type="password" name="password" class="text" /> <span style="color:red;"></span></dd>
        <dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;">Repassword:</dd>
		<dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;"><input type="password" id="passwordUpdate2"name="notpassword" class="text" /><span style="color:red;"></span></dd>
        <dd style="text-align: left;padding: 3px 0;margin:0 0 0 200px;"><input type="submit" class="submit" value="Change Pin" /></dd>
    </form>
    </div>
    <!-- footer navbar -->
    <footer class="navbar-fixed-bottom">
        <div class="row">
          <p style="padding: 10px 30px;color:#eceeef;">Restaurant database | UNCC | Computer Science @2016</p>
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
    <?php 
        require $ROOT.'\config\footer.inc.php';
    ?>
  </body>
</html>
