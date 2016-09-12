<?php 
session_start();
$ROOT = dirname(__FILE__);
require $ROOT.'\..\config\commen.inc.php';
require $ROOT.'\..\config\admin.inc.php';
if(isset($_SESSION['admin'])){
    if($_SESSION['admin'] != '1'){
        location('You have no authority to access this module!!!','admin.php');
    }
} else {
    location('You have no authority to access this module!!!','admin.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0083)file:///D:/xampp/htdocs/CMS/templates_c/a76bcc64829a51022b07aba06874e94ftop.tpl.php -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>top</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css">
<script type="text/javascript" src="../js/admin_top_nav.js"></script>
</head>
<body id="top">
<div id="container0">
    <h1>LOGO</h1>
    <ul>
        <li><a href="admin.php" target="sidebar" id="nav1"  onclick="admin_top_nav(1)">Orders</a></li>
        <li><a href="dishes.php" target="sidebar" id="nav2"  onclick="admin_top_nav(2)">Dishes</a></li>
        <li><a href="members.php" id="nav3" target="sidebar" class="selected" onclick="admin_top_nav(3)">Members</a></li>
        <li><a href="announcement.php" id="nav4" target="sidebar" onclick="admin_top_nav(4)">Announcement</a></li>
        <li><a href="comments.php" id="nav5" target="sidebar" onclick="admin_top_nav(5)">Comments</a></li>
        <li><a href="info.php" id="nav6" target="sidebar" onclick="admin_top_nav(6)">Info</a></li>
    </ul>
    <p>
        Hello,<strong><?php echo $_SESSION['admin'] == '1'?'admin':'staff'; ?></strong>  [ <a href="../index.php" >Home</a> ] [ <a href="admin.php?action=logout" target="_parent">Log out</a> ]
    </p>
</div>
<div id="container1" >
<div id="main">
<div class="map">
	Members Management &gt;&gt; Members List
</div>
<ol>
	<li><a href="" class="null"><strong id="title">Members List</strong></a></li>
</ol>
	<table cellspacing="0">
	<tbody><tr><th>Member#</th><th>Email</th><th>FirtName</th><th>LastName</th><th>Address</th><th>Phone</th><th>DoB</th><<th>Manage</th></tr>
	<!--?php if ($this---><!--?php foreach ($this---><tr>
    
<?php
$flag = '';
if($_GET['deleteID']){
   _mysql_query("DELETE FROM 
                                    `member` 
                      WHERE 
                                    `user_id`  = {$_GET['deleteID']}"
    );
    location(null,'members.php');
        
} else if($_GET['resetID']){
    
    $sql = "UPDATE `member` SET `password` =  '".sha1('abc123')."' WHERE `user_id`  = {$_GET['resetID']}";
    
   _mysql_query($sql);
    location('Reset Success','members.php');
 
}
$result = _mysql_query("SELECT * FROM `member` ORDER BY `user_id` ASC");                 
    while (!!$data = mysql_fetch_array($result)){
		$html = array();
		$html['id'] = $data['user_id'];
        $html['email'] = $data['email'];
		$html['firstName'] = $data['firstname'];
		$html['lastName'] = $data['lastname'];
		$html['address'] = $data['address'];
        $html['zipcode'] = $data['zipcode'];
		$html['phone'] = $data['phone'] == 0?'':$data['phone'];
        $html['dob'] = $data['dob'];
        
        echo '<tr>';
        echo '<td>'.$html['id'].'</td>';
        echo '<td>'.$html['email'].'</td>';
        echo '<td>'.$html['firstName'].'</td>';
        echo '<td>'.$html['lastName'].'</td>';
        echo '<td>'.$html['address'].'</td>';
        echo '<td>'.$html['phone'].'</td>';
        echo '<td>'.$html['dob'].'</td>';
        echo '<td><a href=?resetID='.$html['id'].'>Reset Pin</a> | <a href=?deleteID='.$html['id'].' class="deleteMember" onclick="return confirm(&#39;Delete the ordering&#39;) ? true : false" >Delete</a></td>';
        echo '</tr>';
	}
    close(); 
?>     	
	</tr>
</tbody></table>
</div>
</div>

</body></html>