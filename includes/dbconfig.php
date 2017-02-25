<?php

/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 05/10/2015                                      *
 * Created By : Gayathri D                                         *
 * Vision : Project Toast Masters                                       *  
 * Modified by : Gayathri D     Date : 05/10/2015    Version : 1  *
 * Description : Make DB Connnection                              *
 *****************************************************************/


class DBCON{
	function createCon(){
		/* create connection */
		try{
			  $dbcon = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER_NAME, DB_PASSWORD);
		}
		catch(PDOException $e){
			echo $e->getMessage();                           
		}
		return $dbcon;
	}
	
	function closeCon($dbcon){
		$dbcon = null;
	}
}

$dbconObj = new DBCON();
$dbcon = $dbconObj->createCon();
?>
