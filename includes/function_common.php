<?php

/******************************************************************
 * Ideabytes Software India Pvt Ltd.                              *
 * 50 Jayabheri Enclave, Gachibowli, HYD                          *
 * Created Date : 05/10/2015                                      *
 * Created By : Gayathri D                                        *
 * Vision : Project Toast Masters                                 *  
 * Modified by : Gayathri D     Date : 05/10/2015    Version : 1  *
 * Description : Common functions                                 *
 *****************************************************************/
 
function doPages($page_size, $thepage, $query_string, $total = 0) {
    //per page count
    $index_limit = 5;


    //set the query string to blank, then later attach it with $query_string
    $query = '';

    if (strlen($query_string) > 0) {
        $query = "&" . $query_string;
    }

    //get the current page number example: 3, 4 etc: see above method description
    $current = get_current_page();

    $total_pages = ceil($total / $page_size);
    $start = max($current - intval($index_limit / 2), 1);
    $end = $start + $index_limit - 1;

    $pagging = '<div class="paging">';

    if ($current == 1) {
        $pagging .= '<span class="prn">< Previous</span> ';
    } else {
        $i = $current - 1;
        $pagging .= '<a class="prn" title="go to page ' . $i . '" rel="nofollow" href="' . $thepage . '?page=' . $i . $query . '">< Previous</a> ';
        $pagging .= '<span class="prn">...</span> ';
    }

    if ($start > 1) {
        $i = 1;
        $pagging .= '<a title="go to page ' . $i . '" href="' . $thepage . '?page=' . $i . $query . '">' . $i . '</a> ';
    }

    for ($i = $start; $i <= $end && $i <= $total_pages; $i++) {
        if ($i == $current) {
            $pagging .= '<span>' . $i . '</span> ';
        } else {
            $pagging .= '<a title="go to page ' . $i . '" href="' . $thepage . '?page=' . $i . $query . '">' . $i . '</a> ';
        }
    }

    if ($total_pages > $end) {
        $i = $total_pages;
        $pagging .= '<a title="go to page ' . $i . '" href="' . $thepage . '?page=' . $i . $query . '">' . $i . '</a> ';
    }

    if ($current < $total_pages) {
        $i = $current + 1;
        $pagging .= '<span class="prn">...</span> ';
        $pagging .= '<a class="prn" title="go to page ' . $i . '" rel="nofollow" href="' . $thepage . '?page=' . $i . $query . '">Next ></a> ';
    } else {
        $pagging .= '<span class="prn">Next ></span> ';
    }

    //if nothing passed to method or zero, then dont print result, else print the total count below:
    if ($total != 0) {
        //prints the total result count just below the paging
        $pagging .= '(' . $total . ' Records)';
    }
    $pagging .= '</div>';

    return $pagging;
}

//end of method doPages()
//Both of the functions below required

function check_integer($which) {
    if (isset($_REQUEST[$which])) {
        if (intval($_REQUEST[$which]) > 0) {
            //check the paging variable was set or not,
            //if yes then return its number:
            //for example: ?page=5, then it will return 5 (integer)
            return intval($_REQUEST[$which]);
        } else {
            return false;
        }
    }
    return false;
}

//end of check_integer()

function get_current_page() {
    if (($var = check_integer('page'))) {
        //return value of 'page', in support to above method
        return $var;
    } else {
        //return 1, if it wasnt set before, page=1
        return 1;
    }
}

//end of method get_current_page()

/**
 * Returns an encrypted & utf8-encoded
 */
function encrypt($pure_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
    return $encrypted_string;
}

/**
 * Returns decrypted original string
 */
function decrypt($encrypted_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;
}

function generatePassword_old($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}

function generatePassword($length = 8) {
    $chars_1 = 'abcdefghijklmnopqrstuvwxyz';
    $chars_2 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $chars_3 = '0123456789';
    $chars_ = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    for ($i = 1, $result = ''; $i <= $length; $i++) {
        $j = ($i <= 3) ? $chars_ . $i : $chars_;
        $count = mb_strlen($j);
        $index = rand(0, $count - 1);
        $result .= mb_substr($j, $index, 1);
    }

    return $result;
}

function sendMail($to_email, $from_email, $subject, $message) {
    $headers = 'From:' . $from_email . "\r\n";
    $headers .= "Content-type: text/html; charset=\"UTF-8\"; format=flowed \r\n";
    $headers .= "Mime-Version: 1.0 \r\n";
    $headers .= "Content-Transfer-Encoding: quoted-printable \r\n";
    mail($to_email, $subject, $message, $headers);
}

function sendMailForResetPassword($email, $subject, $message) {
    @ $headers = "From:" . FROM_EMAIL_RESET_PASSWORD . "\r\n";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    mail($email, $subject, $message, $headers);
}

function dateformat($date, $fomat) {
    if ($fomat == "DATE")
        return date("d/m/Y", strtotime($date));
    else
        return date("d/m/Y H:i:s", strtotime($date));
}

