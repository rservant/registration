<?php
    
    include('includes/header.inc_withoutlogin.php');
    include('classes/user.class.php');
    
    $objUser = new USER();
    $presentConferenceId = $objUser->getLatestConferenceIdByCatogery("fall"); //TODO: pass in conference ID
    $clubNames = $objUser->getClubNames();
    $clubNamesWithDetails = $objUser->getClubNamesWithDetails();
    $confData = $objUser->getConfrences();
    $leaderLevelData = $objUser->getLeaderLevels();
    $languageData = $objUser->getLanguages();
    
    $sProducts = $objUser->getProductsOptionString($presentConferenceId);
    $aProducts = $objUser->getProductsOptionArray($presentConferenceId);
    $sMealsCat1 = $objUser->getMealsOptionString($presentConferenceId, $aMealCategoryKeys[0]);
    $sMealsCat2 = $objUser->getMealsOptionString($presentConferenceId, $aMealCategoryKeys[1]);
    
    @$action = isset($_GET['action']) ? $_GET['action'] : $_POST['action'];
    require_once("library.php");
    require_once("paypal_class.php");
    $p 	= new paypal_class(); // paypal class
    $p->admin_mail 	= EMAIL_ADD; // set notification email   TODO: set email based on conference ID (spring vs. fall)
    switch($action){
        case "process": // case process insert the form data in DB and process to the paypal
            $ptyp = $_POST['ptype'];
            $result = $objUser->addUser($_POST);
            
            $_POST["product_name"] = $objUser->getProductNameById($_POST['product']);
            $_POST["product_id"] =  "2345";  //TODO: shouldn't this be variable with the product name?
            $_POST["product_quantity"] = 1;  //Future: Introduce ability to order more than 1 product?
            $_POST["product_amount"] = $objUser->getTotalAmount($_POST['product']);

            if($result == 1){
                if(($ptyp) == 'Paypal'){
                    $this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
                    $p->add_field('business', PAYPAL_EMAIL_ADD); // Call the facilitator eaccount   TODO: set email based on conference ID (spring vs. fall)
                    $p->add_field('cmd', $_POST["cmd"]); // cmd should be _cart for cart checkout
                    $p->add_field('upload', '1');
                    $p->add_field('return', $this_script.'?action=success'); // return URL after the transaction got over
                    $p->add_field('cancel_return', $this_script.'?action=cancel'); // cancel URL if the trasaction was cancelled during half of the transaction
                    $p->add_field('notify_url', $this_script.'?action=ipn'); // Notify URL which received IPN (Instant Payment Notification)
                    $p->add_field('currency_code', $_POST["currency_code"]);
                    $p->add_field('invoice', $_POST["invoice"]);
                    $p->add_field('item_name_1', $_POST["product_name"]);
                    $p->add_field('item_number_1', $_POST["product_id"]);
                    $p->add_field('quantity_1', $_POST["product_quantity"]);
                    $p->add_field('amount_1', $_POST["product_amount"]);
                    $p->add_field('first_name', $_POST["L_PAYMENTREQUEST_0_NAME0"]);
                    $p->add_field('last_name', $_POST["L_PAYMENTREQUEST_0_DESC0"]);
                    $p->add_field('email', $_POST["contact_email"]);
                    $p->submit_paypal_post(); // POST it to paypal
                } else {
                    
                    $sMsg = "<font color='white'>User Registered Successfully,Please see cashier to complete transaction.</font>";  //TODO: translation
                    $msg = $objMessages->msgLayout($sMsg,$result);
                    include('layouts/reg_form.html');
                }
            } else if($result == 3) {
                $sMsg = "<font color='white'>User Not Registered Successfully. Please Try Again.</font>";   //TODO: translation
                $msg = $objMessages->msgLayout($sMsg,$result);
                include('layouts/reg_form.html');
            } else {
                $sMsg = "<font color='white'>Duplicate Email found, Please <a href='index.php'>Login here</a> if you want to register with the existing email.</font>"; //TODO: translation
                $msg = $objMessages->error($sMsg);
                include('layouts/reg_form.html');
            }
            
            break;
            
        case "success": // success case to show the user payment got success
            echo '<title>Your payment was received successfully</title>'; //TODO translation
            echo '<style>.as_wrapper{
                font-family:Arial;
                color:#333;
                font-size:14px;
                padding:20px;
                border:2px dashed #17A3F7;
                width:600px;
                margin:0 auto;
            }</style>';
    echo '<div class="as_wrapper">';
    echo "<h1>Payment Transaction Done Successfully</h1>";  //TODO translation
    echo '<h4>Use this below URL in paypal IPN Handler URL to complete the transaction</h4>'; //sandbox
    echo '<h3>http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?action=ipn</h3>';
    echo '</div>';
    break;
    
case "cancel": // case cancel to show user the transaction was cancelled
    echo "<h1>Transaction Cancelled";  //TODO translation
    break;
    
case "ipn":
    // IPN case to receive payment information. this case will not displayed in browser.
    // This is server to server communication. PayPal will send the transactions each and
    // every details to this case in secured POST menthod by server to server.
    $trasaction_id  = $_POST["txn_id"];
    $payment_status = strtolower($_POST["payment_status"]);
    $invoice		= $_POST["invoice"];
    $log_array		= print_r($_POST, TRUE);
    $log_query		= "SELECT * FROM `paypal_log` WHERE `txn_id` = '$trasaction_id'";
    $log_check 		= mysql_query($log_query);
    if(mysql_num_rows($log_check) <= 0){
        mysql_query("INSERT INTO `paypal_log` (`txn_id`, `log`, `posted_date`) VALUES ('$trasaction_id', '$log_array', NOW())");
    }else{
        mysql_query("UPDATE `paypal_log` SET `log` = '$log_array' WHERE `txn_id` = '$trasaction_id'");
    } // Save and update the logs array
    $paypal_log_fetch 	= mysql_fetch_array(mysql_query($log_query));
    $paypal_log_id		= $paypal_log_fetch["id"];
    if ($p->validate_ipn()){ // validate the IPN, do the others stuffs here as per your app logic
        mysql_query("UPDATE `Registrations` SET `Registration_Confirmation_Number` = '$trasaction_id ', `log_id` = '$paypal_log_id', `payment_status` = '$payment_status' WHERE `invoice` = '$invoice'");
        $subject = 'Instant Payment Notification - Recieved Payment';
        $p->send_report($subject); // Send the notification about the transaction
    }else{
        $subject = 'Instant Payment Notification - Payment Fail';
        $p->send_report($subject); // failed notification
    }
    break;
default:
    $confData = $objUser->getCoferenceDataById($presentConferenceId);
    $cHomeLink = (isset($confData['Conference_website_link'])) ? $confData['Conference_website_link'] : "";
    $cPhno = (isset($confData['contact_ph'])) ? $confData['contact_ph'] : "";
    $cEmail = (isset($confData['contact_email'])) ? $confData['contact_email'] : "";
    include('layouts/reg_form.html');
    break;
    }
    
    ?>
