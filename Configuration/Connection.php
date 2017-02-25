<?php
$conn = mysql_connect(DB_HOST, DB_USER_NAME, DB_PASSWORD);
mysql_select_db(DB_NAME);

class CONN{

	function dbQuery($msql){
	$enus = mysql_query($msql);
	return $enus;
	}

/*function dbFetchArray($enus, $enustype = MYSQL_NUM){
return mysql_fetch_array($enus, $enustype);	
	
}*/
	function dbFetchArray($enus){
	return mysql_fetch_array($enus);	
	}
	
	function dbFETCHROW($enus){
	return mysql_fetch_row($enus);	
	}
	
	function dbFETCHASSOC($enus){
	return mysql_fetch_assoc($enus);	
	}
	
	function dbFETCHOBJECT($enus){
	return mysql_fetch_object($enus);	
	}
	
	function dbOtherQuery($othermsql){
	$otherenus = mysql_query($othermsql);
	return $otherenus;
	}
	
	function dbFetchOtherArray($otherenus){
	return mysql_fetch_array($otherenus);	
	}
	
}


define('CLUBS', 'Clubs');
define('COMML', 'Comm_Levels');
define('CONF', 'Conference');
define('IDENTIFY', 'Identification');
define('LANGUAGE', 'Language');
define('LEADER', 'Leader_Levels');
define('MEALS', 'Meals');
define('PRODUCTS', 'Products');
define('REGISTRATIONS', 'Registrations');
//$mainusers = MAINUSER;


?>
