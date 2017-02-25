<?php 
include('../includes/header.inc1.php');

/*session_start(); 

if(!isset($_SESSION['Client_First_Name']) || $_SESSION['Client_Role'] != 'admin'){
	header("location: ../index.php");
	echo "eret";
} else { 
*/

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
//include('../includes/header.inc1.php');
include("../classes/activitylog.class.php");
$oLog = new ActivityLog();
include('classes/officer.class.php');
$module = "Officer";
@$action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];
switch ($action) {
	case "addOff":
		$objOff = new OFFICER();
		$result = $objOff->addOff($_POST);
		if($result == 1){
			$sMsg = "Officer Added Successfully.";
			$msg = $objMessages->msgLayout($sMsg,$result);
		}else if($result == 2){
			$sMsg = "Duplicate Email found, Please Try Again.";
			$msg = $objMessages->error($sMsg);
		}else{			
			$sMsg = "Officer Not Added Successfully,Please Try Again.";
			$msg = $objMessages->msgLayout($sMsg,$result);
		}
		$inputData = serialize($_POST);
		//$oLog->addLog($module,$aActionForActivityLog[$action],$inputData,$result);
		$oLog->addLog($module,$action,$inputData,$result);
		//echo $msg;
		//break;
	default:
        include("layouts/officer.html");
        break;
}
?>


<?php //} ?>
