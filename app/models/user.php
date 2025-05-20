<?php
require __DIR__ . '../../../public/assets/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;


class usersModel {

    private $conn;
    private $table = 'members';
    private $stages = [];
    private $encryption;
    private $pushnotification;
    private $rootUrl;

    public function __construct($db) {

        $this->conn = $db;
        $this->encryption = new EncryptionHelper(ENCRYPTION_KEY);
        $this->pushnotification = new PushNotificationService($this->conn,VAPID_PUBLIC_KEY,VAPID_PRIVATE_KEY);
        $this->stages = [
            ['stage' => 1, 'downlines' => 2, 'total_downlines' => 15, 'compensation' => 6, 'task_info' => 'In this stage, your task is to personally recruit 2 downlines and accumulate 15 global downlines.'],
            ['stage' => 2, 'downlines' => 4, 'total_downlines' => 75, 'compensation' => 16, 'task_info' => 'In this stage, your task is to personally recruit 4 downlines and accumulate 75 global downlines.'],
            ['stage' => 3, 'downlines' => 4, 'total_downlines' => 375, 'compensation' => 39, 'task_info' => 'In this stage, your task is to personally recruit 4 downlines and accumulate 375 global downlines.'],
            ['stage' => 4, 'downlines' => 6, 'total_downlines' => 1875, 'compensation' => 77, 'task_info' => 'In this stage, your task is to personally recruit 6 downlines and accumulate 1875 global downlines.'],
            ['stage' => 5, 'downlines' => 8, 'total_downlines' => 9375, 'compensation' => 240, 'task_info' => 'In this stage, your task is to personally recruit 8 downlines and accumulate 9375 global downlines.'],
            ['stage' => 6, 'downlines' => 8, 'total_downlines' => 46875, 'compensation' => 1988, 'task_info' => 'In this stage, your task is to personally recruit 8 downlines and accumulate 46875 global downlines.'],
            ['stage' => 7, 'downlines' => 18, 'total_downlines' => 234375, 'compensation' => 9986,'task_info'=>'In this stage, your task is to personally recruit 18 downlines and accumulate 234375 global downlines.']
        ];

    }

    public function getAllStages() {
        return $this->stages;
    }

    public function getStageInfo($stageNumber) {
        foreach ($this->stages as $stage) {
            if ($stage['stage'] === $stageNumber) {
                return $stage;
            }
        }
        return null;
    }

    public function sanitizeInput($data) {
        if (is_array($data)) {
            // Loop through each element of the array and sanitize recursively
            foreach ($data as $key => $value) {
                $data[$key] = $this->sanitizeInput($value);
            }
        } else {
            // If it's not an array, sanitize the string
            $data = trim($data); // Remove unnecessary spaces
            $data = stripslashes($data); // Remove backslashes
            $data = htmlspecialchars($data); // Convert special characters to HTML entities
        }
        return $data;
    }

    public function getCurrentUrl() {
          // Check if HTTPS is on or not
          $isHttps = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? true : false;
          // Get the host (domain name) and the requested URI
          $host = $_SERVER['HTTP_HOST'];
          // Get the HTTP protocol (http or https)
          $protocol = $isHttps ? 'https://' . $host : 'http://' . $host .'/globalsingle';
  
          //$uri = $_SERVER['REQUEST_URI'];
  
          // Build the full URL
          $fullUrl = $protocol;
  
          // Return an associative array with the information
          return $fullUrl;
    }

    public function checkTransactionhash($hash) {
        $stmt = $this->conn->prepare("SELECT * FROM wallet_funding_log  WHERE tranx_hash = ?");
        $stmt->bind_param("s", $hash);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0; // Return true if display name exists, false otherwise
    }

