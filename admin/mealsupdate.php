<?php 	
	include('../includes/header.inc1.php');
	$module = "Meal";
	require 'database.php';

	$id = null;
	if ( !empty($_GET['Meal_ID'])) {
		$id = $_REQUEST['Meal_ID'];
	}
	
	if ( null==$id ) {
		header("Location: viewmeal.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$MealConferenceID = null;
		$MealCategory = null;
		$MealItem = null;
		
		// keep track post values
$MealConferenceID = $_POST['Meal_Conference_ID']; 
$MealCategory = $_POST['Meal_Category'];
$MealItem = $_POST['Meal_Item'];
$MealDescriptionEN = $_POST['Meal_Description_EN'];
$MealDescriptionFR = $_POST['Meal_Description_FR'];
$MealMaxQuantity = $_POST['Meal_Max_Quantity'];



		
		// validate input
		$valid = true;
		if (empty($MealConferenceID)) {
$MealConferenceID = 'Please enter Meal ID';
			$valid = false;
		}
		
		if (empty($MealCategory)) {
$MealCategory = 'Please enter Meal Category';
			$valid = false;
		} 
		
		if (empty($MealItem)) {
$MealItem = 'Please enter Meal Item';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Meals  set Meal_Conference_ID = ?, Meal_Category = ?, Meal_Item =?, Meal_Description_EN = ?, Meal_Description_FR = ?, Meal_Max_Quantity = ? WHERE Meal_ID = ?";
			$q = $pdo->prepare($sql);
		$q->execute(array($MealConferenceID, $MealCategory, $MealItem, $MealDescriptionEN, $MealDescriptionFR, $MealMaxQuantity,  $id));
			Database::disconnect();
			$inputData = serialize($_POST);
			$oLog->addLog($module, "Edit", $inputData, "1");
			header("Location: viewmeal.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Meals where Meal_ID = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);

$MealConferenceID = $data['Meal_Conference_ID']; 
$MealCategory = $data['Meal_Category'];
$MealItem = $data['Meal_Item'];
$MealDescriptionEN = $data['Meal_Description_EN'];
$MealDescriptionFR = $data['Meal_Description_FR'];
$MealMaxQuantity = $data['Meal_Max_Quantity'];



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
		    			<h3 style="color:#ffffff;">Update Meals</h3>
		    		</div>
    		<div style="background-color:#fff;">
	    			<form class="form-horizontal" action="mealsupdate.php?Meal_ID=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($MealConferenceID)?'error':'';?>">
					    <label class="control-label">Meal_Conference_ID</label>
					    <div class="controls">
					      	<input name="Meal_Conference_ID" type="text"  placeholder="Meal_Conference_ID" value="<?php echo !empty($MealConferenceID)?$MealConferenceID:'';?>" readonly>
					      	<?php if (!empty($MealConferenceID)): ?>
					      		<span class="help-inline"><?php echo $MealConferenceID;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>

					  <div class="control-group <?php echo !empty($MealCategory)?'error':'';?>">
					    <label class="control-label">Meal_Category</label>
					    <div class="controls">
					      	<input name="Meal_Category" type="text" placeholder="Meal_Category" value="<?php echo !empty($MealCategory)?$MealCategory:'';?>">
					      	<?php if (!empty($MealCategory)): ?>
					      		<span class="help-inline"><?php echo $MealCategory;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

					  <div class="control-group <?php echo !empty($MealItem)?'error':'';?>">
					    <label class="control-label">Meal_Item</label>
					    <div class="controls">
					      	<input name="Meal_Item" type="text"  placeholder="Meal_Item" value="<?php echo !empty($MealItem)?$MealItem:'';?>">
					      	<?php if (!empty($MealItem)): ?>
					      		<span class="help-inline"><?php echo $MealItem;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

 <div class="control-group <?php echo !empty($MealDescriptionEN)?'error':'';?>">
					    <label class="control-label">Meal_Description_EN</label>
					    <div class="controls">
<input name="Meal_Description_EN" type="text"  placeholder="Meal_Description_EN" value="<?php echo !empty($MealDescriptionEN)?$MealDescriptionEN:'';?>">
					      	<?php if (!empty($MealDescriptionEN)): ?>
					      		<span class="help-inline"><?php echo $MealDescriptionEN;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

 <div class="control-group <?php echo !empty($MealDescriptionFR)?'error':'';?>">
					    <label class="control-label">Meal_Description_FR</label>
					    <div class="controls">
					      	<input name="Meal_Description_FR" type="text"  placeholder="Meal_Description_FR" value="<?php echo !empty($MealDescriptionFR)?$MealDescriptionFR:'';?>">
					      	<?php if (!empty($MealDescriptionFR)): ?>
					      		<span class="help-inline"><?php echo $MealDescriptionFR;?></span>
					      	<?php endif;?>
					    </div>
					  </div>

 <div class="control-group <?php echo !empty($MealMaxQuantity)?'error':'';?>">
					    <label class="control-label">Meal_Max_Quantity</label>
					    <div class="controls">
					      	<input name="Meal_Max_Quantity" type="text"  placeholder="Meal_Max_Quantity" value="<?php echo !empty($MealMaxQuantity)?$MealMaxQuantity:'';?>">
					      	<?php if (!empty($MealMaxQuantity)): ?>
					      		<span class="help-inline"><?php echo $MealMaxQuantity; ?></span>
					      	<?php endif;?>
					    </div>
					  </div>




					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="viewmeal.php">Back</a>
						</div>
					</form>
</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
