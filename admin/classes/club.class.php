<?php
class CLUB {	 
    function addClub($aPostArray) {
		$date = gmdate('Y-m-d H:i:s');
		global $dbcon;
		/*$select_q = "SELECT `Conference_Title_EN` FROM Conference WHERE `Conference_Title_EN` = :title";
		$select_query = $dbcon->prepare($select_q);
		$select_query->bindParam(":title", $aPostArray['title_en']);
		$select_query->execute();		
		if($select_query->rowCount() > 0){
			$sMsg = 2;
		}else{*/
			//clubs table
			$conference_insert_query = "INSERT INTO `Clubs`(`Club_Division`, `Club_Area`, `Club_Name`, `Number_For_Club`) VALUES (:Club_Division, :Club_Area, :Club_Name, :Number_For_Club)";
			$sConfInsertQuery = $dbcon->prepare($conference_insert_query);
			$sConfInsertQuery->bindParam(":Club_Division", $aPostArray['cdivision']);
			$sConfInsertQuery->bindParam(":Club_Area", $aPostArray['carea']);
			$sConfInsertQuery->bindParam(":Club_Name", $aPostArray['cname']);
			$sConfInsertQuery->bindParam(":Number_For_Club", $aPostArray['cnumber']);
			//print_r($dbcon->errorInfo());exit;			
			$sMsg = ($sConfInsertQuery->execute()) ? 1 : 3;
		//}
        return $sMsg;
    } 
}
?>
