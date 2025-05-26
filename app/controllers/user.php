<?php

    class Users {

        private $db;
        private $userModel;
        private $vapidPublicKey;
        private $vapidPrivateKey;
        private $pushnotification;
        private $sendTON;

        public function __construct($db) {
            $this->db = $db;
            $this->userModel = new usersModel($db);
            $this->vapidPublicKey = VAPID_PUBLIC_KEY;
            $this->vapidPrivateKey = VAPID_PRIVATE_KEY;
            $this->pushnotification = new PushNotificationService($this->db,$this->vapidPublicKey,$this->vapidPrivateKey);
            $this->sendTON = new TONWallet(TON_API_KEY,FROM_WALLET_ADDRESS,TON_PRIVATE_KEY);
        }

        public function processRegistration(){
            
                try {

                     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                        throw new Exception("Invalid request method");
                    }
                    
                    // Fields to process
                    $requiredFields = ['username', 'password', 'repeat_password', 'bonus_username', 'email', 'sponsor', 'country', 'wallet_username', 'wallet_password', 'gender'];
                    $input = [];
                    $referral_bonus = 2;
                    $indirect_referral_bonus = 0.5;
                    $reg_fee = 10;
                    $year = date('Y');
                    $timezone = $this->userModel->sanitizeInput($_POST['timezone'] ?? '');

                    $this->db->begin_transaction();
    
                    // Sanitize required fields and check if any are empty
                    foreach ($requiredFields as $field) {
                        $input[$field] = $this->userModel->sanitizeInput($_POST[$field] ?? '');
                        if (empty($input[$field])) {
                            throw new Exception(ucfirst($field) . " is required");
                        }
                    }

                    date_default_timezone_set($timezone ?? 'Africa/Lagos');

                    //error_log(print_r($input, true));
                    $avatar = $input['gender'] == 'male' ? 'avatar-1.jpg' : 'avatar-3.jpg';

                    // fetch userinfo
                    $userInfo = $this->userModel->getUserInfo($input['username']);

                    // fetch sponsor info
                    $sponsorInfo = $this->userModel->getUserInfo($input['sponsor']);

                    $stageInfo = $this->userModel->getStageInfo($sponsorInfo['stage'] ?? 1);

                    error_log(print_r($stageInfo, true));
                    $countdownlines = $this->userModel->countDownlines($input['sponsor'], $sponsorInfo['stage']);

                    error_log(print_r($countdownlines, true));

                    if ($stageInfo['downlines'] === $countdownlines['total'] ?? 0) {
                        throw new Exception("Sponsor has reached the maximum number of downlines for their present stage");
                    }

                    $bonusUserInfo = $this->userModel->getUserInfo($input['bonus_username']);
                    if (!$bonusUserInfo) {
                        throw new Exception("Bonus username does not exist");
                    }

                    // fetch wallet username info
                    $walletInfo = $this->userModel->getUserInfo($input['wallet_username']);
                    if (!$walletInfo) {
                        throw new Exception("Invalid wallet username or password");
                    }

                    if (!password_verify($input['wallet_password'], $walletInfo['wallet_password'])){
                        throw new Exception("Invalid wallet username or password");
                    }

                    // check wallet balance if its greater than or equal to the registration fee
                    if ($walletInfo['reg_wallet'] < $reg_fee) {
                        throw new Exception("Insufficient registration wallet balance");
                    }

                    if(!preg_match("/^[a-zA-Z0-9_]+$/", $input['username'])){
                        throw new Exception("Username can only be alpanumeric");
                    }
            
                    // Check if sponsor exists (if provided)
                    if (!$this->userModel->getUserInfo($input['sponsor'])) {
                        throw new Exception("Sponsor username does not exist");
                    }
            
                    // Check if username already exists
                    if ($this->userModel->getUserInfo($input['username'])) {
                        throw new Exception("Username already exists");
                    }

                    // Check if email already exists
                    if ($this->userModel->getUserEmail($input['email'])) {
                        throw new Exception("Email already exists");
                    }

                    if(!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                        throw new Exception("Invalid email format");
                    }
    
                    // Password match check
                    if ($input['password'] !== $input['repeat_password']) {
                         throw new Exception("Passwords do not match");
                    }
            
                    // Hash password
                    $hashedPassword = password_hash($input['password'], PASSWORD_DEFAULT);
                    $sponsor_stage = $sponsorInfo['stage'];
                    $stage = 1;
                    $indirect_sponsor = $this->userModel->fetchSponsor($input['bonus_username'])['sponsor'] ?? null;

                    $activation_link =  $this->userModel->getCurrentUrl() . '/confirmation?user='.$input['username'];

                    $logourl = $this->userModel->getCurrentUrl() . "/public/assets/images/logo_new.png";

                    $message = <<<EMAIL
                        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                        <html xmlns="http://www.w3.org/1999/xhtml">
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Welcome to GlobalSingleLine</title>
                            <style type="text/css">
                                /* Client-specific resets */
                                body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
                                table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
                                img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
                                
                                /* Main styles */
                                body {
                                    font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
                                    background-color: #f5f7fa;
                                    margin: 0 !important;
                                    padding: 0 !important;
                                }
                                
                                /* Fallback for Outlook */
                                .header-fallback {
                                    background-color:rgb(255, 255, 255) !important;
                                }
                            </style>
                        </head>
                        <body style="margin: 0; padding: 0;">
                            <!--[if (gte mso 9)|(IE)]>
                            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                            <td>
                            <![endif]-->
                            
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                <!-- Header -->
                                <tr>
                                    <td align="center" class="header-fallback" style="padding: 30px 0; background:rgb(245, 245, 245);">
                                        <img src="{$logourl}" alt="GlobalSingleLine Logo" width="150" style="display: block;">
                                    </td>
                                </tr>
                                
                                <!-- Content -->
                                <tr>
                                    <td bgcolor="#ffffff" style="padding: 30px; font-size: 16px; line-height: 1.6; color: #4a5568;">
                                        <h1 style="font-size: 24px; color: #2d3748; text-align: center; margin: 0 0 20px 0;">🎉 Welcome to GlobalSingleLine!</h1>
                                        
                                        <p style="margin: 0 0 16px 0;">Hi <strong style="color: #198754;">{$input['username']}</strong>,</p>
                                        
                                        <p style="margin: 0 0 16px 0;">Congratulations on becoming a SINGLE-LEG-WORLDWIDE NETWORKER! You now have access to:</p>
                                        
                                        <ul style="margin: 0 0 16px 0; padding-left: 20px;">
                                            <li style="margin-bottom: 8px;">Exceptional Fund Rewards.</li>
                                            <li style="margin-bottom: 8px;">Global networking platform.</li>
                                            <li style="margin-bottom: 8px;">International Trip And Awards.</li>
                                            <li style="margin-bottom: 8px;">Special vendor benefits</li>
                                            <li style="margin-bottom: 8px;">40% Discount On All Our Services.</li>
                                        </ul>
                                        
                                        <p style="margin: 0 0 16px 0;">We're excited to partner with you in building sustainable network marketing through our services and self-generated funds.</p>
                                
                                        <p style="margin: 0 0 24px 0;">Your account is currently inactive. To unlock all platform features, please activate your account:</p>
                                        
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td align="center">
                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td align="center" bgcolor="#198754" style="border-radius: 6px;">
                                                                <a href="{$activation_link}" style="display: inline-block; padding: 12px 24px; color: #ffffff; font-weight: 600; text-decoration: none;">🔓 Activate Account</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        
                                        <p style="margin: 24px 0 0 0;">We wish you profitable experiences and pleasant business transactions throughout your journey with us.</p>
                                        
                                        <p style="margin: 16px 0 0 0;">Best regards,<br>
                                        <strong>GSL TEAM.</strong><br>
                                        Generating Success for Life...</p>
                                    </td>
                                </tr>
                                
                                <!-- Footer -->
                                <tr>
                                    <td bgcolor="#f5f7fa" style="padding: 20px; text-align: center; font-size: 14px; color: #718096; border-top: 1px solid #e2e8f0;">
                                        © {$year} GlobalSingleLine. All rights reserved.
                                    </td>
                                </tr>
                            </table>
                            
                            <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </table>
                            <![endif]-->
                        </body>
                        </html>
                    EMAIL;

                    // Insert user
                    $stmt = $this->db->prepare("INSERT INTO members (username, password, email, country, stage, reg_date, avatar, gender, timezone) VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?)");
                    $stmt->bind_param("ssssssss", $input['username'], $hashedPassword, $input['email'], $input['country'], $stage, $avatar, $input['gender'], $timezone);
                    if (!$stmt->execute()) {
                        throw new Exception("Failed to insert user: " . $stmt->error);
                    }

                        $date = date('Y-m-d H:i:s');

                        // Update paying wallet
                        $sql = $this->db->prepare("UPDATE members SET reg_wallet = reg_wallet - ? WHERE username = ?");
                        $sql->bind_param("is", $reg_fee, $input['wallet_username']);
                        if (!$sql->execute()) {
                            throw new Exception("Failed to debit registration wallet");
                        }
                        $sql->close();

                        $this->userModel->sendmail($input['email'],$input['username'],$message,"Registration Confirmation");

                        // Insert Transaction history for paying wallet
                        $this->userModel->InsertHistory($input['wallet_username'], $reg_fee, $date, 'debit', 'Registration Fee for ' . $input['username']);

                        // Update sponsor wallet
                        $sql = $this->db->prepare("UPDATE members SET earning_wallet = earning_wallet + ? WHERE username = ?");
                        $sql->bind_param("ds", $referral_bonus, $input['bonus_username']);
                        if (!$sql->execute()) {
                            throw new Exception("Failed to credit sponsor earning wallet");
                        }
                        $sql->close();

                        // Insert Transaction history for sponsor
                        $this->userModel->InsertHistory($input['bonus_username'], $referral_bonus, $date, 'credit', 'Referral Bonus for ' . $input['username']);

                        if(!is_null($indirect_sponsor)){

                            // Update indirect sponsor wallet
                            $sql = $this->db->prepare("UPDATE members SET earning_wallet = earning_wallet + ? WHERE username = ?");
                            $sql->bind_param("ds", $indirect_referral_bonus, $indirect_sponsor);
                            if (!$sql->execute()) {
                                throw new Exception("Failed to credit indrect sponsor earning wallet");
                            }
                            $sql->close();

                            // Insert Transaction history for indirect sponsor
                            $this->userModel->InsertHistory($indirect_sponsor, $indirect_referral_bonus, $date, 'credit', 'Indirect Bonus for ' . $input['username']);

                            $this->pushnotification->sendNotification($indirect_sponsor, 'Credit Alert', 'Dear ' .$input['bonus_username']. ', The sum of $'. $indirect_referral_bonus .' has just been credited into your earning wallet', $this->userModel->getCurrentUrl());

                        }
                
                        // Insert into referral tree
                        $sql = $this->db->prepare("INSERT INTO referral_tree (username, sponsor, sponsor_stage, reg_date) VALUES (?, ?, ?, NOW())");
                        $sql->bind_param("sss", $input['username'], $input['sponsor'], $sponsor_stage);
                        if (!$sql->execute()) {
                            throw new Exception("Failed to insert user referral tree");
                        }
                        $sql->close();

                        $this->pushnotification->sendCustomNotifications([
                            [
                                'username' => $input['wallet_username'], // Upline
                                'title' => 'Debit Alert!',
                                'body' => 'Dear ' .$input['wallet_username']. ', The sum of $'. $reg_fee .' has just been deducted from your registration wallet',
                                'url' => $this->userModel->getCurrentUrl()
                            ],
                            [
                                'username' => $input['bonus_username'], // Upper Upline
                                'title' => 'Credit Alert',
                                'body' => 'Dear ' .$input['bonus_username']. ', The sum of $'. $referral_bonus .' has just been credited into your earning wallet',
                                'url' => $this->userModel->getCurrentUrl()
                            ],
                        ]);

                        $credits = [
                            ['amount' => 1, 'username' => 'Rose25'],
                            ['amount' => 1, 'username' => 'Richard54'],
                            ['amount' => 0.2, 'username' => 'globalsingle'],
                        ];

                        $this->userModel->creditMultipleWallets($credits);

                        $this->db->commit();

                        return json_encode(["status" => true, "message" => "Congratulations, registration was successful, Kindly check your email for verification"]);

                } catch (Exception $e) {
                    $this->db->rollback();
                    return json_encode([
                        'status' => false,
                        'message' => $e->getMessage()
                    ]);

                }
        }
            

        public function processLogin() {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Sanitize and validate input
                $username = $this->userModel->sanitizeInput($_POST['username']);
                $password = $this->userModel->sanitizeInput($_POST['password']);
    
                // Check if the user exists in the database
                $userInfo = $this->userModel->getUserInfo($username);
                //error_log(print_r($userInfo, true)); // Log user info for debugging
                
                if ($userInfo) {

                    if($userInfo['account_access'] > 0){
                        // Verify password (assuming password is hashed in the database)
                        if (password_verify($password, $userInfo['password'])) {
                            // Start session and set user data
                            session_start();
        
                            $_SESSION['global_single_username'] = $userInfo['username'];
        
                            return json_encode(["status" => true, "message" => "Login was successful"]);
        
                        } else {
        
                            return json_encode(["status" => false, "message" => "Invalid username or password"]);
        
                        }
                    } else {

                        return json_encode(["status" => false, "message" => "Account not yet validated, kindly activate your account through the mail sent to your email"]);

                    }
                } else {
                    return json_encode(["status" => false, "message" => "Invalid username or password"]);
                }
            }
        }

        public function checkStageQualification(){

            try {

                $id = $this->userModel->sanitizeInput($_POST['id']);
                $one = 1;
                // fetch user by id
                $userInfo = $this->userModel->getUserInfo($id);

                if (!$userInfo) throw new Exception("User not found");

                $username = $userInfo['username'];
                $stageInfo = $this->userModel->getStageInfo($userInfo['stage']);
                $compensation = $stageInfo['compensation'];
                $countdownlines = $this->userModel->countDownlines($username, $userInfo['stage']);
                $globalDownlines = $this->userModel->countGlobalDownlines($userInfo['reg_date'], $stageInfo['total_downlines']);
                $globalDownlinespercentage = $this->userModel->calculatePercentage($globalDownlines, $stageInfo['total_downlines'], $decimalPlaces = 2);
                $countdownlinespercentage = $this->userModel->calculatePercentage($countdownlines['total'], $stageInfo['downlines'], $decimalPlaces = 2);



                if($globalDownlinespercentage < 100 && $countdownlinespercentage < 100){

                    throw new Exception("Oooops, you are yet to complete your tasks");
                    
                } 

                    $sql = $this->db->prepare("UPDATE members SET page_access = ? WHERE username = ?");
                    $sql->bind_param("is",$one, $username);
                    $sql->execute();
                    $sql->close();

                    $this->userModel->updateStage($username,$compensation,$userInfo['stage'] + 1);

                   
                    return json_encode(["status" => true, "message" => "Congratulations, stage completed successfully"]);


            } catch (Exception $th) {
                return json_encode(["status" => false, "message" => $th->getMessage()]);
            }
            
        }

        public function processChangePassword(){
            
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return json_encode(["status" => false, "message" => "Invalid request method"]);
            }
    
            // Sanitize and validate input
            $oldPassword = $this->userModel->sanitizeInput($_POST['old_password']);
            $newPassword = $this->userModel->sanitizeInput($_POST['new_password']);
            $repeatPassword = $this->userModel->sanitizeInput($_POST['repeat_password']);
    
            // Check if the user is logged in
            session_start();
            if (!isset($_SESSION['global_single_username'])) {
                return json_encode(["status" => false, "message" => "User not logged in"]);
            }
    
            // Get user info from the database
            $userInfo = $this->userModel->getUserInfo($_SESSION['global_single_username']);
    
            // Verify old password
            if (!password_verify($oldPassword, $userInfo['password'])) {
                return json_encode(["status" => false, "message" => "Old password is incorrect"]);
            }
    
            // Check if new passwords match
            if ($newPassword !== $repeatPassword) {
                return json_encode(["status" => false, "message" => "New passwords do not match"]);
            }
    
            // Hash new password
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    
            // Update password in the database
            $stmt = $this->db->prepare("UPDATE members SET password = ? WHERE username = ?");
            
            $stmt->bind_param("ss", $hashedNewPassword, $_SESSION['global_single_username']);
    
            if ($stmt->execute()) {
                return json_encode(["status" => true, "message" => "Password changed successfully"]);
            } else {
                return json_encode(["status" => false, "message" => "Failed to change password"]);
            }
        }

        public function UpdateWalletAddress(){

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return json_encode(["status" => false, "message" => "Invalid request method"]);
            }
    
            // Sanitize and validate input
            $wallet_address = $this->userModel->sanitizeInput($_POST['wallet_address']);
    
            // Check if the user is logged in
            session_start();

            if (!isset($_SESSION['global_single_username'])) {
                return json_encode(["status" => false, "message" => "User not logged in"]);
            }

            $username = $_SESSION['global_single_username'];
            // Update wallet address in the database
            $stmt = $this->db->prepare("UPDATE members SET wallet_address = ? WHERE username = ?");
            
            $stmt->bind_param("ss", $wallet_address, $_SESSION['global_single_username']);
    
            if ($stmt->execute()) {
                return json_encode(["status" => true, "message" => "Wallet address updated successfully"]);
            } else {
                return json_encode(["status" => false, "message" => "Failed to update wallet address"]);
            }
        }

        public function UpdateWalletPassword(){

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return json_encode(["status" => false, "message" => "Invalid request method"]);
            }

            $requiredFields = ['code', 'password', 'repeat_password'];
            $input = [];

            
            foreach ($requiredFields as $field) {
                $input[$field] = $this->userModel->sanitizeInput($_POST[$field] ?? '');
                if (empty($input[$field])) {
                    return json_encode(["status" => false, "message" => ucfirst($field) . " is required"]);
                }
            }
    
            // Sanitize and validate input
            $password = $input['password'];
            $repeat_password = $input['repeat_password'];
            $code = $input['code'];
            $retrievedCode = "";
    
            // Check if the user is logged in
            session_start();
            if (!isset($_SESSION['global_single_username'])) {
                return json_encode(["status" => false, "message" => "User not logged in"]);
            }

            $username = $_SESSION['global_single_username'];
            // Get user info from the database

            $userInfo = $this->userModel->getUserInfo($username);

            if (isset($_COOKIE['saved_code'])) {
                $retrievedCode = $_COOKIE['saved_code'];
            } else {
                return json_encode(["status" => false, "message" => "No code found or it expired."]);
            }

            if($retrievedCode != $code){
                return json_encode(["status" => false, "message" => "Incorrect Authentication code"]);
            }

            if($password != $repeat_password){
                return json_encode(["status" => false, "message" => "Password entries are not the same"]);
            }
            
            $hashedNewPassword = password_hash($password, PASSWORD_DEFAULT);
            // Update wallet username in the database
            $stmt = $this->db->prepare("UPDATE members SET wallet_password = ? WHERE username = ?");
            
            $stmt->bind_param("ss", $hashedNewPassword, $_SESSION['global_single_username']);
    
            if ($stmt->execute()) {
                // Set expiration to past time
                setcookie("saved_code", "", time() - 3600, "/", "/");
                return json_encode(["status" => true, "message" => "Wallet password updated successfully"]);
            } else {
                return json_encode(["status" => false, "message" => "Failed to update wallet"]);
            }
        }

        public function sendAuthenticationCode(){

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return json_encode(["status" => false, "message" => "Invalid request method"]);
            }

            session_start();
            if (!isset($_SESSION['last_email_time'])) {
                $_SESSION['last_email_time'] = time();
            } elseif (time() - $_SESSION['last_email_time'] < 300) { // 5-minute cooldown
                return json_encode(["status" => false, "message" => "Please wait for 5 minutes before requesting another code."]);
            }
    
            // Check if the user is logged in
           
            if (!isset($_SESSION['global_single_username'])) {
                return json_encode(["status" => false, "message" => "User not logged in"]);
            }
    
            // Get user info from the database
            $userInfo = $this->userModel->getUserInfo($_SESSION['global_single_username']);
            $username = $_SESSION['global_single_username'];
            $email = $userInfo['email'];
            $company_name = "Global Single Line";
            $year = date("Y");
            // Generate a random authentication code
            $verification_code = bin2hex(random_bytes(2)); // 5-character random code if not provided

            // Set cookie with 10-minute expiration (600 seconds)
            setcookie(
                'saved_code',          // Cookie name
                $verification_code,                 // Code value
                time() + 600,          // Expires in 10 minutes
                '/',                   // Available on entire domain
                '',                    // Domain (empty for current)
                false,                 // HTTPS only? (false for HTTP too)
                true                   // HttpOnly flag (security best practice)
            );
    
            // Send the authentication code to the user's email
            $subject = "Authentication Code";

            $_SESSION['last_email_time'] = time();

            $message = <<<EMAIL
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Your Authentication Code</title>
                </head>
                <body style="margin:0; padding:0; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height:1.6; color:#333; background:#f5f5f5;">
                    <!--[if (gte mso 9)|(IE)]>
                    <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                    <td>
                    <![endif]-->
                    
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">
                        <!-- Header -->
                        <tr>
                            <td align="center" bgcolor="#6c63ff" style="padding:30px 20px;">
                                <h1 style="color:white; margin:0; font-size:24px;">Your Authentication Code</h1>
                            </td>
                        </tr>
                        
                        <!-- Content -->
                        <tr>
                            <td style="padding:30px;">
                                <p style="margin:0 0 16px 0;">Hello {$username},</p>
                                <p style="margin:0 0 16px 0;">Here is your Authentication code (valid for <strong>10 minutes</strong>):</p>
                                
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td align="center" style="background:#f5f5ff; border:2px dashed #6c63ff; border-radius:8px; padding:20px; margin:25px 0;">
                                            <div style="font-size:28px; font-weight:bold; letter-spacing:2px; color:#6c63ff; font-family:monospace;">{$verification_code}</div>
                                        </td>
                                    </tr>
                                </table>
                                
                                <p style="margin:16px 0;">For security reasons, please don't share this code.</p>
                                <p style="margin:16px 0 0 0;">Best regards,<br>The {$company_name} Team</p>
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td bgcolor="#f5f5f5" style="padding:20px; text-align:center; font-size:12px; color:#777;">
                                <p style="margin:0;">&copy; {$year} {$company_name}. All rights reserved.</p>
                            </td>
                        </tr>
                    </table>
                    
                    <!--[if (gte mso 9)|(IE)]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
                </body>
                </html>
                EMAIL;
        
        //$message = "Hello {$username},\n\nYour verification code is: {$verification_code}\n\nThis code is valid for 10 minutes.";
            
            if ($this->userModel->sendmail($email, $_SESSION['global_single_username'], $message, $subject)) {
                return json_encode(["status" => true, "message" => "Authentication code sent successfully"]);
            } else {
                return json_encode(["status" => false, "message" => "Failed to send authentication code"]);
            }
        }

        public function processTransfer(){
            
            if (session_status() === PHP_SESSION_NONE){
                session_start();
            }

            try {

                $userInfo = $this->userModel->getUserInfo($_SESSION['global_single_username']);
                $username = $_SESSION['global_single_username'];
                $requiredFields = ['receiver', 'wallet', 'amount', 'wallet_password'];
                $input = [];
                $timezone = $this->userModel->sanitizeInput($_POST['timezone'] ?? '');
                foreach ($requiredFields as $field) {
                    $input[$field] = $this->userModel->sanitizeInput($_POST[$field] ?? '');
                    if (empty($input[$field])) {
                        throw new Exception(ucfirst($field) . " is required");
                    }
                }

                date_default_timezone_set($timezone ?? 'Africa/Lagos');

                $receiver = $input['receiver'];
                $amount = $input['amount'];
                $wallet_balance = $input['wallet'] == 'registration' ? $userInfo['reg_wallet'] : $userInfo['earning_wallet'];
                $wallet_password = $input['wallet_password'];
                $wallet_db_password = $userInfo['wallet_password'];
                $wallet_message = $input['wallet'] == 'registration' ? "Insufficient registration wallet balance" : "Insufficient earning wallet balance";

                //check if wallet is empty
                if($amount < 1){
                    return json_encode(["status" => false, "message" => "Transfer amount must be greater than 0"]);
                    throw new Exception(ucfirst($field) . " is required");
                }

                // Check password
                if (!password_verify($wallet_password, $wallet_db_password)){
                    throw new Exception("Incorrect wallet password");
                }

                if(!$this->userModel->getUserInfo($receiver)){
                    throw new Exception("Receiver username does not exist");
                }

                if($receiver === $username){
                    throw new Exception("You can not transfer to same account");
                }

                if($amount > $wallet_balance){
                    throw new Exception($wallet_message);
                }

                // Credit receiver
                $stmt = $this->db->prepare("UPDATE members SET reg_wallet = reg_wallet + ? WHERE username = ?");
                $stmt->bind_param("is", $amount, $receiver);
                $stmt->execute();
                $stmt->close();

                // Debit sender
                if($input['wallet']=="registration"){

                    $stmt = $this->db->prepare("UPDATE members SET reg_wallet = reg_wallet - ? WHERE username = ?");
                    $stmt->bind_param("is", $amount, $username);
                    $stmt->execute();
                    $stmt->close();

                }else{

                    $stmt = $this->db->prepare("UPDATE members SET earning_wallet = earning_wallet - ? WHERE username = ?");
                    $stmt->bind_param("is", $amount, $username);
                    $stmt->execute();
                    $stmt->close();

                }

                $this->userModel->InsertMultipleHistories([
                    [
                        'username' => $receiver,
                        'amount' => $amount,
                        'type' => 'credit',
                        'description' => 'Wallet transfer from ' . $username
                    ],
                    [
                        'username' => $username,
                        'amount' => $amount,
                        'type' => 'debit',
                        'description' => 'Wallet transfer to ' . $receiver
                    ]
                ]);

                $this->pushnotification->sendCustomNotifications([
                    [
                        'username' => $username, // Upline
                        'title' => 'Debit Alert!',
                        'body' => 'Dear ' .$username. ', Wallet transfer of $'. $amount .' to ' . $receiver .' was successful ',
                        'url' => $this->userModel->getCurrentUrl()
                    ],
                    [
                        'username' => $receiver, // Upper Upline
                        'title' => 'Credit Alert',
                        'body' => 'Dear ' .$receiver. ', Wallet transfer of $'. $amount .' from ' . $username .' was successful ',
                        'url' => $this->userModel->getCurrentUrl()
                    ],
                ]);

                return json_encode(["status" => true, "message" => "Wallet transfer of $$amount to " . $input['receiver'] . " was successful"]);

            } catch (Exception $e) {

                return json_encode([
                    'status' => false,
                    'message' => $e->getMessage()
                ]);

            }
        }

        public function processIntraTransfer(){

            if (session_status() === PHP_SESSION_NONE){
                session_start();
            }

            try {

                $userInfo = $this->userModel->getUserInfo($_SESSION['global_single_username']);
                $username = $_SESSION['global_single_username'];
                $requiredFields = ['wallet_pieces', 'amount', 'wallet_password'];
                $input = [];
                foreach ($requiredFields as $field) {
                    $input[$field] = $this->userModel->sanitizeInput($_POST[$field] ?? '');
                    if (empty($input[$field])) {

                        throw new Exception(ucfirst($field) . " is required");
                    }
                }

                $wallet_balance = $userInfo['vendor_wallet'];
                $wallet_db_password = $userInfo['wallet_password'];
                $converted_amount = $input['wallet_pieces'] * 9;

                // Check password
                if (!password_verify($input['wallet_password'], $wallet_db_password)){
                    throw new Exception("Incorrect wallet password");
                }

                if($converted_amount > $wallet_balance){
                    throw new Exception("Insuficient wallet balance");
                }

                //Credit wallet
                $stmt = $this->db->prepare("UPDATE members SET reg_wallet = reg_wallet + ? WHERE username = ?");
                $stmt->bind_param("is", $converted_amount, $username);
                $stmt->execute();
                $stmt->close();

                // Debit sender
                $stmt = $this->db->prepare("UPDATE members SET vendor_wallet = vendor_wallet - ? WHERE username = ?");
                $stmt->bind_param("is", $converted_amount, $username);
                $stmt->execute();
                $stmt->close();


                $this->userModel->InsertMultipleHistories([
                    [
                        'username' => $username,
                        'amount' => $input['amount'],
                        'receiver' => $username,
                        'type' => 'debit',
                        'description' => 'Wallet transfer to registration wallet was successful'
                    ],
                    [
                        'username' => $username,
                        'amount' => $input['amount'],
                        'receiver' => $username,
                        'type' => 'credit',
                        'description' => 'Wallet transfer from vendor wallet was successful'
                    ]
                ]);
                
                return json_encode(["status" => true, "message" => "Registration wallet credited successfully"]);

            } catch (Exception $e) {

                return json_encode([
                    'status' => false,
                    'message' => $e->getMessage()
                ]);

            }

        }

        public function fetchVendorRequests(){

            if (session_status() === PHP_SESSION_NONE){
                session_start();
            }

            if (isset($_SESSION['global_single_username'])){
                
                $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
                $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
                $rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10;
                $searchValue = $this->userModel->sanitizeInput($_POST['search']['value']); // Search value
            
                $data = $this->userModel->fetchTableRows($start,$rowperpage,$searchValue,"vendor_requests");
                
                $response = array(
                    "draw" => intval($draw),
                    "recordsTotal" => $data['recordsTotal'],
                    "recordsFiltered" => $data['totalRecordsWithFilter'],
                    "data" => $data['data']
                );

                echo json_encode($response);

            } else {
                echo json_encode(['error' => 'User not authenticated']);
            }
        }

        public function fetchAllWallets(){

            if (session_status() === PHP_SESSION_NONE){
                session_start();
            }

            if (isset($_SESSION['global_single_username'])){
                
                $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
                $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
                $rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10;
                $searchValue = $this->userModel->sanitizeInput($_POST['search']['value']); // Search value
            
                $data = $this->userModel->fetchTableRows($start,$rowperpage,$searchValue,"all_wallets");

                $response = array(
                    "draw" => intval($draw),
                    "recordsTotal" => $data['recordsTotal'],
                    "recordsFiltered" => $data['totalRecordsWithFilter'],
                    "data" => $data['data']
                );
                echo json_encode($response);
            } else {
                echo json_encode(['error' => 'User not authenticated']);
            }
        }

        public function fetchTransactionHistory(){
            if (session_status() === PHP_SESSION_NONE){
                session_start();
            }
            try {

                // Get request parameters
                $username = $_SESSION['global_single_username']; // Normally from session
                $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
                $per_page = 5;
                $offset = ($page - 1) * $per_page;

                $search = isset($_POST['search']) ? $this->db->real_escape_string($_POST['search']) : '';
                $type = isset($_POST['type']) ? $_POST['type'] : 'all';

                // Build query
                $query = "SELECT * FROM tranx_history WHERE username = '$username' ";
                $count_query = "SELECT COUNT(*) as total FROM tranx_history WHERE username = '$username' ";

                if (!empty($search)) {
                    $query .= " AND (description LIKE '%$search%' OR amount LIKE '%$search%') ";
                    $count_query .= " AND (description LIKE '%$search%' OR amount LIKE '%$search%') ";
                }

                if ($type !== 'all') {
                    $query .= " AND type = '$type' ";
                    $count_query .= " AND type = '$type' ";
                }

                // Add sorting and pagination
                $query .= "ORDER BY id DESC LIMIT $offset, $per_page";

                //var_export($query);

                // Execute queries
                $result = $this->db->query($query);
                $count_result = $this->db->query($count_query);
                $total_rows = $count_result->fetch_assoc()['total'];
                $total_pages = ceil($total_rows / $per_page);

                // Prepare response
                $transactions = [];
                while ($row = $result->fetch_assoc()) {
                    
                    $transactions[] = [
                        'id' => $row['id'],
                        'amount' => number_format($row['amount'], 2),
                        'type' => $row['type'],
                        'description' => $this->getDescription($row['description']),
                        'status' => 'Completed',
                        'date' => date('M d, Y h:i A', strtotime($row['date'])),
                        'icon' => $this->getTransactionIcon($row['type'], $row['description'])
                    ];

                }

                return json_encode([
                    'transactions' => $transactions,
                    'pagination' => [
                        'total' => $total_rows,
                        'per_page' => $per_page,
                        'current_page' => $page,
                        'total_pages' => $total_pages
                    ]
                ]);
                
            } catch (Exception $e) {
                http_response_code(500); // Internal Server Error
                return json_encode([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'debug_info' => [
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTrace()
                    ]
                ]);
                exit;
            }
        }

        public function getTransactionIcon($type, $description) {

            $icons = [
                'credit' => 'fa-arrow-down',
                'debit' => 'fa-arrow-up'
            ];
            
            // Special cases
            if (stripos($description, 'Registration Fee') !== false) return 'fa-mobile-alt';
            if (stripos($description, 'Referral Bonus') !== false) return 'fa-bolt';
            if (stripos($description, 'Reward') !== false) return 'fa-users';
            if (stripos($description, 'Wallet transfer') !== false) return 'fa-wallet';
            
            return $icons[$type] ?? 'fa-exchange-alt';

        }

        public function getDescription($description){
            if(stripos($description, 'Registration Fee') !== false) return 'Registration Fee';
            if(stripos($description, 'Referral bonus') !== false) return 'Referral Bonus';
            if(stripos($description, 'Indirect') !== false) return 'Indirect Bonus';
            if(stripos($description, 'Reward') !== false) return 'Circle out Reward';
            if(stripos($description, 'Wallet transfer') !== false) return 'Wallet transfer';
            if(stripos($description, 'Withdrawal') !== false) return 'Fund Withdrawal';
            if(stripos($description, 'Wallet Funding') !== false) return 'Wallet Funding';
            if(stripos($description, 'Vendor Application') !== false) return 'Vendor Application Fee';
        }

        public function fetchTransactionDetails(){
            header('Content-Type: application/json');
            if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
                throw new Exception('Invalid transaction ID');
            }

            $id = (int)$_POST['id'];

            $query = "SELECT * FROM tranx_history WHERE id = $id ";
            $result = $this->db->query($query);
            $row = $result->fetch_assoc();

            return json_encode([
                'id' => $row['id'],
                'date' => date('M d, Y h:i A', strtotime($row['date'])),
                'amount' => number_format($row['amount'], 2),
                'type' => $row['type'],
                'description' => $row['description'],
                'status' => 'completed'
            ]);

        }

    
        public function sendMessage() {

            header('Content-Type: application/json');

            // Get the raw POST data
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            $senderId = $data['sender_id'];
            $receiverId = $data['receiver_id'];
            $content = $data['content'];

            // Check if senderId and receiverId exist in the members table
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM members WHERE id = ?");
            
            // Check senderId
            $stmt->bind_param("i", $senderId);
            $stmt->execute();
            $result = $stmt->get_result();
            $senderExists = $result->fetch_assoc()['count'] > 0;

            // Check receiverId
            $stmt->bind_param("i", $receiverId);
            $stmt->execute();
            $result = $stmt->get_result();
            $receiverExists = $result->fetch_assoc()['count'] > 0;

            $stmt->close();

            // Determine if the message is from a guest
            $isGuest = !$senderExists || !$receiverExists ? 1 : 0;

            // Insert the message into the database
            $stmt = $this->db->prepare("INSERT INTO messages (sender_id, receiver_id, is_guest, content) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiis", $senderId, $receiverId, $isGuest, $content);
            $stmt->execute();

            return json_encode([
                'success' => true,
                'message_id' => $stmt->insert_id
            ]);
        }

        public function getConversation() {
            header('Content-Type: application/json');

            try {

                if (!isset($_GET['user1'], $_GET['user2'], $_GET['limit'], $_GET['offset'])) {
                    throw new Exception('Missing required parameters', 400);
                }

                $user1 = (int)$_GET['user1'];
                $user2 = (int)$_GET['user2'];
                $limit = (int)$_GET['limit'];
                $offset = (int)$_GET['offset'];

                // Get total count first
                $countQuery = "SELECT COUNT(*) AS total 
                            FROM messages 
                            WHERE (sender_id = ? AND receiver_id = ?) 
                                OR (sender_id = ? AND receiver_id = ?)";
                
                $countStmt = $this->db->prepare($countQuery);
                if (!$countStmt) throw new Exception("Count prepare failed: " . $this->db->error, 500);
                
                $countStmt->bind_param("iiii", $user1, $user2, $user2, $user1);
                $countStmt->execute();
                $countResult = $countStmt->get_result();
                $totalCount = $countResult->fetch_assoc()['total'] ?? 0;
                $countStmt->close();

                // Fetch paginated messages
                $query = "SELECT 
                            id,
                            content,
                            created_at,
                            sender_id,
                            receiver_id,
                            is_read
                        FROM messages
                        WHERE (sender_id = ? AND receiver_id = ?) 
                            OR (sender_id = ? AND receiver_id = ?)
                        ORDER BY created_at DESC
                        LIMIT ? OFFSET ?";
                
                $stmt = $this->db->prepare($query);
                if (!$stmt) throw new Exception("Prepare failed: " . $this->db->error, 500);

                $stmt->bind_param("iiiiii", $user1, $user2, $user2, $user1, $limit, $offset);
                $stmt->execute();
                $result = $stmt->get_result();
                $messages = $result->fetch_all(MYSQLI_ASSOC);
                $stmt->close();

                echo json_encode([
                    'success' => true,
                    'data' => $messages,
                    'meta' => [
                        'limit' => $limit,
                        'offset' => $offset,
                        'total' => (int)$totalCount,
                        'has_more' => ($offset + $limit) < $totalCount
                    ]
                ]);

            } catch (Exception $e) {
                http_response_code($e->getCode() ?: 500);
                echo json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ]);
            }
        }


        // Get conversation between two users
       /* public function getConversation() {
            header('Content-Type: application/json');

            if (!isset($_GET['user1'], $_GET['user2'], $_GET['limit'], $_GET['offset'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required parameters']);
                return;
            }

            $user1 = (int)$_GET['user1'];
            $user2 = (int)$_GET['user2'];
            $limit = (int)$_GET['limit'];
            $offset = (int)$_GET['offset'];


            $query = "SELECT 
                    id,
                    content,
                    created_at,
                    sender_id,
                    receiver_id,
                    is_read
                FROM messages
                WHERE (sender_id = ? AND receiver_id = ?)
                OR (sender_id = ? AND receiver_id = ?)
                ORDER BY created_at DESC
                LIMIT ? OFFSET ?
            ";

            $stmt = $this->db->prepare($query);
            if (!$stmt) {
                http_response_code(500);
                echo json_encode(['error' => 'Database error']);
                return;
            }

            $stmt->bind_param("iiiiii", $user1, $user2, $user2, $user1, $limit, $offset);

            if (!$stmt->execute()) {
               
                http_response_code(500);
                echo json_encode(['error' => 'Query execution failed']);
                return;
            }

             

            $result = $stmt->get_result();
            //$messages = $result->fetch_all(MYSQLI_ASSOC);
            $messages = [];

            while ($row = $result->fetch_assoc()) {
                $messages[] = $row;
            }

            error_log(print_r($messages, true));

            echo json_encode($messages);
        }*/


        

        // Mark messages as read
        public function markAsRead() {

            header('Content-Type: application/json');
            $data = json_decode(file_get_contents('php://input'), true);

            $message_id = intval($data['message_id']);
            $message_info = $this->userModel->getMessageInfo($message_id);
            $one = 1;
            $zero = 0;

            $stmt = $this->db->prepare("UPDATE messages SET is_read = ? WHERE id = ?");
            $stmt->execute([$one,$message_id]);

            if ($stmt->execute()) {

                $affectedRows = $stmt->affected_rows;
                
                return json_encode([
                    'success' => true,
                    'message_id' => $message_id,
                    'senderId' => $message_info['sender_id']
                ]);

            } else {

                http_response_code(500);
                return json_encode([
                    'success' => false,
                    'error' => 'Database error: ' . $stmt->error
                ]);

            }

        }

        public function fetchVendors() {

            if (session_status() === PHP_SESSION_NONE){
                session_start();
            }
        
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $sort = isset($_GET['sort']) && $_GET['sort'] === 'rating' ? 'rating DESC' : 'username ASC';
            $username = $_SESSION['global_single_username'];
            $one = 1;
        
            $query = "SELECT m.id, m.username, m.avatar, COALESCE(AVG(r.rating), 0) as rating, COUNT(r.id) as rating_count
                      FROM members m
                      LEFT JOIN ratings r ON m.id = r.vendor_id
                      WHERE m.username != ? AND m.vendor_access = ? AND m.username LIKE ?
                      GROUP BY m.id
                      ORDER BY $sort";
        
            $stmt = $this->db->prepare($query);
            $likeSearch = "%$search%";
            $stmt->bind_param("sis", $username, $one, $likeSearch);
            $stmt->execute();
            $result = $stmt->get_result();
        
            $vendors = [];
        
            while ($row = $result->fetch_assoc()) {
                $vendors[] = [
                    'id' => $row['id'],
                    'username' => $row['username'],
                    'avatar' => $row['avatar'] ?: 'default.jpg',
                    'rating' => round($row['rating'], 1),
                    'rating_count' => $row['rating_count']
                ];
            }
        
            echo json_encode($vendors);
        }
        

        public function InsertRatings(){

            header('Content-Type: application/json');

            // Get the raw POST data
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            if (session_status() === PHP_SESSION_NONE){
                session_start();
            }

            $userInfo = $this->userModel->getUserInfo($_SESSION['global_single_username']);

            if (!$userInfo) {
                http_response_code(401);
                return json_encode(['error' => 'Unauthorized']);
                exit;
            }
            
            $vendorId = (int)$data['vendor_id'];
            $rating = min(5, max(1, (int)$data['rating']));
            $userId = (int)$userInfo['id'];
            $one = 1;
            
            // Verify vendor exists and has vendor access
            $checkVendor = $this->db->prepare("SELECT id FROM members WHERE id = ? AND vendor_access = ?");
            $checkVendor->bind_param("ii", $vendorId,$one);
            $checkVendor->execute();
            
            if ($checkVendor->get_result()->num_rows === 0) {
                http_response_code(404);
                return json_encode(['error' => 'Vendor not found']);
            }
            
            // Check if user already rated this vendor
            $check = $this->db->prepare("SELECT id FROM ratings WHERE user_id = ? AND vendor_id = ?");
            $check->bind_param("ii", $userId, $vendorId);
            $check->execute();
            
            if ($check->get_result()->num_rows > 0) {
                // Update existing rating
                $stmt = $this->db->prepare("UPDATE ratings SET rating = ? WHERE user_id = ? AND vendor_id = ?");
                $stmt->bind_param("iii", $rating, $userId,  $vendorId);
            } else {
                // Insert new rating
                $stmt = $this->db->prepare("INSERT INTO ratings (user_id, vendor_id, rating) VALUES (?, ?, ?)");
                $stmt->bind_param("iii", $userId,  $vendorId, $rating);
            }
            
            if ($stmt->execute()) {
                return json_encode(['success' => true]);
            } else {
                http_response_code(500);
                return json_encode(['error' => 'Database error']);
            }
        }

        public function saveSubscriptions(){
            // Allow requests from anywhere (CORS). Restrict in production.
            if (session_status() === PHP_SESSION_NONE){
                session_start();
            }
            //error_log("I got here");
            $username = $_SESSION['global_single_username']; 

            // Get raw POST data
            $checkusername = $this->db->prepare("select username from push_subscriptions where username = ?");
            $checkusername->bind_param("s", $username);
            $checkusername->execute();
            $result = $checkusername->get_result();
            if ($result->num_rows > 0) {
                return;
                exit;
            }

            $input = json_decode(file_get_contents('php://input'), true);
    
            if (isset($input['subscription'])) {

                $subscription = $input['subscription'];

                // Store in database
                $stmt = $this->db->prepare("INSERT INTO push_subscriptions  (endpoint, public_key, auth_token, username)  VALUES (?, ?, ?, ?)");
                $stmt->execute([
                    $subscription['endpoint'],
                    $subscription['keys']['p256dh'],
                    $subscription['keys']['auth'],
                    $username
                ]);
                
                echo json_encode(['success' => true]);
                exit;

            }

        }

        public function updateNotification(){
            $id = $_POST['id'];
            $checked = ($_POST['checked']=="true") ? 1 : 0;

            $stmt = $this->db->prepare("UPDATE members SET notification_access = ? WHERE id = ?");
            $stmt->bind_param("ii", $checked, $id);
            if ($stmt->execute()) {
                if($checked==1){
                    return json_encode(["status" => true, "message" => "Notification enabled successfully"]);
                } else {
                    return json_encode(["status" => false, "message" => "Notification disabled successfully"]);
                }
            } else {
                http_response_code(500);
                return json_encode(['error' => 'Database error']);
            }

        }

        /*public function fetchChatHistory(){

            // Start session if not already started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $userInfo = $this->userModel->getUserInfo($_SESSION['global_single_username'] ?? '');
            $currentUserId = $userInfo['id'] ?? $_SESSION['guest_id'];
            try {
                // Prepare the query
                $query = "
                    SELECT 
                        u.id as user_id,
                        u.username,
                        u.avatar,
                        MAX(m.created_at) as last_message_time,
                        SUM(CASE WHEN m.is_read = 0 AND m.receiver_id = ? THEN 1 ELSE 0 END) as unread_count,
                        (
                            SELECT content 
                            FROM messages 
                            WHERE (sender_id = u.id OR receiver_id = u.id) 
                            AND (sender_id = ? OR receiver_id = ?)
                            ORDER BY created_at DESC 
                            LIMIT 1
                        ) as last_message
                    FROM 
                        members u
                    JOIN 
                        messages m ON (u.id = m.sender_id OR u.id = m.receiver_id)
                    WHERE 
                        (m.sender_id = ? OR m.receiver_id = ?)
                        AND u.id != ?
                    GROUP BY 
                        u.id, u.username, u.avatar
                    ORDER BY 
                        last_message_time DESC
                ";

                // Prepare and bind parameters
                $stmt = $this->db->prepare($query);
                $stmt->bind_param("iiiiii", 
                    $currentUserId, 
                    $currentUserId, 
                    $currentUserId, 
                    $currentUserId, 
                    $currentUserId, 
                    $currentUserId
                );

                // Execute query
                $stmt->execute();
                $result = $stmt->get_result();

                $chats = [];
                while ($row = $result->fetch_assoc()) {
                    $chats[] = $row;
                }

                return json_encode([
                    'success' => true,
                    'chats' => $chats
                ]);

            } catch (Exception $e) {

                return json_encode([
                    'success' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ]);

            } finally {
                // Close connections
                $stmt->close();
                $this->db->close();
            }
        }*/

        public function fetchChatHistory() {
            // Start session if not already started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $userInfo = $this->userModel->getUserInfo($_SESSION['global_single_username'] ?? '');
            $currentUserId = $userInfo['id'] ?? ($_SESSION['guest_id'] ?? null);

            if ($currentUserId === null) {
                return json_encode([
                    'success' => false,
                    'message' => 'User not identified'
                ]);
            }

            try {
                $query = "
                    SELECT 
                        CASE 
                            WHEN m.sender_id = ? THEN m.receiver_id 
                            ELSE m.sender_id 
                        END AS user_id,
                        MAX(m.created_at) as last_message_time,
                        SUM(CASE WHEN m.is_read = 0 AND m.receiver_id = ? THEN 1 ELSE 0 END) as unread_count,
                        (
                            SELECT content 
                            FROM messages 
                            WHERE (sender_id = ? AND receiver_id = user_id)
                            OR (sender_id = user_id AND receiver_id = ?)
                            ORDER BY created_at DESC 
                            LIMIT 1
                        ) as last_message
                    FROM 
                        messages m
                    WHERE 
                        m.sender_id = ? OR m.receiver_id = ?
                    GROUP BY 
                        user_id
                    ORDER BY 
                        last_message_time DESC
                ";

                $stmt = $this->db->prepare($query);
                $stmt->bind_param("iiiiii", 
                    $currentUserId, 
                    $currentUserId, 
                    $currentUserId, 
                    $currentUserId, 
                    $currentUserId,
                    $currentUserId
                );
                $stmt->execute();
                $result = $stmt->get_result();

                $chats = [];
                while ($row = $result->fetch_assoc()) {
                    $chatUserId = $row['user_id'];
                     $user = $this->userModel->getUserInfo($chatUserId);
                    if (!empty($user)) {
                        // Registered user
                        $row['username'] = $user['username'] ?? 'Unknown';
                        $row['avatar'] = $user['avatar'] ;
                    } else {
                        // Guest user
                        $row['username'] = 'Guest #' . $chatUserId;
                        $row['avatar'] = 'avatar-1.jpg'; // Replace with your guest avatar file
                    }

                    $chats[] = $row;
                }

                return json_encode([
                    'success' => true,
                    'chats' => $chats
                ]);

            } catch (Exception $e) {
                error_log($e->getMessage());
                return json_encode([
                    'success' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ]);
            } finally {
                $stmt->close();
                $this->db->close();
            }
        }


        public function processWithdrawal(){

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                return json_encode(["status" => false, "message" => "Invalid request method"]);
            }

            $requiredFields = ['code', 'amount', 'address'];
            $input = [];

            
            foreach ($requiredFields as $field) {
                $input[$field] = $this->userModel->sanitizeInput($_POST[$field] ?? '');
                if (empty($input[$field])) {
                    return json_encode(["status" => false, "message" => ucfirst($field) . " is required"]);
                }
            }
    
            // Sanitize and validate input
            $amount = $input['amount'];
            $address = $input['address'];
            $code = $input['code'];
            $retrievedCode = "";
    
            // Check if the user is logged in
            session_start();
            if (!isset($_SESSION['global_single_username'])) {
                return json_encode(["status" => false, "message" => "User not logged in"]);
            }

            $username = $_SESSION['global_single_username'];
            // Get user info from the database

            $userInfo = $this->userModel->getUserInfo($username);

            if (isset($_COOKIE['saved_code'])) {
                $retrievedCode = $_COOKIE['saved_code'];
            } else {
                return json_encode(["status" => false, "message" => "No code found or it expired."]);
            }

            if($amount + 1 > $userInfo['earning_wallet']){
                return json_encode(["status" => false, "message" => "Insufficient Wallet balance"]);
            }

            if($amount < 0){
                return json_encode(["status" => false, "message" => "Minimum withdrawal is $10"]);
            }

            if($retrievedCode != $code){
                return json_encode(["status" => false, "message" => "Invalid Authentication code"]);
            }

           /* if (!$this->userModel->isValidTonAddressBasic($address)) {
                return json_encode(["status" => false, "message" => "Invalid TON Address"]);
            }*/

            $info = $this->userModel->validateTonAddressViaToncenter($address, TON_API_KEY);
            if (isset($info['error'])) {
                return json_encode(["status" => false, "message" => "Invalid TON address"]);
            }

            /*$sendTON =  $this->sendTON->send(
                $address, // Recipient address
                $amount, // Amount in TON
                'Test payment', // Optional message
                true // Validate balance first
            );*/

            $response = $this->userModel->sendTON($address, $amount);


            $description = "Withdrawal of " . $input['amount'] . " to $address";

           //error_log(print_r($response));

            if (isset($response['status']) && $response['status']===true) {

                $txHash = $response['lt'] ?? null;

                $date = date('Y-m-d H:i:s');

                $history_id = $this->userModel->InsertHistory($username, $input['amount'], $date, 'debit', $description);

                $this->userModel->logTransaction($history_id, $address, $input['amount'], $txHash, 'pending'); // Replace '1' with your user id

                $this->userModel->deductWallet($input['amount'], $username);

                $url = $this->userModel->getCurrentUrl() . '/transaction_history';

                //$this->pushnotification->sendNotification($username,'Withdrawal Request',"Withdrawal of $" . number_format($input['amount'],2) . " to $address was successful", $url);

                return json_encode(['status' => true, 'message' => "Congratulations, withdrawal was successful"]);

            }else{

                return json_encode(['status' => false, 'message' => "Withdrawal failed. Please try again later"]);

            }

        }

        public function processWalletTransfer(){

            try{

                $wallet_id = $_POST['id'];
                $type = $_POST['type'];

                if($type === 'transfer_fund'){

                    $wallet_info = $this->userModel->getUserWallet($wallet_id);
                    $amount = $this->userModel->getTonBalance($wallet_info['wallet_address']);
                    /*if($amount === 0){
                        throw new Exception("Zero wallet balance");
                    }*/
                    
                    $transfer = $this->userModel->transferWalletFunds($wallet_info['mnemonic'], $amount);

                    if(isset($transfer['status']) && $transfer['status']=== true){
                        return json_encode(['status' => true, 'message' => "Wallet transfer was successful"]);
                    }else{
                        throw new Exception($transfer['message']);
                    }

                }

                if($type === 'delete_wallet'){

                    $this->userModel->deleteWallet($wallet_id);
                    return json_encode(['status' => true, 'message' => "Wallet was deleted successfully"]);

                }

                

            } catch (Exception $e) {

                return json_encode([
                    'status' => false,
                    'message' => $e->getMessage()
                ]);

            }
               
        }

        public function processPassword(){
            if (session_status() === PHP_SESSION_NONE){
                session_start();
            }

            $email = $_POST['email'] ?? '';

            if (empty($email)) {
                return json_encode(["status" => false, "message" => "Email is required"]);
            }

            $userInfo = $this->userModel->getUserEmail($email);

            if (!$userInfo) {
                return json_encode(["status" => false, "message" => "Email not found"]);
            }

            $temporaryPassword = bin2hex(random_bytes(3));
            $userName = $userInfo['username'];
            $appName = "GlobalSingleLine";
            $loginLink = $this->userModel->getCurrentUrl() . '/login';
            $subject = 'Forgot Password';
            
            // Build the HTML email using the template
            $emailTemplate = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Password Reset Request</title>
            </head>
            <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
                <div style="background-color: #4a6bff; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0;">
                    <h1 style="margin: 0;">Password Reset Request</h1>
                </div>
                <div style="padding: 25px; background-color: #f9f9f9; border-radius: 0 0 8px 8px; border: 1px solid #e0e0e0;">
                    <p>Hello ' . htmlspecialchars($userName) . ',</p>
                    <p>We received a request to reset your password for your account at ' . htmlspecialchars($appName) . '. Here\'s your temporary password:</p>
                    
                    <div style="background-color: #f0f4ff; border: 1px dashed #4a6bff; padding: 12px; text-align: center; font-size: 18px; font-weight: bold; margin: 15px 0; border-radius: 4px;">
                        ' . htmlspecialchars($temporaryPassword) . '
                    </div>
                    
                    <p><strong style="color: #d9534f;">Important:</strong></p>
                    <ul style="padding-left: 20px; margin-bottom: 20px;">
                        <li>Log in immediately and change your password in Account Settings.</li>
                        <li>If you didn\'t request this, please secure your account.</li>
                    </ul>
                    
                    <a href="' . htmlspecialchars($loginLink) . '" style="display: inline-block; background-color: #4a6bff; color: white !important; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold; margin: 15px 0;">Log In Now</a>
                    
                    <p>For security reasons, do not share this email or password with anyone.</p>
                    <p>Best regards,<br>The ' . htmlspecialchars($appName) . ' Team</p>
                </div>
            </body>
            </html>';

            // Update the user's password in the database
            $hashedPassword = password_hash($temporaryPassword, PASSWORD_DEFAULT);
            $this->userModel->updatepassword($email, $hashedPassword);
        
            //send email
            $send = $this->userModel->sendmail($email,$userName,$emailTemplate,$subject);

            if ($send) {
                return json_encode(["status" => true, "message" => "Password reset was successful, A temporary password has just been sent to your email"]);
            } else {
                return json_encode(["status" => false, "message" => "Failed to send email"]);
            }
        }

        public function Logout() {
                // Start session if not already started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        
            // Try to get redirect from GET param or fallback to HTTP_REFERER
            $raw_redirect = $_GET['redirect'] ?? ($_SERVER['HTTP_REFERER'] ?? '');
            $redirect = '';
        
            if (!empty($raw_redirect)) {
                $parsed_url = parse_url($raw_redirect);
        
                // Only allow relative internal paths (no host, no scheme)
                if (!isset($parsed_url['host']) && isset($parsed_url['path'])) {
                    $redirect = '/dashboard' . $parsed_url['path'];
                    
                    // Optionally append query string if available
                    if (isset($parsed_url['query'])) {
                        $redirect .= '/dashboard?' . $parsed_url['query'];
                    }
                }
            }
        
            // Fallback to a safe page (e.g., homepage or dashboard)
            if (empty($redirect) || stripos($redirect, 'logout') !== false) {
                $redirect =  '/dashboard'; // Change this to your preferred fallback page
            }
        
            // Unset and destroy session
            unset($_SESSION['global_single_username']);
            session_destroy();
        
            // Redirect safely
            if (!headers_sent()) {
                header("Location: login?redirect=" . urlencode($redirect));
                exit;
            } else {
                echo "Error: Headers already sent. Cannot redirect.";
            }
        }

        public function fetchAllUsers(){
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            } // Ensure session is started
            if (isset($_SESSION['global_single_username'])){
                
                $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
                $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
                $rowperpage = isset($_POST['length']) ? intval($_POST['length']) : 10;
                $searchValue = $this->userModel->sanitizeInput($_POST['search']['value']); // Search value
            
                $data = $this->userModel->fetchTableRows($start,$rowperpage,$searchValue,"all_users");

                $response = array(
                    "draw" => intval($draw),
                    "recordsTotal" => $data['recordsTotal'],
                    "recordsFiltered" => $data['totalRecordsWithFilter'],
                    "data" => $data['data']
                );
                echo json_encode($response);

            } else {
                echo json_encode(['error' => 'User not authenticated']);
            }
        }

        public function submitVendorApplication(){

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $response = ['status' => false, 'message' => ''];

            try {
                // Validate required fields
                if (empty($_FILES['imageFile']) || empty($_POST['why']) || empty($_POST['experience'])) {
                    throw new Exception("All fields are required");
                }
        
                // File upload handling
                $uploadDir = 'public/assets/images/vendors/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
        
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                $file = $_FILES['imageFile'];
                $fileType = mime_content_type($file['tmp_name']);
        
                // Validate file
                if (!in_array($fileType, $allowedTypes)) {
                    throw new Exception("Only JPG, JPEG, and PNG files are allowed");
                }
        
                if ($file['size'] > 2 * 1024 * 1024) { // 2MB limit
                    throw new Exception("File size must be less than 2MB");
                }
        
                // Generate unique filename
                $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
                $fileName = 'vendor_id_' . $_SESSION['global_single_username'] . '_' . time() . '.' . $fileExt;
                $uploadPath = $uploadDir . $fileName;
        
                // Move uploaded file
                if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    throw new Exception("Failed to upload file");
                }
        
                // Prepare data for database
                $username = $_SESSION['global_single_username']; // Assuming user is logged in
                $experience = htmlspecialchars($_POST['experience']);
                $whyVendor = htmlspecialchars($_POST['why']);
                $status = 'pending'; // Initial status
                $applicationDate = date('Y-m-d H:i:s');
        
                // Insert into database
                $stmt = $this->db->prepare("INSERT INTO vendor_application (username, experience, reason_why, fileImage, status, date) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $username, $experience, $whyVendor, $uploadPath, $status, $applicationDate);
                $stmt->execute();
                $stmt->close();

                $response = [
                    'status' => true,
                    'message' => 'Application submitted successfully!',
                    'redirect' => 'vendor_thankyou.php'
                ];

                header('Content-Type: application/json');
                echo json_encode($response);
        
            } catch (Exception $e) {

                $response['message'] = $e->getMessage();

                header('Content-Type: application/json');
                echo json_encode($response);
                
                // Delete the file if upload succeeded but DB failed
                if (!empty($uploadPath) && file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
            }
        }

        public function processVendorRequest(){

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $response = ['status' => false, 'message' => ''];

            try {
                // Validate required fields
                if (empty($_POST['id']) || empty($_POST['username'])) {
                    throw new Exception("All fields are required");
                }

                $username = $this->userModel->sanitizeInput($_POST['username']);
                $id = intval($_POST['id']);
        
                // File upload handling
                $userInfo = $this->userModel->getUserInfo($username);
                $earning_balance = $userInfo['earning_wallet'];
                $amount = 5;
        
                // Prepare data for database
                $workedby = $_SESSION['global_single_username']; // Assuming user is logged in
                $message = htmlspecialchars($_POST['message']);
                $status = $_POST['status']; // Initial status
                $applicationDate = date('Y-m-d H:i:s');

                if($status=='approved'){

                    if($earning_balance < 5){
                        throw new Exception("User must have a minimum of $5 in their earning balance");
                    }

                    $generate_wallet = $this->userModel->generateTonWallet($username);
                    error_log("Wallet Response: " . $generate_wallet);

                    $generate_response = json_decode($generate_wallet, true);

                    if ($generate_response === null) {
                        throw new Exception("Invalid JSON: " . json_last_error_msg());
                    }

                    if (!isset($generate_response['status'])) {
                        throw new Exception("Missing 'status' in response.");
                    }

                    if ($generate_response['status'] === false) {
                        throw new Exception($generate_response['message']);
                    }

                    $stmt = $this->db->prepare("UPDATE vendor_application SET status = ?, workedby = ? WHERE id = ?");
                    $stmt->bind_param("ssi", $status,$workedby,$id);
                    $stmt->execute();
                    $stmt->close();

                    $one = 1;

                    $stmt = $this->db->prepare("UPDATE members SET earning_wallet = earning_wallet - ?, vendor_access = ? WHERE username = ?");
                    $stmt->bind_param("sis", $amount, $one, $username);
                    $stmt->execute();
                    $stmt->close();

                    $date = date('Y-m-d H:i:s');

                    $this->userModel->InsertHistory($username, $amount, $date, 'debit', 'Vendor Application Fee');

                    $this->pushnotification->sendCustomNotifications([
                        [
                            'username' => $username, // Upline
                            'title' => 'Alert!',
                            'body' => 'Dear ' .$username. ', Congratulations, Your application for GlobalSingle Vendorship has just been approved. The sum of $'. $amount .' has just been deducted from your earning wallet',
                            'url' => $this->userModel->getCurrentUrl()
                        ]
                    ]);

                    $response = [
                        'status' => true,
                        'message' => 'Application was approved successfully!',
                    ];

                    header('Content-Type: application/json');
                    echo json_encode($response);

                }

                if($status=="rejected"){

                    $stmt = $this->db->prepare("UPDATE vendor_application SET status = ?, admin_notes = ?, workedby = ? WHERE id = ?");
                    $stmt->bind_param("sssi", $status,$message,$workedby,$id);
                    $stmt->execute();
                    $stmt->close();

                    $this->pushnotification->sendCustomNotifications([
                        [
                            'username' => $username, // Upline
                            'title' => 'Debit Alert!',
                            'body' => 'Dear ' .$username. ', Ooops, We are sorry to announce to you that your application for GlobalSingle Vendorship was rejected.',
                            'url' => $this->userModel->getCurrentUrl()
                        ]
                    ]);

                    $response = [
                        'status' => true,
                        'message' => 'Application was rejected successfully!',
                    ];

                    header('Content-Type: application/json');
                    echo json_encode($response);

                }

        
            } catch (Exception $e) {

                $response['message'] = $e->getMessage();

                header('Content-Type: application/json');
                echo json_encode($response);
            
            }
        }

        
        

    }

?>