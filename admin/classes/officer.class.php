<?php
class OFFICER {	
 
    function addOff($aPostArray) {
		$date = gmdate('Y-m-d H:i:s');
		global $dbcon;
		$select_q = "SELECT * FROM `admin_users` WHERE `email` = :email";
		$select_query = $dbcon->prepare($select_q);
		$select_query->bindParam(":email", $aPostArray['email']);
		$select_query->execute();		
		if($select_query->rowCount() > 0){
			$sMsg = 2;
		}else{
			$password = $this->generatePassword();
			$md5 = md5($password);
			//clubs table
			$conference_insert_query = "INSERT INTO `admin_users` (`first_name`, `last_name`, `email`, `phone`, `password`, `role`) VALUES (:first_name, :last_name, :email, :phone, :password, :role)";
			$sConfInsertQuery = $dbcon->prepare($conference_insert_query);
			$sConfInsertQuery->bindParam(":first_name", $aPostArray['fname']);
			$sConfInsertQuery->bindParam(":last_name", $aPostArray['lname']);
			$sConfInsertQuery->bindParam(":email", $aPostArray['email']);
			$sConfInsertQuery->bindParam(":phone", $aPostArray['phone']);
			$sConfInsertQuery->bindParam(":password", $md5);
			$sConfInsertQuery->bindValue(":role", "officer");					
			$sMsg = ($sConfInsertQuery->execute()) ? 1 : 3;
			//print_r($dbcon->errorInfo());exit;
			$subject = SUB_OFFICER_ADD;
			$message = MESSAGE_OFFICER_ADD;
			$name = $aPostArray['fname'] . " " . $aPostArray['lname'];			
			$message = str_replace("{NAME}", $name, $message);
			$message = str_replace("{USERNAME}", $aPostArray['email'], $message);
			$message = str_replace("{NEW_PSWD}", $password, $message);			
			sendMail($aPostArray['email'], FROM_EMAIL, $subject, $message);
		}
        return $sMsg;
    } 
	
	function getOfficers() {
		global $dbcon;
		$result = array();
		$select_q = "SELECT * FROM admin_users WHERE role = :role";
		$select_query = $dbcon->prepare($select_q);
		$select_query->bindValue(":role", "officer");
		$select_query->execute();		
		if($select_query->rowCount() > 0){
			$result = $select_query->fetchAll(PDO::FETCH_ASSOC);
		}
		return $result;
	}	
	
	function getOffById($id) {
		global $dbcon;
		$result = array();
		$select_q = "SELECT * FROM admin_users WHERE `id` = :id";
		$select_query = $dbcon->prepare($select_q);
		$select_query->bindParam(":id", $id);
		$select_query->execute();		
		if($select_query->rowCount() > 0){
			$result = $select_query->fetch(PDO::FETCH_ASSOC);
		}
		return $result;
	}
	
	function generatePassword($length = 8) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$count = mb_strlen($chars);

		for ($i = 0, $result = ''; $i < $length; $i++) {
			$index = rand(0, $count - 1);
			$result .= mb_substr($chars, $index, 1);
		}

		return $result;
   }
}
?>
