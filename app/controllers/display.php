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
    private $bscwallet;

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

    public function showHomepage($rootUrl) {
        include('app/views/homepage.php');
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
            $date = date('Y-m-d H:i:s');
          
            if($page_access > 0){

                $reward = $stageInfo['compensation'];
                $this->userModel->InsertHistory($username, $reward, $date, 'credit', 'Reward for completing stage '.$userInfo['stage']);
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

    public function showGeneratePinPage($rootUrl){
        
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        // Check if the session variable is set
        if (isset($_SESSION['global_single_username'])) {
            

            $username = $_SESSION['global_single_username'];
            $userInfo = $this->userModel->getUserInfo($username);
            $fetchSponsor = $this->userModel->fetchSponsor($username);
            if($userInfo['vendor_access'] > 0){

                include('app/views/generate_reg_pin.php');

            } else {
                include('app/views/404.php');
            }

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
            $fetchAdmin = $this->userModel->fetchAdmins('globalsingle');
        
        
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

        if(isset($_SESSION['global_single_username'])){

            $userdetails = $this->userModel->getUserInfo($Id);
            if(empty($userdetails)){

                $userInfo = ['username' => 'Guest', 'avatar' => 'avatar-1.jpg', 'id' => $Id];

            }
            $userInfo = $this->userModel->getUserInfo($_SESSION['global_single_username']);

        } else {

            if(isset($_SESSION['guest_id'])){

                $guest_id = $_SESSION['global_single_username'];

            } else {

                $guest_id = $this->userModel->generateGuestId();
                
            }

            $userdetails = $this->userModel->getUserInfo($Id);
            $userInfo = ['username' => 'Guest', 'avatar' => 'avatar-1.jpg', 'id' => $guest_id];
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
         // 3. Begin transaction
         $this->db->begin_transaction();

        try {
            // 1. Get a pending withdrawal request
            $query = "SELECT wl.id, wl.tx_hash, wl.tranx_id, wl.amount, wl.to_address, h.username 
                      FROM withdrawal_log wl
                      JOIN tranx_history h ON wl.tranx_id = h.id
                      WHERE wl.status = 'pending'
                      LIMIT 1";
    
            $result = $this->db->query($query);
    
            if (!$result) {
                throw new Exception("Query failed: " . $this->db->error);
            }
    
            $tx = $result->fetch_assoc();
    
            // 2. Exit if no pending withdrawal
            if (!$tx) {
                return;
                //return json_encode(['status' => false, 'message' => 'No pending withdrawals.']);
            }
    
            $amount = $tx['amount'];
            $toAddress = $tx['to_address'];
            $tranx_id = $tx['id'];
            $username = $tx['username'];
            $tx_hash = $tx['tx_hash'];
    
            // 4. Send funds using internal method
            $response = $this->userModel->transferWalletFunds('', $amount, $toAddress);
    
            error_log("Transfer Response: " . print_r($response, true));
    
            // 5. Check if successful
            if (isset($response['status']) && $response['status'] === true) {
                $this->userModel->confirmWithdrawalTransaction($amount, $tranx_id, $tx_hash, $username, $toAddress);
                $this->db->commit();
    
               /* return json_encode([
                    'status' => true,
                    'message' => "Congratulations, withdrawal was successful",
                    'txHash' => $response['txHash'] ?? null
                ]);*/
            } else {
                // 6. Mark failed and log reason
                $errorMessage = $response['error'] ?? json_encode($response);
                $failed = 'failed';
    
                $stmt = $this->db->prepare("UPDATE withdrawal_log SET status = ?, error = ? WHERE id = ?");
                $stmt->bind_param("sss", $failed, $errorMessage, $tranx_id);
                $stmt->execute();
                $stmt->close();
    
                $this->db->commit();
    
               /* return json_encode([
                    'status' => false,
                    'message' => "Withdrawal failed. Please try again later",
                    'error' => $errorMessage
                ]);*/
            }
    
        } catch (Throwable $th) {
            $this->db->rollback();
            error_log("Withdrawal processing error: " . $th->getMessage());
            /*return json_encode([
                'status' => false,
                'message' => "System error: " . $th->getMessage()
            ]);*/
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

                $minConfirmations = 3;
                $checkInterval = 5; // minutes
            
                try {
                    // 1. Fetch wallets needing checks
                    $query = "SELECT id, address, username, last_checked
                              FROM user_wallets 
                              WHERE last_checked < NOW() - INTERVAL {$checkInterval} MINUTE 
                              LIMIT 5";
                    $result = $this->db->query($query);
            
                    if (!$result) {
                        throw new Exception("Wallet fetch failed: " . $this->db->error);
                    }
            
                    $endBlock = $this->userModel->getLatestBlockNumber(); // Current block number
            
                    $this->db->begin_transaction();
            
                    while ($wallet = $result->fetch_assoc()) {
                        $walletId = $wallet['id'];
                        $walletAddress = $wallet['address'];
                        $username = $wallet['username'];
                        $startBlock = $this->userModel->getLastCheckedBlock($walletAddress) + 1;
            
                        try {
                            $transactions = $this->userModel->fetchUsdtTransactions($walletAddress, $startBlock, $endBlock);
            
                            if (empty($transactions)) {
                                $this->userModel->updateLastChecked($walletId);
                                continue;
                            }
            
                            $lastBlock = $startBlock - 1;
            
                            foreach ($transactions as $tx) {
                                $txHash = $tx['hash'];
                                $amount = $tx['value'];
                                $txBlock = (int)$tx['blockNumber'];
                                $confirmations = $endBlock - $txBlock + 1;
                                $tokenDecimal = isset($tx['tokenDecimal']) ? (int)$tx['tokenDecimal'] : 18;
            
                                if (
                                    $this->userModel->checkTransactionhash($txHash) ||
                                    $amount <= 0 ||
                                    $confirmations < $minConfirmations
                                ) {
                                    continue;
                                }
            
                                $amountUsdt = $amount / pow(10, $tokenDecimal);
                                $sender = $tx['from'] ?? 'unknown';
            
                                // Record payment
                                $this->userModel->ConfirmPaymentTransaction($username, $amountUsdt, $txHash, $sender, $walletId);
                                error_log("Credited $username with $amountUsdt USDT from tx $txHash");
            
                                $lastBlock = max($lastBlock, $txBlock);
                            }
            
                            // 6. Update tracking info
                            $this->userModel->updateLastChecked($walletId);
                            if ($lastBlock >= $startBlock) {
                                $this->userModel->saveLastCheckedBlock($walletAddress, $lastBlock);
                            }
            
                        } catch (Exception $e) {
                            error_log("Wallet $walletId error: " . $e->getMessage());
                            continue;
                        }
                    }
            
                    $this->db->commit();
            
                } catch (Exception $e) {
                    $this->db->rollback();
                    error_log("System error: " . $e->getMessage());
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