    public function getUserInfo($username) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE username = ? OR id = ?");
        $stmt->bind_param("si", $username,$username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getUserWallet($username) {
        $stmt = $this->conn->prepare("SELECT * FROM user_wallets WHERE username = ? OR id = ?");
        $stmt->bind_param("si", $username,$username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getMessageInfo($id) {
        $stmt = $this->conn->prepare("SELECT * FROM messages WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getUserEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function InsertHistory($username, $amount, $type, $description) {
        $stmt = $this->conn->prepare("INSERT INTO tranx_history (username, amount, date, type, description) VALUES (?, ?, NOW(), ?, ?)");
        $stmt->bind_param("ssss", $username, $amount, $type, $description);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function InsertFundingLog($username, $amount, $hash, $sender) {
        $stmt = $this->conn->prepare("INSERT INTO wallet_funding_log (username, amount, tranx_hash, sender, date) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $username, $amount, $hash, $sender);
        $stmt->execute();
        $stmt->close();
    }

    public function fetchSponsor($sponsor){
        $stmt = $this->conn->prepare("SELECT sponsor FROM referral_tree WHERE username = ?");
        $stmt->bind_param("s", $sponsor);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function fetchHistoryDetails($id){
        $stmt = $this->conn->prepare("SELECT username FROM tranx_history WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    public function countDownlines($username, $stage) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM referral_tree WHERE sponsor = ? and sponsor_stage = ?");
        $stmt->bind_param("si", $username,$stage);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function countGlobalDownlines($date, $max) {
        $query = "SELECT id FROM members WHERE reg_date > ? LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $date, $max);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows; // Only counts up to $max
    }

    public function deductWallet($amount, $username){
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET earning_wallet = earning_wallet - ? WHERE username = ?");
        $stmt->bind_param("ss", $amount, $username);
        $stmt->execute();
        $stmt->close();
    }

    public function fetchAdmins(){
        $one = 1;
        $stmt = $this->conn->prepare("SELECT id, username FROM members WHERE admin_access = ?");
        $stmt->bind_param("i", $one);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            // Fetch all rows as an associative array
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return []; // Return an empty array if no rows found
        }
    }

    public function calculatePercentage($part, $total, $decimalPlaces = 2) {
        if ($total == 0) {
            return "0%"; // avoid division by zero
        }
    
        $percentage = ($part / $total) * 100;
        return round($percentage, $decimalPlaces);
    }

    public function updateStage($username, $amount, $stage, $page_access = 0) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET stage = ?, earning_wallet = earning_wallet + ?, page_access = ? WHERE username = ?");
        $stmt->bind_param("iiis", $stage, $amount, $page_access, $username);
        $stmt->execute();
        $stmt->close();
    }

    public function curlRequest(string $url, string $method = 'GET', array $data = []): array {
        $ch = curl_init();
        
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FAILONERROR => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2TLS,
        ];
        
        if ($method === 'POST') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
            $options[CURLOPT_HTTPHEADER] = ['Content-Type: application/json'];
        }
        
        curl_setopt_array($ch, $options);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($error) throw new Exception("cURL error: $error");
        if ($httpCode !== 200) throw new Exception("API request failed with HTTP code $httpCode");
        
        $result = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) throw new Exception("Invalid JSON response");
        
        return $result;
    }

    public function getVendorInfo($username) {

        $username = trim($username);
    
        $query = "SELECT * FROM vendor_application WHERE username = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
    
        $stmt->bind_param("s", $username);
        $stmt->execute();
    
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
    
        $stmt->close();
    
        return [
            'count' => $data ? 1 : 0,
            'data' => $data ?: null
        ];

    }
    
    public function fetchTableRows($start, $rowperpage, $searchValue, $tabletype) {
        $searchQuery = "";
        $params = [];
        $paramTypes = "";
        $query = "";
        $user = $_SESSION['global_single_username'] ?? "";
        $rootUrl = $this->getCurrentUrl();

        if ($tabletype === 'transaction_history') {

            $query = "SELECT id, username, amount, date, receiver, description, type FROM tranx_history WHERE username = ?"; // Adjust column names and table as needed
            $params[] = $user;
            $paramTypes .= "s";
            if (!empty($searchValue)) {
                $searchQuery = " WHERE username LIKE ? OR amount LIKE ?";
                $params[] = "%$searchValue%";
                $params[] = "%$searchValue%";
                $paramTypes .= "ss";
            }
    
            $query .= "$searchQuery ORDER BY id DESC LIMIT ?, ?";

        } elseif ($tabletype === 'all_users') {

            $query = "SELECT id, username, email, reg_date, country, avatar, stage FROM members"; // Adjust column names and table as needed
            if (!empty($searchValue)) {
                $searchQuery = " WHERE username LIKE ? OR email LIKE ?";
                $params[] = "%$searchValue%";
                $params[] = "%$searchValue%";
                $paramTypes .= "ss";
            }
    
            $query .= "$searchQuery ORDER BY id DESC LIMIT ?, ?";

        } elseif ($tabletype === 'vendor_requests') {

            $query = "SELECT id, username, experience, reason_why, admin_notes, fileImage, date, status FROM vendor_application"; // Adjust column names and table as needed
            if (!empty($searchValue)) {
                $searchQuery = " WHERE username LIKE ?";
                $params[] = "%$searchValue%";
                $paramTypes .= "s";
            }
    
            $query .= "$searchQuery ORDER BY id DESC LIMIT ?, ?";

        } elseif($tabletype === 'all_wallets'){
            $query = "SELECT id, username, wallet_address, created_at FROM user_wallets"; // Adjust column names and table as needed
            if (!empty($searchValue)) {
                $searchQuery = " WHERE username LIKE ?";
                $params[] = "%$searchValue%";
                $paramTypes .= "s";
            }
    
            $query .= "$searchQuery ORDER BY id DESC LIMIT ?, ?";
        } else {

            die("Invalid table type provided.");

        }
    
        // Append pagination parameters
        $params[] = $start;
        $params[] = $rowperpage;
        $paramTypes .= "ii";
    
        // Prepare the statement
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Query preparation failed: " . $this->conn->error);
        }
    
        // Bind parameters dynamically
        $stmt->bind_param($paramTypes, ...$params);

        //var_export($query);die;
    
        // Execute the query and fetch results
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Collect the data into an array
        $data = [];
        $i = 0;

        while ($row = $result->fetch_assoc()) {
            if($tabletype === 'transaction_history'){
                $amount = $row['type'] == 'credit' ? "<b class='text-success'>+ $" . number_format($row['amount']) . "</b>" : "<b class='text-danger'>- $" . number_format($row['amount']) . "</b>";
                $data[] = [
                    "id" => ++$i,
                    "type" => $row['type'],
                    "amount" => $amount,
                    "description" =>  $row['description'],
                    "date" =>  $row['date'],
                    "action" =>  "<button data-id='".$row['id']."'  class='btn btn-danger btn-sm del_package'>Details</button>"
                ];

            } elseif($tabletype === 'all_users'){

                $avatar = !empty($row['avatar']) ? "<img src='".$rootUrl."/public/assets/images/user/".$row['avatar']."' class='rounded-circle' width='30' height='30'>" : "<img src='".$rootUrl."/public/assets/images/default-avatar.png' class='rounded-circle' width='50' height='50'>";
                
                $data[] = [
                    "id" => ++$i,
                    "username" => $avatar .' '. $row['username'],
                    "email" => $row['email'],
                    "country" => $row['country'],
                    "stage" => $row['stage'],
                    "date" =>  $row['reg_date'],
                    "action" =>  "<button data-id='".$row['id']."'  class='btn btn-danger btn-sm del_package'>Delete User</button>"
                ];

            } elseif($tabletype === 'vendor_requests'){

                $action = "<div class='btn-group'>
                    <button class='btn btn-secondary btn-sm dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>Action</button><div class='dropdown-menu'>";
                    if($row['status']=='under review'){
                        echo "";
                    }else if($row['status']=='pending'){
                            
                        $action .=  "<a data-id='".$row['id']."' data-username='".$row['username']."' data-status='approved' class='dropdown-item approve_vendor' href='#0'><i class='fas fa-check'></i> Accept</a>";
                        $action .=  "<a data-id='".$row['id']."' data-username='".$row['username']."' data-status='rejected'  data-bs-toggle='modal' data-bs-target='#modalCentered' class='dropdown-item' href='#0'><i class='fas fa-minus'></i> Reject</a>";
                        
                    }
                
                $action .= "</div></div>";

                $badge = "";
                if($row['status']=='pending'){
                    $badge = "<span class='badge text-bg-secondary'>".$row['status']."</span>";
                }elseif($row['status']=='approved'){
                    $badge = "<span class='badge text-bg-success'>".$row['status']."</span>";
                }
                elseif($row['status']=='rejected'){
                    $badge = "<span class='badge text-bg-danger'>".$row['status']."</span>";
                }

                
                $data[] = [
                    "id" => ++$i,
                    "username" => $row['username'].' '.$badge,
                    "experience" => $row['experience'],
                    "reason" => $row['reason_why'],
                    "image" => "<img src='" . $row['fileImage'] . "' class='img-fluid' width='100' />",
                    "status" => $row['status'],
                    "admin_notes" => $row['admin_notes'],
                    "date" =>  $row['date'],
                    "action" =>  $action
                ];

                

            } elseif($tabletype === 'all_wallets'){

               $action = "<div class='btn-group'>
                    <button class='btn btn-secondary btn-sm dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>Action</button><div class='dropdown-menu'>";
                         
                        $action .=  "<a data-id='".$row['id']."' data-type='transfer_fund' data-message='Are you sure you want transfer this fund ?' class='dropdown-item process_wallet' href='#0'><i class='fas fa-check'></i> Transfer Fund</a>";
                        $action .=  "<a data-id='".$row['id']."' data-type='delete_wallet' data-message='Are you sure you want to delete this wallet ?'  class='dropdown-item process_wallet' href='#0'><i class='fas fa-trash'></i> Delete Wallet</a>";
                
                $action .= "</div></div>";

                $balance = $this->getTonBalance($row['wallet_address'], true);

                $data[] = [
                    "id" => ++$i,
                    "username" => $row['username'],
                    "address" => $row['wallet_address'],
                    "balance" => '$' . number_format($balance,2),
                    "date" =>  $row['created_at'],
                    "action" =>  $action
                ];

            }
        }

        return [
            "recordsTotal" => $this->getTotalRecords($tabletype),
            "totalRecordsWithFilter" => $this->getTotalRecordswithFilter($tabletype,$searchValue),
            "data" => $data
        ];
    }

    
    public function fetchMyHistory($username){ 

        $stmt = $this->conn->prepare("SELECT description, amount, date, type FROM tranx_history WHERE username = ? ORDER BY id DESC LIMIT 5");
        
        $stmt->bind_param("s", $username);
        $stmt->execute();
        
        // Fetch the result
        $result = $stmt->get_result();
        
        // Check if there are any rows
        if ($result->num_rows > 0) {
            // Fetch all rows as an associative array
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return []; // Return an empty array if no rows found
        }

    }

    public function getTonBalance($address) {

        $baseUrl = TESTNET
            ? "https://testnet.toncenter.com/api/v2/getAddressBalance" 
            : "https://toncenter.com/api/v2/getAddressBalance";
    
        $apiKey = TON_API_KEY; // Optional
        $url = $baseUrl . '?address=' . urlencode($address);

        try {

            $response = $this->curlRequest($url);
            
            if (!isset($response['result'])) {
                throw new Exception("Invalid balance response");
            }

            return $response['result'] / 1000000000; // nanoTON to TON
        } catch (Exception $e) {
            //$e->getMessage();
            return 0;
        }
    
    }
    
    public function getTotalRecords($tabletype){
        $query = "";
        $params = [];
        $paramTypes = "";
        $user = $_SESSION['global_single_username'] ?? "";

        switch ($tabletype){
            case 'transaction_history':
                $query = "SELECT COUNT(*) AS count FROM tranx_history WHERE username = ?";
                $params[] = $user;
                $paramTypes .= "s";
                break;
            case 'all_users':
                $query = "SELECT COUNT(*) AS count FROM members ";
                break;
            case 'vendor_requests':
                $query = "SELECT COUNT(*) AS count FROM vendor_application ";
                break;
            case 'all_wallets':
                $query = "SELECT COUNT(*) AS count FROM user_wallets ";
                break;
            default:
                throw new Exception("Invalid table type provided.");
        }

         // Prepare the SQL query
         $stmt = $this->conn->prepare($query);
         if (!$stmt) {
             throw new Exception("Query preparation failed: " . $this->conn->error);
         }
     
         // Bind parameters if any
         if (!empty($params)) {
             $stmt->bind_param($paramTypes, ...$params);
         }
     
         $stmt->execute();
         $result = $stmt->get_result();
         $row = $result->fetch_assoc();
     
         return $row['count'] ?? 0;
    }

    public function getTotalRecordswithFilter($tabletype, $searchValue = ""){
        $searchQuery = "";
        $params = [];
        $paramTypes = "";
        $user = $_SESSION['global_single_username'] ?? "";

        if($tabletype === 'transaction_history'){

            $query = "SELECT COUNT(*) AS count FROM tranx_history WHERE username = ?";
            $params[] = $user;
            $paramTypes .= "s";
            if (!empty($searchValue)) {
                $searchQuery = "WHERE username LIKE ? OR amount LIKE ?";
                $params = ["%$searchValue%", "%$searchValue%"];
                $paramTypes = "ss";
            }

        } elseif($tabletype === 'all_users'){

            $query = "SELECT COUNT(*) AS count FROM members ";
            if (!empty($searchValue)) {
                $searchQuery = "WHERE username LIKE ? OR email LIKE ?";
                $params = ["%$searchValue%", "%$searchValue%"];
                $paramTypes = "ss";
            }

        } elseif($tabletype === 'vendor_requests'){

            $query = "SELECT COUNT(*) AS count FROM vendor_application ";
            if (!empty($searchValue)) {
                $searchQuery = "WHERE username LIKE ?";
                $params = ["%$searchValue%"];
                $paramTypes = "s";
            }

        } elseif($tabletype === 'all_wallets'){

            $query = "SELECT COUNT(*) AS count FROM user_wallets ";
            if (!empty($searchValue)) {
                $searchQuery = "WHERE username LIKE ?";
                $params = ["%$searchValue%"];
                $paramTypes = "s";
            }

        } else {
            throw new Exception("Invalid table type provided.");
        }

        $query .= " $searchQuery";
    
        // Prepare and execute query
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            throw new RuntimeException("Query preparation failed: " . $this->conn->error);
        }
    
        if (!empty($params)) {
            $stmt->bind_param($paramTypes, ...$params);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        return $row['count'] ?? 0; // Return 0 if no count is found
    }

    public function updatepassword($email, $password) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $password, $email);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function sendmail($email,$name,$body,$subject){

        require_once 'PHPMailer/src/Exception.php';
        require_once 'PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        
        try {
            
            $mail->isSMTP();                           
            $mail->Host       = SMTP_HOST;      
            $mail->SMTPAuth   = true;
            $mail->SMTPKeepAlive = true; //SMTP connection will not close after each email sent, reduces SMTP overhead	
            $mail->Username   = SMTP_USERNAME;    
            $mail->Password   = SMTP_PASSWORD;             
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   
            $mail->Port       = 465;               
    
            //Recipients
            $mail->setFrom(SMTP_FROM_EMAIL, 'GlobalSingleLine'); // Sender's email and name
            $mail->addAddress("$email", "$name"); 
            
            $mail->isHTML(true); 
            $mail->Subject = $subject;
            $mail->Body    = $body;
    
            $mail->send();
            $mail->clearAddresses();
            return true;
            
        } catch (Exception $e){
            return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    function isValidTonAddressBasic($address) {
        return preg_match('/^[A-Z2-7]{48}$/i', $address);
    }

    function validateTonAddressViaToncenter($address, $apiKey = null) {
        $baseUrl = TESTNET ? "https://testnet.toncenter.com/api/v2" : "https://toncenter.com/api/v2";
        $url = $baseUrl . "/getAddressInformation?address=" . urlencode($address);
    
        $headers = [
            'Content-Type: application/json'
        ];
        if ($apiKey) {
            $headers[] = 'X-API-Key: ' . $apiKey;
        }
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
    
        if ($err) {
            return ['error' => $err];
        }
    
        $data = json_decode($response, true);
        if (isset($data['result'])) {
            return [
                'is_active' => $data['result']['state'] === 'active',
                'balance' => $data['result']['balance'],
                'status' => 'ok'
            ];
        } else {
            return ['error' => 'Invalid or inactive address'];
        }
    }

    public function sendTON($recipient, $amount) {

        $jsApiUrl = 'http://localhost:3000/send-ton';

        // Send request to JavaScript API to generate serialized BOC
        $payload = json_encode(["recipient" => $recipient, "mnemonic" => TON_MNEMONIC, "amount" => $amount, "apiKey" => TON_API_KEY ]);
        $ch = curl_init($jsApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $jsResponse = curl_exec($ch);
        curl_close($ch);
        if ($jsResponse === false) {
            die('Error : ' . curl_error($ch));
        }

        error_log($jsResponse); // Log the response for debugging

        $jsData = json_decode($jsResponse, true);

        return $jsData; // Return the response from the JavaScript API
        //curl_close($ch);
    }

    public function makePositive($value) {
        return abs((float)$value); // Ensures it works with floats too
    }

    public function transferWalletFunds($mnemonic, $amount){

        $url = 'http://localhost:3000/send-wallet-funds';
       

        $phrase = $this->encryption->decryptFromBase64($mnemonic);
        //$private = $this->encryption::decryptFromBase64($privateKey);
        //error_log($phrase);

        $payload = [
            'mnemonic' => $phrase, // 24 words
            'toAddress' => FROM_WALLET_ADDRESS, // Destination TON address
            'amountTon' => $this->makePositive($amount - 0.5), // Amount
            'apiKey' => TON_API_KEY
        ];

        return $this->curlRequest($url, 'POST', $payload);

    }

    public function logTransaction($tranxId, $toAddress, $amount, $txId, $status) {
        $stmt = $this->conn->prepare("INSERT INTO withdrawal_log (tranx_id, to_address, amount, tx_id, status) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $tranxId, $toAddress, $amount, $txId, $status);
        $stmt->execute();
        $stmt->close();
    }

    public function InsertMultipleHistories($histories) {
        if (empty($histories)) return false;
    
        $placeholders = [];
        $values = [];
    
        foreach ($histories as $history) {
            $placeholders[] = "(?, ?, NOW(), ?, ?, ?)";
            $values[] = $history['username'];
            $values[] = $history['amount'];
            $values[] = $history['receiver'];
            $values[] = $history['type'];
            $values[] = $history['description'];
        }
    
        $sql = "INSERT INTO tranx_history (username, amount, date, receiver, type, description) VALUES " . implode(", ", $placeholders);
    
        $stmt = $this->conn->prepare($sql);
    
        if ($stmt === false) {
            throw new Exception("Failed to prepare statement: " . $this->conn->error);
        }
    
        // Bind dynamically
        $types = str_repeat('s', count($values)); // All strings
        $stmt->bind_param($types, ...$values);
    
        $stmt->execute();
    
        return $stmt->insert_id; // Only the first inserted id
    }

    public function allCounts($count_type) {

        $totalRows = 0; // Default value
        $date = date("Y-m-d");
        $zero = 0;
    
        // Prepare query based on count type
        if ($count_type === "allusers") {
            $query = "SELECT COUNT(*) FROM members ";
            $stmt = $this->conn->prepare($query);
        } elseif ($count_type === "total_vend_wallet") {
            $query = "SELECT SUM(COALESCE(vendor_wallet, 0)) FROM members ";
            $stmt = $this->conn->prepare($query);
        } elseif ($count_type === "total_reg_wallet") {
            $query = "SELECT  SUM(COALESCE(reg_wallet, 0)) FROM members ";
            $stmt = $this->conn->prepare($query);
        } elseif ($count_type === "total_earn_wallet") {
            $query = "SELECT  SUM(COALESCE(earning_wallet, 0)) FROM members ";
            $stmt = $this->conn->prepare($query);
        } elseif ($count_type === "total_vendors") {
            $query = "SELECT COUNT(*) FROM members WHERE vendor_access > ?";
            $stmt = $this->conn->prepare($query);
            if ($stmt) {
                $stmt->bind_param("s", $zero);
            }
        } elseif ($count_type === "total_reg_today") {
            $query = "SELECT COUNT(*) FROM members WHERE DATE(reg_date) = ?";
            $stmt = $this->conn->prepare($query);
            if ($stmt) {
                $stmt->bind_param("s", $date);
            }
        } else {
            return $totalRows; // Return 0 for unmatched cases (fallback)
        }
    
        // Execute query and fetch the result
        if ($stmt) {

            $stmt->execute();
            $stmt->bind_result($totalRows);
            $stmt->fetch();
            $stmt->close();

        } else {
            return "Failed to prepare statement: " . $this->conn->error;
        }
    
        return $totalRows ?? 0; // Ensure fallback to 0 if no value is fetched
    }

    public function generateEncryptionKey(){
        // Generate a test key
        $key = Key::createNewRandomKey();
        //error_log("Encryption test successful! Sample key: " . $key->saveToAsciiSafeString());
        //echo "Encryption test successful! Sample key: " . $key->saveToAsciiSafeString() . "\n";
    }

    public function deleteWallet($walletId){
        $stmt = $this->conn->prepare("DELETE FROM user_wallets WHERE id = ?");
        $stmt->bind_param("i", $walletId);
        $stmt->execute();
        $stmt->close();
    }


    public function generateTonWallet($username)
    {
        try {
            $payload = json_encode(['apiKey' => TON_API_KEY]);

            $ch = curl_init('http://localhost:3000/generate-wallet');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_TIMEOUT => 5, // Timeout after 5 seconds
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);

            curl_close($ch);

            error_log($response);

            if ($response === false || $httpCode !== 200) {
                throw new Exception('Failed to connect to wallet generation service: ' . $curlError);
            }

            $walletData = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON response from wallet service');
            }

            // Validate keys
            $requiredKeys = ['mnemonic', 'privateKey', 'address'];
            foreach ($requiredKeys as $key) {
                if (!isset($walletData[$key])) {
                    throw new Exception("Missing $key in wallet response");
                }
            }

            $mnemonic = is_array($walletData['mnemonic']) ? $walletData['mnemonic'][0] : $walletData['mnemonic'];
            // Encrypt sensitive data
            $encryptedData = [
                'mnemonic' => $this->encryption->encryptToBase64($mnemonic),
                'privateKey' => $this->encryption->encryptToBase64($walletData['privateKey']),
                'publicKey' => $this->encryption->encryptToBase64($walletData['publicKey'] ?? ''), // Add fallback
                'address' => $walletData['address'],
            ];

            // Encrypt and store logic (same as before)...
            $stmt = $this->conn->prepare("
                INSERT INTO user_wallets 
                (username, wallet_address, public_key, private_key, mnemonic, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())
            ");

            $stmt->bind_param("sssss", $username, $encryptedData['address'], $encryptedData['publicKey'], $encryptedData['privateKey'], $encryptedData['mnemonic']);
            $stmt->execute();
            $stmt->close();

            return json_encode([
                'status' => true,
                'message' => 'Wallet created successfully',
            ]);

        } catch (Exception $e) {
            return json_encode([
                'status' => false,
                'message' => $e->getMessage(),
                'error_code' => $e->getCode(),
            ]);
        }
    }

    public function fetchTonTransactions($walletAddress, $limit = 5) {
        $apiKey = TON_API_KEY; // Your API key
        $url = TESTNET ? "https://testnet.toncenter.com/api/v2/getTransactions" : "https://toncenter.com/api/v2/getTransactions";
        
        $params = [
            'address' => $walletAddress,
            'limit' => $limit,
            'archival' => false // Set to true for old transactions
        ];
    
        $headers = [
            'Content-Type: application/json',
            'X-API-Key: ' . $apiKey // TonCenter v2 uses X-API-Key header
        ];
    
        $ch = curl_init($url . '?' . http_build_query($params));
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET => true, // GET request instead of POST
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 10
        ]);
    
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
    
        if ($error) {
            throw new Exception("cURL Error: $error");
        }
    
        $data = json_decode($response, true);
    
        if ($httpCode !== 200 || isset($data['error'])) {
            $errorMsg = $data['error']['message'] ?? 'Unknown error';
            throw new Exception("TonCenter Error ($httpCode): $errorMsg");
        }
    
        if (!isset($data['result'])) {
            throw new Exception("Invalid response format");
        }
    
        return $data['result'] ?? [];
    }

    public function confirmWithdrawalTransaction($amount,$id,$hist_id,$address){
        
        $this->conn->begin_transaction();
        
        try {

            $history_details = $this->fetchHistoryDetails($hist_id);

            // Update withdrawal status if needed
            $confirmed = "confirmed";
            $stmt = $this->conn->prepare("UPDATE withdrawal_log SET status = ?, confirmed_at = NOW() WHERE id = ?");
            $stmt->bind_param("si", $confirmed,$id);
            $stmt->execute();
            $stmt->close();

            $url = $this->getCurrentUrl() . '/transaction_history';

            $this->pushnotification->sendNotification($history_details['username'],'Fund Withdrawal',"Withdrawal of $" . number_format($amount,2) . " to $address was successful", $url);
            
        } catch (Exception $e) {
            $this->conn->rollback();
            throw new Exception("Transaction processing failed: " . $e->getMessage());
        }

    }

    public function checkConfirmations($txBlockHeight) {
        try {
            // Get current block height from API
            $currentBlock = $this->getCurrentBlockHeight();
            
            // Require at least 6 confirmations
            return ($currentBlock - $txBlockHeight) >= 6;
        } catch (Exception $e) {
            error_log("Confirmation check failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function getCurrentBlockHeight() {
        $apiUrl = "https://toncenter.com/api/v2/getMasterchainInfo";
        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);
        
        if (!isset($data['result']['last']['seqno'])) {
            throw new Exception("Invalid block height response");
        }
        
        return $data['result']['last']['seqno'];
    }

    public function updateLastChecked($walletId){
        $stmt = $this->conn->prepare("UPDATE user_wallets SET last_checked = NOW() WHERE id = ?");
        $stmt->bind_param("i", $walletId);
        $stmt->execute();
        $stmt->close();
    }
    
    public function ConfirmPaymentTransaction($username, $amount, $hash, $sender, $walletId) {
        // Start transaction
        $this->conn->begin_transaction();
        
        try {
            // Record funding
            $this->InsertFundingLog($username, $amount, $hash, $sender);
            
            // Add to history
            $this->InsertHistory($username, $amount, 'credit', "Wallet Funding of $amount TON");
        
            
            // Update user balance
            $stmt = $this->conn->prepare("UPDATE members SET vendor_wallet = vendor_wallet + ? WHERE username = ?");
            $stmt->bind_param("is", $amount,$username);
            $stmt->execute();
            $stmt->close();

            // Commit all changes
            $this->conn->commit();
            
            // Optional: Send notification
            $this->pushnotification->sendNotification($username, 'Wallet Funding', 'Wallet Funding of $' . number_format($amount,2) . ' has just been credited to your vending wallet', $this->getCurrentUrl());
            
        } catch (Exception $e) {

            $this->conn->rollback();
            throw new Exception("Transaction processing failed: " . $e->getMessage());

        }
    }



    


    
}