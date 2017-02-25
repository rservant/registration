<?php  
include("../includes/header.inc1.php");
$module = "Meal";
$oLog->addLog($module, "View", "", "");
?>
<!DOCTYPE html>
<html lang="en">
<head><title>Toastmasters</title>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body style="background-color:#4C5D67;">
    <div class="container">
    		<div class="row"><h3 style="color:#ffffff;">Toastmasters Meals View</h3>
    		</div>
<div align="right"><iframe src="menus.php" width="100%" frameborder="0" scrolling="no" height="37"></iframe></div>
			<div class="row">
				<!--<p>
					<a href="create.php" class="btn btn-success">Create</a>
				</p>-->
				
				<table class="table table-striped table-bordered" style="background-color: #fff;">
		              <thead>
		                <tr>

		                  <th>Meal<br />Conference</th>
		                  <th>Meal<br />Category</th>
		                  <th>Meal<br />Item</th>
		                  <th>Meal<br />Description<br />EN</th>
<th>Meal<br />Description<br />FR</th>
<th>Meal<br />Max<br />Quantity</th>
<th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
			$sql = "SELECT * FROM Meals ORDER BY Meal_ID DESC";

	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['Meal_Conference_ID'] . '</td>';
							   	echo '<td>'. $row['Meal_Category'] . '</td>';
							   	echo '<td>'. $row['Meal_Item'] . '</td>';
//echo '<td>'. $row['Meal_Price'] . '</td>';
echo '<td>'. $row['Meal_Description_EN'] . '</td>';
echo '<td>'. $row['Meal_Description_FR'] . '</td>';
echo '<td>'. $row['Meal_Max_Quantity'] . '</td>';


							   	echo '<td width=250>';
							   	/*echo '<a class="btn" href="mealsread.php?Meal_ID='.$row['Meal_ID'].'">Read</a>';
							   	echo '&nbsp;';*/
							   	echo '<a class="btn btn-success" href="mealsupdate.php?Meal_ID='.$row['Meal_ID'].'">Update</a>';
							   	echo '&nbsp;';
								if($logininfo['user_role'] == "admin"){
									echo '<a class="btn btn-danger" href="mealsdelete.php?Meal_ID='.$row['Meal_ID'].'">Delete</a>';
								}
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
