<?php 
include('../includes/header.inc1.php');
include('classes/conf.class.php');
$module = "Product";
$objConf = new CONF();
@$action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];
switch ($action) {
	case "addProd":		
		$result = $objConf->addProd($_POST);
		if($result == 1){
			$sMsg = "Product Added Successfully.";
			$msg = $objMessages->msgLayout($sMsg,$result);
		//}else if($result == 3){
		  }else{
			$sMsg = "Product Not Added Successfully,Please Try Again.";
			$msg = $objMessages->msgLayout($sMsg,$result);
		}/*else{
			$sMsg = "Duplicate Conference found, Please Try Again.";
			$msg = $objMessages->error($sMsg);
		}*/
		$inputData = serialize($_POST);
		$oLog->addLog($module, "Add", $inputData, $result);
	default:
	    $confData = $objConf->getConfs();
        include("layouts/prod_form.html");
        break;
}
?>

