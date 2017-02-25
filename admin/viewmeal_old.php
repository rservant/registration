<?php 


session_start(); 

if(!isset($_SESSION['Client_First_Name']) || $_SESSION['Client_Role'] != 'admin'){
	header("location: ../index.php");
	echo "eret";


?>

<?php } else { 


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>T MASTERS</title>
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
					"sAjaxSource": "../dtab/view_meals.php"
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
				<font style="color:#ffffff;"><h3>Toastmasters Meals Details</h3></font>
<div align="right"><iframe src="menus.php" width="100%" frameborder="0" scrolling="no" height="37"></iframe></div>
			</div>
			
			<h1 style="color:#ffffff;">MEALS DETAILS</h1>
			<!--<p>All Conference.</p>
			
			<h1>DETAILS</h1>-->
			<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<th width="16%">Meal_Conference_ID</th>
			<th width="16%">Meal_Category</th>
			<th width="16%">Meal_Item</th>
			
			<th width="15%">Meal_Description_EN</th>
                        <th width="15%">Meal_Description_FR</th>
<th width="16%">Meal_Max_ Quantity</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th width="16%">Meal_Conference_ID</th>
			<th width="16%">Meal_Category</th>
			<th width="16%">Meal_Item</th>
			
			<th width="15%">Meal_Description_EN</th>
                        <th width="15%">Meal_Description_FR</th>
<th width="16%">Meal_Max_ Quantity</th>
		</tr>
	</tfoot>
	<tbody>
		<tr class="odd gradeX">
			<td>Trident</td>
			<td>Internet
				 Explorer 4.0</td>
			<td>Win 95+</td>
			<td class="center">4</td>
			<td class="center">X</td>
		</tr>
		</tbody>
</table>
			</div></div>
			<div class="spacer"></div>
<?php include('botom.php'); ?>
</body>
</html>
<?php } ?>
