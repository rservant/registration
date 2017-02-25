<?php 
	include('../includes/header.inc1.php');
	$module = "Product";
	require 'database.php';
	$id = $_GET['Meal_ID'];
	
	if ( !empty($_GET['Meal_ID'])) {
		$id = $_REQUEST['Meal_ID'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['MID'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM Meals WHERE Meal_ID = '$id'";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		header("Location: viewmeal.php");
		
	} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
	<script src="layouts/js/jquery.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Delete a PRODUCT</h3>
		    		</div>
		    		
	    			<form class="form-horizontal" action="mealsdelete.php" method="post">
	    			  <input type="hidden" name="MID" value="<?php echo $id;?>"/>
					  <p class="alert alert-error">Are you sure to delete ?</p>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn" href="index.php">No</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
