<?php
include('../includes/header.inc1.php');
include('adminindex.php'); 
?>
<div id="container">
	<div class="full_width big">
		<font style="color:#ffffff;"><h3>Toastmasters Users Details</h3></font>
		<div align="right">
			<iframe src="menus.php" width="80%" frameborder="0" scrolling="no" height="37"></iframe>
		</div>
	</div>			
	<!--<h1>USERS DETAILS</h1>
	<p>All Users for Spring Meeting.</p>
	
	<h1>DETAILS</h1>-->
	<div id="demo">
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
			<thead>
				<tr>
					<th width="20%">Client Name</th>
					<th width="25%">Club Number</th>
					<th width="25%">Leadership Level</th>
					<th width="15%">Email</th>
					<th width="15%">Cell Phone</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th width="20%">Client Name</th>
					<th width="25%">Club Number</th>
					<th width="25%">Leadership Level</th>
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
	</div>
</div>
<div class="spacer"></div>
<?php include('botom.php'); ?>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#example').dataTable( {
			"sScrollY": 200,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../dtab/getit.php"
		} );
	});
</script>
