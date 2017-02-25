<?php 
include("../includes/header.inc1.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Toastmasters D61 Fall Conference</title>
<script type="text/javascript" language="javascript" src="../dtab/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../dtab/js/jquery.dataTables.js"></script>
		<!--<script type="text/javascript" language="javascript" src="../dtab/js/shCore.js"></script>-->
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable( {
					"sScrollY": 200,
					"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "../dtab/view_springreg.php"
				} );
			} );
		</script>
		<link href="../dtab/js/demo_page.css" type="text/css" rel="stylesheet" />
		<link href="../dtab/js/demo_table.css" type="text/css" rel="stylesheet" />
		<!--<link href="../dtab/js/shCore.css" type="text/css" rel="stylesheet" />-->
		<link href="../dtab/js/jquery-ui-1.8.4.custom.css" type="text/css" rel="stylesheet" />
		<link href="../dtab/js/demo_table_jui.css" type="text/css" rel="stylesheet" />

</head>
<body id="dt_example">
<?php include('header.php'); ?>
<!--<body> for 100% body-->
<div id="container">
			<div class="full_width big">
				<font style="color:#ffffff;"><h3>Toastmasters Users Details</h3></font>
<div align="right"><iframe src="menus.php" width="100%" frameborder="0" scrolling="no" height="37"></iframe></div>
			</div>
			
			<h1 style="color:#ffffff;">USERS DETAILS</h1>
			<!--<p>All Users for Spring Meeting.</p>
			
			<h1>DETAILS</h1>-->
<div align="right"><a href="springexport.php" style="color:#ffffff;">Export Members Details</a></div>
<div align="right"><a href="meals_details_spring.php" style="color:#ffffff;">Export Meals Details</a></div>
			<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<th width="20%">Id</th>
			<th width="25%">Club Name</th>
                        <th width="15%">Club Division</th>
			<th width="25%">Conference Title EN</th>
<th width="15%">Conference<br /> Category</th>
			<th width="15%">First Name</th>
			
			<th width="20%">Email</th>
			<th width="25%">Product Price</th>
			<!--<th width="25%">Meal Category1</th>-->
			<th width="15%">Choose your meal for the Saturday Lunch</th>
			<!--<th width="15%">Meal Price</th>-->
			<!--<th width="25%">Meal Category2</th>-->
			<th width="15%">Saturday Banquet</th>
			<!--<th width="15%">Meal Price</th>-->
			<th width="15%">Conference Start Date</th>
			<th width="15%">Conference End Date</th>
<th width="15%">Payment<br />Type</th>
<th width="15%">Transaction<br />ID</th>
<th width="15%">Payment<br /> Status</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th width="20%">Id</th>
			<th width="25%">Club Name</th>
                        <th width="15%">Club Division</th>
			<th width="25%">Conference Title EN</th>
			<th width="15%">First Name</th>
			
			<th width="20%">Email</th>
			<th width="25%">Product Price</th>
			<!--<th width="25%">Meal Category1</th>-->
			<th width="15%">Choose your meal for the Saturday Lunch</th>
			<!--<th width="15%">Meal Price</th>-->
			<!--<th width="25%">Meal Category2</th>-->
			<th width="15%">Saturday Banquet</th>
			<!--<th width="15%">Meal Price</th>-->
			<th width="15%">Conference Start Date</th>
			<th width="15%">Conference End Date</th>
<th width="15%">Transaction<br />ID</th>
<th width="15%">Payment<br /> Status</th>
		</tr>
	</tfoot>
	<tbody>
		<tr>
			<th width="20%">Id</th>
			<th width="25%">Club Name</th>
			<th width="25%">Conference Title EN</th>
			<th width="15%">First Name</th>
			<th width="15%">Last Name</th>
			<th width="20%">Email</th>
			<th width="25%">Product Price</th>
			<th width="25%">Meal Category1</th>
			<th width="15%">Meal Item</th>
			<th width="15%">Meal Price</th>
			<th width="25%">Meal Category2</th>
			<th width="15%">Meal Item</th>
			<th width="15%">Meal Price</th>
			<th width="15%">Conference Start Date</th>
			<th width="15%">Conference End Date</th>
<th width="15%">Transaction<br />ID</th>
<th width="15%">Payment<br /> Status</th>
		</tr>
		</tbody>
</table>
			</div></div>
			<div class="spacer"></div>
<?php include('botom.php'); ?>
</body>
</html>
