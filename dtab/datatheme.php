<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>T MASTERS</title>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
		<!--<script type="text/javascript" language="javascript" src="js/shCore.js"></script>-->
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable( {
					"sScrollY": 200,
					"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "getit.php"
				} );
			} );
		</script>
		<link href="js/demo_page.css" type="text/css" rel="stylesheet" />
		<link href="js/demo_table.css" type="text/css" rel="stylesheet" />
		<!--<link href="js/shCore.css" type="text/css" rel="stylesheet" />-->
		<link href="js/jquery-ui-1.8.4.custom.css" type="text/css" rel="stylesheet" />
		<link href="js/demo_table_jui.css" type="text/css" rel="stylesheet" />
</head>

<body id="dt_example">
<!--<body> for 100% body-->
<div id="container">
			<div class="full_width big">
				T Masters Users Details
			</div>
			
			<h1>USERS DETAILS</h1>
			<p>All Users for Spring Meeting.</p>
			
			<h1>DETAILS</h1>
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
