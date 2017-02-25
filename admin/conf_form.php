<?php 
include('../includes/header.inc1.php');
include('classes/conf.class.php');
$module = "Conference";
@$action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];
switch ($action) {
	case "addConf":
		$objConf = new CONF();
		$result = $objConf->addConf($_POST);
		if($result == 1){
			$sMsg = "Conference Added Successfully.";
			$msg = $objMessages->msgLayout($sMsg,$result);
		}else if($result == 2){
			$sMsg = "Duplicate Conference found, Please Try Again.";
			$msg = $objMessages->error($sMsg);
		}else{			
			$sMsg = "Conference Not Added Successfully,Please Try Again.";
			$msg = $objMessages->msgLayout($sMsg,$result);
		}		
		$inputData = serialize($_POST);
		$oLog->addLog($module, "Add", $inputData, $result);
	default:
        include("layouts/conf_form.html");
        break;
}
?>
