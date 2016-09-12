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
        <li><a href="dishes.php" target="sidebar" id="nav2" class="selected" onclick="admin_top_nav(2)">Dishes</a></li>
        <li><a href="members.php" id="nav3" target="sidebar" onclick="admin_top_nav(3)">Members</a></li>
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
	Dishes Management &gt;&gt; Dishes List
</div>

<ol>
	<li><a href="" class="null"><strong id="title">Dishes List</strong></a></li>
	<li><a href="dishCreate.php" class="null">Create Dish</a></li>
</ol>
	<table cellspacing="0">
	<tbody><tr><th>DishID</th><th>Pic</th><th>Name</th><th>Price</th><th>Category</th><th>Manage</th></tr>
	
<?php
$flag = '';
if($_GET['deleteID']){
   _mysql_query("DELETE FROM 
                                    `food` 
                      WHERE 
                                    `food_id`  = {$_GET['deleteID']}"
    );
    location(null,'dishes.php');
    close();      
} else {
    
    if ($_GET['nav'] == '1') {
        $result = _mysql_query("SELECT 
							*
						FROM 
							`food` 
                        ORDER BY
                            `price`
                        DESC
					");
    } else if ($_GET['nav'] == '2') {
        $result = _mysql_query("SELECT 
							*
						FROM 
							`food` 
                        ORDER BY
                            `price`
                        ASC
					");
    } else {
        $result = _mysql_query("SELECT 
							*
						FROM 
							`food` 
		");
}
    $cateArr = array();
    $sssql = "select * from `menu`"; 
    $cateresult = _mysql_query($sssql);
    while (!!$data = mysql_fetch_array($cateresult)){
        
        $cateArr[$data['category_id']] = $data['category_name'];
        
    } 
   $sqli = "CREATE VIEW 
                        foodN(food_name,category_name) 
                   AS SELECT 
                        food_name,category_name 
                   FROM 
                        food,menu 
                   WHERE 
                        food.category_id=menu.category_id;";             
       
       
    while (!!$data = mysql_fetch_array($result)){
		$html = array();
		$html['id'] = $data['food_id'];
        $html['price'] = $data['price'];
		$html['name'] = $data['food_name'];
		$html['img'] = $data['image'];
        echo '<tr>';
        echo '<td>'.$html['id'].'</td>';
        echo '<td><img class="photo" src='.$html['img'].'></td>';
        echo '<td>'.$html['name'].'</td>';
        echo '<td>$'.$html['price'].'</td>';
        if($cateArr[$data['category_id']] == ""){
            echo '<td>Default</td>';
        } else {
            echo '<td>'.$cateArr[$data['category_id']].'</td>';
        }
        
        echo '<td><a href=dishUpdate.php?updateID='.$html['id'].'>Update</a> | <a href=?deleteID='.$html['id'].' class="deleteOrder" onclick="return confirm(&#39;Delete the ordering&#39;) ? true : false" >Delete</a></td>';
        echo '</tr>';
	}
    close(); 
}
?>     	
	</tr>
</tbody></table>

<form action="" method="get">
<div id="page">
	
		
		<select name="nav" class="select">
			<option value="0">Default </option>
			<option value="1">Price DESC</option>
            <option value="2">Price ASC</option>
		</select>
		<input value="SEARCH" type="submit" >
</div>
</form>


</div>
</div>

</body></html>