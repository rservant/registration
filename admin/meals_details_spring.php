<?php 
include("../includes/header.inc1.php");
include("../Configuration/Connection.php");
//header('Content-type: text/csv');
require_once '../phpexcel/Classes/PHPExcel.php';
$tablename = "Identification"; 

//$query = "SELECT * FROM $tablename"; 

$tsquery ="SELECT SQL_CALC_FOUND_ROWS Registrations.Registration_Number, Registration_Confirmation_Number, payment_status, invoice,  Club_Name, Club_Division, Conference_Title_EN, Product_Description, Registration_Paye_Method
, Client_First_Name, Client_Email, Product_Price, m1.Meal_Item AS m1_item, m2.Meal_Item AS m2_item, Conference_Start_Date
, Conference_End_Date
     FROM   Registrations
      JOIN Identification ON Identification.Client_Number = Registrations.Registration_Client_Identifier
 LEFT JOIN Clubs ON Clubs.Club_Number = Identification.Client_Club_Number JOIN Meals as m1
    ON m1.Meal_ID = Registrations.Registration_Meal_Lunch_Identifier JOIN Meals as m2
    ON m2.Meal_ID = Registrations.Registration_Meal_Banquet_Identifier JOIN Products ON Products.Product_Identification
 = Registrations.Registration_Product_Identifier JOIN Conference ON Conference.Conference_Identifier
 = Products.Product_Conference_Number WHERE Conference.conference_category='spring'
     ORDER BY  Registrations.Registration_Number DESC "; 
// WHERE payment_status = 'complete'
// Execute the database query
//GROUP BY (m1_item, m2_item, Product_Description, Registration_Paye_Method) 

/*$tsquery = mysql_query("SELECT Registrations.Registration_Number, Club_Name, Club_Division, Client_Home_Phone, Client_Work_Phone, Client_Cell_Phone, Conference_Title_EN, Client_First_Name, RegistrationVolunteer, Client_Email, Product_Price, m1.Meal_Item AS m1_item, m2.Meal_Item AS m2_item, Conference_Start_Date, Conference_End_Date, Registration_Paye_Method, Registration_Confirmation_Number, payment_status, Client_Allergies FROM Registrations 
JOIN Identification ON Identification.Client_Number = Registrations.Registration_Client_Identifier
LEFT JOIN Clubs ON Clubs.Club_Number = Identification.Client_Club_Number
LEFT JOIN Meals as m1 ON m1.Meal_ID = Registrations.Registration_Meal_Lunch_Identifier
JOIN Meals as m2 ON m2.Meal_ID = Registrations.Registration_Meal_Banquet_Identifier
JOIN Products ON Products.Product_Identification = Registrations.Registration_Product_Identifier
JOIN Conference ON Conference.Conference_Identifier = Products.Product_Conference_Number 
WHERE Registration_Confirmation_Number != '' AND Conference.conference_category='spring'");*/


$result = mysql_query($tsquery);




// Instantiate a new PHPExcel object
$objPHPExcel = new PHPExcel(); 
// Set the active Excel worksheet to sheet 0
$objPHPExcel->setActiveSheetIndex(0); 
// Initialise the Excel row number
$rowCount = 2; 
$rowCountmo = 2;
$rowCountmeal = 2; 
$rowCountproduct = 2;
$rowCountpayment = 2;

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Saturday Lunch')
            ->setCellValue('B1', 'Count')
            ->setCellValue('C1', 'Saturday Banquet')
            ->setCellValue('D1', 'Count')
->setCellValue('E1', 'Registration type')
->setCellValue('F1', 'Count')
->setCellValue('G1', 'Payment Type')
->setCellValue('H1', 'Count');
$objPHPExcel->getActiveSheet()
    ->getStyle('A1:Z1')
    ->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'cccccc')
            )
        )
    );
$objPHPExcel->getActiveSheet()
    ->getStyle('A2:Z110')
    ->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFFBB')
            )
        )
    );

$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
/*
->setCellValue('I1', '')
->setCellValue('J1', 'Start Date')
->setCellValue('K1', 'End Date')
->setCellValue('L1', 'Tranction ID')
->setCellValue('M1', 'Payment Status')*/
while($row = mysql_fetch_array($result)){ 
  
 /*  $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['m1_item']); 
$satl =  $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['m1_item']); 

    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, count($satl));  */
  

 
/*$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['Product_Description']); 
$pdty = $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['Product_Description']); 
$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, count($pdty));

$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row['Registration_Paye_Method']); 
$ptyp = $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row['Registration_Paye_Method']); 
$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, count($ptyp)); */ 
/*$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row['m2_item']); 
$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row['Conference_Start_Date']); 
$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row['Conference_End_Date']); 
$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row['Registration_Confirmation_Number']); 
$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row['payment_status']); 
    $rowCount++; */
} 

