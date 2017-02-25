<?php 


session_start(); 

if(!isset($_SESSION['Client_First_Name']) || $_SESSION['Client_Role'] != 'admin'){
	header("location: index.php");
	echo "eret";


?>

<?php } else { 


?>
<?php 
	
	require 'database.php';

	$id = null;
	if ( !empty($_GET['Product_Identification'])) {
		$id = $_REQUEST['Product_Identification'];
	}
	
	if ( null==$id ) {
		header("Location: viewproduct.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$ProductConferenceNumber = null;
		$ProductTitleEN = null;
		$ProductTitleFR = null;
		
		// keep track post values
$ProductConferenceNumber = $_POST['Product_Conference_Number']; 
$ProductTitleEN = $_POST['Product_Title_EN'];
$ProductTitleFR = $_POST['Product_Title_FR'];
$ProductDescription = $_POST['Product_Description'];
$ProductPrice = $_POST['Product_Price'];
$ProductEffectiveDateTime = $_POST['Product_Effective_Date_Time'];
$ProductExpiryDateTime = $_POST['Product_Expiry_Date_Time'];
$product_meals_display = $_POST['product_meals_display'];
$productmealscategories = $_POST['product_meals_categories'];


		
		// validate input
		$valid = true;
		if (empty($ProductConferenceNumber)) {
			$ProductConferenceNumber = 'Please enter Conference';
			$valid = false;
		}
		
		if (empty($ProductTitleEN)) {
$ProductTitleEN = 'Please enter Product Title ENGLISH';
			$valid = false;
		} 
		
		if (empty($ProductTitleFR)) {
$ProductTitleFR = 'Please enter Product Title FRENCH';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Products  set Product_Conference_Number = ?, Product_Title_EN = ?, Product_Title_FR =?, Product_Description = ?, Product_Price = ?, Product_Effective_Date_Time = ?, Product_Expiry_Date_Time = ?, product_meals_display = ?, product_meals_categories = ? WHERE Product_Identification = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($ProductConferenceNumber, $ProductTitleEN, $ProductTitleFR, $ProductDescription, $ProductPrice, $ProductEffectiveDateTime, $ProductExpiryDateTime, $product_meals_display, $productmealscategories,  $id));
			Database::disconnect();
			header("Location: viewproduct.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Products where Product_Identification = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);

$ProductConferenceNumber = $data['Product_Conference_Number']; 
$ProductTitleEN = $data['Product_Title_EN'];
$ProductTitleFR = $data['Product_Title_FR'];
$ProductDescription = $data['Product_Description'];
$ProductPrice = $data['Product_Price'];
$ProductEffectiveDateTime = $data['Product_Effective_Date_Time'];
$ProductExpiryDateTime = $data['Product_Expiry_Date_Time'];
$product_meals_display = $data['product_meals_display'];
$productmealscategories = $data['product_meals_categories'];


		Database::disconnect();
	}
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
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3 style="color:#ffffff;">Update a Product</h3>
		    		</div>
    		<div style="background-color:#fff;">
	    			<form class="form-horizontal" action="productsupdate.php?Product_Identification=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($ProductConferenceNumber)?'error':'';?>">
					    <label class="control-label">Product_Conference_Number</label>
					    <div class="controls">
					      	<input name="Product_Conference_Number" type="text"  placeholder="Product_Conference_Number" value="<?php echo !empty($ProductConferenceNumber)?$ProductConferenceNumber:'';?>" readonly>
					      	<?php if (!empty($ProductConferenceNumber)): ?>
					      		<span class="help-inline"><?php echo $ProductConferenceNumber;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>

					  <div class="control-group <?php echo !empty($ProductTitleEN)?'error':'';?>">
					    <label class="control-label">Product_Title_EN</label>
					    <div class="controls">
					      	<input name="Product_Title_EN" type="text" placeholder="Product_Title_EN" value="<?php echo !empty($ProductTitleEN)?$ProductTitleEN:'';?>">
					      	<?php if (!empty($ProductTitleEN)): ?>
					      		<span class="help-inline"><?php echo $ProductTitleEN;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

					  <div class="control-group <?php echo !empty($ProductTitleFR)?'error':'';?>">
					    <label class="control-label">Product_Title_FR</label>
					    <div class="controls">
					      	<input name="Product_Title_FR" type="text"  placeholder="Product_Title_FR" value="<?php echo !empty($ProductTitleFR)?$ProductTitleFR:'';?>">
					      	<?php if (!empty($ProductTitleFR)): ?>
					      		<span class="help-inline"><?php echo $ProductTitleFR;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

 <div class="control-group <?php echo !empty($ProductDescription)?'error':'';?>">
					    <label class="control-label">Product_Description</label>
					    <div class="controls">
<input name="Product_Description" type="text"  placeholder="Product_Description" value="<?php echo !empty($ProductDescription)?$ProductDescription:'';?>">
					      	<?php if (!empty($ProductDescription)): ?>
					      		<span class="help-inline"><?php echo $ProductDescription;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

 <div class="control-group <?php echo !empty($ProductPrice)?'error':'';?>">
					    <label class="control-label">Product_Price</label>
					    <div class="controls">
					      	<input name="Product_Price" type="text"  placeholder="Product_Price" value="<?php echo !empty($ProductPrice)?$ProductPrice:'';?>">
					      	<?php if (!empty($ProductPrice)): ?>
					      		<span class="help-inline"><?php echo $ProductPrice;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

 <div class="control-group <?php echo !empty($ProductEffectiveDateTime)?'error':'';?>">
					    <label class="control-label">Product_Effective_Date_Time</label>
					    <div class="controls">
					      	<input name="Product_Effective_Date_Time" type="text"  placeholder="Product_Effective_Date_Time" value="<?php echo !empty($ProductEffectiveDateTime)?$ProductEffectiveDateTime:'';?>">
					      	<?php if (!empty($ProductEffectiveDateTime)): ?>
					      		<span class="help-inline"><?php echo $ProductEffectiveDateTime;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

 <div class="control-group <?php echo !empty($ProductExpiryDateTime)?'error':'';?>">
					    <label class="control-label">Product_Expiry_Date_Time</label>
					    <div class="controls">
					      	<input name="Product_Expiry_Date_Time" type="text"  placeholder="Product_Expiry_Date_Time" value="<?php echo !empty($ProductExpiryDateTime)?$ProductExpiryDateTime:'';?>">
					      	<?php if (!empty($ProductExpiryDateTime)): ?>
					      		<span class="help-inline"><?php echo $ProductExpiryDateTime;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

 <div class="control-group <?php echo !empty($productmealsdisplay)?'error':'';?>">
					    <label class="control-label">Product_meals_display</label>
					    <div class="controls">
					      	<input name="product_meals_display" type="text"  placeholder="product_meals_display" value="<?php echo !empty($productmealsdisplay)?$productmealsdisplay:'';?>">
					      	<?php if (!empty($productmealsdisplay)): ?>
					      		<span class="help-inline"><?php echo $productmealsdisplay;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

 <div class="control-group <?php echo !empty($productmealscategories)?'error':'';?>">
					    <label class="control-label">Product_meals_categories</label>
					    <div class="controls">
					      	<input name="product_meals_categories" type="text"  placeholder="product_meals_categories" value="<?php echo !empty($productmealscategories)?$productmealscategories:'';?>">
					      	<?php if (!empty($productmealscategories)): ?>
					      		<span class="help-inline"><?php echo $productmealscategories;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="viewproduct.php">Back</a>
						</div>
					</form>
</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
<?php } ?>
