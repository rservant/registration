<?php 
include("../includes/header.inc1.php");
include("../Configuration/Connection.php");
//header('Content-type: text/csv');
require_once '../phpexcel/Classes/PHPExcel.php';
$tablename = "Identification"; 

//$query = "SELECT * FROM $tablename"; 

// Instantiate a new PHPExcel object
$objPHPExcel = new PHPExcel(); 
// Set the active Excel worksheet to sheet 0
$objPHPExcel->setActiveSheetIndex(0); 
// Initialise the Excel row number
$rowCount = 2; 

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Registration ID')
            ->setCellValue('B1', 'Club Name')
            ->setCellValue('C1', 'Club Division')
            ->setCellValue('D1', 'Conference Title')
->setCellValue('E1', 'Name')
->setCellValue('F1', 'Email')
->setCellValue('G1', 'Home Phone')
->setCellValue('H1', 'Work Phone')
->setCellValue('I1', 'Cell Phone')
->setCellValue('J1', 'Lead Designation')
->setCellValue('K1', 'Product Price')
->setCellValue('L1', 'Saturday Lunch')
->setCellValue('M1', 'Saturday Banquet')
->setCellValue('N1', 'Food_Allergies')
->setCellValue('O1', 'Start Date')
->setCellValue('P1', 'End Date')
->setCellValue('Q1', 'Payment Status');
/*->setCellValue('R1', 'Registration Type')
->setCellValue('S1', 'Registration code')
->setCellValue('T1', 'Transaction Date')
->setCellValue('U1', 'First Time')
->setCellValue('V1', 'Volunteer')
->setCellValue('W1', 'Comm Level')
->setCellValue('X1', 'Language Prefer');*/

$squery = mysql_query("SELECT Registrations.Registration_Number, Club_Name, Club_Division, Client_Home_Phone, Client_Work_Phone, Client_Cell_Phone, Conference_Title_EN, Client_First_Name, RegistrationVolunteer, Product_Title_EN, Client_Email, Product_Price, m1.Meal_Item AS m1_item, m2.Meal_Item AS m2_item, Conference_Start_Date, Conference_End_Date, Registration_Paye_Method, Registration_Confirmation_Number, Client_Leadership_Type_Code, Client_Communication_Type_Code, Client_Language_Type_Code, Registration_First_Time_Indicator, Registration_Transaction_Date_Time, payment_status, Client_Allergies FROM Registrations 
JOIN Identification ON Identification.Client_Number = Registrations.Registration_Client_Identifier
LEFT JOIN Clubs ON Clubs.Club_Number = Identification.Client_Number
LEFT JOIN Meals as m1 ON m1.Meal_ID = Registrations.Registration_Meal_Lunch_Identifier
JOIN Meals as m2 ON m2.Meal_ID = Registrations.Registration_Meal_Banquet_Identifier
JOIN Products ON Products.Product_Identification = Registrations.Registration_Product_Identifier
JOIN Conference ON Conference.Conference_Identifier = Products.Product_Conference_Number 
WHERE Registration_Confirmation_Number != '' AND Conference.conference_category='spring'");

while($sele = mysql_fetch_array($squery)){
//echo $sele['Registration_Number'];

/*print_r($sele);
exit;*/
$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $sele['Registration_Number']); 


    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $sele['Club_Name']); 
  
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $sele['Club_Division']); 


$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $sele['Conference_Title_EN']); 
$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $sele['Client_First_Name']); 
$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $sele['Client_Email']);
$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $sele['Client_Home_Phone']); 
$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $sele['Client_Work_Phone']); 
$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $sele['Client_Cell_Phone']); 
$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $sele['Client_Leadership_Type_Code']); 
$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $sele['Product_Price']); 
$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $sele['m1_item']); 
$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $sele['m2_item']);
$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $sele['Client_Allergies']);
$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $sele['Conference_Start_Date']); 
$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $sele['Conference_End_Date']);
$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $sele['payment_status']); 
/*$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $sele['Product_Title_EN']); 
$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $sele['Registration_Confirmation_Number']); 
$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $sele['Registration_Transaction_Date_Time']); 
$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $sele['Registration_First_Time_Indicator']);
$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $sele['RegistrationVolunteer']);
$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $sele['Client_Communication_Type_Code']);
$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $sele['Client_Language_Type_Code']);*/
$rowCount++;
}



$dat = date('dis');
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"spring_members_details.xlsx\"");
header("Cache-Control: max-age=0");
 require_once '../phpexcel/Classes/PHPExcel/IOFactory.php';
                   
                    $objActSheet = $objPHPExcel->getActiveSheet();
                    $objActSheet->setTitle('Users AttendanceRecord');


                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                    
$objWriter->save("php://output");
//$objWriter->save('exportexcel/'.$dat.'users.xlsx'); 
ob_clean();
?>