$querymo ="SELECT count( Registration_Meal_Lunch_Identifier ) AS lunch_count, m.Meal_Item
FROM Registrations AS r
JOIN Meals AS m ON m.Meal_Id = r.Registration_Meal_Lunch_Identifier
GROUP BY Registration_Meal_Lunch_Identifier";

$resultmo = mysql_query($querymo);

while($rowmo = mysql_fetch_array($resultmo)){ 

//print_r($rowmo);exit;


 $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCountmo, $rowmo['Meal_Item']); 
//$satl =  $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCountmo, $rowmo['Meal_Item']); 

    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCountmo, $rowmo['lunch_count']);
$rowCountmo++; 
}

/*$querymeal ="SELECT count( Registration_Meal_Banquet_Identifier ) AS banquet_count, m.Meal_Item
FROM Registrations AS r
JOIN Meals AS m ON m.Meal_Id = r.Registration_Meal_Banquet_Identifier
WHERE Registration_Product_Identifier = ''
GROUP BY Registration_Meal_Banquet_Identifier";*/


$querymeal =("SELECT count( Registration_Meal_Banquet_Identifier ) AS banquet_count, m.Meal_Item, r.*, p.*, c.Conference_Title_EN FROM Registrations as r join Products as p on  r.`Registration_Product_Identifier` = p.Product_Identification 

join Conference as c on  p.`Product_Conference_Number` = c.Conference_Identifier
JOIN Meals AS m ON m.Meal_Id = r.Registration_Meal_Banquet_Identifier
WHERE Registration_Confirmation_Number != '' AND c.Conference_Title_EN = 'District 61 2016 Spring Conference'
GROUP BY Registration_Meal_Banquet_Identifier");


$resultmeal = mysql_query($querymeal);

while($rowmeal = mysql_fetch_array($resultmeal)){ 

//print_r($rowmo);


$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCountmeal, $rowmeal['Meal_Item']); 
//$bsta = $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCountmeal, $rowmeal['Meal_Item']); 

$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCountmeal, $rowmeal['banquet_count']);
$rowCountmeal++; 
}



/*$queryproduct ="SELECT count( Registration_Product_Identifier ) AS product_count, p.Product_Title_EN
FROM Registrations AS r
JOIN Products AS p ON p.Product_Identification = r.Registration_Product_Identifier
GROUP BY Registration_Product_Identifier";*/

$queryproduct =("SELECT count( Registration_Product_Identifier ) AS product_count, p.Product_Title_EN, r.*, p.*, c.Conference_Title_EN FROM Registrations as r join Products as p on  r.`Registration_Product_Identifier` = p.Product_Identification 

join Conference as c on  p.`Product_Conference_Number` = c.Conference_Identifier
JOIN Meals AS m ON m.Meal_Id = r.Registration_Meal_Banquet_Identifier
WHERE Registration_Confirmation_Number != '' AND c.Conference_Title_EN = 'District 61 2016 Spring Conference'
GROUP BY Registration_Product_Identifier");



$resultproduct = mysql_query($queryproduct);

while($rowproduct = mysql_fetch_array($resultproduct)){ 

//print_r($rowmo);


$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCountproduct, $rowproduct['Product_Title_EN']); 
//$bsta = $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCountproduct, $rowproduct['Meal_Item']); 

$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCountproduct, $rowproduct['product_count']);
$rowCountproduct++; 
}


/*$querypayment ="SELECT count( Registration_Paye_Method ) AS payment_count, r.Registration_Paye_Method FROM Registrations AS r
GROUP BY Registration_Paye_Method";*/

$querypayment =("SELECT count( Registration_Paye_Method ) AS payment_count, r.Registration_Paye_Method, r.*, p.*, c.Conference_Title_EN FROM Registrations as r join Products as p on  r.`Registration_Product_Identifier` = p.Product_Identification 

join Conference as c on  p.`Product_Conference_Number` = c.Conference_Identifier
JOIN Meals AS m ON m.Meal_Id = r.Registration_Meal_Banquet_Identifier
WHERE Registration_Confirmation_Number != '' AND c.Conference_Title_EN = 'District 61 2016 Spring Conference'
GROUP BY Registration_Paye_Method");


$resultpayment = mysql_query($querypayment);

while($rowpayment = mysql_fetch_array($resultpayment)){ 

//print_r($rowmo);


$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCountpayment, $rowpayment['Registration_Paye_Method']); 
//$bsta = $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCountpayment, $rowpayment['Registration_Paye_Method']); 

$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCountpayment, $rowpayment['payment_count']);
$rowCountpayment++; 
}





//exit;




$dat = date('dis');
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"spring_meals_details.xlsx\"");
header("Cache-Control: max-age=0");
 require_once '../phpexcel/Classes/PHPExcel/IOFactory.php';
                   
                    $objActSheet = $objPHPExcel->getActiveSheet();
                    $objActSheet->setTitle('Users AttendanceRecord');


                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                    
$objWriter->save("php://output");
//$objWriter->save('exportexcel/'.$dat.'users.xlsx'); 
ob_clean();
?>
