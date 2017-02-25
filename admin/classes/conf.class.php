<?php
class CONF {	 
    function addConf($aPostArray) {
		$date = gmdate('Y-m-d H:i:s');
		global $dbcon;
		$select_q = "SELECT `Conference_Title_EN` FROM Conference WHERE `Conference_Title_EN` = :title";
		$select_query = $dbcon->prepare($select_q);
		$select_query->bindParam(":title", $aPostArray['title_en']);
		$select_query->execute();		
		if($select_query->rowCount() > 0){
			$sMsg = 2;
		}else{
			//clubs table
			$conference_insert_query = "INSERT INTO `Conference`(`Conference_Title_EN`, `Conference_Title_FR`, `Conference_Theme_EN`, `Conference_Theme_FR`, `Conference_Start_Date`, `Conference_End_Date`, `Conference_website_link`, `contact_ph`, `contact_email`, `conference_category`) VALUES (:Conference_Title_EN, :Conference_Title_FR, :Conference_Theme_EN, :Conference_Theme_FR, :Conference_Start_Date, :Conference_End_Date, :Conference_website_link, :contact_ph, :contact_email, :conference_category)";
			$sConfInsertQuery = $dbcon->prepare($conference_insert_query);
			$sConfInsertQuery->bindParam(":Conference_Title_EN", $aPostArray['title_en']);
			$sConfInsertQuery->bindParam(":Conference_Title_FR", $aPostArray['title_fr']);
			$sConfInsertQuery->bindParam(":Conference_Theme_EN", $aPostArray['theme_en']);
			$sConfInsertQuery->bindParam(":Conference_Theme_FR", $aPostArray['theme_fr']);
			$sConfInsertQuery->bindParam(":Conference_Start_Date", $aPostArray['c_start']);
			$sConfInsertQuery->bindParam(":Conference_End_Date", $aPostArray['c_end']);
			$sConfInsertQuery->bindParam(":Conference_website_link", $aPostArray['c_website_link']);
			$sConfInsertQuery->bindParam(":contact_ph", $aPostArray['c_ph']);
			$sConfInsertQuery->bindParam(":contact_email", $aPostArray['c_email']);
			$sConfInsertQuery->bindParam(":conference_category", $aPostArray['conference_category']);
			//print_r($dbcon->errorInfo());			
			$sMsg = ($sConfInsertQuery->execute()) ? 1 : 3;
		}
        return $sMsg;
    } 
	
	function getConfs() {
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
	
	function addProd($aPostArray){
		global $dbcon;
		$presentConfData = $this->getConfById($aPostArray['conf_id']);
		$prodMealsCat = (isset($aPostArray['meals_cat']) && count($aPostArray['meals_cat']) > 0) ? implode("," , $aPostArray['meals_cat']) : "";
		$product_insert_query = "INSERT INTO `Products`(`Product_Conference_Number`, `Product_Title_EN`, `Product_Title_FR`, `Product_Description`, `Product_Price`, `Product_Effective_Date_Time`, `Product_Expiry_Date_Time`, `product_meals_display`, `product_meals_categories`) VALUES (:Product_Conference_Number, :Product_Title_EN, :Product_Title_FR, :Product_Description, :Product_Price, :Product_Effective_Date_Time, :Product_Expiry_Date_Time, :product_meals_display, :product_meals_categories)";
			$sProdInsertQuery = $dbcon->prepare($product_insert_query);
			$sProdInsertQuery->bindParam(":Product_Conference_Number", $aPostArray['conf_id']);
			$sProdInsertQuery->bindParam(":Product_Title_EN", $aPostArray['title_en']);
			$sProdInsertQuery->bindParam(":Product_Title_FR", $aPostArray['title_fr']);
			$sProdInsertQuery->bindParam(":Product_Description", $aPostArray['prod_desc']);
			$sProdInsertQuery->bindParam(":Product_Price", $aPostArray['prod_price']);
			$sProdInsertQuery->bindParam(":Product_Effective_Date_Time", $aPostArray['p_start']);
			$sProdInsertQuery->bindParam(":Product_Expiry_Date_Time", $aPostArray['p_end']);
			$sProdInsertQuery->bindParam(":product_meals_display", $aPostArray['meals_display']);
			$sProdInsertQuery->bindParam(":product_meals_categories", $prodMealsCat);
			//print_r($dbcon->errorInfo());			
			$sMsg = ($sProdInsertQuery->execute()) ? 1 : 3;
			return $sMsg;
	}
	
	function addMeal($aPostArray){
		global $dbcon;
		$meals_insert_query = "INSERT INTO `Meals`(`Meal_Conference_ID`, `Meal_Category`, `Meal_Item`,  `Meal_Description_EN`, `Meal_Description_FR`, `Meal_Max_Quantity`) VALUES (:Meal_Conference_ID, :Meal_Category, :Meal_Item,:Meal_Description_EN,:Meal_Description_FR,:Meal_Max_Quantity )";
		$sMealInsertQuery = $dbcon->prepare($meals_insert_query);
		$sMealInsertQuery->bindParam(":Meal_Conference_ID", $aPostArray['conf_id']);
		$sMealInsertQuery->bindParam(":Meal_Category", $aPostArray['meal_cat']);
		$sMealInsertQuery->bindParam(":Meal_Item", $aPostArray['meal_item']);
		//$sMealInsertQuery->bindParam(":Meal_Price", $aPostArray['meal_price']); `Meal_Price`, :Meal_Price,
		$sMealInsertQuery->bindParam(":Meal_Description_EN", $aPostArray['meal_desc_en']);
		$sMealInsertQuery->bindParam(":Meal_Description_FR", $aPostArray['meal_desc_fr']);
		$sMealInsertQuery->bindParam(":Meal_Max_Quantity", $aPostArray['meal_max_quan']);
		//print_r($dbcon->errorInfo());			
		$sMsg = ($sMealInsertQuery->execute()) ? 1 : 3;
		return $sMsg;
	}
	
	function getConfById($id) {
		global $dbcon;
		$result = array();
		$select_q = "SELECT * FROM Conference WHERE `Conference_Identifier` = :Conference_Identifier";
		$select_query = $dbcon->prepare($select_q);
		$select_query->bindParam(":Conference_Identifier", $id);
		$select_query->execute();		
		if($select_query->rowCount() > 0){
			$result = $select_query->fetch(PDO::FETCH_ASSOC);
		}
		return $result;
	}
}
?>
