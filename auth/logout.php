<?php
session_start();
 
$_SESSION = array();
 
session_destroy();
 
echo '<script>window.location.replace("/spendwise/auth/login.php");</script>';
exit;
?>