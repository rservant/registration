<?php 
	include('../includes/header.inc1.php');
	
	require 'database.php';
	$id = $_GET['Conference_Identifier'];
	
	if ( !empty($_GET['Conference_Identifier'])) {
		$id = $_REQUEST['Conference_Identifier'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['CIdentifier'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM Conference  WHERE Conference_Identifier = '$id'";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		header("Location: view_conf.php");
		
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
		    		
	    			<form class="form-horizontal" action="confdelete.php" method="post">
	    			  <input type="hidden" name="CIdentifier" value="<?php echo $id;?>"/>
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
