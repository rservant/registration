<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>T MASTERS</title>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="js/jquery.jeditable.js"></script>
		
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				var oTable = $('#example').dataTable( {
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "getit.php",
					"fnDrawCallback": function () {
						$('#example tbody td').editable( 'editable_ajax.php', {
							"callback": function( sValue, y ) {
								/* Redraw the table from the new data on the server */
								oTable.fnDraw();
							},
							"height": "14px"
						} );
					}
				} );
			} );
		</script>
		<link href="js/demo_page.css" type="text/css" rel="stylesheet" />
		<link href="js/demo_table.css" type="text/css" rel="stylesheet" />
</head>

<body>
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
	<tbody>
		<tr>
			<td colspan="5" class="dataTables_empty">Loading data from server</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th width="20%">Client Name</th>
			<th width="25%">Club Number</th>
			<th width="25%">Leadership Type</th>
			<th width="15%">Email</th>
			<th width="15%">Cell Phone</th>
		</tr>
	</tfoot>
</table>
<!--<h1>Initialisation code</h1>
			<pre class="brush: js;">$(document).ready(function() {
	var oTable = $('#example').dataTable( {
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "getit.php",
		"fnDrawCallback": function () {
			$('#example tbody td').editable( 'editable_ajax.php', {
				"callback": function( sValue, y ) {
					/* Redraw the table from the new data on the server */
					oTable.fnDraw();
				},
				"height": "14px"
			} );
		}
	} );
} );</pre>-->
</body>
</html>
