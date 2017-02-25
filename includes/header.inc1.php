<?php
/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 13/08/2015                                      *
 * Created By : Gayathri D                                        *
 * Vision : DGSMS WEB SERVICES                                    *
 * Modified by : Gayathri D    Date : 13/08/2015    Version :     *
 * Description : Header file - file includes,session, cookie      *
 * language selection, page content can be processed here         *
 * *************************************************************** */

/* For Seesion initialize  */

session_start();
/* For display error report  */
error_reporting(E_ALL);

include("../includes/configuration.php");  //Default configurations

/* check logged session */
//echo "<pre>";
//var_dump($_SESSION);
//var_dump($_SESSION[LOG_SESSION]);
//echo "</pre>";
//exit;
@$logininfo = unserialize($_SESSION[LOG_SESSION]);


if ($logininfo["name"] == "") {
    if (basename($_SERVER['PHP_SELF']) != "login.php") {
        header("Location: ../login.php");
        exit;
    }
}

if($logininfo['user_role'] != "admin" && $logininfo['user_role'] != "officer"){  
  header('location:reg_form_for_users.php');
}

/* Includes config,db and table definitions and common functions files */

include("../includes/dbconfig.php");   //Creates db connection

include("../includes/function_common.php");  //Common functions , which can be used all over application often
include("../includes/tables.php");  //Table configurations

include("../classes/messages.class.php");  //pop up messages styles 
$objMessages = new Messages();


include("../classes/activitylog.class.php");
$oLog = new ActivityLog();

if(isset($_GET["btnlogout"])){
	$oLog->addLog("Login", "Logged out", "", "1");
	unset($_SESSION[LOG_SESSION]);	
	header("Location: ../login.php");
	exit;
}
?>
