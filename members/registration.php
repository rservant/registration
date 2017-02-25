<?php
/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 05/10/2015                                      *
 * Created By : Gayathri D                                        *
 * Vision : Toast Masters                                         *  
 * Modified by : Gayathri D    Date : 05/10/2015    Version : 1.0 *
 * Description : members registration form                        *
 *****************************************************************/

/* Includes header file and class file*/
include('../regform/includes/header.inc1.php');
include('../regform/classes/user.class.php');
$objUser = new USER();
$userData = $objUser->getUserByEmail($_SESSION['Client_Email']);
//print_r($userData);exit;

$firstName = (isset($userData['Client_First_Name']) && ($userData['Client_First_Name'] != "")) ? $userData['Client_First_Name'] : "";
$middleName = (isset($userData['Client_Middle_Name']) && ($userData['Client_Middle_Name'] != "")) ? $userData['Client_Middle_Name'] : "";
$lastName = (isset($userData['Client_Last_Name']) && ($userData['Client_Last_Name'] != "")) ? $userData['Client_Last_Name'] : "";
$clientAddress = (isset($userData['Client_Address']) && ($userData['Client_Address'] != "")) ? $userData['Client_Address'] : "";
$clientCity = (isset($userData['Client_City']) && ($userData['Client_City'] != "")) ? $userData['Client_City'] : "";
$clientProvinceState = (isset($userData['Client_Province_State']) && ($userData['Client_Province_State'] != "")) ? $userData['Client_Province_State'] : "";
$clientPostalZipCode = (isset($userData['Client_Postal_Zip_Code']) && ($userData['Client_Postal_Zip_Code'] != "")) ? $userData['Client_Postal_Zip_Code'] : "";
$clientEmail = (isset($userData['Client_Email']) && ($userData['Client_Email'] != "")) ? $userData['Client_Email'] : "";
$clientHomePhone = (isset($userData['Client_Home_Phone']) && ($userData['Client_Home_Phone'] != "")) ? $userData['Client_Home_Phone'] : "";
$clientCellPhone = (isset($userData['Client_Cell_Phone']) && ($userData['Client_Cell_Phone'] != "")) ? $userData['Client_Cell_Phone'] : "";
$clientWorkPhone = (isset($userData['Client_Work_Phone']) && ($userData['Client_Work_Phone'] != "")) ? $userData['Client_Work_Phone'] : "";
$clientAccessibilityNeeds = (isset($userData['Client_Accessibility_Needs']) && ($userData['Client_Accessibility_Needs'] != "")) ? $userData['Client_Accessibility_Needs'] : "";
$clientAllergies = (isset($userData['Client_Allergies']) && ($userData['Client_Allergies'] != "")) ? $userData['Client_Allergies'] : "";
$clientClubNumber = (isset($userData['Client_Club_Number']) && ($userData['Client_Club_Number'] != "")) ? $userData['Client_Club_Number'] : "";
$Club_Division = (isset($userData['Club_Division']) && ($userData['Club_Division'] != "")) ? $userData['Club_Division'] : "";
$Club_Area = (isset($userData['Club_Area']) && ($userData['Club_Area'] != "")) ? $userData['Club_Area'] : "";
$Club_Name = (isset($userData['Club_Name']) && ($userData['Club_Name'] != "")) ? $userData['Club_Name'] : "";

include('layouts/reg_from.html');
?>