/* function getCustomerIds() {
  global $dbcon;
  $select_q = "SELECT customer_id FROM ".CUSTOMER_INFO." WHERE delete_status = 0 ";
  $select_query = $dbcon->prepare($select_q);
  $select_query->execute();
  $select_query_result = $select_query->fetchALL();
  $sDropDown = "<select name='customer_id' onchange='this.form.submit();'>";
  $sDropDown.= "<option value=''>Select Customer</option>";
  foreach($select_query_result as $customer){
  $sDropDown.="<option value='".$customer['customer_id']."'>".$customer['customer_id']."</option>";
  }
  $sDropDown.= "</select>";
  return $sDropDown;
  } */

function prepareFiveDegitNo($num) {
    $format = '%1$05d';
    $req_five_digit_num = sprintf($format, $num);
    return $req_five_digit_num;
}

/*
  function activeInactiveDropDown($name="",$status="") {
  global $aActiveInactive;
  $sDropDown = "<select name='".$name."' >";
  foreach($aActiveInactive as $key=>$value){
  $selected = ($status == $key) ? "selected" : "";
  $sDropDown.="<option value='".$key."' ".$selected.">".$value."</option>";
  }
  $sDropDown.= "</select>";
  return $sDropDown;
  }

  function enableDisableDropDown($name="",$status="") {
  global $aEnableDisable;
  $sDropDown = "<select name='".$name."' >";
  foreach($aEnableDisable as $key=>$value){
  $selected = ($status == $key) ? "selected" : "";
  $sDropDown.="<option value='".$key."' ".$selected.">".$value."</option>";
  }
  $sDropDown.= "</select>";
  return $sDropDown;
  } */

