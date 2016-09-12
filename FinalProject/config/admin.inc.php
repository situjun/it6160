<?php 
if(isset($_SESSION['admin'])){
    
} else {
    location('Forbidden Operation!!!','index.php');
}
if($_GET['action'] == 'logout'){
    session_destroy();
    location(null,'index.php');
}
?>