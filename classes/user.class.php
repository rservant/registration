<?php
class USER {	
	function addUser($aPostArray) {
		$date = gmdate('Y-m-d H:i:s');
		//print_r($aPostArray);
		global $dbcon;
		$sMsg = 0;
		/*$deplicateCheck = "true";
		if(isset($logininfo['email'])){
			$deplicateCheck = "false";
		}
		if($deplicateCheck == "true") {
			$select_q = "SELECT * FROM Identification WHERE `Client_Email` = :email";
			$select_query = $dbcon->prepare($select_q);
			$select_query->bindParam(":email", $aPostArray['contact_email']);
			$select_query->execute();
			if($select_query->rowCount() > 0){
				$sMsg = 2;
			}
		}*/
		//if(($deplicateCheck == "true" && $sMsg != 2) || ($deplicateCheck == "false")){
			$clubNo = $aPostArray['club_ref'];
			//$leaderLevels = (isset($aPostArray['level']) && count($aPostArray['level']) > 0) ? implode(",", $aPostArray['level']) : "";
			$e_level = (isset($aPostArray['e_level']) && count($aPostArray['e_level']) > 0) ? implode(",", $aPostArray['e_level']) : "";
			$l_level = (isset($aPostArray['l_level'])) ? $aPostArray['l_level'] : "";
			$c_level = (isset($aPostArray['c_level'])) ? $aPostArray['c_level'] : "";
			$languageNo = $aPostArray['language'];
			$volunteerInfo = (isset($aPostArray['volunteer']) && $aPostArray['volunteer'] == "yes" && isset($aPostArray['volunteer_level']) && count($aPostArray['volunteer_level']) > 0 )? implode(",", $aPostArray['volunteer_level']) : "";
			$volunteerInfo = (isset($aPostArray['other_volunteer_text']) && ($aPostArray['other_volunteer_text'] != "")) ? $volunteerInfo . ",Other:::".$aPostArray['other_volunteer_text'] : $volunteerInfo;
			//echo $volunteerInfo;exit;
			$password = $this->generatePassword();
			$md5 = md5($password);
			
			$query = "INSERT INTO `Identification`(`Client_First_Name`,  `Client_Last_Name`, `Client_Email`, `Client_Home_Phone`, `Client_Cell_Phone`, `Client_Work_Phone`, `Client_Accessibility_Needs`, `Client_Allergies`, `Client_Club_Number`, `Client_Language_Type_Code`, `Client_Communication_Type_Code`, `Client_Leadership_Type_Code`, `Client_Other_Titles`, `Client_Password`, `Client_Role`) VALUES (:Client_First_Name, :Client_Last_Name, :Client_Email, :Client_Home_Phone, :Client_Cell_Phone, :Client_Work_Phone, :Client_Accessibility_Needs, :Client_Allergies, :Client_Club_Number, :Client_Language_Type_Code, :Client_Communication_Type_Code, :Client_Leadership_Type_Code, :Client_Other_Titles, :Client_Password, :Client_Role)";
			$sInsertQuery = $dbcon->prepare($query);
			//$sInsertQuery->bindParam(":Client_First_Name", $aPostArray['f_name']);
			$sInsertQuery->bindParam(":Client_First_Name", $aPostArray['L_PAYMENTREQUEST_0_NAME0']);
			//$sInsertQuery->bindParam(":Client_Middle_Name", $aPostArray['m_name']);
			//$sInsertQuery->bindParam(":Client_Middle_Name", $aPostArray['L_PAYMENTREQUEST_0_NUMBER0']);
			//$sInsertQuery->bindParam(":Client_Last_Name", $aPostArray['l_name']);
			$sInsertQuery->bindParam(":Client_Last_Name", $aPostArray['L_PAYMENTREQUEST_0_DESC0']);
			/*$sInsertQuery->bindParam(":Client_Address", $aPostArray['address']);
			$sInsertQuery->bindParam(":Client_City", $aPostArray['city']);
			$sInsertQuery->bindParam(":Client_Province_State", $aPostArray['province']);
			$sInsertQuery->bindParam(":Client_Postal_Zip_Code", $aPostArray['postal']);*/
			$sInsertQuery->bindParam(":Client_Email", $aPostArray['contact_email']);
			$sInsertQuery->bindParam(":Client_Home_Phone", $aPostArray['h_phone']);
			$sInsertQuery->bindParam(":Client_Cell_Phone", $aPostArray['cell_phone']);
			$sInsertQuery->bindParam(":Client_Work_Phone", $aPostArray['w_phone']);
			$sInsertQuery->bindParam(":Client_Accessibility_Needs", $aPostArray['accessibility']);
			$sInsertQuery->bindParam(":Client_Allergies", $aPostArray['allergies']);
			$sInsertQuery->bindParam(":Client_Club_Number", $clubNo);
			$sInsertQuery->bindParam(":Client_Language_Type_Code", $languageNo);
			$sInsertQuery->bindParam(":Client_Communication_Type_Code", $c_level);
			$sInsertQuery->bindParam(":Client_Leadership_Type_Code", $l_level);
			$sInsertQuery->bindParam(":Client_Other_Titles", $e_level);
			$sInsertQuery->bindParam(":Client_Password", $md5);
			$sInsertQuery->bindParam(":Client_Role", $aPostArray['Client_Role']);
			$sMsg = ($sInsertQuery->execute()) ? 1 : 3;
			$client_identifier = $dbcon->lastInsertId();
			
			//$choiceArray = explode("$", $aPostArray['choice']);
			//registration table insertion
			$lunchId = (isset($aPostArray['mealCat1']) && ($aPostArray['mealCat1'] != "")) ? $aPostArray['mealCat1'] : "";
			$banquetId = (isset($aPostArray['mealCat2']) && ($aPostArray['mealCat2'] != "")) ? $aPostArray['mealCat2'] : "";
			$totalAmount = 0;
			//$totalAmount = $this->getTotalAmount($aPostArray['product'], $lunchId, $banquetId);
			$totalAmount = $this->getTotalAmount($aPostArray['product']);
			$regInsert_query = "INSERT INTO `Registrations`( `Registration_Client_Identifier`, `Registration_Product_Identifier`, `Registration_First_Time_Indicator`, `Registration_Meal_Lunch_Identifier`, `Registration_Meal_Banquet_Identifier`, `RegistrationVolunteer`, `Registration_Total_Amount`, `Registration_Paye_Method`, `Registration_Confirmation_Number`, `Registration_Transaction_Date_Time`,`invoice`,`log_id`,`payment_status`) VALUES (:Registration_Client_Identifier, :Registration_Product_Identifier, :Registration_First_Time_Indicator, :Registration_Meal_Lunch_Identifier, :Registration_Meal_Banquet_Identifier, :RegistrationVolunteer, :Registration_Total_Amount, :Registration_Paye_Method, :Registration_Confirmation_Number, :Registration_Transaction_Date_Time, :invoice,:log_id,:payment_status)";
			$sRegInsertQuery = $dbcon->prepare($regInsert_query);
			$sRegInsertQuery->bindParam(":Registration_Client_Identifier", $client_identifier);
			$sRegInsertQuery->bindParam(":Registration_Product_Identifier", $aPostArray['product']);
			$sRegInsertQuery->bindParam(":Registration_First_Time_Indicator", $aPostArray['ftc']);
			$sRegInsertQuery->bindParam(":Registration_Meal_Lunch_Identifier", $lunchId);
			$sRegInsertQuery->bindParam(":Registration_Meal_Banquet_Identifier", $banquetId);
			$sRegInsertQuery->bindParam(":RegistrationVolunteer", $volunteerInfo);
			//$sRegInsertQuery->bindParam(":Registration_Total_Amount", $choiceArray[1]);
			//$sRegInsertQuery->bindParam(":Registration_Total_Amount", $aPostArray['PAYMENTREQUEST_0_AMT']);
			$sRegInsertQuery->bindParam(":Registration_Total_Amount", $totalAmount);
			//$sRegInsertQuery->bindParam(":Registration_Paye_Method", $aPostArray['choice']);
			$sRegInsertQuery->bindParam(":Registration_Paye_Method", $aPostArray['ptype']);
			$sRegInsertQuery->bindValue(":Registration_Confirmation_Number", "");
			$sRegInsertQuery->bindParam(":Registration_Transaction_Date_Time", $date);
			$sRegInsertQuery->bindParam(":invoice", $aPostArray['invoice']);
			$sRegInsertQuery->bindValue(":log_id", "");
			$sRegInsertQuery->bindValue(":payment_status", "pending");
			$sMsg1 = ($sRegInsertQuery->execute()) ? 1 : 3;
			//print_r($dbcon->errorInfo());exit;
		//}
		
		/*if($deplicateCheck == "true" && $sMsg == 1){
			$insertQ = "INSERT INTO `admin_users`(`first_name`, `last_name`, `email`, `phone`, `password`, `role`, `identification_id`) VALUES (:first_name, :last_name, :email, :phone, :password, :role, :identification_id)";
			$sAdminUsersInsertQuery = $dbcon->prepare($insertQ);
			$sAdminUsersInsertQuery->bindParam(":first_name", $aPostArray['L_PAYMENTREQUEST_0_NAME0']);
			$sAdminUsersInsertQuery->bindParam(":last_name", $aPostArray['L_PAYMENTREQUEST_0_DESC0']);
			$sAdminUsersInsertQuery->bindParam(":email", $aPostArray['contact_email']);
			$sAdminUsersInsertQuery->bindParam(":phone", $aPostArray['h_phone']);
			$sAdminUsersInsertQuery->bindParam(":password", $md5);
			$sAdminUsersInsertQuery->bindValue(":role", "user");
			$sAdminUsersInsertQuery->bindParam(":identification_id", $client_identifier);
			$sAdminUsersInsertQuery->execute();
			$subject = SUB_USER_ADD;
			$message = MESSAGE_USER_ADD;			
			$message = str_replace("{NAME}", $aPostArray['L_PAYMENTREQUEST_0_NAME0'], $message);
			$message = str_replace("{USERNAME}", $aPostArray['L_PAYMENTREQUEST_0_NAME0'], $message);
			$message = str_replace("{NEW_PSWD}", $password, $message);
			
			sendMail($aPostArray['contact_email'], FROM_EMAIL, $subject, $message);
		}*/
        return $sMsg;
    }
    /*function addUser($aPostArray) {
		$date = gmdate('Y-m-d H:i:s');
		global $dbcon;
		$sMsg = 0;
		$deplicateCheck = "true";
		if(isset($logininfo['email'])){
			$deplicateCheck = "false";
		}
		if($deplicateCheck == "true") {
			$select_q = "SELECT * FROM Identification WHERE `Client_Email` = :email";
			$select_query = $dbcon->prepare($select_q);
			$select_query->bindParam(":email", $aPostArray['contact_email']);
			$select_query->execute();
			if($select_query->rowCount() > 0){
				$sMsg = 2;
			}
		}
		if(($deplicateCheck == "true" && $sMsg != 2) || ($deplicateCheck == "false")){
			$clubNo = $aPostArray['club_ref'];
			
			$e_level = (isset($aPostArray['e_level']) && count($aPostArray['e_level']) > 0) ? implode(",", $aPostArray['e_level']) : "";
			$l_level = (isset($aPostArray['l_level'])) ? $aPostArray['l_level'] : "";
			$c_level = (isset($aPostArray['c_level'])) ? $aPostArray['c_level'] : "";
			$languageNo = $aPostArray['language'];
			$volunteerInfo = (isset($aPostArray['volunteer']) && $aPostArray['volunteer'] == "yes" && isset($aPostArray['volunteer_level']) && count($aPostArray['volunteer_level']) > 0 )? implode(",", $aPostArray['volunteer_level']) : "";
			$volunteerInfo = (isset($aPostArray['other_volunteer_text']) && ($aPostArray['other_volunteer_text'] != "")) ? $volunteerInfo . ",Other:::".$aPostArray['other_volunteer_text'] : $volunteerInfo;
			
			$password = $this->generatePassword();
			$md5 = md5($password);
			
			$query = "INSERT INTO `Identification`(`Client_First_Name`,  `Client_Last_Name`, `Client_Email`, `Client_Home_Phone`, `Client_Cell_Phone`, `Client_Work_Phone`, `Client_Accessibility_Needs`, `Client_Allergies`, `Client_Club_Number`, `Client_Language_Type_Code`, `Client_Communication_Type_Code`, `Client_Leadership_Type_Code`, `Client_Other_Titles`, `Client_Password`, `Client_Role`) VALUES (:Client_First_Name, :Client_Last_Name, :Client_Email, :Client_Home_Phone, :Client_Cell_Phone, :Client_Work_Phone, :Client_Accessibility_Needs, :Client_Allergies, :Client_Club_Number, :Client_Language_Type_Code, :Client_Communication_Type_Code, :Client_Leadership_Type_Code, :Client_Other_Titles, :Client_Password, :Client_Role)";
			$sInsertQuery = $dbcon->prepare($query);
			
			$sInsertQuery->bindParam(":Client_First_Name", $aPostArray['L_PAYMENTREQUEST_0_NAME0']);
			
			$sInsertQuery->bindParam(":Client_Last_Name", $aPostArray['L_PAYMENTREQUEST_0_DESC0']);
			
			$sInsertQuery->bindParam(":Client_Email", $aPostArray['contact_email']);
			$sInsertQuery->bindParam(":Client_Home_Phone", $aPostArray['h_phone']);
			$sInsertQuery->bindParam(":Client_Cell_Phone", $aPostArray['cell_phone']);
			$sInsertQuery->bindParam(":Client_Work_Phone", $aPostArray['w_phone']);
			$sInsertQuery->bindParam(":Client_Accessibility_Needs", $aPostArray['accessibility']);
			$sInsertQuery->bindParam(":Client_Allergies", $aPostArray['allergies']);
			$sInsertQuery->bindParam(":Client_Club_Number", $clubNo);
			$sInsertQuery->bindParam(":Client_Language_Type_Code", $languageNo);
			$sInsertQuery->bindParam(":Client_Communication_Type_Code", $c_level);
			$sInsertQuery->bindParam(":Client_Leadership_Type_Code", $l_level);
			$sInsertQuery->bindParam(":Client_Other_Titles", $e_level);
			$sInsertQuery->bindParam(":Client_Password", $md5);
			$sInsertQuery->bindParam(":Client_Role", $aPostArray['Client_Role']);
			$sMsg = ($sInsertQuery->execute()) ? 1 : 3;
			$client_identifier = $dbcon->lastInsertId();
			
		
			$lunchId = (isset($aPostArray['mealCat1']) && ($aPostArray['mealCat1'] != "")) ? $aPostArray['mealCat1'] : "";
			$banquetId = (isset($aPostArray['mealCat2']) && ($aPostArray['mealCat2'] != "")) ? $aPostArray['mealCat2'] : "";
			$totalAmount = 0;
			
			$totalAmount = $this->getTotalAmount($aPostArray['product']);
			$regInsert_query = "INSERT INTO `Registrations`( `Registration_Client_Identifier`, `Registration_Product_Identifier`, `Registration_First_Time_Indicator`, `Registration_Meal_Lunch_Identifier`, `Registration_Meal_Banquet_Identifier`, `RegistrationVolunteer`, `Registration_Total_Amount`, `Registration_Paye_Method`, `Registration_Confirmation_Number`, `Registration_Transaction_Date_Time`,`invoice`,`log_id`,`payment_status`) VALUES (:Registration_Client_Identifier, :Registration_Product_Identifier, :Registration_First_Time_Indicator, :Registration_Meal_Lunch_Identifier, :Registration_Meal_Banquet_Identifier, :RegistrationVolunteer, :Registration_Total_Amount, :Registration_Paye_Method, :Registration_Confirmation_Number, :Registration_Transaction_Date_Time, :invoice,:log_id,:payment_status)";
			$sRegInsertQuery = $dbcon->prepare($regInsert_query);
			$sRegInsertQuery->bindParam(":Registration_Client_Identifier", $client_identifier);
			$sRegInsertQuery->bindParam(":Registration_Product_Identifier", $aPostArray['product']);
			$sRegInsertQuery->bindParam(":Registration_First_Time_Indicator", $aPostArray['ftc']);
			$sRegInsertQuery->bindParam(":Registration_Meal_Lunch_Identifier", $lunchId);
			$sRegInsertQuery->bindParam(":Registration_Meal_Banquet_Identifier", $banquetId);
			$sRegInsertQuery->bindParam(":RegistrationVolunteer", $volunteerInfo);
			
			$sRegInsertQuery->bindParam(":Registration_Total_Amount", $totalAmount);
			
			$sRegInsertQuery->bindParam(":Registration_Paye_Method", $aPostArray['ptype']);
			$sRegInsertQuery->bindValue(":Registration_Confirmation_Number", "");
			$sRegInsertQuery->bindParam(":Registration_Transaction_Date_Time", $date);
			$sRegInsertQuery->bindParam(":invoice", $aPostArray['invoice']);
			$sRegInsertQuery->bindValue(":log_id", "");
			$sRegInsertQuery->bindValue(":payment_status", "pending");
			$sMsg1 = ($sRegInsertQuery->execute()) ? 1 : 3;
			
		}
		
		if($deplicateCheck == "true" && $sMsg == 1){
			$insertQ = "INSERT INTO `admin_users`(`first_name`, `last_name`, `email`, `phone`, `password`, `role`, `identification_id`) VALUES (:first_name, :last_name, :email, :phone, :password, :role, :identification_id)";
			$sAdminUsersInsertQuery = $dbcon->prepare($insertQ);
			$sAdminUsersInsertQuery->bindParam(":first_name", $aPostArray['L_PAYMENTREQUEST_0_NAME0']);
			$sAdminUsersInsertQuery->bindParam(":last_name", $aPostArray['L_PAYMENTREQUEST_0_DESC0']);
			$sAdminUsersInsertQuery->bindParam(":email", $aPostArray['contact_email']);
			$sAdminUsersInsertQuery->bindParam(":phone", $aPostArray['h_phone']);
			$sAdminUsersInsertQuery->bindParam(":password", $md5);
			$sAdminUsersInsertQuery->bindValue(":role", "user");
			$sAdminUsersInsertQuery->bindParam(":identification_id", $client_identifier);
			$sAdminUsersInsertQuery->execute();
			$subject = SUB_USER_ADD;
			$message = MESSAGE_USER_ADD;			
			$message = str_replace("{NAME}", $aPostArray['L_PAYMENTREQUEST_0_NAME0'], $message);
			$message = str_replace("{USERNAME}", $aPostArray['L_PAYMENTREQUEST_0_NAME0'], $message);
			$message = str_replace("{NEW_PSWD}", $password, $message);
			
			sendMail($aPostArray['contact_email'], FROM_EMAIL, $subject, $message);
		}
        return $sMsg;
    } */
    
