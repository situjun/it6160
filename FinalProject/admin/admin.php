<?php 
session_start();
$ROOT = dirname(__FILE__);
require $ROOT.'\..\config\commen.inc.php';
require $ROOT.'\..\config\admin.inc.php';
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
        <li><a href="admin.php" target="sidebar" id="nav1" class="selected" onclick="admin_top_nav(1)">Orders</a></li>
        <li><a href="dishes.php" target="sidebar" id="nav2" onclick="admin_top_nav(2)">Dishes</a></li>
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
	Ordering Management &gt;&gt; Ordering List<strong id="title"></strong>
</div>

<ol>
<?php
    if(!isset($_GET['history'])){
        
	
        echo '<li><a href="?" class="null"><strong id="title">Ordering List</strong></a></li>';
        echo '<li><a href="?history" class="null">Delivered history</a></li>';
    } else {
        echo '<li><a href="?" class="null">Ordering List</a></li>';
        echo '<li><a href="?history" class="null"><strong id="title">Delivered history</strong></a></li>';
    }
?>
	
</ol>
	<table cellspacing="0">
	<tbody><tr><th>Order#</th><th>PersonID</th><th>Total Price</th><th>Address</th><th>Phone</th><th>Dishes Amount</th><th>Order Placed</th>
<?php
    if(!isset($_GET['history'])){
?>
    <th>Manage</th>
<?php
    }

?>
</tr><tr>
    
<?php
$flag = '';
if(isset($_GET['history'])){
        $result = _mysql_query("SELECT 
                            *
                        FROM 
                            `orders` 
                        WHERE 
                            `deliver_status` = 1
        ");           
        while (!!$data = mysql_fetch_array($result)){
            $html = array();
            $html['id'] = $data['orderNum'];
            $html['order_id'] = $data['order_id'];
            $html['personID'] = $data['user_id'];
            $html['price'] = $data['total_price'];
            $html['addr'] = $data['address'];	
            $html['phone'] = $data['phone'];	            
            $html['amount'] = $data['quantity'];
            $html['time'] = $data['time'];       
            echo '<tr>';
            echo '<td>'.$html['id'].'</td>';
            echo '<td>'.$html['personID'].'</td>';
            echo '<td>'.$html['price'].'</td>';
            echo '<td>'.$html['addr'].'</td>';
            echo '<td>'.$html['phone'].'</td>';
            echo '<td>'.$html['amount'].'</td>';
            echo '<td>'.$html['time'].'</td>';
            if(!isset($_GET['history'])) echo '<td><a href=?deliveryID='.$html['order_id'].' onclick="return confirm(&#39;Delivery the ordering&#39;) ? true : false">Delivery</a> | <a href=?deleteID='.$html['order_id'].' class="deleteOrder" onclick="return confirm(&#39;Delete the ordering&#39;) ? true : false" >Delete</a></td>';
            echo '</tr>';
        }
} else {
    if($_GET['deleteID']){    
       _mysql_query("DELETE FROM 
                                        `orders` 
                          WHERE 
                                        `order_id`  = {$_GET['deleteID']}"
        );
       location(null,'admin.php');
    } else if($_GET['deliveryID']){
        _mysql_query("UPDATE `orders` SET `deliver_status` = 1 WHERE `order_id` = {$_GET['deliveryID']}");
       location(null,'admin.php');
    } else {
        if ($_GET['nav'] == '1') {
            $result = _mysql_query("SELECT 
                                *
                            FROM 
                                `orders` 
                            WHERE 
                                `deliver_status` = 0
                            ORDER BY
                                `total_price`
                            DESC
                        ");
        } else {
            $result = _mysql_query("SELECT 
                                *
                            FROM 
                                `orders` 
                            WHERE 
                                `deliver_status` = 0
            ");
        }                       
        while (!!$data = mysql_fetch_array($result)){
            $html = array();
            $html['id'] = $data['orderNum'];
            $html['order_id'] = $data['order_id'];
            $html['personID'] = $data['user_id'];
            $html['price'] = $data['total_price'];
            $html['addr'] = $data['address'];	
            $html['phone'] = $data['phone'];	            
            $html['amount'] = $data['quantity'];
            $html['time'] = $data['time'];       
            echo '<tr>';
            echo '<td>'.$html['id'].'</td>';
            echo '<td>'.$html['personID'].'</td>';
            echo '<td>'.$html['price'].'</td>';
            echo '<td>'.$html['addr'].'</td>';
            echo '<td>'.$html['phone'].'</td>';
            echo '<td>'.$html['amount'].'</td>';
            echo '<td>'.$html['time'].'</td>';
            echo '<td><a href=?deliveryID='.$html['order_id'].' onclick="return confirm(&#39;Delivery the ordering&#39;) ? true : false">Delivery</a> | <a href=?deleteID='.$html['order_id'].' class="deleteOrder" onclick="return confirm(&#39;Delete the ordering&#39;) ? true : false" >Delete</a></td>';
            echo '</tr>';
        }
        
    }
}
close();
?>    		
	</tr>
</tbody></table>

<?php
    if(!isset($_GET['history'])){
?>
    <form action="" method="get">
        <div id="page">
            
                
                <select name="nav" class="select">
                    <option value="0">Default Order</option>
                    <option value="1">Price DESC</option>
                </select>
                <input value="SEARCH" type="submit" >
        </div>
    </form>
<?php
    }

?>
</div>
</div>

</body></html>