<?php 


session_start(); 

if(!isset($_SESSION['Client_First_Name']) || $_SESSION['Client_Role'] != 'admin'){
	header("location: ../index.php");
	echo "eret";


?>

<?php } else { 
include("../includes/header.inc1.php");

$start_limit = 0;
$searchstring = "";
@$page = isset($_GET['page']) ? $_GET['page'] : $_POST['page'];
if (!isset($page))
    $page = 1;
if ($page > 1)
    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);

@$s = (isset($_GET['s'])) ? $_GET['s'] : $_POST['s'];
if(@$s != ""){
	$searchstring = "s=" . $s;
}
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
    			<h3 style="color:#ffffff;">Toastmasters Products View</h3>
    		</div>
			<div align="right"><iframe src="menus.php" width="100%" frameborder="0" scrolling="no" height="37"></iframe></div>
			<div class="row">
				<!--<p>
					<a href="create.php" class="btn btn-success">Create</a>
				</p>-->
		<form action="viewproduct.php" method="POST">
			<input type="text" name="s" id="s" value="<?php echo @$s; ?>"> 
			<input type="submit" name="submitbtn" id="submitbtn" value="Search">
		</form>		
				<table class="table table-striped table-bordered" style="background-color: #fff;">
		              <thead>
		                <tr>
<th>Conference<br /></th>
		                  <th>Product<br />Title EN</th>
		                  <th>Product<br />Title FR</th>
		                  <th>Product<br />Description</th>
		                  <th>Product<br />Price</th>
<th>Product<br />Start Date</th>
<th>Product<br />End Date</th>
<th>Product<br />Meals</th>
<th>Meals<br />Category</th>
<th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
			//$sql = "SELECT * FROM Products ORDER BY Product_Identification DESC";
			//$sql= "SELECT p.*, c.Conference_Title_EN FROM Products as p join Conference as c on  p.`Product_Conference_Number` = c.Conference_Identifier ORDER BY p.Product_Identification DESC";
            $countForPagenationQuery = "SELECT count(*) as count FROM Products";
			$stmt = $pdo->prepare($countForPagenationQuery);
			$stmt->execute();
			if($stmt->rowCount() > 0){
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
				$countForPagenation = $result['count'];
			}
			$sql= "SELECT p.*, c.Conference_Title_EN FROM Products as p join Conference as c on  p.`Product_Conference_Number` = c.Conference_Identifier ORDER BY p.Product_Identification DESC Limit " . $start_limit . " , " . ROW_PER_PAGE;
			$count =0;
			foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['Conference_Title_EN'] . '</td>';
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
								$count++;
					   }
	    


 Database::disconnect();
					  ?>
                             <span style="padding-right:2px;margin-top:0px;">
                            <?php
                            //Display pagging
                            if(@$count > 0){
								echo doPages(ROW_PER_PAGE, 'viewproduct.php', $searchstring, $countForPagenation);
                            }
                            ?>
                        </span>

			 </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>
<?php } ?>
