<?php
	include("../includes/configuration.php");
   /*
    * Script:    DataTables server-side script for PHP and MySQL
    * Copyright: 2010 - Allan Jardine
    * License:   GPL v2 or BSD (3-point)
    */


   $aColumns = array(
     'Registrations.Registration_Number', // 0
     'Club_Name',       // 1 etc
'Club_Division',
     'Conference_Title_EN',
'conference_category',
     //'Conference_Title_FR', //'regie_dslam_type_id',//DATE_FORMAT(regie_uitgifte_bsse,"%m-%d")',
     'Client_First_Name',
	// 'Client_Last_Name',
     'Client_Email',
     'Product_Price',
	// 'm1.Meal_Category AS m1_cat',
	 'm1.Meal_Item AS m1_item',
	// 'm1.Meal_Price AS m1_price',
	// 'm2.Meal_Category AS m2_cat',
	 'm2.Meal_Item AS m2_item',
	// 'm2.Meal_Price AS m2_price',
     'Conference_Start_Date', 
     'Conference_End_Date',
 'Registration_Paye_Method',
     'Registration_Confirmation_Number',
'payment_status'

     /*,
     'iptv_status.name AS iptv_status', //'regie_status_iptv',
     'wba_status.name AS wba_status', //regie_status_wba',
     'regina_dslams.created AS created',
     'regina_dslams.updated AS updated',
     'u.username AS username'*/
        
   );
    
   /* Indexed column (used for fast and accurate table cardinality) */
   $sIndexColumn = "Registrations.Registration_Number";
 
   /* DB table to use */
   $sTable = "Registrations";

   // Joins
   
   $sJoin = ' JOIN Identification ON Identification.Client_Number = Registrations.Registration_Client_Identifier';
   $sJoin .= ' LEFT JOIN Clubs ON Clubs.Club_Number = Identification.Client_Number';
   $sJoin .= ' LEFT JOIN Meals as m1
    ON m1.Meal_ID = Registrations.Registration_Meal_Lunch_Identifier';
	$sJoin .= ' JOIN Meals as m2
    ON m2.Meal_ID = Registrations.Registration_Meal_Banquet_Identifier';
   $sJoin .= ' JOIN Products ON Products.Product_Identification = Registrations.Registration_Product_Identifier';
   $sJoin .= ' JOIN Conference ON Conference.Conference_Identifier = Products.Product_Conference_Number WHERE Conference.conference_category="fall"';
 
   // get the database credentials from the configfile
  // $database = new DATABASE_CONFIG;
  // $db = get_class_vars(get_class($database));
    
    /* MySQL connection */
   $gaSql['user']       = DB_USER_NAME;
	$gaSql['password']   = DB_PASSWORD;
	$gaSql['db']         = DB_NAME;
	$gaSql['server']     = DB_HOST;
   // for html links
 //  App::import('Helper', 'Html');
   //$html = new HtmlHelper();
    
   // get or post
   $_METHOD = $_GET;
   /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    * If you just want to use the basic configuration for DataTables with PHP server-side, there is
    * no need to edit below this line
    */
 
  /* $gaSql['link'] =  mysql_connect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
     die( 'Could not open connection to server' );
 
   mysql_select_db( $gaSql['db'], $gaSql['link'] ) or
     die( 'Could not select database '. $gaSql['db'] );*/
