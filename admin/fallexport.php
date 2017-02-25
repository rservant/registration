<?php 
include("../includes/header.inc1.php");
include("../Configuration/Connection.php");

?>
<?php
// The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=fall-export.xls");
 
// Add data table
?>
<table border="1">
    <tr>
    	<th>NO.</th>
		<th>Registration ID</th>
<th>Club Name</th>
<th>Club Division</th>
<th>Conference Title</th>
<th>Name</th>
<th>Last Name</th>
<th>Email</th>
<th>Home Phone</th>
<th>Work Phone</th>
<th>Cell Phone</th>
<th>Lead Designation</th>
<th>Product Price</th>
<th>Saturday Lunch</th>
<th>Saturday Banquet</th>
<th>Food_Allergies</th>
<th>Start Date</th>
<th>End Date</th>
<th>Payment Status</th>
<th>Registration Type</th>
<th>Registration code</th>
<th>Transaction Date</th>
<th>First Time</th>
<th>Volunteer</th>
<th>Comm Level</th>
<th>Language Prefer</th>
	</tr>
<?php
	
	
	//query get data
	$squery = mysql_query("SELECT Registrations.Registration_Number, Club_Name, Club_Division, Client_Home_Phone, Client_Last_Name, Client_Work_Phone, Client_Cell_Phone, Conference_Title_EN, Client_First_Name, RegistrationVolunteer, Product_Title_EN, Client_Email, Product_Price, m1.Meal_Item AS m1_item, m2.Meal_Item AS m2_item, Conference_Start_Date, Conference_End_Date, Registration_Paye_Method, Registration_Confirmation_Number, Client_Leadership_Type_Code, Client_Communication_Type_Code, Client_Language_Type_Code, Registration_First_Time_Indicator, Registration_Transaction_Date_Time, payment_status, Client_Allergies FROM Registrations 
JOIN Identification ON Identification.Client_Number = Registrations.Registration_Client_Identifier
LEFT JOIN Clubs ON Clubs.Club_Number = Identification.Client_Number
LEFT JOIN Meals as m1 ON m1.Meal_ID = Registrations.Registration_Meal_Lunch_Identifier
JOIN Meals as m2 ON m2.Meal_ID = Registrations.Registration_Meal_Banquet_Identifier
JOIN Products ON Products.Product_Identification = Registrations.Registration_Product_Identifier
JOIN Conference ON Conference.Conference_Identifier = Products.Product_Conference_Number 
WHERE Conference.conference_category='fall'");//Registration_Confirmation_Number != '' AND
$no = 1;
while($sele = mysql_fetch_array($squery)){
	
	
		echo '
		<tr>
			<td>'.$no.'</td>
			<td>'.$sele['Registration_Number'].'</td> 


<td>'.$sele['Club_Name'].'</td>
  
<td>'.$sele['Club_Division'].'</td> 


<td>'.$sele['Conference_Title_EN'].'</td> 
<td>'.$sele['Client_First_Name'].'</td> 
<td>'.$sele['Client_Last_Name'].'</td> 
<td>'.$sele['Client_Email'].'</td>
<td>'.$sele['Client_Home_Phone'].'</td> 
<td>'.$sele['Client_Work_Phone'].'</td>
<td>'.$sele['Client_Cell_Phone'].'</td> 
<td>'.$sele['Client_Leadership_Type_Code'].'</td> 
<td>'.$sele['Product_Price'].'</td>
<td>'.$sele['m1_item'].'</td> 
<td>'.$sele['m2_item'].'</td>
<td>'.$sele['Client_Allergies'].'</td>
<td>'.$sele['Conference_Start_Date'].'</td> 
<td>'.$sele['Conference_End_Date'].'</td>
<td>'.$sele['payment_status'].'</td> 
<td>'.$sele['Product_Title_EN'].'</td> 
<td>'.$sele['Registration_Confirmation_Number'].'</td> 
<td>'.$sele['Registration_Transaction_Date_Time'].'</td> 
<td>'.$sele['Registration_First_Time_Indicator'].'</td>
<td>'.$sele['RegistrationVolunteer'].'</td>
<td>'.$sele['Client_Communication_Type_Code'].'</td>
<td>'.$sele['Client_Language_Type_Code'].'</td>

		</tr>
		';
		$no++;
	}
	?>
</table>
