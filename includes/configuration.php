<?php

/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 05/10/2015                                      *
 * Created By : Gayathri D                                        *
 * Vision : Project Toast Masters                                 *  
 * Modified by : Gayathri D     Date : 05/10/2015    Version : 1  *
 * Description : Application config file                          *
 *****************************************************************/
/* TODO: rewrite this configuration file to read local configuration from file/environment */
    
    /*
define('DB_NAME', 'mastersto');
define('DB_HOST', 'localhost');
define('DB_USER_NAME', 'root');
define('DB_PASSWORD', '');
*/


/* Define Meta informations  */
define("SITE_BASE_URL", "");
define("VERSION", "Version 1.0");
define("APPNAME", "Toast Masters");
define("ROW_PER_PAGE", "10");
define("RESET_PWD_LINK", "");
define("FROM_EMAIL", "admin@ifoo.bar");
define("TO_MAIL", "admin@foo.bar");

define("SUB_OFFICER_ADD", APPNAME);
define("MESSAGE_OFFICER_ADD","Hi {NAME},<br><br>You have been added as officer in " . APPNAME . " <br>Your login details are as follows:<br /> Username : {USERNAME} <br>Password : {NEW_PSWD} <br><br>Thanks,<br>Toastmaster Admin");

define("SUB_USER_ADD", APPNAME."  Toastmasters District 61 Conference");
define("MESSAGE_USER_ADD","Hi {NAME},<br><br>Thank you for registering for the Fall 2015 Conference! " . APPNAME . " <br>Your registration details are as follows:<br /> Username : {USERNAME} <br>Password : {NEW_PSWD} <br><br>Thanks,<br>Conference Team");

define('EMAIL_ADD', 'email@email'); // define any notification email
define('PAYPAL_EMAIL_ADD', 'email@email'); // facilitator email which will receive payments change this email to a live paypal account id when the site goes live
define('USE_PAYPAL_SAND_BOX', '0'); // 1 for sandbox, 0 for live

$aMealCategory = array("mealCat1"=>"Lunch", "mealCat2"=>"Banquet");
$aMealCategoryKeys = array_keys($aMealCategory);
$presentConferenceId = 1;


define('SPRING_EMAIL_ADD', 'email@email');
define('SPRING_PAYPAL_EMAIL_ADD', 'email@email');

define("LOG_SESSION", "toastmasters_logininfo");

$aActionForActivityLog = array("changeStatus" => "Change Status",
    "Add" => "Add", "Update" => "Update", "delete" => "Delete", "resetPwd" => "Reset Password", "view" => "View",
    "customer_info_Add" => "Customer Add", "customer_contractInfo_and_users_Add" => "Add Customer Contract Info",
    "customer_contractInfo_and_users_Update" => "Update Customer Contract Info",
    "customer_info_Update" => "Update Customer Info", "login" => "Logged In", "logout" => "Logged Out",
    "resetPasseword" => "Reset Password", "archive" => "Archived", "channel_statistics" => "Viewing Channel Statistics",
    "add" => "Add", 'vod_asset' => 'Fetching VOD Asset List','consolidated_statistics' => 'Fetching Consolidated Statistics','setPassword'=>'Reset Password','password_not_match' => 'Both fields  must be matched','preg_match'=>'Password should be have at least(1 small later,1Cap later and 1 Number)',"token"=>"Token Missmatch","pass_match"=>"Both Fields Should be match",
    "password_length" => "Password Should be at least 8 characters","special_chars"=>"Special Characters not allowed",'content_error'=>'File content invalid');
?>
