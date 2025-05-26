<?php
require __DIR__ . '../../../public/assets/vendor/autoload.php';
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;

class Display {

    private $db;
    private $rootUrl;
    private $userModel;
    private $pushnotification;
    private $encryption;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new UsersModel($db);
        $this->rootUrl = (new UsersModel($db))->getCurrentUrl();
        $this->pushnotification = new PushNotificationService($this->db,VAPID_PUBLIC_KEY,VAPID_PRIVATE_KEY);
        $this->encryption = new EncryptionHelper(ENCRYPTION_KEY);
        
    }

    public function showLoginPage($rootUrl) {
        include('app/views/login.php');
    }

    public function showForgotPasswordPage($rootUrl) {
        include('app/views/forgot_password.php');
    }

    public function showRegistrationPage($rootUrl) {
        include('app/views/register.php');
    }

    public function showConfirmationPage($rootUrl) {
        if(isset($_GET['user']) && $_GET['user'] !== ''){

            $this->userModel->activateAccount($_GET['user']);
            include('app/views/confirmation.php');

        } else {
            include('app/views/404.php');
        }
        
    }

    public function showCheckersPage($rootUrl) {
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if (isset($_SESSION['global_single_username'])) {
            $username = $_SESSION['global_single_username'];
            $userInfo = $this->userModel->getUserInfo($username);
            $page_access = $userInfo['page_access'];
            $stageInfo = $this->userModel->getStageInfo($userInfo['stage']);
            
          
            if($page_access > 0){

                $reward = $stageInfo['compensation'];
                $this->userModel->InsertHistory('globalsingle', $reward, $username, 'credit', 'Reward for completing stage '.$userInfo['stage']);
                $this->userModel->updateStage($username, $reward, $userInfo['stage'] + 1);
                $currentStage = $userInfo['stage'];
                include('app/views/checkers.php');

            } else {

                include('app/views/404.php');

            }
            
        }else {
            header("Location: $rootUrl/login");
            exit();
        }
    }

    public function showDashboardPage($rootUrl){
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }

       $this->userModel->generateEncryptionKey();
        // Check if the session variable is set
        if (isset($_SESSION['global_single_username'])) {

            // User is logged in, proceed to the dashboard
    
            $username = $_SESSION['global_single_username'];
            $userInfo = $this->userModel->getUserInfo($username);
            $stageInfo = $this->userModel->getStageInfo($userInfo['stage']);
            $countdownlines = $this->userModel->countDownlines($username, $userInfo['stage']);
            $globalDownlines = $this->userModel->countGlobalDownlines($userInfo['reg_date'], $stageInfo['total_downlines']);
            $globalDownlinespercentage = $this->userModel->calculatePercentage($globalDownlines, $stageInfo['total_downlines'], $decimalPlaces = 2);
            $countdownlinespercentage = $this->userModel->calculatePercentage($countdownlines['total'], $stageInfo['downlines'], $decimalPlaces = 2);
            $myhistory = $this->userModel->fetchMyHistory($username);
           
            include('app/views/dashboard.php');
        } else {
            header("Location: $rootUrl/login");
            exit();
        }
    }

   public function showProfilePage($rootUrl){
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        // Check if the session variable is set
        if (isset($_SESSION['global_single_username'])) {
            $username = $_SESSION['global_single_username'];
            $userInfo = $this->userModel->getUserInfo($username);
            $fetchSponsor = $this->userModel->fetchSponsor($username);
            include('app/views/account_profile.php');
        } else {
            header("Location: $rootUrl/login");
            exit();
        }
   }

   public function showSupportPage($rootUrl){
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        // Check if the session variable is set
            if(isset($_SESSION['global_single_username'])){

                $username = $_SESSION['global_single_username'];

            } else {

                if(isset($_SESSION['guest_id'])){

                    $username = $_SESSION['guest_id'];

                } else {

                     $username = $this->userModel->generateGuestId();
                     $_SESSION['guest_id'] = $username;

                }
               
            }
             
            $userInfo = $this->userModel->getUserInfo($username);
            $fetchSponsor = $this->userModel->fetchSponsor($username);
            $fetchAdmin = $this->userModel->fetchAdmins();
        
            include('app/views/help.php');

    }

   public function showWalletTransferPage($rootUrl){
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if (isset($_SESSION['global_single_username'])) {

            $username = $_SESSION['global_single_username'];
            $userInfo = $this->userModel->getUserInfo($username);

            include('app/views/wallet_transfer.php');

        } else {
            header("Location: $rootUrl/login");
            exit();
        }
    }

   public function showIntraTransferPage($rootUrl){
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if (isset($_SESSION['global_single_username'])) {

            $username = $_SESSION['global_single_username'];
            
            $userInfo = $this->userModel->getUserInfo($username);

            include('app/views/intra_wallet_transfer.php');

        } else {
            header("Location: $rootUrl/login");
            exit();
        }
    }

   public function showTransactionHistoryPage($rootUrl){
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if (isset($_SESSION['global_single_username'])) {

            $username = $_SESSION['global_single_username'];
            
            $userInfo = $this->userModel->getUserInfo($username);

            include('app/views/transaction_history.php');

        } else {
            header("Location: $rootUrl/login");
            exit();
        }
    }

    public function show404Page($rootUrl){
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
       

            $username = $_SESSION['global_single_username'] ?? "";
            $userInfo = $this->userModel->getUserInfo($username);

        include('app/views/404.php');
    }

    public function showMyChatPage($rootUrl){
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if (isset($_SESSION['global_single_username'])) {

            $username = $_SESSION['global_single_username'];
            
            $userInfo = $this->userModel->getUserInfo($username);

            include('app/views/my_chats.php');

        } else {
            header("Location: $rootUrl/login");
            exit();
        }
        
    }

    public function showUserChatPage($Id,$rootUrl){

        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
    
        $userdetails = $this->userModel->getUserInfo($Id);
        if(empty($userdetails)){
            $userdetails = ['username' => 'Guest', 'avatar' => 'avatar-1.jpg', 'id' => $Id];
        }
        // Display the homepage
    

        $username = $_SESSION['global_single_username'] ?? '';
        $userInfo = $this->userModel->getUserInfo($username);
        if(empty($userInfo)){
            $userInfo = ['username' => 'Guest', 'avatar' => 'avatar-1.jpg', 'id' => $_SESSION['guest_id']];
        }


        require_once 'app/views/user_chat.php';

        
    }

            /*if(isset($_SESSION['global_single_username'])){
                // Display the homepage
                $userdetails = $this->userModel->getUserInfo($Id);

                if (!empty($userdetails)) {

                    $username = $_SESSION['global_single_username'] ?? '';
                    $userInfo = $this->userModel->getUserInfo($username);

                } 

            } 

            require_once 'app/views/user_chat.php';*/


    public function showVendorsPage($rootUrl){

        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }

        if (isset($_SESSION['global_single_username'])) {

            $username = $_SESSION['global_single_username'];
            
            $userInfo = $this->userModel->getUserInfo($username);

            include('app/views/vendors.php');

        } else {
            header("Location: $rootUrl/login");
            exit();
        }
        
    }

    public function showAllUsersPage($rootUrl){

        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        if (isset($_SESSION['global_single_username'])) {

            $username = $_SESSION['global_single_username'];
            
            $userInfo = $this->userModel->getUserInfo($username);

            if($userInfo['admin_access'] > 0){

                include('app/views/allusers.php');

            } else {
                header("Location: $rootUrl/404");
                exit();
            }

        } else {
            header("Location: $rootUrl/login");
            exit();
        }
        
    }

    public function showAllWalletsPage($rootUrl){

        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        if (isset($_SESSION['global_single_username'])) {

            $username = $_SESSION['global_single_username'];
            
            $userInfo = $this->userModel->getUserInfo($username);

            if($userInfo['admin_access'] > 0){

                include('app/views/all_wallets.php');

            } else {
                header("Location: $rootUrl/404");
                exit();
            }

        } else {
            header("Location: $rootUrl/login");
            exit();
        }
        
    }

    public function showFundWalletPage($rootUrl){

        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        if (isset($_SESSION['global_single_username'])) {

            $username = $_SESSION['global_single_username'];
            
            $userInfo = $this->userModel->getUserInfo($username);

            if($userInfo['vendor_access'] > 0){

                $userWallet = $this->userModel->getUserWallet($username);
                $addressInfo = $this->userModel->detectAddress($userWallet['wallet_address']);

                include('app/views/fund_wallet.php');

            } else {

                header("Location: $rootUrl/404");
                exit();

            }

        } else {
            header("Location: $rootUrl/login");
            exit();
        }
        
    }

    public function showStatisticsPage($rootUrl){

        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        if (isset($_SESSION['global_single_username'])) {

            $username = $_SESSION['global_single_username'];
            
            $userInfo = $this->userModel->getUserInfo($username);

            $total_users = $this->userModel->allCounts("allusers");
            $total_vend_wallet = $this->userModel->allCounts("total_vend_wallet");
            $total_reg_wallet = $this->userModel->allCounts("total_reg_wallet");
            $total_earn_wallet = $this->userModel->allCounts("total_earn_wallet");
            $total_vendors = $this->userModel->allCounts("total_vendors");
            $total_reg_today = $this->userModel->allCounts("total_reg_today");

            if($userInfo['admin_access'] > 0){

                include('app/views/statistics.php');

            } else {

                header("Location: 404");
                exit();

            }

        } else {
            header("Location: login");
            exit();
        }
    }

    public function showVendorRequestPage($rootUrl){

        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        if (isset($_SESSION['global_single_username'])) {

            $username = $_SESSION['global_single_username'];
            
            $userInfo = $this->userModel->getUserInfo($username);

            if($userInfo['admin_access'] > 0){

                include('app/views/vendor_requests.php');

            } else {

                header("Location: 404");
                exit();

            }

        } else {
            header("Location: login");
            exit();
        }
        
    }

    public function showBecomeVendorPage($rootUrl){

        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        if (isset($_SESSION['global_single_username'])) {

            $username = $_SESSION['global_single_username'];
            
            $userInfo = $this->userModel->getUserInfo($username);
            $checkVendor = $this->userModel->getVendorInfo($username);

            include('app/views/become_a_vendor.php');


        } else {

            header("Location: $rootUrl/login");
            exit();

        }
        
    }

    public function showWithdrawalPage($rootUrl){

        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        if (isset($_SESSION['global_single_username'])) {

            $username = $_SESSION['global_single_username'];
            
            $userInfo = $this->userModel->getUserInfo($username);

            include('app/views/withdrawal.php');

        } else {
            header("Location: $rootUrl/login");
            exit();
        }
        
    }

    /*public function CheckandUpdateWithdrawals(){

        try {
            
            $apiKey = TON_API_KEY;
            $baseUrl = TESTNET ? "https://testnet.toncenter.com/api/v2/getTransactions" : "https://toncenter.com/api/v2/getTransactions";

            $query = "SELECT * FROM withdrawal_log WHERE status = 'pending'";
            $result = $this->db->query($query);

            if (!$result) {
                die("Query failed: " . $this->db->error);
            }

            while ($tx = $result->fetch_assoc()) {

                $senderWallet = FROM_WALLET_ADDRESS;
                $lt = $tx['tx_id'];
                $id = $tx['id'];

                $url = "$baseUrl?address=$senderWallet&limit=5&lt=$lt&api_key=$apiKey";
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ["X-API-Key: $apiKey"]);
                $response = curl_exec($ch);
                curl_close($ch);

                $data = json_decode($response, true);

                //error_log("Response: " . print_r($data, true)); // Log the response for debugging
                print_r($data);

                if (!isset($data['ok']) || !$data['ok']) {
                    error_log("Failed to fetch transactions for $senderWallet");
                    continue;
                }

                foreach ($data['result'] as $resultTx) {

                    $hash = $resultTx['transaction_id']['hash'];
                    $timestamp = $resultTx['utime'];
                    $amountNano = $resultTx['in_msg']['value'];
                    $amountTon = $amountNano / 1e9;
                    $sender = $resultTx['in_msg']['source'];
                    $blockHeight = $resultTx['block_height'];

                    // Skip if no value or already processed
                    if ($resultTx['transaction_id']['lt'] == $lt) {

                        $stmt = $this->db->prepare("UPDATE withdrawal_log SET status = 'confirmed' WHERE id = ?");
                        $stmt->bind_param("i", $tx['id']);
                        $stmt->execute();
                        $stmt->close();
                    
                    // echo "Transaction with lt {$lt} confirmed.\n";
                        break;
                    }

                }
            }

            $this->db->close();

        } catch (\Throwable $th) {
            throw $th;
        }

    }*/


    public function checkAndUpdateWithdrawals() {
    
        // page_refresher.php
        try {
            $apiKey = TON_API_KEY;
            $baseUrl = TESTNET ? 
                "https://testnet.toncenter.com/api/v2/getTransactions" : 
                "https://toncenter.com/api/v2/getTransactions";
    
            // Get pending withdrawals older than 2 minutes
            $query = "SELECT wl.id, wl.tx_id, wl.tranx_id, wl.amount, wl.to_address, h.username 
                     FROM withdrawal_log wl
                     JOIN tranx_history h ON wl.tranx_id = h.id
                     WHERE wl.status = 'pending' 
                     AND wl.created_at < DATE_SUB(NOW(), INTERVAL 10 MINUTE)
                     LIMIT 20";
            
            $result = $this->db->query($query);
            
            if (!$result) {
                throw new Exception("Query failed: " . $this->db->error);
            }
    
            $senderWallet = FROM_WALLET_ADDRESS;
            $pendingWithdrawals = [];
            
            // Store all pending withdrawals with their details
            while ($tx = $result->fetch_assoc()) {
                $pendingWithdrawals[$tx['id']] = [
                    'tx_id' => $tx['tx_id'],
                    'tranx_id' => $tx['tranx_id'],
                    'amount' => $tx['amount'],
                    'to_address' => $tx['to_address'],
                    'username' => $tx['username']
                ];
            }
    
            if (empty($pendingWithdrawals)) {
                return; // Nothing to process
            }
    
            // Get recent transactions once
            $url = "$baseUrl?address=" . urlencode($senderWallet) . 
                   "&limit=50&archival=true&api_key=$apiKey";
            
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => ["X-API-Key: $apiKey"],
                CURLOPT_TIMEOUT => 15 // Increased timeout
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode !== 200) {
                throw new Exception("TON API returned status: $httpCode");
            }
    
            $data = json_decode($response, true);
            
            if (empty($data['result'])) {
                error_log("No transactions found for $senderWallet");
                return;
            }
    
            // Process all pending withdrawals
            $this->db->begin_transaction();
            
            try {
                foreach ($data['result'] as $tx) {

                    if (!isset($tx['transaction_id']['lt'])) {
                        continue; // Skip malformed transactions
                    }
    
                    $txLt = $tx['transaction_id']['lt'];
                    
                    foreach ($pendingWithdrawals as $id => $withdrawal) {
                        if ($txLt == $withdrawal['tx_id']) {
                            // Found confirmed withdrawal
                            $stmt = $this->db->prepare(
                                "UPDATE withdrawal_log 
                                SET status = 'confirmed', 
                                confirmed_at = NOW() 
                                WHERE id = ?"
                            );
                            $stmt->bind_param("i", $id);
                            $stmt->execute();
    
                            // Send notification
                            $url = $this->userModel->getCurrentUrl() . '/transaction_history';
                            $this->pushnotification->sendNotification(
                                $withdrawal['username'],
                                'Fund Withdrawal',
                                "Withdrawal of $" . number_format($withdrawal['amount'], 2) . 
                                " to " . substr($withdrawal['to_address'], 0, 6) . "... was successful",
                                $url
                            );
    
                            unset($pendingWithdrawals[$id]);
                            break;
                        }
                    }
                    
                    if (empty($pendingWithdrawals)) break;
                }
                
                // Mark old pending withdrawals as failed
                $hourAgo = date('Y-m-d H:i:s', strtotime('-1 hour'));
                $failedIds = array_keys($pendingWithdrawals);
                
                if (!empty($failedIds)) {
                    $placeholders = implode(',', array_fill(0, count($failedIds), '?'));
                    $types = str_repeat('i', count($failedIds));
                    
                    $stmt = $this->db->prepare(
                        "UPDATE withdrawal_log 
                        SET status = 'failed',
                        error = 'Timeout: Not found in blockchain'
                        WHERE id IN ($placeholders) AND created_at < ?"
                    );
                    
                    $params = array_merge($failedIds, [$hourAgo]);
                    $stmt->bind_param($types . 's', ...$params);
                    $stmt->execute();
                }
                
                $this->db->commit();
                
            } catch (Exception $e) {
                $this->db->rollback();
                throw $e;
            }
            
        } catch (Throwable $th) {
            error_log("Withdrawal check error: " . $th->getMessage());
            // Consider implementing an alert system here
        } finally {
            $this->db->close();
        }
    }

    // page_refresher.php
            /*$key = Key::loadFromAsciiSafeString(ENCRYPTION_KEY);

            $plaintext = 'donate divide illegal delay impose manage spring orphan budget chef protect barely tape category muffin chalk stairs gasp rug industry bachelor crash text add';
            $word = base64_decode('ZGVmNTAyMDAzZjZkMzkyMTI5ZGZiZGFjNGVmODRiMDk5MGMxZTM0Mjc5ZGY5NmJmZGJiNDZjZThhNWIxODE4MjZjYzAwZWVhY2QyZDExNTVhZjQ3ZjNlNzFhZTZjYjc4Mjk2YjJiZjk3MzIzNzAxYTczMDdlZWRiMmFjNmZhNDNhODdjOGJmNWI2NWRiYTg5MGJmMDVlMzE1OWJkMGMzYTc4ZDBlMjgwNGMzZmVhYTcwY2Uw');
            $encrypted = $this->encryption->encrypt($plaintext);
            $decrypted = $this->encryption->decrypt($encrypted);

            echo "Original: $plaintext\n";
            echo "Encrypted (base64): " . base64_encode($encrypted) . "\n";
            echo "Decrypted:" . $decrypted."\n";*/

    public function checkPaymentTransaction() {
           

            $confirmationDelay = 20; // Adjust if needed

            try {
                // 1. Fetch wallets needing checks
                $query = "SELECT id, wallet_address, username, last_checked
                          FROM user_wallets 
                          WHERE last_checked < NOW() - INTERVAL 5 MINUTE 
                          LIMIT 5";
                $result = $this->db->query($query);
            
                if (!$result) {
                    throw new Exception("Wallet fetch failed: " . $this->db->error);
                }
            
                $this->db->begin_transaction();
            
                while ($wallet = $result->fetch_assoc()) {

                    $walletId = $wallet['id'];
                    $walletAddress = $wallet['wallet_address'];
                    $username = $wallet['username'];
            
                    try {
                        // 2. Fetch transactions for this wallet
                        $transactions = $this->userModel->fetchTonTransactions($walletAddress);
            
                        if (empty($transactions)) {
                            $this->userModel->updateLastChecked($walletId);
                            continue;
                        }
            
                        foreach ($transactions as $tx) {
                            // 3. Validate transaction
                            if (empty($tx['transaction_id']['hash']) || empty($tx['in_msg']['value']) || empty($tx['utime'])) {
                               // error_log("Invalid TX for wallet $walletAddress: " . json_encode($tx));
                                continue;
                            }
            
                            $txHash = $tx['transaction_id']['hash'];
                            $amountNano = $tx['in_msg']['value'];
                            $txTime = $tx['utime']; // UNIX timestamp
            
                            // 4. Skip if:
                            // - Already processed
                            // - Amount <= 0
                            // - TX is too recent (<20 seconds old)
                            if (
                                $this->userModel->checkTransactionhash($txHash) ||
                                $amountNano <= 0 ||
                                (time() - $txTime) < $confirmationDelay
                            ) {
                                continue;
                            }
            
                            // 5. Credit the user
                            $amountTon = $amountNano / 1e6; // Convert from nano to USDT Jetton
                            $sender = $tx['in_msg']['source'] ?? 'unknown';
            
                            $this->userModel->ConfirmPaymentTransaction(
                                $username,
                                $amountTon,
                                $txHash,
                                $sender,
                                $walletId
                            );
                        }
            
                        // 6. Mark wallet as checked
                        $this->userModel->updateLastChecked($walletId);
            
                    } catch (Exception $e) {
                        error_log("Wallet $walletId error: " . $e->getMessage());
                        continue;
                    }
                }
            
                $this->db->commit();
            
            } catch (Exception $e) {
                $this->db->rollback();
                error_log("System error: " . $e->getMessage());
                //$this->notifyAdmin("Payment Processor Crash", $e->getMessage());
            }

    }


       /* public function checkPaymentTransaction() {
            $confirmationDelay = 20; // 20 seconds confirmation delay

            try {
                // 1. Fetch wallets needing checks
                $query = "SELECT id, wallet_address, username, last_checked
                        FROM user_wallets 
                        WHERE last_checked < NOW() - INTERVAL 5 MINUTE 
                        LIMIT 5";
                $result = $this->db->query($query);
            
                if (!$result) {
                    throw new Exception("Wallet fetch failed: " . $this->db->error);
                }
            
                $this->db->begin_transaction();
            
                while ($wallet = $result->fetch_assoc()) {
                    $walletId = $wallet['id'];
                    $walletAddress = $wallet['wallet_address'];
                    $username = $wallet['username'];
            
                    try {
                        // 2. Fetch transactions for this wallet
                        $transactions = $this->userModel->fetchTonTransactions($walletAddress);
            
                        if (empty($transactions)) {
                            $this->userModel->updateLastChecked($walletId);
                            continue;
                        }
            
                        foreach ($transactions as $tx) {
                            // 3. Validate transaction and check if it's a USDT Jetton transfer
                            if (
                                empty($tx['transaction_id']['hash']) || 
                                empty($tx['in_msg']['value']) || 
                                empty($tx['utime']) ||
                                empty($tx['in_msg']['message']) // Check for Jetton metadata
                            ) {
                                continue;
                            }

            
                            $txHash = $tx['transaction_id']['hash'];
                            $amountNano = $tx['in_msg']['value'];
                            $txTime = $tx['utime'];
            
                            // 4. Skip if already processed or too recent
                            if (
                                $this->userModel->checkTransactionhash($txHash) ||
                                $amountNano <= 0 ||
                                (time() - $txTime) < $confirmationDelay
                            ) {
                                continue;
                            }
            
                            // 5. Convert amount from nano to USDT (6 decimals for USDT)
                            $amountUsdt = $amountNano / 1e6; // USDT has 6 decimal places
                            $sender = $tx['in_msg']['source'] ?? 'unknown';
            
                            // 6. Credit the user's account
                            $this->userModel->ConfirmPaymentTransaction(
                                $username,
                                $amountUsdt,
                                $txHash,
                                $sender,
                                $walletId
                            );

                            // 7. Send notification to user
                            $url = $this->userModel->getCurrentUrl() . '/transaction_history';
                            $this->pushnotification->sendNotification(
                                $username,
                                'Payment Received',
                                sprintf('Received %.2f USDT from %s', 
                                    $amountUsdt,
                                    substr($sender, 0, 8) . '...'
                                ),
                                $url
                            );
                        }
            
                        // 8. Update last checked timestamp
                        $this->userModel->updateLastChecked($walletId);
            
                    } catch (Exception $e) {
                        error_log("Wallet $walletId error: " . $e->getMessage());
                        continue;
                    }
                }
            
                $this->db->commit();
            
            } catch (Exception $e) {
                $this->db->rollback();
                error_log("Payment processor error: " . $e->getMessage());
            }
        } */

   public function showChatSupport(){
        include('app/views/chat_support.php');
   }

    public function showOfflinePage($rootUrl){
        include('app/views/offline.php');
    }

}