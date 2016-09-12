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
if ($_GET['action'] == 'addimg') {
    $_info = array();
    $_info['name'] = $_POST['name'];
    $_info['price'] = $_POST['price'];
    $_info['img'] = $_POST['img'];
    $_info['description'] = $_POST['content'];
    $_info['category_id'] = $_POST['category'];
    $result = _mysql_query("INSERT INTO `food` (
                                              `food_name`,
                                              `price`,
                                              `image`,
                                              `description`,
                                              `category_id`
                                                            ) 
                                            VALUES (
                                              '{$_info['name']}',
                                              '{$_info['price']}',
                                              '{$_info['img']}',
                                              '{$_info['description']}',
                                              '{$_info['category_id']}'
                                                            )"
                                                            );
    if(_affected_rows() == 1){
            close();
            location('Create Successfully','dishes.php');
    } else {
            close();
            location('Create Fail','dishCreate.php');
    }	
} else {
    
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>top</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css">
<link rel="stylesheet" type="text/css" href="../css/photo_add_img.css">
<script type="text/javascript" src="../js/admin_top_nav.js"></script>
<script type="text/javascript" src="../js/photo_add_img.js"></script>
<script type='text/javascript'>

</script>
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
	Dishes Management &gt;&gt; Create Dish
</div>

<ol>
	<li><a href="dishes.php" class="null">Dishes List</a></li>
	<li><a href="dishCreate.php" class="null"><strong id="title">Create Dish</strong></a></li>
</ol>

<div id="photo">
	
	<form method="post" name="up" action="?action=addimg" onsubmit="return checkSubmit()">
	
	<dl>
		<dd>Dish Name:<input id="dishName" type="text" name="name" class="text" /></dd>
        <dd>Dish Price:<input type="text" id="price" name="price" class="text" /></dd>
		<dd>Picture:<input type="text" name="img" id="url" readonly="readonly" class="text" /> <a href="javascript:;" title="photo" id="up">Upload</a></dd>
		Discrption:
        <dd><textarea name="content" cols="30" rows="10"></textarea></dd>
        Category:
        <dd>
        
        <select name="category" class="select">
            <option value="-1" selected="selected">Default</option>  
<?php
    $sql = "select * from `menu`"; 
    $result = _mysql_query($sql);
    while (!!$data = mysql_fetch_array($result)){
       echo '<option   value="'.$data['category_id'].'">'.$data['category_name'].'</option>';
        
    } 
    close();       
?>           
        </select>
        </dd>
		<dd><input type="submit" class="submit" value="Submit" onsubmit="return checkSubmit();"/></dd>
	</dl>
	</form>
</div>

</div>
</div>

</body></html>