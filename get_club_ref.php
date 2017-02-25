<?php
include('includes/header.inc.php');
include('classes/user.class.php');
$objUser = new USER();
$cRef = $objUser->getClubNumber($_POST['cName']);
echo $cRef;
?>
