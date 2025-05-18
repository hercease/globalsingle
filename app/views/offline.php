<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->
<head>
    <title>Offline | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Offline | GlobalSingleLine">
    <meta name="description" content="The platform for Networkers">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Offline | GlobalSingleLine">
    <meta property="og:description" content="The platform for Networkers">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/offline">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Offline | GlobalSingleLine">
    <meta name="twitter:description" content="The platform for Networkers">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/offline">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/offline">

    <link rel="icon" href="<?php echo $rootUrl ?>/public/assets/images/favicon.png" type="image/x-icon"> <!-- [Google Font] Family -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/fontawesome.css">
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/css/style.css" id="main-style-link" >
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .offline-container {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            background-color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .offline-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
            animation: pulse 2s infinite;
        }
        
        .btn-retry {
            background-color: var(--primary-color);
            border: none;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-retry:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .features-list {
            text-align: left;
            margin: 2rem 0;
        }
        
        .feature-item {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        
        .feature-icon {
            margin-right: 10px;
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="offline-container">
            <div class="offline-icon">
                <i class="fas fa-wifi"></i>
            </div>
            <h1 class="mb-3">You're Offline</h1>
            <p class="lead text-muted mb-4">Don't worry! Here's what you can still do:</p>
            
            <div class="features-list">
                <div class="feature-item">
                    <i class="fas fa-check-circle feature-icon"></i>
                    <span>Access previously viewed content</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle feature-icon"></i>
                    <span>Use core app features</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle feature-icon"></i>
                    <span>View saved data</span>
                </div>
            </div>
            
            <button id="retryButton" class="btn btn-primary btn-retry rounded-pill">
                <i class="fas fa-sync-alt me-2"></i> Retry Connection
            </button>
            
            <div class="mt-4 text-muted small">
                <p>Connection will automatically restore when available</p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/popper.min.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/bootstrap.min.js"></script>
    
    <script>
        document.getElementById('retryButton').addEventListener('click', function() {
            if (navigator.onLine) {
                window.location.reload();
            } else {
                // Show toast notification
                const toast = document.createElement('div');
                toast.className = 'position-fixed bottom-0 end-0 p-3';
                toast.innerHTML = `
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">No Connection</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            Still offline. Please check your network connection.
                        </div>
                    </div>
                `;
                document.body.appendChild(toast);
                
                // Remove toast after 3 seconds
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }
        });
        
        // Check for connection periodically
        /*setInterval(() => {
            if (navigator.onLine) {
                window.location.reload();
            }
        }, 5000);*/
    </script>
</body>
</html>