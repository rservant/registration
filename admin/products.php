<?php
include ("../includes/header.inc1.php");
include("classes/getDetails.class.php");
$oDeatials = new DETAILS();
include('classes/conf.class.php');
$objConf = new CONF();
$confData = $objConf->getConfs();

$start_limit = 0;
$searchstring = "";
@$page = isset($_GET['page']) ? $_GET['page'] : $_POST['page'];
if (!isset($page))
    $page = 1;
if ($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);

@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];

@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id'];

@$s = (isset($_GET['s'])) ? $_GET['s'] : $_POST['s'];
if(@$s != ""){
	$searchstring = "s=" . $s;
}

@$confId = (isset($_POST['conf_id'])) ? $_POST['conf_id'] : "";

$aProductDeatials = array();


switch ($action) {
	case "edit":
	$aProdDetails = $oDeatials->getProductDetailsById($id);
	include 'layouts/prod_edit_form.html';
	break;
	case "editProd":
	$result = $oDeatials->editProduct($_POST);
	if($result == 1){
		$sMsg = "Product Edited Successfully.";
		$msg = $objMessages->msgLayout($sMsg,$result);
	} else{
		$sMsg = "Product Not Edited Successfully, Please Try Again.";
		$msg = $objMessages->msgLayout($sMsg,$result);
	}
	
    default:
		if($confId != ""){
			$aProductDeatials = $oDeatials->getProductDetails($confId);
		}
		$countForPagenation = $count = count($aProductDeatials);
        include 'layouts/products_list.html';
}
?>
