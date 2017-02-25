<?php 
include('../includes/header.inc1.php');

	require 'database.php';

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: view_officer.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$BankName = null;
		$ChequeNo = null;
		$paymentstatus = null;
		
		// keep track post values
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name']; 
		$email = $_POST['email'];
		$phone = $_POST['phone'];


		
		// validate input
		$valid = true;
		if (empty($first_name)) {
			$BankName = 'Please enter first name';
			$valid = false;
		}
		
		if (empty($last_name)) {
			$ChequeNo = 'Please enter last name';
			$valid = false;
		} 
		
		if (empty($email)) {
			$paymentstatus = 'Please enter email';
			$valid = false;
		}
		
		if (empty($phone)) {
			$paymentstatus = 'Please enter phone no';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE `admin_users`  set first_name = ?, last_name = ?, email =?, phone = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($first_name, $last_name, $email, $phone, $id));
			Database::disconnect();
			header("Location: view_officer.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM  `admin_users` where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);

		$first_name = $data['first_name'];
		$last_name = $data['last_name']; 
		$email = $data['email'];
		$phone = $data['phone'];
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
	<script src="layouts/js/jquery.min.js"></script>
</head>

<body style="background-color:#4C5D67;">
    <div class="container">    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3 style="color:#ffffff;">Update Officer</h3>
		    		</div>
					<div style="background-color:#fff;">
	    			<form class="form-horizontal" action="newoffupdate.php?id=<?php echo $id?>" method="post">
					<div class="control-group <?php echo !empty($first_name)?'error':'';?>">
					    <label class="control-label">First Name</label>
					    <div class="controls">
							<input name="first_name" type="text"  placeholder="First Name" value="<?php echo !empty($first_name)? $first_name:'';?>">
					      	<?php if (!empty($first_name)): ?>
					      		<span class="help-inline"><?php echo $first_name; ?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($last_name) ? 'error':'';?>">
					    <label class="control-label">Last Name</label>
					    <div class="controls">
					      	<input name="last_name" type="text"  placeholder="Last Name" value="<?php echo !empty($last_name) ? $last_name:'';?>">
					      	<?php if (!empty($last_name)): ?>
					      		<span class="help-inline"><?php echo $last_name;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($email) ? 'error':'';?>">
					    <label class="control-label">Email</label>
					    <div class="controls">
					      	<input name="email" type="text" placeholder="Email" value="<?php echo !empty($email) ? $email : '';?>">
					      	<?php if (!empty($email)): ?>
					      		<span class="help-inline"><?php echo $email;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($phone)?'error':'';?>">
					    <label class="control-label">Phone</label>
					    <div class="controls">
					      	<input name="phone" type="text"  placeholder="Phone" value="<?php echo !empty($phone)?$phone:'';?>">
					      	<?php if (!empty($phone)): ?>
					      		<span class="help-inline"><?php echo $phone;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
 
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="view_officer.php">Back</a>
						</div>
					</form>
</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>