    fucntion getProductsOptionArrayDateLimited($confId) {
        global $dbcon;
        $result = array();
        $sSelectQ = "SELECT * FROM `Products` WHERE `Product_Conference_Number` = :Product_Conference_Number";
        $sSelectQuery = $dbcon->prepare($sSelectQ);
        $sSelectQuery->bindParam(":Product_Conference_Number", $confId);
        $sSelectQuery->execute();
        if ($sSelectQuery->rowCount() > 0) {
            $result = $sSelectQuery->fetchALL(PDO::FETCH_ASSOC);
        }
        return $result;

    }
	
	function getProductsOptionArray($confId){
		global $dbcon;
		$result = array();
		$sSelectQ = "SELECT * FROM `Products` WHERE `Product_Conference_Number` = :Product_Conference_Number";
		$sSelectQuery = $dbcon->prepare($sSelectQ);
		$sSelectQuery->bindParam(":Product_Conference_Number", $confId);
		$sSelectQuery->execute();
		if ($sSelectQuery->rowCount() > 0) {
			$result = $sSelectQuery->fetchALL(PDO::FETCH_ASSOC);			
		}
		return $result;
	} 
	
	function getProductNameById($Id){
		global $dbcon;
		$pdesc = "";
		$sSelectQ = "SELECT * FROM `Products` WHERE `Product_Identification` = :Product_Identification";
		$sSelectQuery = $dbcon->prepare($sSelectQ);
		$sSelectQuery->bindParam(":Product_Identification", $Id);
		$sSelectQuery->execute();
		if ($sSelectQuery->rowCount() > 0) {
			$result = $sSelectQuery->fetch(PDO::FETCH_ASSOC);	
			$pdesc = $result['Product_Title_EN'];//Product_Description
		}
		return $pdesc;
	}
	
