<?php 
include('Configuration/Connection.php');

/*$uidno = $_SESSION['user_idno'];
$logot = date("Y-m-d H:i:s");
$inse = mysql_query("UPDATE user_login SET user_logout = '$logot' WHERE user_idno = '$uidno' AND user_logout = ''");*/
session_start();
session_unset();
unset($_SESSION['user_name']);
unset($_SESSION['user_role']);

session_destroy();
header('location:index.php');

?>
