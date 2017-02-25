<?php 
	
	require 'database.php';

	$id = null;
	if ( !empty($_GET['Registration_Number'])) {
		$id = $_REQUEST['Registration_Number'];
	}
	
	if ( null==$id ) {
		header("Location: offlineusers.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$BankName = null;
		$ChequeNo = null;
		$paymentstatus = null;
		
		// keep track post values
		$BankName = $_POST['Bank_name'];
		$ChequeNo = $_POST['Cheque_No'];
		$paymentstatus = $_POST['payment_status'];

		
		// validate input
		$valid = true;
		if (empty($BankName)) {
			$BankName = 'Please enter Bank Name';
			$valid = false;
		}
		
		if (empty($ChequeNo)) {
$ChequeNo = 'Please enter Cheque Address';
			$valid = false;
		} 
		
		if (empty($paymentstatus)) {
			$paymentstatus = 'Please enter Payment Status';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Registrations  set Bank_name = ?, Cheque_No = ?, payment_status =? WHERE Registration_Number = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($BankName,$ChequeNo,$paymentstatus,$id));
			Database::disconnect();
			header("Location: offlineusers.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Registrations where Registration_Number = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$BankName = $data['Bank_name'];
		$ChequeNo = $data['Cheque_No'];
		$paymentstatus = $data['payment_status'];
		Database::disconnect();
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
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3 style="color:#ffffff;">Update a Customer</h3>
		    		</div>
    		<div style="background-color:#fff;">
	    			<form class="form-horizontal" action="newuserupdate.php?Registration_Number=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($Bankname)?'error':'';?>">
					    <label class="control-label">Bank Name</label>
					    <div class="controls">
					      	<input name="Bank_name" type="text"  placeholder="Bank Name" value="<?php echo !empty($Bankname)?$Bankname:'';?>">
					      	<?php if (!empty($Bankname)): ?>
					      		<span class="help-inline"><?php echo $BankName;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($ChequeNo)?'error':'';?>">
					    <label class="control-label">Cheque No</label>
					    <div class="controls">
					      	<input name="Cheque_No" type="text" placeholder="Cheque No" value="<?php echo !empty($ChequeNo)?$ChequeNo:'';?>">
					      	<?php if (!empty($ChequeNo)): ?>
					      		<span class="help-inline"><?php echo $ChequeNo;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($paymentstatus)?'error':'';?>">
					    <label class="control-label">Payment Status</label>
					    <div class="controls">
					      	<input name="payment_status" type="text"  placeholder="Complete" value="<?php echo !empty($paymentstatus)?$paymentstatus:'';?>">
					      	<?php if (!empty($paymentstatus)): ?>
					      		<span class="help-inline"><?php echo $paymentstatus;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="offlineusers.php">Back</a>
						</div>
					</form>
</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