function getOfficerIds($id) {
    global $dbcon;
    $sSelectQ = "SELECT * FROM " . ADMIN_USERS . " WHERE (role = :role1 OR  role = :role2) AND delete_status = 0";
    $sSelectQuery = $dbcon->prepare($sSelectQ);
	$sSelectQuery->bindValue(":role1", "admin");
	$sSelectQuery->bindValue(":role2", "officer");
    $sSelectQuery->execute();
	//print_r($sSelectQuery->errorInfo());
    $aCustomers = $sSelectQuery->fetchAll(PDO::FETCH_ASSOC);
    // print_r($aCustomers);exit;
    $cDropDown = "<select name='user_id' id='user_id' onchange='this.form.submit();'>"
            . "<option value = '' selected>-Select Customer-</option>";
    foreach ($aCustomers as $aCustomer) {
        if ($id == $aCustomer['id']) {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        $cDropDown .= "<option value = " . $aCustomer['id'] . " $selected>" . $aCustomer['first_name'] . " " .$aCustomer['last_name'] . "</option>";
    }
    $cDropDown .= "</select>";
    return $cDropDown;
}

function getUserNamebyId($iUserType, $iId) {
    global $dbcon;
    $table_name = ($iUserType == 1) ? ADMIN_LOGIN : CUSTOMER_USERS;
    $sSelectQ = "SELECT `name` FROM " . $table_name . " WHERE id = :id";
    $sSelectQuery = $dbcon->prepare($sSelectQ);
    $sSelectQuery->bindParam(":id", $iId);
    $sSelectQuery->execute();
    if ($sSelectQuery->rowCount() > 0) {
        $result = $sSelectQuery->fetch(PDO::FETCH_ASSOC);
        return $result['name'];
    }
    return "";
}

function getStartAndEndDate($week, $year) {
    $time = strtotime("1 January $year", time());
    $day = date('w', $time);
    $time += ((7 * $week) - $day) * 24 * 3600;
    $return[0] = date('Y-n-j', $time);
    $time += 6 * 24 * 3600;
    $return[1] = date('Y-n-j', $time);
    return $return;
}

function sortingArray($sViewedBy, $aBytesUsed) {
    global $aDateFormat;
    if ($sViewedBy == "DATE") {
        foreach ($aBytesUsed as $key => $row) {
            $mid[$key] = $row['group1'];
        }
        @array_multisort($mid, SORT_ASC, $aBytesUsed);
        $aDisplayDates = $aBytesUsed;
        foreach ($aBytesUsed as $key => $row) {
            $aDisplayDates[$key]['group1'] = $row['group1'];
        }
    }
    if ($sViewedBy == "MONTH") {

        foreach ($aBytesUsed as $key => $row) {
            $mid['group1'][$key] = $row['group1'];
            $mid['group2'][$key] = $row['group2'];
        }
        @ array_multisort($mid['group2'], SORT_ASC, $mid['group1'], SORT_ASC, $aBytesUsed);
        $aDisplayDates = $aBytesUsed;
        foreach ($aBytesUsed as $key => $row) {
            $aDisplayDates[$key]['group1'] = $aDateFormat[$row['group1']] . '-' . $row['group2'];
        }
    }
    if ($sViewedBy == "WEEK") {
        foreach ($aBytesUsed as $key => $row) {
            $mid['group1'][$key] = $row['group1'];
            $mid['group2'][$key] = $row['group2'];
        }
        @ array_multisort($mid['group2'], SORT_ASC, $mid['group1'], SORT_ASC, $aBytesUsed);
        $aDisplayDates = $aBytesUsed;
        foreach ($aBytesUsed as $key => $row) {
            $aSEDate = getStartAndEndDate($row['group1'], $row['group2']);
            $aDisplayDates[$key]['group1'] = $aSEDate[0] . '~~' . $aSEDate[1];
        }
    }
    return $aDisplayDates;
}

function getDateCodeForWeekandMonth($sViewedBy, $aDates) {
    global $aDateFormat;
    $aDates_new = array();
    if ($sViewedBy == "WEEK") {
        foreach ($aDates as $xdate) {
            $aExplode = explode(":::", $xdate);
            $aSETDate = getStartAndEndDate($aExplode[1], $aExplode[0]);
            $aDates_new[] = $aSETDate[0] . "-" . $aSETDate[1];
        }
    } else {
        foreach ($aDates as $xdate) {
            $aExplode = explode(":::", $xdate);
            $aSETDate = $aDateFormat[$aExplode[1]] . '-' . $aExplode[0];
            //array_push($aDates_new,$aSETDate);
            $aDates_new[] = $aSETDate;
        }
    }
    return $aDates_new;
}

function yearMonth2digitCode() {
    $two_digit_year = gmdate("y");
    $two_digit_month = gmdate("m");
    return $two_digit_year . $two_digit_month;
}

function yearMonthStartEndDateCode($startDate, $endDate) {
    $time1 = strtotime($startDate);
    $month1 = date("m", $time1);
    $year1 = date("y", $time1);
    $time2 = strtotime($endDate);
    $month2 = date("m", $time2);
    $year2 = date("y", $time2);
    $yearMonthStartEndDateCode = $year1 . $month1 . $year2 . $month2;
    return $yearMonthStartEndDateCode;
}

function getCountries() {
    global $dbcon;
    $result = array();
    $sSelectQ = "SELECT `country_id`,`name` FROM `country_list`";
    $sSelectQuery = $dbcon->prepare($sSelectQ);
    $sSelectQuery->execute();
    if ($sSelectQuery->rowCount() > 0) {
        $result = $sSelectQuery->fetchALL(PDO::FETCH_ASSOC);
    }
    return $result;
}

function getStates($country_id, $state = "") {
    global $dbcon;
    $options_String = "";
    $sSelectQ = "SELECT `id`,`name` FROM `states_list` WHERE `country_id` = :country_id";
    $sSelectQuery = $dbcon->prepare($sSelectQ);
    $sSelectQuery->bindParam(":country_id", $country_id);
    $sSelectQuery->execute();
    if ($sSelectQuery->rowCount() > 0) {
        $result = $sSelectQuery->fetchALL(PDO::FETCH_ASSOC);
        foreach ($result as $states) {
            $selected = ($states['id'] == $state) ? "selected" : "";
            $options_String .= "<option value='" . $states['id'] . "' " . $selected . ">" . $states['name'] . "</option>";
        }
    }
    return $options_String;
}

function getCallingCode($country_id) {
    global $dbcon;
    $calling_code = "";
    $sSelectQ = "SELECT `calling_code` FROM `country_list`  WHERE `country_id` = :country_id";
    $sSelectQuery = $dbcon->prepare($sSelectQ);
    $sSelectQuery->bindParam(":country_id", $country_id);
    $sSelectQuery->execute();
    if ($sSelectQuery->rowCount() > 0) {
        $result = $sSelectQuery->fetch(PDO::FETCH_ASSOC);
        $calling_code = $result['calling_code'];
    }
    return $calling_code;
}

function getDashboardSetting($sCustomerID) {
    global $dbcon;
    $sSelectQ = "SELECT * FROM `settings` WHERE customer_id = :customer_id";
    $sSelectQuery = $dbcon->prepare($sSelectQ);
    $sSelectQuery->bindParam(':customer_id', $sCustomerID);
    $sSelectQuery->execute();
    if ($sSelectQuery->rowCount() > 0) {
        return $sSelectQuery->fetch(PDO::FETCH_ASSOC);
    }
}

function getChannelLogoPath($sCustomer_Id, $sChannel_id) {
    //global $dbcon;
    $dbcon1 = new PDO("mysql:host=localhost;dbname=cmadmin_tvstreamanalytics","cmadmin_dev", "CmAdmin123");
    $sSelectQ = "SELECT ci.logo FROM customer_channels as cc "
            . " JOIN channel_info as ci ON cc.channel_id = ci.channel_id WHERE cc.customer_id = :customer_id AND cc.channel_id = :channel_id";
    $sSelectQuery = $dbcon1->prepare($sSelectQ);
    $sSelectQuery->bindParam(':customer_id', $sCustomer_Id);
    $sSelectQuery->bindParam(':channel_id', $sChannel_id);
    $sSelectQuery->execute();
   // print_r($sSelectQuery->errorInfo());
    if ($sSelectQuery->rowCount() > 0) {
        return $sSelectQuery->fetch(PDO::FETCH_ASSOC);
    }
}

?>
