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
	if ( !empty($_GET['Conference_Identifier'])) {
		$id = $_REQUEST['Conference_Identifier'];
	}
	
	if ( null==$id ) {
		header("Location: viewconference.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$BankName = null;
		$ChequeNo = null;
		$paymentstatus = null;
		
		// keep track post values
$ConferenceTitleEN = $_POST['Conference_Title_EN']; 
$ConferenceTitleFR = $_POST['Conference_Title_FR'];
$ConferenceThemeEN = $_POST['Conference_Theme_EN'];
$ConferenceThemeFR = $_POST['Conference_Theme_FR'];
$ConferenceStartDate = $_POST['Conference_Start_Date'];
$ConferenceEndDate = $_POST['Conference_End_Date'];
$Conferencewebsitelink = $_POST['Conference_website_link'];
$contactph = $_POST['contact_ph'];
$contactemail = $_POST['contact_email'];


		
		// validate input
		$valid = true;
		if (empty($ConferenceTitleEN)) {
			$BankName = 'Please enter Conference Title ENGLISH';
			$valid = false;
		}
		
		if (empty($ConferenceTitleFR)) {
$ChequeNo = 'Please enter Conference Title FRENCH';
			$valid = false;
		} 
		
		if (empty($ConferenceThemeEN)) {
			$paymentstatus = 'Please enter Conference Theme ENGLISH';
			$valid = false;
		}
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Conference  set Conference_Title_EN = ?, Conference_Title_FR = ?, Conference_Theme_EN =?, Conference_Theme_FR = ?, Conference_Start_Date = ?, Conference_End_Date = ?, Conference_website_link = ?, contact_ph = ?, contact_email = ? WHERE Conference_Identifier = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($ConferenceTitleEN, $ConferenceTitleFR, $ConferenceThemeEN, $ConferenceThemeFR, $ConferenceStartDate, $ConferenceEndDate, $Conferencewebsitelink, $contactph, $contactemail,  $id));
			Database::disconnect();
			header("Location: view_conf.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM Conference where Conference_Identifier = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);

$ConferenceTitleEN = $data['Conference_Title_EN']; 
$ConferenceTitleFR = $data['Conference_Title_FR'];
$ConferenceThemeEN = $data['Conference_Theme_EN'];
$ConferenceThemeFR = $data['Conference_Theme_FR'];
$ConferenceStartDate = $data['Conference_Start_Date'];
$ConferenceEndDate = $data['Conference_End_Date'];
$Conferencewebsitelink = $data['Conference_website_link'];
$contactph = $data['contact_ph'];
$contactemail = $data['contact_email'];

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
		    			<h3 style="color:#ffffff;">Update Conference</h3>
		    		</div>
    		<div style="background-color:#fff;">
	    			<form class="form-horizontal" action="newconfupdate.php?Conference_Identifier=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($ConferenceTitleEN)?'error':'';?>">
					    <label class="control-label">Conference_Title_EN</label>
					    <div class="controls">
					      	<input name="Conference_Title_EN" type="text"  placeholder="Conference_Title_EN" value="<?php echo !empty($ConferenceTitleEN)?$ConferenceTitleEN:'';?>">
					      	<?php if (!empty($ConferenceTitleEN)): ?>
					      		<span class="help-inline"><?php echo $ConferenceTitleEN;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($ConferenceTitleFR)?'error':'';?>">
					    <label class="control-label">Conference_Title_FR</label>
					    <div class="controls">
					      	<input name="Conference_Title_FR" type="text" placeholder="Conference_Title_FR" value="<?php echo !empty($ConferenceTitleFR)?$ConferenceTitleFR:'';?>">
					      	<?php if (!empty($ConferenceTitleFR)): ?>
					      		<span class="help-inline"><?php echo $ConferenceTitleFR;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($ConferenceThemeEN)?'error':'';?>">
					    <label class="control-label">Conference_Theme_EN</label>
					    <div class="controls">
					      	<input name="Conference_Theme_EN" type="text"  placeholder="Conference_Theme_EN" value="<?php echo !empty($ConferenceThemeEN)?$ConferenceThemeEN:'';?>">
					      	<?php if (!empty($ConferenceThemeEN)): ?>
					      		<span class="help-inline"><?php echo $ConferenceThemeEN;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
 <div class="control-group <?php echo !empty($ConferenceThemeFR)?'error':'';?>">
					    <label class="control-label">Conference_Theme_FR</label>
					    <div class="controls">
<input name="Conference_Theme_FR" type="text"  placeholder="Conference_Theme_FR" value="<?php echo !empty($ConferenceThemeFR)?$ConferenceThemeFR:'';?>">
					      	<?php if (!empty($ConferenceThemeFR)): ?>
					      		<span class="help-inline"><?php echo $ConferenceThemeFR;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
 <div class="control-group <?php echo !empty($ConferenceStartDate)?'error':'';?>">
					    <label class="control-label">Conference_Start_Date</label>
					    <div class="controls">
					      	<input name="Conference_Start_Date" type="text"  placeholder="Conference_Start_Date" value="<?php echo !empty($ConferenceStartDate)?$ConferenceStartDate:'';?>">
					      	<?php if (!empty($ConferenceStartDate)): ?>
					      		<span class="help-inline"><?php echo $ConferenceStartDate;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
 <div class="control-group <?php echo !empty($ConferenceEndDate)?'error':'';?>">
					    <label class="control-label">Conference_End_Date</label>
					    <div class="controls">
					      	<input name="Conference_End_Date" type="text"  placeholder="Conference_End_Date" value="<?php echo !empty($ConferenceEndDate)?$ConferenceEndDate:'';?>">
					      	<?php if (!empty($ConferenceEndDate)): ?>
					      		<span class="help-inline"><?php echo $ConferenceEndDate;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
 <div class="control-group <?php echo !empty($Conferencewebsitelink)?'error':'';?>">
					    <label class="control-label">Conference_website_link</label>
					    <div class="controls">
					      	<input name="Conference_website_link" type="text"  placeholder="Conference_website_link" value="<?php echo !empty($Conferencewebsitelink)?$Conferencewebsitelink:'';?>">
					      	<?php if (!empty($Conferencewebsitelink)): ?>
					      		<span class="help-inline"><?php echo $Conferencewebsitelink;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
 <div class="control-group <?php echo !empty($contactph)?'error':'';?>">
					    <label class="control-label">Contact_ph</label>
					    <div class="controls">
					      	<input name="contact_ph" type="text"  placeholder="contact_ph" value="<?php echo !empty($contactph)?$contactph:'';?>">
					      	<?php if (!empty($contactph)): ?>
					      		<span class="help-inline"><?php echo $contactph;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
 <div class="control-group <?php echo !empty($contactemail)?'error':'';?>">
					    <label class="control-label">Contact_email</label>
					    <div class="controls">
					      	<input name="contact_email" type="text"  placeholder="contact_email" value="<?php echo !empty($contactemail)?$contactemail:'';?>">
					      	<?php if (!empty($contactemail)): ?>
					      		<span class="help-inline"><?php echo $contactemail;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn" href="view_conf.php">Back</a>
						</div>
					</form>
</div>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
<?php } ?>
