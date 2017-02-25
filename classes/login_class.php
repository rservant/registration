<?php

//error_reporting (E_ALL ^ E_NOTICE);
Class Login {

    function authendication($username, $password) {
        global $dbcon;

        //$password = encrypt($password, PASSWROD_SALT);
		$password = md5($password);

        $query = "SELECT * FROM admin_users WHERE `email` = :email AND `delete_status` = 0 AND password = :password";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":email", $username);
		$select_query->bindParam(":password", $password);
        $select_query->execute();
        $count = $select_query->rowCount();
        if ($count > 0) {
            $select_query_result = $select_query->fetch(PDO::FETCH_ASSOC);
			return $select_query_result;
        } 
        return 2;
    }

    function resetPassword($email) {
        global $dbcon;
        $required_email = "";
        //$rand_for_password = rand();
        $rand_for_password = generatePassword();

        //$hashPassword = md5($rand_for_password);
        $hashPassword = encrypt($rand_for_password, PASSWROD_SALT);

        $query2 = "SELECT * FROM `" . ADMIN_LOGIN . "` WHERE email = :email";
        $select_query2 = $dbcon->prepare($query2);
        $select_query2->bindParam(":email", $email);
        $select_query2->execute();
        $count2 = $select_query2->rowCount();
        if ($count2 > 0) {
            $select_query_result = $select_query2->fetch();

            $required_email = $select_query_result['email'];
            //$required_first_name = $select_query_result['first_name'];
            //$required_last_name = $select_query_result['last_name'];
            $required_name = $select_query_result['name'];
            $required_id = $select_query_result['id'];
            $sql = "UPDATE `" . ADMIN_LOGIN . "` SET `active_status` = '1',`password` = :password WHERE id = :id";
            try {
                $stmt = $dbcon->prepare($sql);
                $stmt->bindParam(":password", $hashPassword);
                $stmt->bindParam(":id", $required_id);
                $stmt->execute();
                $stmt = null;
                $result = 1;
            } catch (PDOException $e) {
                $result = 2;
                print $e->getMessage();
            }
        } else {
            $result = 3;
        }

        //mail new password

        if ($required_email != "") {
            $subject = APPNAME . "  | Successful Reset Password";
            $message = CONST_MAIL_RESET_PSW_MSG;
            $message = str_replace("{NAME}", $required_name, $message);
            $message = str_replace("{NEW_PSWD}", $rand_for_password, $message);
            sendMail($required_email, FROM_EMAIL, $subject, $message);
        }
        return $result;
    }

    function resetPasswordById($sPassword, $aUserID, $sUserType) {
        global $dbcon;
        $hashPassword = encrypt($sPassword, PASSWROD_SALT);
        if ($sUserType == 'ADMIN') {
            $sTable = ADMIN_LOGIN;
        }
        if ($sUserType == 'CUSTOMER_USER') {
            $sTable = CUSTOMER_USERS;
        }
        $sql = "UPDATE `" . $sTable . "` SET `active_status` = '1',`password` = :password WHERE id = :id";
        try {
            $stmt = $dbcon->prepare($sql);
            $stmt->bindParam(":password", $hashPassword);
            $stmt->bindParam(":id", $aUserID);
            $stmt->execute();
            $stmt = null;
            $result = 1;
        } catch (PDOException $e) {
            $result = 2;
            print $e->getMessage();
        }
        return $result;
    }

    function getBlockedStatus($email) {
        global $dbcon;
        $query = "SELECT * FROM " . ADMIN_LOGIN . " WHERE `email` = :email";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":email", $email);
        $select_query->execute();
        $select_query->rowCount();
        if ($select_query->rowCount() > 0) {
            return $result = $select_query->fetch(PDO::FETCH_ASSOC);
        } else {
            $query1 = "SELECT * FROM " . CUSTOMER_USERS . " WHERE `email` = :email";
            $select_query1 = $dbcon->prepare($query1);
            $select_query1->bindParam(":email", $email);
            $select_query1->execute();
            $select_query1->rowCount();
            if ($select_query1->rowCount() > 0) {
                return $result1 = $select_query1->fetch(PDO::FETCH_ASSOC);
            }
        }
        return "";
    }

    function blockAccount($email, $table) {
        global $dbcon;
        $update_q = "UPDATE `" . $table . "` SET `active_status` = '0', `login_attempt` = '0' WHERE `email` = :email";
        $update_query = $dbcon->prepare($update_q);
        $update_query->bindParam(":email", $email);
        $update_query->execute();
    }

    function sendResetPasswordLink($email) {
        global $dbcon;
        $query = "SELECT * FROM " . ADMIN_LOGIN . " WHERE `email` = :email AND `delete_status` = 0";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":email", $email);
        $select_query->execute();
        $count = $select_query->rowCount();
        if ($count > 0) {
            $aResult = $select_query->fetch(PDO::FETCH_ASSOC);
            //Insert the forgot password request table info table
            $update_q = "INSERT INTO " . FORGOTPASSWORD_REQUESTINFO . " (user_id,user_type,created_datetime,access_token)"
                    . " VALUES(:user_id,:user_type,:created_datetime,:access_token);";
            $update_query = $dbcon->prepare($update_q);
            $update_query->bindParam(":user_id", $aResult['id']);
            $sUser_Type = 'ADMIN';
            $update_query->bindParam(":user_type", $sUser_Type);
            $sDateTime = date("Y-m-d H:i:s");
            $update_query->bindParam(":created_datetime", $sDateTime);
            $number = rand(0, 1000000000);
            $sAccessToken = $number . '' . strtotime($sDateTime); //Including with mail
            $update_query->bindParam(":access_token", $sAccessToken);
            $result = $update_query->execute() ? 1 : 2;
        } else {
           $query1 = "SELECT * FROM " . CUSTOMER_USERS . " WHERE `email` = :email AND `delete_status` = 0";
            $select_query1 = $dbcon->prepare($query1);
            $select_query1->bindParam(":email", $email);
            $select_query1->execute();
            if ($select_query1->rowCount() > 0) {
                $aResult = $select_query1->fetch(PDO::FETCH_ASSOC);
                //Insert the forgot password request table info table
               $update_q = "INSERT INTO " . FORGOTPASSWORD_REQUESTINFO . " (user_id,user_type,created_datetime,access_token)"
                        . " VALUES(:user_id,:user_type,:created_datetime,:access_token);";
                $update_query = $dbcon->prepare($update_q);
                $update_query->bindParam(":user_id", $aResult['id']);
                $sUser_Type = 'CUSTOMER_USER';
                $update_query->bindParam(":user_type", $sUser_Type);
                $sDateTime = date("Y-m-d H:i:s");
                $update_query->bindParam(":created_datetime", $sDateTime);
                $number = rand(0, 1000000000);
                $sAccessToken = $number . '' . strtotime($sDateTime); //Including with mail
                $update_query->bindParam(":access_token", $sAccessToken);
                $result = $update_query->execute() ? 1 : 2;
				//print_r($update_query->errorInfo());
            } else {
                return 3; // user not found
            }
        }
        if ($result == 1) {

            $subject = APPNAME . "  | Reset Password Link";
            $link = "sanatized_ron?token=" . $sAccessToken . "&action=resetPasswordForm";
            $message = "<html><body>Hi " . $aResult['name'] .
                ",<br>Please click on link to reset your password:
                          <a href ='" . $link . "'>Click Here</a></body></html>";
            sendMailForResetPassword($email,$subject,$message);
            return 1;
        }
    }

    function getUserDetailsByAccesToken($sAccessToken) {
        global $dbcon;
        $query = "SELECT * FROM " . FORGOTPASSWORD_REQUESTINFO . " WHERE access_token = :access_token";
        $select_query = $dbcon->prepare($query);
        $select_query->bindParam(":access_token", $sAccessToken);
        $select_query->execute();
        $aResult = $select_query->fetch(PDO::FETCH_ASSOC);
        return $aResult;
    }

}

?>