	function getProductDataById($Id){
		global $dbcon;
		$result = array();
		$sSelectQ = "SELECT * FROM `Products` WHERE `Product_Identification` = :Product_Identification";
		$sSelectQuery = $dbcon->prepare($sSelectQ);
		$sSelectQuery->bindParam(":Product_Identification", $Id);
		$sSelectQuery->execute();
		if ($sSelectQuery->rowCount() > 0) {
			$result = $sSelectQuery->fetch(PDO::FETCH_ASSOC);
		}
		return $result;
	}
	
	function getProductsOptionString($confId, $product = ""){
		global $dbcon;
		$options_String = "";
		$sSelectQ = "SELECT * FROM `Products` WHERE `Product_Conference_Number` = :Product_Conference_Number";
		$sSelectQuery = $dbcon->prepare($sSelectQ);
		$sSelectQuery->bindParam(":Product_Conference_Number", $confId);
		$sSelectQuery->execute();
		if ($sSelectQuery->rowCount() > 0) {
			$result = $sSelectQuery->fetchALL(PDO::FETCH_ASSOC);
			foreach ($result as $products) {
				$selected = ($products['Product_Identification'] == $product) ? "checked" : "";
				$options_String .= '<label for="'. $products['Product_Title_EN'] .'" class="control-label"><input type="radio"
								value="'. $products['Product_Identification'] .'" id="'. $products['Product_Title_EN'] .'" name="product" class="input-block-level" required>'. $products['Product_Title_EN'] . '($'.$products['Product_Price'].')' . '</input>
							</label>';
			}
		}
		return $options_String;
	}
	
