<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//date_default_timezone_set("Africa/lagos");
// Load config and allcontrollers
require_once('config/config.php');
require_once('app/controllers/user.php');
require_once('app/models/user.php');
require_once('app/models/pushnotification.php');
require_once('app/models/tonwallet.php');
require_once('app/models/encryption.php');
require_once('app/controllers/database.php');
require_once('app/controllers/display.php');

// Handle routing
$baseDir = '/globalsingle';  // Base directory where your app is located
$url = str_replace($baseDir, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
// Initialize database
$db = (new Database())->connect();
// Initialize User Controller
$Usercontroller = new Users($db);
// Initialize User Model
$UserModel = new UsersModel($db);
$rootUrl = $UserModel->getCurrentUrl();
// Initialize Display Controller
$DisplayController = new Display($db);

switch ($url) {
    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showLoginPage($rootUrl);
        }
        break;
    case '/register':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showRegistrationPage($rootUrl);
        }
        break;
    case '/profile':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showProfilePage($rootUrl);
        }
        break;
    case '/wallet_transfer':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showWalletTransferPage($rootUrl);
        }
        break;
    case '/intra_transfer':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showIntraTransferPage($rootUrl);
        }
        break;
    case '/checkers':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showCheckersPage($rootUrl);
        }
        break;
    case '/transaction_history':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showTransactionHistoryPage($rootUrl);
        }
        break;
    case '/404':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->show404Page($rootUrl);
        }
        break;
    case '/my_chats':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showMyChatPage($rootUrl);
        }
        break;
    case (preg_match('/^\/chat\/(-?\d+)$/', $url, $matches) ? '/chat/' . $matches[1] : null):
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $Id = $matches[1];
        $DisplayController->showUserChatPage($Id, $rootUrl);
    }
    break;
    case '/vendors':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showVendorsPage($rootUrl);
        }
        break;
    case '/fetchVendors':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $Usercontroller->fetchVendors($rootUrl);
        }
        break;
    case '/withdrawal':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showWithdrawalPage($rootUrl);
        }
        break;
    case '/getConversations':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $Usercontroller->getConversation();
        }
        break;
    case '/offline':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showOfflinePage($rootUrl);
        }
        break;
    case '/checkandupdatewithdrawals':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->CheckandUpdateWithdrawals();
        }
        break;
    case '/forgot_password':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showForgotPasswordPage($rootUrl);
        }
        break;
    case '/dashboard':
    case '/':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showDashboardPage($rootUrl);
        }
        break;
    case '/logout':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
           echo $Usercontroller->Logout();
        }
        break;
    case '/allusers':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showAllUsersPage($rootUrl);
        }
        break;
    case '/become_a_vendor':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showBecomeVendorPage($rootUrl);
        }
        break;
    case '/statistics':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showStatisticsPage($rootUrl);
        }
        break;
    case '/vendor_requests':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showVendorRequestPage($rootUrl);
        }
        break;
    case '/all_wallets':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showAllWalletsPage($rootUrl);
        }
        break;
    case '/fund_wallet':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showFundWalletPage($rootUrl);
        }
        break;
    case '/checkpaymenttransactions':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->checkPaymentTransaction();
        }
        break;
    case '/support':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showSupportPage($rootUrl);
        }
        break;
    case '/chatsupport':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $DisplayController->showChatSupport($rootUrl);
        }
        break;
    case '/processRegistration':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->processRegistration();
        }
        break;
    case '/processLogin':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->processLogin();
        }
        break;
    case '/processForgot':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->processPassword();
        }
        break;
    case '/checkqualification':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->checkStageQualification();
        }
        break;
    case '/processChangePassword':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->processChangePassword();
        }
        break;
    case '/updateWalletAddress':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->UpdateWalletAddress();
        }
        break;
    case '/updateWalletPassword':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->UpdateWalletPassword();
        }
        break;
    case '/sendAuthenticationCode':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->sendAuthenticationCode();
        }
        break;
    case '/processwallettransfer':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->processTransfer();
        }
        break;
    case '/processintratransfer':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->processIntraTransfer();
        }
        break;
    case '/fetchtransactionhistory':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->fetchTransactionHistory();
        }
        break;
    case '/fetchtransactiondetails':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->fetchTransactionDetails();
        }
        break;
    case '/markasread':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->markAsRead();
        }
        break;
    case '/insertratings':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->InsertRatings();
        }
        break;
    case '/send_message':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->sendMessage();
        }
        break;
    case '/updatenotification':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->updateNotification();
        }
        break;
    case '/fetchchathistory':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->fetchChatHistory();
        }
        break;
    case '/savesubscription':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->saveSubscriptions();
        }
        break;
    case '/processwithdrawal':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->processWithdrawal();
        }
        break;
    case '/fetchallusers':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->fetchAllUsers();
        }
        break;
    case '/submitVendorApplication':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->submitVendorApplication();
        }
        break;
    case '/fetchVendorRequests':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->fetchVendorRequests();
        }
        break;
    case '/processvendorrequest':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->processVendorRequest();
        }
        break;
    case '/fetchallwallets':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->fetchAllWallets();
        }
        break;
    case '/processuserwallettransfer':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo $Usercontroller->processWalletTransfer();
        }
        break;
    default:
    // Handle 404
    http_response_code(404);
    $DisplayController->show404Page($rootUrl);
    break;
}