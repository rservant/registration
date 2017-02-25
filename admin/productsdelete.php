<?php 
	include('../includes/header.inc1.php');
	$module = "Product";
	require 'database.php';
	$id = $_GET['Product_Identification'];
	
	if ( !empty($_GET['Product_Identification'])) {
		$id = $_REQUEST['Product_Identification'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['PIdentification'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM Products  WHERE Product_Identification = '$id'";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		header("Location: viewproduct.php");
		
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
		    		
	    			<form class="form-horizontal" action="productsdelete.php" method="post">
	    			  <input type="hidden" name="PIdentification" value="<?php echo $id;?>"/>
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
