<?php 


session_start(); 

if(!isset($_SESSION['Client_First_Name']) || $_SESSION['Client_Role'] != 'admin'){
	header("location: index.php");
	echo "eret";


?>

<?php } else { 


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
    			<h3 style="color:#ffffff;">Toastmasters Conference View</h3>
    		</div>
<div align="right"><iframe src="menus.php" width="100%" frameborder="0" scrolling="no" height="37"></iframe></div>
			<div class="row">
				<!--<p>
					<a href="create.php" class="btn btn-success">Create</a>
				</p>-->
				
				<table class="table table-striped table-bordered" style="background-color: #fff;">
		              <thead>
		                <tr>
		                  <th>Conference<br />Title EN</th>
		                  <th>Conference<br />Title FR</th>
		                  <th>Conference<br />Theme EN</th>
		                  <th>Conference<br />Theme FR</th>
<th>Conference<br />Start Date</th>
<th>Conference<br />End Date</th>
<th>Website<br />Link</th>
<th>Phone No</th>
<th>Email</th>
<th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
			$sql = "SELECT * FROM Conference ORDER BY Conference_Identifier DESC";

	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['Conference_Title_EN'] . '</td>';
							   	echo '<td>'. $row['Conference_Title_FR'] . '</td>';
							   	echo '<td>'. $row['Conference_Theme_EN'] . '</td>';
echo '<td>'. $row['Conference_Theme_FR'] . '</td>';
echo '<td>'. $row['Conference_Start_Date'] . '</td>';
echo '<td>'. $row['Conference_End_Date'] . '</td>';
echo '<td>'. $row['Conference_website_link'] . '</td>';
echo '<td>'. $row['contact_ph'] . '</td>';
echo '<td>'. $row['contact_email'] . '</td>';

							   	echo '<td width=250>';
							   	/*echo '<a class="btn" href="newconfread.php?Conference_Identifier='.$row['Conference_Identifier'].'">Read</a>';
							   	echo '&nbsp;';*/
							   	echo '<a class="btn btn-success" href="newconfupdate.php?Conference_Identifier='.$row['Conference_Identifier'].'">Update</a>';
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
<?php } ?>
