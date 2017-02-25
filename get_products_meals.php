<?php
include('includes/header.inc.php');
include('classes/user.class.php');
$objUser = new USER();
$sProducts = $objUser->getProductsOptionString($_POST['confId']);
$sMealsCat1 = $objUser->getMealsOptionString($_POST['confId'], $aMealCategoryKeys[0]);
$sMealsCat2 = $objUser->getMealsOptionString($_POST['confId'], $aMealCategoryKeys[1]);
echo $sProducts .":::". $sMealsCat1 .":::". $sMealsCat2;
?>
