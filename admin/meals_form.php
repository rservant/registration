<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 05/10/2015                                      *
 * Created By : Gayathri D                                        *
 * Vision : Toast Masters                                    *  
 * Modified by : Gayathri D    Date : 05/10/2015    Version : 1.0 *
 * Description : Home page(Default page of Toast masters registration)     *
 *****************************************************************/

/* Includes header file and class file*/
include('../includes/header.inc1.php');
include('classes/conf.class.php');
$module = "Meals";
$objConf = new CONF();
@$action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];
switch ($action) {
	case "addMeal":		
		$result = $objConf->addMeal($_POST);
		if($result == 1){
			$sMsg = "Meal Item Added Successfully.";
			$msg = $objMessages->msgLayout($sMsg,$result);
		//}else if($result == 3){
		}else{
			$sMsg = "Meal Item Not Added Successfully,Please Try Again.";
			$msg = $objMessages->msgLayout($sMsg,$result);
		}/*else{
			$sMsg = "Duplicate Meal Item found, Please Try Again.";
			$msg = $objMessages->error($sMsg);
		}*/
		$inputData = serialize($_POST);
		$oLog->addLog($module, "Add", $inputData, $result);
	default:
	    $confData = $objConf->getConfs();
        include("layouts/meal_form.html");
        break;
}
?>
