<?php
include ("../includes/header.inc1.php");
include("classes/getDetails.class.php");
$oRegDeatials = new DETAILS();

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

switch ($action) {
	
    default:
		/*
        $count = $oDeviceVsChannels->getDeviceHistoryListCount();
        if ($count > 0) {
			$aDeviceIdGroupByList = $oDeviceVsChannels->getDeviceIdGroupByListFromHistory();
            $countForPagenation = $oDeviceVsChannels->getDeviceHistoryListCountWithSearch();
            $aDeviceHistory = $oDeviceVsChannels->getDeviceHistoryList();        
		}*/
		//echo "<pre>";
		//print_r($aDeviceVsChannels);
       // if ($action = 'Add')
          //  $searchstring .= '&page=' . ceil($count / ROW_PER_PAGE);
		$aRegDeatials = $oRegDeatials->getRegDetails();
		$countForPagenation = $count = 2;
		//print_r($aRegDeatials);exit;
        include 'layouts/registrations_list.html';
}
?>
