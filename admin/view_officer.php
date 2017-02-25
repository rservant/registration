<?php 
include('../includes/header.inc1.php');
/*
session_start(); 

if(!isset($_SESSION['Client_First_Name']) || $_SESSION['Client_Role'] != 'admin'){
	header("location: index.php");
	echo "eret";


?>

<?php } else { 

*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Toastmasters</title>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body style="background-color:#4C5D67;">
    <div class="container">
    		<div class="row">
    			<h3 style="color:#ffffff;">View Officers</h3>
    		</div>
<div align="right"><iframe src="menus.php" width="100%" frameborder="0" scrolling="no" height="37"></iframe></div>
			<div class="row">
				<!--<p>
					<a href="create.php" class="btn btn-success">Create</a>
				</p>-->
				
				<table class="table table-striped table-bordered" style="background-color: #fff;">
		              <thead>
		                <tr>
						  <th>First Name</th>
		                  <th>Last Name</th>
		                  <th>Email</th>
		                  <th>Phone</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
			$sql = "SELECT * FROM admin_users WHERE role = 'officer'";

	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	//echo '<td>'. $row['Conference_Identifier'] . " -- " .$row['Conference_Title_EN'] . '</td>';
								echo '<td>'. $row['first_name'] . '</td>';
								echo '<td>'. $row['last_name'] . '</td>';
							   	echo '<td>'. $row['email'] . '</td>';
							   	echo '<td>'. $row['phone'] . '</td>';
							   	echo '<td width=250>';
							   	/*echo '<a class="btn" href="newconfread.php?Conference_Identifier='.$row['Conference_Identifier'].'">Read</a>';
							   	echo '&nbsp;';*/
							   	echo '<a class="btn btn-success" href="newoffupdate.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	/*echo '<a class="btn btn-danger" href="confdelete.php?Conference_Identifier='.$row['Conference_Identifier'].'">Delete</a>';*/
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
<?php //} ?>