if ( ! $gaSql['link'] = mysql_connect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) )
	{
		fatal_error( 'Could not open connection to server' );
	}

	if ( ! mysql_select_db( $gaSql['db'], $gaSql['link'] ) )
	{
		fatal_error( 'Could not select database ' );
	}
 
   $sLimit = "";
   if ( isset( $_METHOD['iDisplayStart'] ) && $_METHOD['iDisplayLength'] != '-1' )
   {
     $sLimit = "LIMIT ".mysql_real_escape_string( $_METHOD['iDisplayStart'] ).", ".
       mysql_real_escape_string( $_METHOD['iDisplayLength'] );
   }
 
   if ( isset( $_METHOD['iSortCol_0'] ) )
   {
     $sOrder = "ORDER BY  ";
     for ( $i=0 ; $i<intval( $_METHOD['iSortingCols'] ) ; $i++ )
     {
       if ( $_METHOD[ 'bSortable_'.intval($_METHOD['iSortCol_'.$i]) ] == "true" )
       {
         $sFieldname = $aColumns[ intval( $_METHOD['iSortCol_'.$i] ) ];
         if(strpos($sFieldname, " AS ") !== false) {
           $arr = split(" ", $sFieldname);
           $sFieldname = $arr[0];
         }         
         $sOrder .= $sFieldname . "
           ".mysql_real_escape_string( $_METHOD['sSortDir_'.$i] ) .", ";
       }
     }
 
     $sOrder = substr_replace( $sOrder, "", -2 );
     if ( $sOrder == "ORDER BY" )
     {
       $sOrder = "";
     }
   }
 
   $sWhere = "";
   if ( $_METHOD['sSearch'] != "" )
   {
     $sWhere = "WHERE (";
     for ( $i=0 ; $i<count($aColumns) ; $i++ )
     {
       $sFieldname = $aColumns[$i]; // iptv_uitgezet.username AS iptv_uitgezet
       if(strpos($sFieldname, " AS ") !== false) {
         $arr = split(" ", $sFieldname);
         $sFieldname = $arr[0];
       }
       $sWhere .= $sFieldname." LIKE '%".mysql_real_escape_string( $_METHOD['sSearch'] )."%' OR ";
     }
     $sWhere = substr_replace( $sWhere, "", -3 );
     $sWhere .= ')';
   }
 
   /* Individual column filtering */
   for ( $i=0 ; $i<count($aColumns) ; $i++ )
   {
     if ( $_METHOD['bSearchable_'.$i] == "true" && $_METHOD['sSearch_'.$i] != '' )
     {
       if ( $sWhere == "" )
       {
         $sWhere = "WHERE ";
       }
       else
       {
         $sWhere .= " AND ";
       }
       $sFieldname = $aColumns[$i];
       if(strpos($sFieldname, " AS ") !== false) {
         $arr = split(" ", $sFieldname);
         $sFieldname = $arr[0];
       }
       $sWhere .= $sFieldname." LIKE '%".mysql_real_escape_string($_METHOD['sSearch_'.$i])."%' ";
     }
   }
 
 
   /*
    * SQL queries
    * Get data to display
    */
   $sQuery = "
     SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
     FROM   $sTable
     $sJoin
     $sWhere
     $sOrder
     $sLimit
   ";
   
   $sDataQuery = $sQuery;
   $rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
 
   /* Data set length after filtering */
   $sQuery = "
     SELECT FOUND_ROWS()
   ";
   $rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
   $aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
   $iFilteredTotal = $aResultFilterTotal[0];
 
   /* Total data set length */
   $sQuery = "
     SELECT COUNT(".$sIndexColumn.")
     FROM   $sTable
   ";
   $rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
   $aResultTotal = mysql_fetch_array($rResultTotal);
   $iTotal = $aResultTotal[0];
 
 
   /*
    * Output
    */
   $output = array(
     "sEcho" => intval($_METHOD['sEcho']),
     "iTotalRecords" => $iTotal,
     "iTotalDisplayRecords" => $iFilteredTotal,
     "aaData" => array(),
     "sQuery" => $sDataQuery
   );
 
   while ( $aRow = mysql_fetch_array( $rResult ) )
   {
     $row = array();
     for ( $i=0 ; $i<count($aColumns) ; $i++ )
     {
       if(strpos($aColumns[$i], " AS ") !== false) {
         $arr = split(" ", $aColumns[$i]);
         //$row[] = $this->truncate( $aRow[ $arr[2] ], 20);
		 $row[] = $aRow[ $arr[2] ];
       }
       else if ( $aColumns[$i] == "version" )
       {
         /* Special output formatting for 'version' column */
          $row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
       }
       else if ( $aColumns[$i] != ' ' )
       {
         //General output 
         if($aColumns[$i]=="Registrations.Registration_Number") {
           //$row[] = $html->link('edit', '/regina_dslams/edit/'.$aRow[ 'Registration_Number' ] );
		   $row[] = $aRow[ 'Registration_Number' ];
         } else {
         //$row[] = $this->truncate($aRow[ $aColumns[$i] ], 20); // truncate long results
         $row[] = $aRow[ $aColumns[$i] ];
		 }
       }
     }
     $output['aaData'][] = $row;
   }
  
 
   echo json_encode( $output );
  // exit();
?>