	function getMealsOptionString($confId, $mealCat, $product = ""){
		global $dbcon;
		$options_String = "";
		$sSelectQ = "SELECT * FROM `Meals` WHERE `Meal_Conference_ID` = :Meal_Conference_ID AND `Meal_Category` = :Meal_Category";
		$sSelectQuery = $dbcon->prepare($sSelectQ);
		$sSelectQuery->bindParam(":Meal_Conference_ID", $confId);
		$sSelectQuery->bindParam(":Meal_Category", $mealCat);
		$sSelectQuery->execute();
		if ($sSelectQuery->rowCount() > 0) {
			$result = $sSelectQuery->fetchALL(PDO::FETCH_ASSOC);
			foreach ($result as $products) {
				$selected = ($products['Meal_ID'] == $product) ? "checked" : "";
				$options_String .= '<label for="'. $products['Meal_Item'] .'" class="control-label"><input type="radio"
								value="'. $products['Meal_ID'] .'" id="'. $products['Meal_Item'] .'" name="'.$mealCat.'" class="input-block-level '.$mealCat.'" required>'. $products['Meal_Item'] . '</input>
							</label>';
			}
		}
		return $options_String;
	}
	
	function getTotalAmount($productId){
		global $dbcon;
		$price = 0;
		$product = $this->getProductById($productId);
		$productPrice = (isset($product['Product_Price'])) ? $product['Product_Price'] : 0;
		$price = $productPrice;
		return $price;
	}
	
