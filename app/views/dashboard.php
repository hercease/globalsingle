<?php
  $db = new Database;
  $controller = new Users($db);
?>
<!DOCTYPE html>
   <html>
   <head>
   <title>Dashboard | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Dashboard | GlobalSingleLine">
    <meta name="description" content="The platform for Networkers">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Dashboard | GlobalSingleLine">
    <meta property="og:description" content="The platform for Networkers">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/dashboard">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Dashboard | GlobalSingleLine">
    <meta name="twitter:description" content="The platform for Networkers">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/dashboard">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/dashboard">
    <link rel="manifest" href="manifest.json">

  <!-- [Favicon] icon -->
  <link rel="icon" href="<?php echo $rootUrl ?>/public/assets/images/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&amp;display=swap" id="main-font-link">
  <!-- [Tabler Icons] https://tablericons.com -->
  <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/tabler-icons.min.css">
  <!-- [Feather Icons] https://feathericons.com -->
  <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/feather.css">
  <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
  <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/fontawesome.css">
  <!-- [Material Icons] https://fonts.google.com/icons -->
  <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/material.css">
  <!-- [Template CSS Files] -->
  <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/css/style.css" id="main-style-link">
  <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/css/style-preset.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">

  <style>
    body {
            background: #deebf1;
            background-size: cover;
            background-blend-mode: overlay;
            background-image: url('public/assets/images/background.png'); /* Replace with your image path */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            background-position: center center; /* Centers the image */
        }
    /* Centering the loader */
      .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            flex-direction: column;
            display: flex;
            z-index: 9999;
        }

        /* Bouncing Bars */
        .bar-loader {
            display: flex;
            gap: 6px;
            justify-content: center;
            align-items: end;
            height: 40px;
        }

        .bar {
            width: 8px;
            height: 20px;
            background-color: #c96d18;
            border-radius: 4px;
            animation: bounce 1s infinite ease-in-out;
        }

        .bar:nth-child(2) {
            animation-delay: 0.1s;
            background-color: #faad14;
        }
        .bar:nth-child(3) {
            animation-delay: 0.2s;
            background-color: #facc4f;
        }
        .bar:nth-child(4) {
            animation-delay: 0.3s;
            background-color: #fbd97f;
        }
        .bar:nth-child(5) {
            animation-delay: 0.4s;
            background-color: #ffe8b0;
        }

        @keyframes bounce {
            0%, 100% {
                height: 20px;
                transform: translateY(0);
            }
            50% {
                height: 40px;
                transform: translateY(-10px);
            }
        }

        /* Loading Text */
        .loading-text {
            margin-top: 20px;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

      @media (max-width: 576px) { /* Small devices */
          .card-custom-padding {
          padding: 6px 0px 0px 11px !important;
          border-left: solid;
          }
      }

      .vendor-banner {
            background: linear-gradient(135deg, #6e48aa 0%, #9d50bb 100%);
            border-radius: 12px;
            padding: 30px;
            max-width: 800px;
            margin: 20px auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            color: white;
            font-family: 'Segoe UI', 'Helvetica Neue', sans-serif;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.8s ease-out;
        }

        /* Decorative Animated Elements */
        .vendor-banner::before {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: pulse 6s infinite alternate;
        }

        .vendor-banner::after {
            content: "";
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: pulse 8s 2s infinite alternate;
        }

        /* Floating Icons */
        .banner-icon {
            position: absolute;
            opacity: 0.7;
            animation: float 12s infinite linear;
        }
        .icon-1 { top: 15%; left: 10%; font-size: 24px; animation-delay: 0s; }
        .icon-2 { top: 70%; right: 8%; font-size: 20px; animation-delay: 2s; }
        .icon-3 { bottom: 20%; left: 15%; font-size: 18px; animation-delay: 4s; }

        /* Typography with Animation */
        .banner-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            animation: slideInDown 0.8s ease-out;
        }

        .banner-subtitle {
            font-size: 1.2rem;
            margin-bottom: 25px;
            opacity: 0;
            animation: fadeInUp 0.8s 0.4s ease-out forwards;
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Animated CTA Button */
        .cta-button {
            display: inline-block;
            background: white;
            color: #6e48aa;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
            border: none;
            cursor: pointer;
            opacity: 0;
            animation: fadeInUp 0.8s 0.6s ease-out forwards;
            transform-style: preserve-3d;
        }

        .cta-button:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.3);
            background: #f8f8f8;
        }

        .cta-button:active {
            transform: translateY(1px);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInDown {
            from { 
                transform: translateY(-30px);
                opacity: 0;
            }
            to { 
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.7; }
            100% { transform: scale(1.1); opacity: 0.3; }
        }

        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-15px) rotate(5deg); }
            50% { transform: translateY(0) rotate(0deg); }
            75% { transform: translateY(-10px) rotate(-5deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .vendor-banner {
                padding: 25px 20px;
                margin: 20px 15px;
            }
            
            .banner-title {
                font-size: 2rem;
            }
            
            .banner-subtitle {
                font-size: 1rem;
            }
            
            .banner-icon {
                display: none; /* Hide floating icons on mobile */
            }
        }

        .update-toast {
          z-index: 10000;
          max-width: 300px;
        }

        .dashboard-card {
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            border: none;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .card-icon {
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }
        .card-value {
            font-size: 1.5rem;
            font-weight: 600;
        }
        .card-title {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .referral-card {
            background: linear-gradient(6deg, #3F51B5 0%, #2196F3 100%);
            color: white;
        }
        .vendor-btn {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            font-weight: 500;
        }

        /* Stat Card Base Styles */
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
            height: 100%;
            background-color: #fff;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }
        
        .icon-circle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover .icon-circle {
            transform: scale(1.1);
        }
        
        .card-subtitle {
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            color: #6c757d !important;
        }
        
        h2.mb-0 {
            font-weight: 700;
            font-size: 1.8rem;
            color: #343a40;
        }
        
        /* Color variants */
        .bg-primary { background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%) !important; }
        .bg-success { background: linear-gradient(135deg, #4cc9f0 0%, #4895ef 100%) !important; }
        .bg-warning { background: linear-gradient(135deg, #f8961e 0%, #f3722c 100%) !important; }
        .bg-danger { background: linear-gradient(135deg, #f72585 0%, #b5179e 100%) !important; }
        
        /* Trend indicator */
        .trend-indicator {
            font-size: 0.75rem;
            padding: 3px 8px;
            border-radius: 12px;
            margin-left: 8px;
        }

        @media (max-width: 400px) {
            .stat-card {
                min-width: 140px; /* Prevents over-squishing */
            }
        }
        
        .trend-up { background-color: rgba(40, 167, 69, 0.15); color: #28a745; }
        .trend-down { background-color: rgba(220, 53, 69, 0.15); color: #dc3545; }

        /* Rotating Circle */
            .rotating-circle {
                position: relative;
                width: 80px;
                height: 80px;
                border-radius: 50%;
                border: 5px solid transparent;
                border-top: 5px solid #143a83;
                border-right: 5px solid #ffffff;
                animation: spin 1.5s linear infinite;
            }

            /* Static Logo in Center */
            .loader-wrapper {
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .logo {
                position: absolute;
                width: 45px;
                height: 45px;
                object-fit: contain;
                border-radius: 50%;
            }

            /* Spinning Animation */
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            /* Loading Text */
            .loading-text {
                margin-top: 10px;
                color: #fff;
                font-size: 18px;
                font-weight: bold;
                text-align: center;
            }
            .loading-text::after {
                animation: blink 1s infinite;
            }
            @keyframes blink {
                0%, 100% { opacity: 1; }
                50% { opacity: 0; }
            }

            .support-icon {
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
                background-color: #3498db; /* Adjust color */
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                font-size: 24px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
                z-index: 9999;
                transition: transform 0.3s, background-color 0.3s;
                }

                .support-icon:hover {
                transform: scale(1.1);
                background-color: #2980b9; /* Darker shade on hover */
                }

                /* Optional: Animation */
                @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.1); }
                100% { transform: scale(1); }
                }
                .support-icon {
                animation: pulse 2s infinite;
                }
  </style>
   <script>
        window.env = {
            NOTIFICATION_ACCESS: "<?php echo $userInfo['notification_access']; ?>",
            VAPID_PUBLIC_KEY: "<?php echo VAPID_PUBLIC_KEY ?>",
            ENDPOINT: "<?php echo $rootUrl ?>"
        };
    </script>
</head>
<!-- [Head] end -->
<!-- [Body] Start -->
        <div class="loader-container">
            <div class="loader-wrapper">
                <div class="rotating-circle"></div>
                <img src="public/assets/images/favicon.png" alt="Logo" class="logo">
            </div>
            <div class="loading-text"></div>
        </div>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light" style="font-family:Public Sans, sans-serif">
 <!-- [ Sidebar Menu ] start -->
<!-- [ Sidebar Menu ] start -->
  <?php include("includes/sidebar.php"); ?>
    <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
    <?php include("includes/header.php"); ?>
<!-- [ Header ] end -->
  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
        <div class="page-header">
          <div class="page-block">
            <div class="row align-items-center">
              <div class="col-md-12">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="">Home</a></li>
                  <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>
                  <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="page-header-title">
                  <h2 class="mb-0">Dashboard</h2>
                </div>
              </div>
            </div>
          </div>
        </div>

      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-6 col-xl-3 col-md-3">
          <div class="card bg-blue-500 shadow rounded border border-light rounded-3">
            <div class="card-body card-custom-padding">
              <h6 class="mb-2 f-w-400 text-light"><i class="ti ti-wallet"></i> Earning wallet</h6>
              <h5 class="mb-2 text-light">$<?php echo number_format($userInfo['earning_wallet'], 2) ?></h5>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3 col-md-3">
          <div class="card bg-blue-800 shadow rounded border border-light">
            <div class="card-body card-custom-padding">
              <h6 class="mb-2 f-w-400 text-white"><i class="ti ti-stairs-up"></i> Current Stage</h6>
              <h5 class="mb-2 text-white">Stage <?php echo $userInfo['stage']; ?></h5>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3 col-md-3">
          <div class="card bg-gray-600 shadow rounded border border-light">
            <div class="card-body card-custom-padding">
              <h6 class="mb-2 f-w-400 text-white"><i class="ti ti-wallet"></i> Reg Wallet</h6>
              <h5 class="mb-2 text-white">$ <?php echo number_format($userInfo['reg_wallet'],2); ?></h5>
            </div>
          </div>
        </div>
        <?php if($userInfo['vendor_access'] > 0){ ?>
          <div class="col-6 col-xl-3 col-md-3">
            <div class="card bg-secondary-800 shadow rounded border border-secondary">
              <div class="card-body card-custom-padding">
                <h6 class="mb-2 f-w-400 text-dark"><i class="ti ti-wallet"></i> Vending Wallet</h6>
                <h5 class="mb-2 text-dark">$ <?php echo number_format($userInfo['vendor_wallet'],2); ?></h5>
              </div>
            </div>
          </div>
        <?php } ?>


          <div class="col-12">
                <div class="card referral-card dashboard-card">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="mb-3"><i class="fas fa-link me-2"></i> Referral Link</h4>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="<?php echo $rootUrl ?>/register?referral=<?php echo $userInfo['username'] ?>" readonly>
                                    <button class="btn btn-light" type="button" id="copy-button">
                                        <i class="fas fa-copy"></i> Copy
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <button class="btn vendor-btn btn-lg px-4 py-2">
                                    <i class="fas fa-store me-2"></i> Become a Vendor
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!--<div class="col-md-12">
            <div class="vendor-banner">
                <div class="banner-icon icon-1">🛒</div>
                <div class="banner-icon icon-2">💰</div>
                <div class="banner-icon icon-3">📈</div>
                
                <h1 class="banner-title">Become a Vendor</h1>
                <p class="banner-subtitle">Join our global network and grow your business with thousands of potential customers. Enjoy exclusive benefits and support!</p>
                <a href="#" class="cta-button">Apply Now →</a>
            </div>
        </div>-->
  
        <div class="col-md-12 col-xl-6">
        
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="mb-0">Stage Completion Progress</h5>
          </div>
          <div class="card">
            <div class="card-body">
            <div class="row align-items-center mb-3">
                <div class="col-sm-6 mb-2 mb-sm-0">
                  <p class="mb-0">Stage <?php echo $stageInfo['stage'] ?> Task</p>
                </div>
                <div class="col-sm-6">
                  <div class="d-flex align-items-center">
                    <div class="flex-grow-1 me-3 fw-bold">
                      <?php echo $stageInfo['task_info']; ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row align-items-center mb-3">
                <div class="col-sm-6 mb-2 mb-sm-0">
                  <p class="mb-0">Recruited Downlines</p>
                </div>
                <div class="col-sm-6">
                  <div class="d-flex align-items-center">
                    <div class="flex-grow-1 me-3">
                      <div class="progress progress-warning" style="height: 15px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: <?php echo $countdownlinespercentage. '%' ?>" aria-valuenow="<?php echo $countdownlinespercentage ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $countdownlinespercentage. '%' ?></div>
                      </div>
                    </div>
                    <div class="flex-shrink-0">
                      <p class="mb-0 text-muted"><?php echo $countdownlines['total'] ?></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row align-items-center mb-3">
                <div class="col-sm-6 mb-2 mb-sm-0">
                  <p class="mb-0">Global Downlines</p>
                </div>
                <div class="col-sm-6">
                  <div class="d-flex align-items-center">
                    <div class="flex-grow-1 me-3">
                      <div class="progress progress-success align-center" style="height: 15px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: <?php echo $globalDownlinespercentage. '%' ?>" aria-valuenow="<?php echo $globalDownlinespercentage ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $globalDownlinespercentage. '%' ?></div>
                      </div>
                    </div>
                    <div class="flex-shrink-0">
                      <p class="mb-0 text-muted"><?php echo $globalDownlines ?></p>
                    </div>
                  </div>
                </div>
              </div>

              <?php if($countdownlinespercentage === 100 && $globalDownlinespercentage === 100){  ?>
                <a id="<?php echo $userInfo['id'] ?>" class="btn btn-secondary btn-shadow reward">Claim Reward</a>
              <?php } ?>
              
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-6">
          <h5 class="mb-3">Transaction History</h5>

          <div class="card">
            <div class="list-group list-group-flush">
           <?php
            // Fetch transaction history from the database
              foreach($myhistory as $trans): 

                $typeClass = $trans['type'] === 'credit' ? 'success' : 'danger';
                $statusClass = 'Completed';

            ?>
                <a class="list-group-item list-group-item-action">
                  <div class="d-flex">
                    <div class="flex-shrink-0">
                      <div class="avtar avtar-s rounded-circle text-success bg-light-success">
                        <i class="fa <?php echo $controller->getTransactionIcon($trans['type'], $trans['description']); ?>"></i>
                      </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <h6 class="mb-1"><?php echo $controller->getDescription($trans['description']); ?></h6>
                      <p class="mb-0 text-muted"><?php echo date('M d, Y h:i A', strtotime($trans['date'])); ?></p>
                    </div>
                    <div class="flex-shrink-0 text-end">
                      <h6 class="mb-1 text-<?php echo $typeClass ?>"><?php echo $trans['type'] === 'credit' ? '+' : '-'; ?> <?php echo '$' . number_format($trans['amount'],2); ?></h6>
                      <span class="badge bg-light text-success badge-pill">Completed</span>
                    </div>
                  </div>
                </a>

            <?php endforeach; ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Transaction Details Modal -->
  <div class="modal fade" id="transactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Transaction Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="transactionDetails">
          <!-- Details will be loaded here via AJAX -->
          <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="printReceipt">
            <i class="fas fa-print me-2"></i>Print Receipt
          </button>
        </div>
      </div>
    </div>
  </div>

      <a href="support" class="support-icon">
          <span><i class="fas fa-headset"></i></span> <!-- Or use an icon (e.g., Font Awesome) -->
      </a>
  <!-- [ Main Content ] end -->
  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
        <div class="colsm my-1">
          <p class="m-0">Crafted by Team <a>GlobalSingleLine</a></p>
        </div>
        <div class="col-auto my-1">
          <ul class="list-inline footer-link mb-0">
            <li class="list-inline-item"><a href="../index.html">Home</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- [Page Specific JS] start -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/pages/dashboard-default.js"></script>

  <!-- [Page Specific JS] end -->
  <!-- Required Js -->
  <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/popper.min.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/simplebar.min.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/bootstrap.min.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/fonts/custom-font.js"></script>
  <script src="https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-window.prod.mjs" type="module"></script>

  <script src="<?php echo $rootUrl ?>/public/assets/js/pcoded.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/feather.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
  <script src="sw.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/app.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/workboxreg.js"></script>

  

  <script>layout_change('light');</script>
  
  <script>change_box_container('false');</script>
  
  <script>layout_rtl_change('false');</script>
  
  <script>preset_change("preset-1");</script>
  
  <script>font_change("Public-Sans");</script>
  <script>
     window.addEventListener('load', () => {
            const preloader = document.querySelector(".loader-container");
            //preloader.style.opacity = '0'; // Fade-out effect
            setTimeout(() => {
                preloader.style.display = 'none'; // Hide after fade-out
            }, 500); // Matches the CSS transition duration (if added)
        });

        $('.reward').on('click', function () {
            // Save the button element for use in callbacks
            const $button = $(this);
            const id = $(this).attr('id');

            console.log(id);
            // Disable the button and show a spinner
            $button.prop("disabled", true).html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i> Loading...');

            // Perform AJAX request
            $.ajax({
                url: 'checkqualification', // Replace with your backend endpoint
                type: 'POST', // or 'GET' depending on your API
                dataType: 'json',
                data: { id : id }, // Send the input value as a parameter
                success: function (data) {
                    // Re-enable the button and reset text
                    $button.prop("disabled", false).html('Claim Reward');

                    if (data.status === true) {

                        window.location.href="checkers";

                    } else {
                        // Enable the submit button and populate the results container
                        iziToast.error({ title: 'Error', message: data.message });
                    }
                },
                error: function (xhr, status, error) {
                    // Re-enable the button and handle errors
                    $button.prop("disabled", false).html('Claim Reward');

                    if (xhr.status === 0) {
                        iziToast.error({
                            title: 'Network Error',
                            message: 'No internet connection or the server is unreachable. Please check your network.'
                        });
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: 'An error occurred: ' + xhr
                        });
                    }
                }
            });
        });
    </script>

    <script>
        // Copy referral link functionality
        document.getElementById('copy-button').addEventListener('click', function() {
            const referralInput = document.querySelector('.referral-card input');
            referralInput.select();
            document.execCommand('copy');
            
            // Change button text temporarily
            const copyButton = this;
            const originalText = copyButton.innerHTML;
            copyButton.innerHTML = '<i class="fas fa-check"></i> Copied!';
            
            setTimeout(function() {
                copyButton.innerHTML = originalText;
            }, 2000);
        });
    </script>
   
  
</body>
</html>