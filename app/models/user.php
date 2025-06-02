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
     private $bscwallet;

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

    public function generateGuestId() {
        // Try secure random first
        if (function_exists('random_int')) {
            return -random_int(100000000, 999999999);
        }
        
        // Fallback to mt_rand
        return -mt_rand(100000000, 999999999);
    }

    public function getTotalMessageCount($user1, $user2) {
        $countQuery = "SELECT COUNT(*) FROM messages 
                    WHERE (sender_id = ? AND receiver_id = ?) 
                    OR (sender_id = ? AND receiver_id = ?)";
        $stmt = $this->conn->prepare($countQuery);
        $stmt->bind_param("iiii", $user1, $user2, $user2, $user1);
        $stmt->execute();
        return (int)$stmt->get_result()->fetch_row()[0];
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

    public function InsertHistory($username, $amount, $date, $type, $description) {
        $stmt = $this->conn->prepare("INSERT INTO tranx_history (username, amount, date, type, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $amount, $date, $type, $description);
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

    public function checkpin($pin) {
        $stmt = $this->conn->prepare("SELECT status FROM reg_pin WHERE pin = ?");
        $stmt->bind_param("s", $pin);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return [
                'exists' => true,
                'status' => $row['status']
            ];
        } else {
            return [
                'exists' => false,
                'status' => null
            ];
        }
    }

    public function generatePins($username, $numberOfPins) {
        try {
            $pins = [];
            $values = [];
            $placeholders = [];
            $currentDate = date('Y-m-d H:i:s');

            // Generate requested number of unique pins
            while (count($pins) < $numberOfPins) {
                $pin = 'GSL-';
                for ($i = 0; $i < 6; $i++) {
                    $pin .= mt_rand(0, 11); 
                }
                
                
                // Check if pin already exists
                $stmt = $this->conn->prepare("SELECT pin FROM reg_pin WHERE pin = ?");
                $stmt->bind_param("s", $pin);
                $stmt->execute();
                
                if ($stmt->get_result()->num_rows === 0) {
                    $pins[] = $pin;
                    $values = array_merge($values, [$username, $pin, $currentDate]);
                    $placeholders[] = "(?, ?, ?)";
                }
            }

            // Insert all pins in a single query
            $sql = "INSERT INTO reg_pin (username, pin, created_on) VALUES " . implode(",", $placeholders);
            $stmt = $this->conn->prepare($sql);
            
            // Bind all parameters 
            $types = str_repeat("sss", count($pins)); // 3 params per pin
            $stmt->bind_param($types, ...$values);
            
            $stmt->execute();
            $stmt->close();

            return [
                'status' => true, 
                'pins' => $pins,
                'message' => count($pins) . ' pins generated successfully'
            ];

        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Error generating pins: ' . $e->getMessage()
            ];
        }
    }


    public function deductWallet($amount, $username){
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET earning_wallet = earning_wallet - ? WHERE username = ?");
        $stmt->bind_param("ss", $amount, $username);
        $stmt->execute();
        $stmt->close();
    }

    public function creditWallet($amount, $username){
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET earning_wallet = earning_wallet + ? WHERE username = ?");
        $stmt->bind_param("ds", $amount, $username);
        $stmt->execute();
        $stmt->close();
    }

    public function creditMultipleWallets(array $credits): void {
        foreach ($credits as $credit) {
            $amount = $credit['amount'];
            $username = $credit['username'];
            $date = date('Y-m-d H:i:s');

            // Optional: validate inputs
            if (!is_numeric($amount) || empty($username)) {
                continue; // or throw exception
            }

            $this->InsertHistory($username, $amount, $date, 'credit', 'Registration rebate');

            $this->creditWallet($amount, $username);
        }
    }


    public function fetchAdmins($username){
        $one = 1;
        $stmt = $this->conn->prepare("SELECT id, username, task FROM members WHERE admin_access = ? and username != ?");
        $stmt->bind_param("is", $one,$username);
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
        $stmt->bind_param("idis", $stage, $amount, $page_access, $username);
        $stmt->execute();
        $stmt->close();
    }

    public function activateAccount($username){
        $one = 1;
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET account_access = ? WHERE username = ?");
        $stmt->bind_param("is", $one, $username);
        $stmt->execute();
        $stmt->close();
    }

    public function detectAddress($address){
        $baseUrl = TESTNET
            ? "https://testnet.toncenter.com/api/v2/detectAddress"
            : "https://toncenter.com/api/v2/detectAddress";
        $url = "$baseUrl?address=$address&api_key=" . TON_API_KEY;
        return $this->curlRequest($url);
    }

    public function curlRequest(string $url, string $method = 'GET', array $data = [], array $headers = []): array {
        $ch = curl_init();
        error_log($url);
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
        
        // Merge custom headers with content-type if POST
        $httpHeaders = [];
        if ($method === 'POST') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
            $httpHeaders[] = 'Content-Type: application/json';
        }
        
        // Add custom headers if provided
        if (!empty($headers)) {
            $httpHeaders = array_merge($httpHeaders, $headers);
        }
        
        if (!empty($httpHeaders)) {
            $options[CURLOPT_HTTPHEADER] = $httpHeaders;
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

        if ($tabletype === 'my_generated_wallets') {

            $query = "SELECT id, pin, created_on, used_by, used_on, status FROM reg_pin WHERE username = ?"; // Adjust column names and table as needed
            $params[] = $user;
            $paramTypes .= "s";
            if (!empty($searchValue)) {
                $searchQuery = " WHERE pin LIKE ? OR used_by LIKE ?";
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

            $query = "SELECT id, username, address, created_at FROM user_wallets"; // Adjust column names and table as needed
            if (!empty($searchValue)) {
                $searchQuery = " WHERE username LIKE ? OR address LIKE ?";
                $params[] = "%$searchValue%";
                $params[] = "%$searchValue%";
                $paramTypes .= "ss";
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

        // For 'all_wallets', collect addresses for batch balance fetch
        $addresses = [];
        if ($tabletype === 'all_wallets') {

            while ($row = $result->fetch_assoc()) {
                $addresses[] = $row['address'];
                $rows[] = $row;  // Save rows to process after balance fetch
            }

            //error_log(print_r($addresses, true));

            // Call Node.js batch API to get balances for these addresses
            $balances = [];
            if (!empty($addresses)) {
                $url = "http://localhost:3000/api/batch-balances"; // Change to your Node.js endpoint
                $postData = ['addresses' => $addresses];

                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                $response = curl_exec($ch);
                curl_close($ch);

                $respData = json_decode($response, true);

                error_log(print_r($respData, true));

                if ($respData && $respData['success']) {
                    $balances = $respData['balances'];
                }
            }

            // Build data array with balances
            $data = [];
            $i = 0;
            foreach ($rows as $row) {
                $action = "<div class='btn-group'>
                    <button class='btn btn-secondary btn-sm dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>Action</button><div class='dropdown-menu'>
                        <a data-id='" . $row['id'] . "' data-type='transfer_fund' data-message='Are you sure you want transfer this fund ?' class='dropdown-item process_wallet' href='#0'><i class='fas fa-check'></i> Transfer Fund</a>
                        <a data-id='" . $row['id'] . "' data-type='delete_wallet' data-message='Are you sure you want to delete this wallet ?'  class='dropdown-item process_wallet' href='#0'><i class='fas fa-trash'></i> Delete Wallet</a>
                    </div></div>";

                $usdtbalance = $balances[$row['address']]['usdt'] ?? 0;
                $bnb_balance = $balances[$row['address']]['bnb_usd'] ?? 0;
                

                $data[] = [
                    "id" => ++$i,
                    "username" => $row['username'],
                    "address" => $row['address'],
                    "usdt_balance" => '$' . number_format($usdtbalance, 2),
                    "bnb_balance" => '$' . number_format($bnb_balance, 2),
                    "date" => $row['created_at'],
                    "action" => $action
                ];
            }

            return [
                "recordsTotal" => $this->getTotalRecords($tabletype),
                "totalRecordsWithFilter" => $this->getTotalRecordswithFilter($tabletype, $searchValue),
                "data" => $data
            ];
        }
    
        // Collect the data into an array
        $data = [];
        $i = 0;

        while ($row = $result->fetch_assoc()) {
            if($tabletype === 'my_generated_wallets'){

                $status = $row['status'] == 1 ? 'Used' : '';

                $data[] = [
                    "id" => ++$i,
                    "pin" => $row['pin'],
                    "created_on" => $row['created_on'],
                    "used_by" =>  $row['used_by'],
                    "used_on" =>  $row['used_on'],
                    "status" =>  $status
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
                
                $status = 
                
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

            return $response['result'] / 1000000; // nanoTON to TON
        } catch (Exception $e) {
            //$e->getMessage();
            return 0;
        }
    
    }

    public function getJettonBalance($walletAddress) {
        $baseUrl = TESTNET
            ? "https://testnet.tonapi.io/v2/accounts/{address}/jettons" 
            : "https://tonapi.io/v2/accounts/{address}/jettons";
        
        $apiKey = TON_API_KEY; // Required for tonapi.io
        $url = str_replace('{address}', urlencode($walletAddress), $baseUrl);
error_log("Jetton Balance URL: " . $url); // Log for debugging
        try {

            $headers = [
                'Authorization: Bearer ' . $apiKey,
                'Accept: application/json'
            ];

            $response = $this->curlRequest($url, 'GET', [], []);
            error_log("Jetton Balance Response: " . json_encode($response)); // Log for debugging
            if (!isset($response['balances'])) {
                throw new Exception("Invalid jetton response");
            }

            // Extract jetton addresses from the response
            $jettonAddresses = [];
            foreach ($response['balances'] as $jetton) {
                if (isset($jetton['jetton']['address'])) {
                    $jettonAddresses[] = $jetton['jetton']['address'];
                }
            }

            error_log("Jetton Addresses: " . json_encode($jettonAddresses)); // Log for debugging

            return $jettonAddresses;

        } catch (Exception $e) {
            // Log error if needed: $e->getMessage();
            return [];
        }
    }
    
    public function getTotalRecords($tabletype){
        $query = "";
        $params = [];
        $paramTypes = "";
        $user = $_SESSION['global_single_username'] ?? "";

        switch ($tabletype){
            case 'my_generated_wallets':
                $query = "SELECT COUNT(*) AS count FROM reg_pin WHERE username = ?";
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

        if($tabletype === 'my_generated_wallets'){

            $query = "SELECT COUNT(*) AS count FROM reg_pin WHERE username = ?";
            $params[] = $user;
            $paramTypes .= "s";
            if (!empty($searchValue)) {
                $searchQuery = "WHERE pin LIKE ? OR used_by LIKE ?";
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
        
        $jsApiUrl = CHAT_ENDPOINT.'/api/send-ton';

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

    public function transferWalletFunds($privatekey, $amount, $address){

        $url = CHAT_ENDPOINT . '/api/transfer-usdt';
        $key = $privatekey == '' ? WALLET_PRIVATE_KEY : $privatekey;
        $payload = [
            'privatekey' => $key,
            'amount' => $amount, // Amount
            'toAddress' => $address
        ];

        return $this->curlRequest($url, 'POST', $payload);

    }

    public function transferBnB($amount, $address){

        $url = CHAT_ENDPOINT . '/api/transfer-bnb';

        $payload = [
            'privatekey' => WALLET_PRIVATE_KEY,
            'amount' => $amount, // Amount
            'toAddress' => $address
        ];

        return $this->curlRequest($url, 'POST', $payload);

    }

    public function validateBep20WalletAddress($address){

        $url = CHAT_ENDPOINT . '/api/check-address';

        $payload = [
            'toAddress' => $address
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
        try {

            if (empty($histories)) return false;

            $placeholders = [];
            $values = [];
        
            foreach ($histories as $history) {
                $placeholders[] = "(?, ?, NOW(), ?, ?)";
                $values[] = $history['username'];
                $values[] = $history['amount'];
                $values[] = $history['type'];
                $values[] = $history['description'];
            }

            $sql = "INSERT INTO tranx_history (username, amount, date, type, description) VALUES " . implode(", ", $placeholders);

            $stmt = $this->conn->prepare($sql);
        
            if ($stmt === false) {
                throw new Exception("Failed to prepare statement: " . $this->conn->error);
            }
        
            // Bind dynamically
            $types = str_repeat('s', count($values)); // All strings
            $stmt->bind_param($types, ...$values);
        
            $stmt->execute();
        
            return $stmt->insert_id; // Only the first inserted id

        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
        
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

            $ch = curl_init(CHAT_ENDPOINT.'/api/generate-wallet');
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

            $mnemonic = $walletData['mnemonic']['phrase'];
            // Encrypt sensitive data
            $encryptedData = [
                'mnemonic' => $this->encryption->encryptToBase64($mnemonic),
                'privateKey' => $this->encryption->encryptToBase64($walletData['privateKey']),
                'address' => $walletData['address'] ?? '', // Add fallback for ton_address
            ];

            // Encrypt and store logic (same as before)...
            $stmt = $this->conn->prepare("
                INSERT INTO user_wallets 
                (username, address, private_key, mnemonic, created_at) 
                VALUES (?, ?, ?, ?, NOW())
            ");

            $stmt->bind_param("ssss", $username, $encryptedData['address'], $encryptedData['privateKey'], $encryptedData['mnemonic']);
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

    public function fetchJettonTransactions($walletAddress, $limit = 5) {
        //https://toncenter.com/api/v3/jetton/transfers?owner_address=EQBE8dSZuymb3R48z_FR7iQLtDNUVqc-gEhR59yBX20gkO_N&direction=in&limit=10&offset=0&sort=desc
        $apiKey = TON_API_KEY; // Your API key

        $url = TESTNET ? "https://toncenter.com/api/v3/jetton/transfers" : "https://toncenter.com/api/v3/jetton/transfers";

        $params = [
            'owner_address' => $walletAddress,
            'direction' => 'in', // or 'out' for outgoing transfers
            'limit' => $limit,
            'offset' => 0,
            'sort' => 'desc'
        ];

        $headers = [
            'Content-Type: application/json'
        ];

        $ch = curl_init($url . '?' . http_build_query($params));

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET => true,
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
            throw new Exception("TonAPI Error ($httpCode): $errorMsg");
        }

        if (!isset($data['jetton_transfers'])) {
            throw new Exception("Invalid response format");
        }

        return $data['jetton_transfers'] ?? [];
    }

    function saveLastCheckedBlock(string $wallet, int $blockNumber): bool {
        // Try to update first
        $stmt = $this->conn->prepare("UPDATE user_wallets SET last_checked_block = ? WHERE address = ?");
        $stmt->bind_param("is", $blockNumber, $wallet);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            // No rows updated, insert new record
            $stmt->close();
            $stmt = $this->conn->prepare("INSERT INTO user_wallets (address, last_checked_block) VALUES (?, ?)");
            $stmt->bind_param("si", $wallet, $blockNumber);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        }

        $stmt->close();
        return true;
    }


    function getLatestBlockNumber() {
        $apiKey = BSC_API_KEY;
        $url = "https://api.bscscan.com/api?module=proxy&action=eth_blockNumber&apikey=$apiKey";
        $headers = [
            'Content-Type: application/json'
        ];

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET => true,
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
            throw new Exception("TonAPI Error ($httpCode): $errorMsg");
        }
        return hexdec($data['result']);
    }

    function getLastCheckedBlock(string $wallet): int {
        $lastCheckedBlock = 0; // Default value if not found
        $stmt = $this->conn->prepare("SELECT last_checked_block FROM user_wallets WHERE address = ?");
        $stmt->bind_param("s", $wallet);
        $stmt->execute();
        $stmt->bind_result($lastCheckedBlock);
        if ($stmt->fetch()) {
            $stmt->close();
            return (int)$lastCheckedBlock;
        }
        $stmt->close();
        return 0; // default if no record found
    }

    public function fetchUsdtTransactions($walletAddress, $startBlock, $endBlock, $limit = 5) {
        $apiKey= BSC_API_KEY; // Your BscScan API key
        $url = "https://api.bscscan.com/api";
        $params = [
            'module' => 'account',
            'action' => 'tokentx',
            'contractaddress' => USDT_CONTRACT_ADDRESS, // Replace with actual USDT contract address
            'address' => $walletAddress,
            'startblock' => $startBlock,
            'endblock' => $endBlock,
            'sort' => 'desc',
            'page' => 1,
            'offset' => $limit,
            'apikey' => $apiKey
        ];

        $headers = [
            'Content-Type: application/json'
        ];

        $ch = curl_init($url . '?' . http_build_query($params));

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET => true,
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
            throw new Exception("TonAPI Error ($httpCode): $errorMsg");
        }

        if (!isset($data['result']) || !is_array($data['result'])) {
            return []; // handle error or empty result
        }

        error_log(print_r($data, true));

        // Filter only incoming transfers
        $incoming = array_filter($data['result'], function($tx) use ($walletAddress) {
            return strtolower($tx['to']) === strtolower($walletAddress);
        });

        // Return up to the requested limit
        return array_slice(array_values($incoming), 0, $limit);

    }

    public function confirmWithdrawalTransaction($amount,$id,$hash,$username,$address){

        $this->conn->begin_transaction();

        try {

            // Update withdrawal status if needed
            $confirmed = "confirmed";
            $stmt = $this->conn->prepare("UPDATE withdrawal_log SET status = ?, tx_hash = ? confirmed_at = NOW() WHERE id = ?");
            $stmt->bind_param("sss", $confirmed,$hash,$id);
            $stmt->execute();
            $stmt->close();

            $url = $this->getCurrentUrl() . '/transaction_history';

            $this->pushnotification->sendNotification($username,'Fund Withdrawal',"Withdrawal of $" . number_format($amount,2) . " to $address was successful", $url);
            
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
        $stmt = $this->conn->prepare("UPDATE user_wallets SET last_checked = NOW() + INTERVAL 5 MINUTE WHERE id = ?");
        $stmt->bind_param("i", $walletId);
        $stmt->execute();
        $stmt->close();
    }
    
    public function ConfirmPaymentTransaction($username, $amount, $hash, $sender, $walletId) {
        // Start transaction
        $this->conn->begin_transaction();
        
        try {
            
            $date = date('Y-m-d H:i:s');
            // Record funding
            $this->InsertFundingLog($username, $amount, $hash, $sender);
            
            // Add to history
            $this->InsertHistory($username, $amount, $date, 'credit', "Wallet Funding of $amount USDT from $sender");
        
            
            // Update user balance
            $stmt = $this->conn->prepare("UPDATE members SET vendor_wallet = vendor_wallet + ? WHERE username = ?");
            $stmt->bind_param("ds", $amount,$username);
            $stmt->execute();
            $stmt->close();

            // Commit all changes
            $this->conn->commit();
            
            // Optional: Send notification
                $this->pushnotification->sendCustomNotifications([
                    [
                        'username' => $username, // Upper Upline
                        'title' => 'Wallet Funding',
                        'body' => 'Wallet Funding of $' . number_format($amount,2) . ' has just been credited to your vending wallet',
                        'url' => $this->getCurrentUrl()
                    ],
                ]);

        } catch (Exception $e) {

            $this->conn->rollback();
            throw new Exception("Transaction processing failed: " . $e->getMessage());

        }
    }



    


    
}