	function getTotalAmount_bc($productId, $meal1Id, $meal2Id){
		global $dbcon;
		$price = 0;
		$product = $this->getProductById($productId);
		$meal1 = $this->getMealById($meal1Id);
		$meal2 = $this->getMealById($meal2Id);
		$productPrice = (isset($product['Product_Price'])) ? $product['Product_Price'] : 0;
		$meal1Price = (isset($meal1['Meal_Price'])) ? $meal1['Meal_Price'] : 0;
		$meal2Price = (isset($meal2['Meal_Price'])) ? $meal2['Meal_Price'] : 0;
		$price = $productPrice + $meal1Price + $meal2Price;
		return $price;
	}
	
	function getProductById($id){
		global $dbcon;
		$result = array();
		$sSelectQ = "SELECT * FROM `Products` WHERE Product_Identification = :Product_Identification";
		$sSelectQuery = $dbcon->prepare($sSelectQ);
		$sSelectQuery->bindParam(":Product_Identification", $id);
		$sSelectQuery->execute();
		if ($sSelectQuery->rowCount() > 0) {
			$result = $sSelectQuery->fetch(PDO::FETCH_ASSOC);
		}
		return $result;
	}
	
	function getMealById($id){
		global $dbcon;
		$result = array();
		$sSelectQ = "SELECT * FROM `Meals` WHERE Meal_ID = :Meal_ID";
		$sSelectQuery = $dbcon->prepare($sSelectQ);
		$sSelectQuery->bindParam(":Meal_ID", $id);
		$sSelectQuery->execute();
		if ($sSelectQuery->rowCount() > 0) {
			$result = $sSelectQuery->fetch(PDO::FETCH_ASSOC);
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

   function getUserByEmail($email) {
            global $dbcon;
            $result = array();
	    //$select_q = "SELECT * FROM Identification WHERE Client_Email = :email ";
            $select_q = "SELECT i.*,c.* FROM Identification as i join Clubs as c on c.Club_Number = i.Client_Club_Number WHERE i.Client_Email = :email";
            $select_query = $dbcon->prepare($select_q);
	    $select_query->bindParam(":email", $email);
	    $select_query->execute();
            // print_r($dbcon->errorInfo());
            if($select_query->rowCount() > 0){
               $result = $select_query->fetch(PDO::FETCH_ASSOC);     
            }
            return $result;
    }
	
	function getClubNames(){
		global $dbcon;		
        $result = array();
		$select_q = "SELECT * FROM Clubs";
        $select_query = $dbcon->prepare($select_q);
	    $select_query->execute();
             //print_r($dbcon->errorInfo());
            if($select_query->rowCount() > 0){				
               $clubNames = $select_query->fetchAll(PDO::FETCH_ASSOC);
				foreach($clubNames as $data){
					//$result[] = $data['Club_Name'] . "(" . $data['Club_Area'] . " " . $data['Club_Division'] . ")";
					$result[] = $data['Club_Name'];
				}
            }
			//print_r($result);exit;
            return $result;
	}
	
	function getClubNamesWithDetails(){
		global $dbcon;
        $result = array();
		$select_q = "SELECT * FROM Clubs";
        $select_query = $dbcon->prepare($select_q);
	    $select_query->execute();
            // print_r($dbcon->errorInfo());
            if($select_query->rowCount() > 0){
               $clubs = $select_query->fetchAll(PDO::FETCH_ASSOC); 
				foreach($clubs as $data){
					$temp = array();
					//$temp['Club_Number'] = $data['Club_Number'];
					//$temp['Club_Division'] = $data['Club_Division'];
					//$temp['Club_Area'] = $data['Club_Area'];
					//$temp['Club_Name'] = $data['Club_Name'];
					$temp['Number_For_Club'] = $data['Number_For_Club'];
					//$key = $data['Club_Name'] . "(" . $data['Club_Area'] . " " . $data['Club_Division'] . ")";
					//$key = $data['Club_Name'];
					$key = $data['Number_For_Club'];
					$result[$key] = $temp;
				}
            }
            return json_encode($result);
	}
	
	function getConfrences(){
		global $dbcon;
        $result = array();
		$select_q = "SELECT * FROM Conference";
		$select_query = $dbcon->prepare($select_q);
	    $select_query->execute();
		if($select_query->rowCount() > 0){
			$result = $select_query->fetchAll(PDO::FETCH_ASSOC);
		}
		return $result;
	}
	
	function getLeaderLevels(){
		global $dbcon;
        $result = array();
		$select_q = "SELECT * FROM Leader_Levels";
		$select_query = $dbcon->prepare($select_q);
	    $select_query->execute();
		if($select_query->rowCount() > 0){
			$result = $select_query->fetchAll(PDO::FETCH_ASSOC);
		}
		return $result;
	}
	
	function getLanguages(){
		global $dbcon;
        $result = array();
		$select_q = "SELECT * FROM Language";
		$select_query = $dbcon->prepare($select_q);
	    $select_query->execute();
		if($select_query->rowCount() > 0){
			$result = $select_query->fetchAll(PDO::FETCH_ASSOC);
		}
		return $result;
	}
	
	function getCoferenceTitleById($id, $lang="en"){
		global $dbcon;
        $confTitle = "";
		$select_q = "SELECT * FROM Conference WHERE Conference_Identifier = :Conference_Identifier";
		$select_query = $dbcon->prepare($select_q);
	    $select_query->bindParam(":Conference_Identifier", $id);
		$select_query->execute();
		if($select_query->rowCount() > 0){
			$result = $select_query->fetch(PDO::FETCH_ASSOC);
			$confTitle = ($lang == "en") ? $result['Conference_Title_EN'] : $result['Conference_Title_FR'];
		}
		return $confTitle;
	}
	
	function getCoferenceDataById($id, $lang="en"){
		global $dbcon;
        $result = array();
		$select_q = "SELECT * FROM Conference WHERE Conference_Identifier = :Conference_Identifier";
		$select_query = $dbcon->prepare($select_q);
	    $select_query->bindParam(":Conference_Identifier", $id);
		$select_query->execute();
		if($select_query->rowCount() > 0){
			$result = $select_query->fetch(PDO::FETCH_ASSOC);
		}
		return $result;
	}
	
	function getClubNumber($cName){
		global $dbcon;
        $confTitle = "";
		$select_q = "SELECT * FROM Clubs WHERE Club_Name = :Club_Name";
		$select_query = $dbcon->prepare($select_q);
	    $select_query->bindParam(":Club_Name", $cName);
		$select_query->execute();
		if($select_query->rowCount() > 0){
			$result = $select_query->fetch(PDO::FETCH_ASSOC);
			//$confTitle = ($lang == "en") ? $result['Conference_Title_EN'] : $result['Conference_Title_FR'];
			$confTitle = $result['Number_For_Club'] . ":::" . $result['Club_Division'] . ":::" . $result['Club_Number'];
		}
		return $confTitle;
	}
	
	function getLatestConferenceIdByCatogery($confCategory){
		global $dbcon;
        $result = "";
		$select_q = "SELECT * FROM `Conference` where Conference_Start_Date = (select max(Conference_Start_Date) as maxdate FROM `Conference` WHERE `conference_category` = :conference_category)";
		$select_query = $dbcon->prepare($select_q);
	    $select_query->bindParam(":conference_category", $confCategory);
		$select_query->execute();
		if($select_query->rowCount() > 0){
			$resultArray = $select_query->fetch(PDO::FETCH_ASSOC);
			$result = $resultArray['Conference_Identifier'];
		}
		return $result;
	}
}
?>
