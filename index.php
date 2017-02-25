<?php
include('includes/header.inc.php');

if($logininfo['user_role'] == "admin" || $logininfo['user_role'] == "officer"){  
  header("Location: admin/index.php");
} else if($logininfo['user_role'] == "user"){
  header('location:reg_form_for_users.php');
} /*else{
	header('location:reg_form.php');
}*/
exit;
?>


