<?php 
include("../includes/header.inc1.php");
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
include('classes/club.class.php');
$objClub = new CLUB();
@$action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];
switch ($action) {
	case "addClub":		
		$result = $objClub->addClub($_POST);
		if($result == 1){
			$sMsg = "Club Added Successfully.";
			$msg = $objMessages->msgLayout($sMsg,$result);
		//}else if($result == 3){
		}else{
			$sMsg = "Club Item Not Added Successfully,Please Try Again.";
			$msg = $objMessages->msgLayout($sMsg,$result);
		}/*else{
			$sMsg = "Duplicate Meal Item found, Please Try Again.";
			$msg = $objMessages->error($sMsg);
		}*/
		//echo $msg;
		//break;
	default:	
    
        include("layouts/clubs_form.html");
        break;
}
?>
