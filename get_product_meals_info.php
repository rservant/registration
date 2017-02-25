<?php
include('includes/header.inc.php');
include('classes/user.class.php');
$objUser = new USER();
$prodData = $objUser->getProductDataById($_POST['pId']);
echo $prodData['product_meals_display'] . ":::" . $prodData['product_meals_categories'];
?>
