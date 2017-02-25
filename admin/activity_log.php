<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 07/07/2014                                      *
 * Created By : Gayathri D                                        *
 * Vision : TV Streaming Analytics                                *
 * Modified by : Gayathri D    Date : 07/07/2014    Version : V1  *
 * Description : Home page (Defaut page of sparkle)               *
 *****************************************************************/
 
/* Includes header file and class file*/ 
include ("../includes/header.inc1.php");

$searchstring = "";
$start_limit = 0;
$module = "ActivityLog";
$module_heading = "ActivityLog";
@$page = isset($_GET['page']) ? $_GET['page'] : $_POST['page']; 
if(!isset($page))
    $page = 1;    
if($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);
	
@$action = (isset($_GET['action'])) ? $_GET['action'] : $_POST['action'];
@$id = (isset($_GET['id'])) ? $_GET['id'] : $_POST['id']; 

if($logininfo['user_role'] == "admin"){
	@$user_id =  (isset($_GET['user_id']) && ($_GET['user_id'] != "")) ? $_GET['user_id'] : $_POST['user_id'];
	if(@$user_id != ""){
		$searchstring = "user_id=" . $user_id;
	}
} else{
	$user_id = $logininfo['id'];
}




$userNames = $oLog->getUserNamesArray();
//print_r($userNames);exit;
switch ($action) {	
	default:
	$count = $oLog->logCount(@$user_id);
	if($count > 0){
		$logList = $oLog->logList(@$user_id);
	}
	include("layouts/activity_log.html");
}
?>
