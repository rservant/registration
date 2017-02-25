<?php
/* * ****************************************************************
 * Ideabytes Software India Pvt Ltd.                                *
 * 50 Jayabheri Enclave, Gachibowli, HYD                            *
 * Created Date : 11/07/2014                                        *
 * Created By : GAYATHRI D                                          *
 * Vision : Project Streaming Analytics                             *
 * Modified by : GAYATHRI D    Date : 11/07/2014    Version : V1    *
 * Description : Activity Log Class                                 *
 * *************************************************************** */

class ActivityLog {	 
    public function addLog($module,$action,$inputData="",$actionStatus="") {
		global $dbcon,$logininfo;
		//print_r($logininfo);
		//$user_type = isset($logininfo["admin_logged_status"]) ? $logininfo["admin_logged_status"] : 2;
		$user_type = isset($logininfo["user_role"]) ? $logininfo["user_role"] : 2;

		$customer_id = isset($logininfo["customer_id"]) ? $logininfo["customer_id"] : "";
		if(isset($logininfo["id"])){
			$user_id = $logininfo["id"];
		} else{
			@$logininfo = unserialize($_SESSION[LOG_SESSION]);
			$user_id = isset($logininfo["id"]) ? $logininfo["id"] : "";
			$user_type = isset($logininfo["user_role"]) ? $logininfo["user_role"] : 2;
		}
		
		$ipAddress = "183.82.9.51";
		$date = gmdate("Y-m-d H:i:s");
		$query = "INSERT INTO `".ACTIVITY_LOGS."` (`ipaddress`, `user_type`, `user_id`,`customer_id`, `module`, `action`, `input_data`, `action_status`, `create_datetime`) VALUES (:ipaddress, :user_type, :user_id,:customer_id, :module, :action, :input_data, :action_status, :create_datetime)";
		try {
			$insert_query = $dbcon->prepare($query);
			$insert_query->bindParam(":ipaddress",$ipAddress);
			$insert_query->bindParam(":user_type",$user_type);
			$insert_query->bindParam(":user_id",$user_id);
			$insert_query->bindParam(":customer_id",$customer_id);
			$insert_query->bindParam(":module",$module);
			$insert_query->bindParam(":action",$action);
			$insert_query->bindParam(":input_data",$inputData);
			$insert_query->bindParam(":action_status",$actionStatus);
			$insert_query->bindParam(":create_datetime",$date);
			$insert_query->execute();
			//print_r($insert_query->errorInfo());
		}catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
    }
	
	function logCount($user_id = ""){
		global $dbcon;
		$sCond = "";
		if($user_id != "")
			$sCond = "AND `user_id` = :user_id";
      
		$q = "SELECT count(id) as count FROM `".ACTIVITY_LOGS."` WHERE 1 ".$sCond;
		try {
			$select_query = $dbcon->prepare($q);
			if($user_id != "")
				$select_query->bindParam(":user_id",$user_id);
        
			$select_query->execute();
			$count = $select_query->rowCount();
			if($count >0){
				$select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
				return $select_query_result['count'];
			}
		}catch (PDOException $e){
            print $e->getMessage();
        }
        return "";
	}
	
	function logList($user_id = ""){
		global $dbcon,$start_limit;
		$sCond = "";
		if($user_id != "")
		  $sCond = "AND `user_id` = :user_id";
		  
			$q = "SELECT * FROM `".ACTIVITY_LOGS."` WHERE 1 ".$sCond." ORDER BY id DESC LIMIT ".$start_limit.",".ROW_PER_PAGE;
			$select_query = $dbcon->prepare($q);
			if($user_id != "")
				$select_query->bindParam(":user_id",$user_id);
			
			$select_query->execute();
			if($select_query->rowCount() > 0 ){
				$result = $select_query->fetchAll();
				return $result;
			}
			return "";
	}
	
	function getUserNamesArray(){
		global $dbcon;
		$usersData = array(); 
		$q = "SELECT * FROM `admin_users` WHERE 1 ";
		$select_query = $dbcon->prepare($q);
		$select_query->execute();
		if($select_query->rowCount() > 0 ){
			$result = $select_query->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $data){
				$usersData[$data['id']] = $data['first_name'] . " "  . $data['last_name'];
			}
		}
		return $usersData;
	}
}

?>
