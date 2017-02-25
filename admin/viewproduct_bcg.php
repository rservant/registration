<?php 


session_start(); 

if(!isset($_SESSION['Client_First_Name']) || $_SESSION['Client_Role'] != 'admin'){
	header("location: ../index.php");
	echo "eret";


?>

<?php } else { 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body style="background-color:#4C5D67;">
    <div class="container">
    		<div class="row">
    			<h3 style="color:#ffffff;">Toastmasters Products View</h3>
    		</div>
<div align="right"><iframe src="menus.php" width="100%" frameborder="0" scrolling="no" height="37"></iframe></div>
			<div class="row">
				<!--<p>
					<a href="create.php" class="btn btn-success">Create</a>
				</p>-->
				
				<table class="table table-striped table-bordered" style="background-color: #fff;">
		              <thead>
		                <tr>
<th>Conference<br /></th>
		                  <th>Conference<br />Title EN</th>
		                  <th>Conference<br />Title FR</th>
		                  <th>Product<br />Description</th>
		                  <th>Product<br />Price</th>
<th>Product<br />Start Date</th>
<th>Product<br />End Date</th>
<th>Product<br />Meals</th>
<th>Product<br />Category</th>
<th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
			$sql = "SELECT * FROM Products ORDER BY Product_Identification DESC";

	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['Product_Conference_Number'] . '</td>';
							   	echo '<td>'. $row['Product_Title_EN'] . '</td>';
							   	echo '<td>'. $row['Product_Title_FR'] . '</td>';
echo '<td>'. $row['Product_Description'] . '</td>';
echo '<td>'. $row['Product_Price'] . '</td>';
echo '<td>'. $row['Product_Effective_Date_Time'] . '</td>';
echo '<td>'. $row['Product_Expiry_Date_Time'] . '</td>';
echo '<td>'. $row['product_meals_display'] . '</td>';
echo '<td>'. $row['product_meals_categories'] . '</td>';

							   	echo '<td width=250>';
							   	/*echo '<a class="btn" href="newconfread.php?Product_Identification='.$row['Product_Identification'].'">Read</a>';
							   	echo '&nbsp;';*/
							   	echo '<a class="btn btn-success" href="productsupdate.php?Product_Identification='.$row['Product_Identification'].'">Update</a>';
							   	echo '&nbsp;';
							   	/*echo '<a class="btn btn-danger" href="confdelete.php?Product_Identification='.$row['Product_Identification'].'">Delete</a>';*/
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
<?php } ?>
