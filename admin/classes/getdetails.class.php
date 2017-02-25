<?php
class DETAILS {	

    function getRegDetails(){
		global $dbcon, $start_limit, $searchstring, $s;
		if($searchstring != ""){
			$searchCond = "WHERE ( i.Client_First_Name LIKE '%".$s."%' OR  c.Club_Name LIKE '%".$s."%' )";
		} else{
			$searchCond = " ";
		}
       /* $sSelectQ = "SELECT * FROM " . DEVICE_HISTORY. $searchCond ." ORDER BY id ASC LIMIT ".$start_limit.",".ROW_PER_PAGE;
	    . $searchCond ." ORDER BY reg.Registration_Number ASC LIMIT ".$start_limit.",".ROW_PER_PAGE
	   */	
	   $sSelectQ = "SELECT reg.Registration_Number,reg.Registration_Meal_Lunch_Identifier,reg.Registration_Meal_Banquet_Identifier,i.Client_First_Name,i.Client_Last_Name,i.Client_Club_Number,c.Club_Name, p.Product_Title_En,p.Product_Price,conf.Conference_Title_EN FROM `Registrations` as reg join Identification as i on i.Client_Number = reg.Registration_Client_Identifier left join Clubs as c on c.Club_Number = i.Client_Club_Number join Products as p on  p.product_Identification = reg.Registration_Product_Identifier join Conference as conf on conf.Conference_Identifier = p.Product_Conference_Number  ". $searchCond ." LIMIT ".$start_limit.",".ROW_PER_PAGE;
	   //echo $sSelectQ;exit;
        $sSelectQuery = $dbcon->prepare($sSelectQ);		
        $sSelectQuery->execute();
        $aSelectQuery_result = $sSelectQuery->fetchAll(PDO::FETCH_ASSOC);
        return $aSelectQuery_result;
	}
	
    function getMeals($id) {
		global $dbcon;$mealItem = "";
		$select_q = "SELECT * FROM `Meals` WHERE `Meal_ID` = :Meal_ID";
		$select_query = $dbcon->prepare($select_q);
		$select_query->bindParam(":Meal_ID", $id);
		$select_query->execute();		
		if($select_query->rowCount() > 0){
			$result = $select_query->fetch(PDO::FETCH_ASSOC);
			$mealItem = $result['Meal_Item'] . "($".$result['Meal_Price'].")"; 
		}
        return $mealItem;
    } 
	
	function getClubName($id){
		global $dbcon;$clubname = "";
		$select_q = "SELECT * FROM `Clubs` WHERE `Club_Number` = :Club_Number";
		$select_query = $dbcon->prepare($select_q);
		$select_query->bindParam(":Club_Number", $id);
		$select_query->execute();		
		if($select_query->rowCount() > 0){
			$result = $select_query->fetch(PDO::FETCH_ASSOC);
			$clubname = $result['Club_Name']; 
		}
        return $clubname;
	}
	
	function getProductDetails($confId){
	   global $dbcon, $start_limit;
	   $aSelectQuery_result = array();
	   $sSelectQ = "SELECT * FROM Products WHERE `Product_Conference_Number` = :Product_Conference_Number LIMIT ".$start_limit.",".ROW_PER_PAGE;
        $sSelectQuery = $dbcon->prepare($sSelectQ);	
		$sSelectQuery->bindParam(":Product_Conference_Number", $confId);
        $sSelectQuery->execute();
		if($sSelectQuery->rowCount() > 0){
			$aSelectQuery_result = $sSelectQuery->fetchAll(PDO::FETCH_ASSOC);
		}        
        return $aSelectQuery_result;
	}
	
	function getProductDetailsById($id){
		global $dbcon;
		$aSelectQuery_result = array();
		$sSelectQ = "SELECT * FROM Products WHERE `Product_Identification` = :Product_Identification";
        $sSelectQuery = $dbcon->prepare($sSelectQ);	
		$sSelectQuery->bindParam(":Product_Identification", $id);
        $sSelectQuery->execute();
		if($sSelectQuery->rowCount() > 0){
			$aSelectQuery_result = $sSelectQuery->fetch(PDO::FETCH_ASSOC);
		}   
		//print_r($aSelectQuery_result);exit;
        return $aSelectQuery_result;
	}
	
	function editProduct($aPostArray){
		global $dbcon;
		$sUpdateQ = "UPDATE Products SET `Product_Title_EN` = :Product_Title_EN, `Product_Title_FR` = :Product_Title_FR, `Product_Description` = :Product_Description, `Product_Price` = :Product_Price, `Product_Effective_Date_Time` = :Product_Effective_Date_Time, `Product_Expiry_Date_Time`=:Product_Expiry_Date_Time WHERE  `Product_Identification` = :Product_Identification";
        $sSelectQuery = $dbcon->prepare($sUpdateQ);
		$sSelectQuery->bindParam(":Product_Title_EN", $aPostArray['title_en']);
		$sSelectQuery->bindParam(":Product_Title_FR", $aPostArray['title_fr']);
		$sSelectQuery->bindParam(":Product_Description", $aPostArray['prod_desc']);
		$sSelectQuery->bindParam(":Product_Price", $aPostArray['prod_price']);
		$sSelectQuery->bindParam(":Product_Effective_Date_Time", $aPostArray['p_start']);
		$sSelectQuery->bindParam(":Product_Expiry_Date_Time", $aPostArray['p_end']);		
		$sSelectQuery->bindParam(":Product_Identification", $aPostArray['p_id']);
        $result = ($sSelectQuery->execute()) ? 1 : 3;
		return $result;
	}
}
?>
