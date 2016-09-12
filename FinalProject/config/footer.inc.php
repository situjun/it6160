<?php 
 if(isset($_COOKIE['firstName'])){
            echo " <script type='text/javascript'>document.getElementById('signinButton').style.display = 'none';</script> ";
            echo " <script type='text/javascript'>document.getElementById('logoutButton').style.display = '';</script> ";
        } else {
            echo " <script type='text/javascript'>document.getElementById('logoutButton').style.display = 'none';</script> ";
            echo " <script type='text/javascript'>document.getElementById('signinButton').style.display = '';</script> ";
        }

?>