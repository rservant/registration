<?php 
include("Configuration/Connection.php");
//header('Content-type: text/csv');
require_once 'phpexcel/Classes/PHPExcel.php';
$tablename = "Identification"; 

//$query = "SELECT * FROM $tablename"; 

$query ="SELECT SQL_CALC_FOUND_ROWS Registrations.Registration_Number, Club_Name, Club_Division, Conference_Title_EN
, Client_First_Name, Client_Email, Product_Price, m1.Meal_Item AS m1_item, m2.Meal_Item AS m2_item, Conference_Start_Date
, Conference_End_Date
     FROM   Registrations
      JOIN Identification ON Identification.Client_Number = Registrations.Registration_Client_Identifier
 LEFT JOIN Clubs ON Clubs.Club_Number = Identification.Client_Club_Number JOIN Meals as m1
    ON m1.Meal_ID = Registrations.Registration_Meal_Lunch_Identifier JOIN Meals as m2
    ON m2.Meal_ID = Registrations.Registration_Meal_Banquet_Identifier JOIN Products ON Products.Product_Identification
 = Registrations.Registration_Product_Identifier JOIN Conference ON Conference.Conference_Identifier
 = Products.Product_Conference_Number
     WHERE payment_status = 'complete'
     ORDER BY  Registrations.Registration_Number"; 

// Execute the database query
$result = mysql_query($query);

// Instantiate a new PHPExcel object
$objPHPExcel = new PHPExcel(); 
// Set the active Excel worksheet to sheet 0
$objPHPExcel->setActiveSheetIndex(0); 
// Initialise the Excel row number
$rowCount = 2; 

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Id')
            ->setCellValue('B1', 'Club Name')
            ->setCellValue('C1', 'Club Division')
            ->setCellValue('D1', 'Conference Title')
->setCellValue('E1', 'Name')
->setCellValue('F1', 'Email')
->setCellValue('G1', 'Product Price')
->setCellValue('H1', 'Saturday Lunch')
->setCellValue('I1', 'Saturday Banquet')
->setCellValue('J1', 'Start Date')
->setCellValue('K1', 'End Date');
while($row = mysql_fetch_array($result)){ 
  
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['Registration_Number']); 

    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['Club_Name']); 
  
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['Club_Division']); 
$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['Conference_Title_EN']); 
$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['Client_First_Name']); 
$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row['Client_Email']); 
$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row['Product_Price']); 
$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row['m1_item']); 
$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row['m2_item']); 
$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row['Conference_Start_Date']); 
$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row['Conference_End_Date']); 
    $rowCount++; 
} 

$dat = date('dis');
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"results.xlsx\"");
header("Cache-Control: max-age=0");
 require_once 'phpexcel/Classes/PHPExcel/IOFactory.php';
                   
                    $objActSheet = $objPHPExcel->getActiveSheet();
                    $objActSheet->setTitle('Users AttendanceRecord');


                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                    
$objWriter->save("php://output");
//$objWriter->save('exportexcel/'.$dat.'users.xlsx'); 
ob_clean();

?>
