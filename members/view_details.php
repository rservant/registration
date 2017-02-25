<?php 


session_start(); 

if(!isset($_SESSION['Client_Email']) || $_SESSION['Client_Role'] != 'user'){
	header("location: index.php");
	echo "eret";


?>

<?php } else { 


?>





<?php 
include("../Configuration/Connection.php");

$detailpage = new CONN();
$userm = $_SESSION['Client_Email'];
//echo $userm;
$slog = $_SESSION['Client_First_Name'];
$detailpage->msql = ("SELECT *FROM ".IDENTIFY." WHERE Client_Email = '$userm' ");
@$detailpage->enus = $detailpage->dbQuery($detailpage->msql);

while($detail = $detailpage->dbFetchArray($detailpage->enus)){

$slog = $detail['Client_First_Name']. '<br />';

}
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
		    var userEmail = '<?php echo $_SESSION['Client_Email'];?>';
			$(document).ready(function() {
				$('#example').dataTable( {
					"sScrollY": 200,
					"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "../dtab/getuser.php?userEmail="+userEmail
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
<!--<body> for 100% body-->
<div id="container">
			<div class="full_width big">
				T Masters Users Details

			</div>
			
			<h1>USERS DETAILS</h1>
<div align="right"><a href="registration.php">Register</a>
<a href="../lout.php">Logout</a></div>
			<!--<p>All Users for Spring Meeting.</p>
			
			<h1>DETAILS</h1>-->
			<div id="demo">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<th width="20%">Client Name</th>
			<th width="25%">Club Number</th>
			<th width="25%">Leadership Type</th>
			<th width="15%">Email</th>
			<th width="15%">Cell Phone</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th width="20%">Client Name</th>
			<th width="25%">Club Number</th>
			<th width="25%">Leadership Type</th>
			<th width="15%">Email</th>
			<th width="15%">Cell Phone</th>
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
</body>
</html>

<?php } ?>
