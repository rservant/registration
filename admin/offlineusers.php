<?php 
include("../includes/header.inc1.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Toastmasters</title>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
<link href="../dtab/js/demo_page.css" type="text/css" rel="stylesheet" />
</head>

<body style="background-color:#4C5D67;">
    <div class="container">
    		<div class="row">
    			<h3 style="color:#ffffff;">Toastmasters Offline Users Details</h3>
    		</div>
<div align="right"><iframe src="menus.php" width="100%" frameborder="0" scrolling="no" height="37"></iframe></div>
			<div class="row">
				<!--<p>
					<a href="create.php" class="btn btn-success">Create</a>
				</p>-->
				
				<table class="table table-striped table-bordered" style="background-color: #fff;">
		              <thead>
		                <tr>
		                  <th>Transaction<br />ID</th>
		                  <th>Payment<br />Type</th>
		                  <th>Amount</th>
		                  <th>Date</th>
<th>Bank<br />Name</th>
<th>Cheque<br />No</th>
<th>Payment<br />Status</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
			$sql = "SELECT * FROM Registrations WHERE Registration_Paye_Method != 'paypal' ORDER BY Registration_Number DESC";

	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['invoice'] . '</td>';
							   	echo '<td>'. $row['Registration_Paye_Method'] . '</td>';
							   	echo '<td>'. $row['Registration_Total_Amount'] . '</td>';
echo '<td width="207px">'. $row['Registration_Transaction_Date_Time'] . '</td>';
echo '<td width="207px">'. $row['Bank_name'] . '</td>';
echo '<td width="207px">'. $row['Cheque_No'] . '</td>';
echo '<td>'. $row['payment_status'] . '</td>';
							   	echo '<td width=250>';
/*echo '<a class="btn" href="newuserread.php?Registration_Number='.$row['Registration_Number'].'">Read</a>';*/
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="newuserupdate.php?Registration_Number='.$row['Registration_Number'].'">Update</a>';
							   	echo '&nbsp;';
							   	/*echo '<a class="btn btn-danger" href="delete.php?Club_Number='.$row['Club_Number'].'">Delete</a>';*/
							   	echo '</td>';
							   	echo '</tr>';
					   }
	    


 Database::disconnect();
					  ?>
     

			 </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>
