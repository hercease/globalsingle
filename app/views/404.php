<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found | GlobalSingleLine</title>
    <link rel="icon" href="<?php echo $rootUrl ?>/public/assets/images/favicon.png" type="image/x-icon"> <!-- [Google Font] Family -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="404 | GlobalSingleLine">
    <meta name="description" content="The platform for Networkers">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="404 | GlobalSingleLine">
    <meta property="og:description" content="The platform for Networkers">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/404">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="404 | GlobalSingleLine">
    <meta name="twitter:description" content="The platform for Networkers">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/404">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/404">
    <link rel="manifest" href="manifest.json">
       <!-- Bootstrap 5 CSS -->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        :root {
            --primary-color: #6c63ff;
            --dark-color: #2f2e41;
            --light-color: #f8f9fa;
        }
        
        body {
            background-color: var(--light-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .error-container {
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .error-icon {
            font-size: 8rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .error-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 1rem;
        }
        
        .error-subtitle {
            font-size: 1.5rem;
            color: #6c757d;
            margin-bottom: 2rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #564fd8;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.3);
        }
        
        .astronaut-img {
            max-width: 200px;
            margin: 0 auto;
            display: block;
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
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="text-center animate__animated animate__fadeIn">
                    <!-- SVG Astronaut Illustration -->
                    <svg class="astronaut-img mb-4 animate__animated animate__bounceIn" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="#6c63ff" d="M256 0a256 256 0 1 0 0 512A256 256 0 1 0 256 0zM127 281c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l71 71L232 136c0-13.3 10.7-24 24-24s24 10.7 24 24l0 182.1 71-71c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9L273 345c-9.4 9.4-24.6 9.4-33.9 0L127 281z"/>
                    </svg>
                    
                    <h1 class="error-title animate__animated animate__fadeInDown">404</h1>
                    <h2 class="error-subtitle animate__animated animate__fadeInUp animate__delay-1s">Oops! Page Not Found</h2>
                    <p class="lead mb-4 animate__animated animate__fadeIn animate__delay-2s">The page you're looking for doesn't exist or has been moved.</p>
                    
                    <div class="d-flex justify-content-center gap-3 animate__animated animate__fadeInUp animate__delay-3s">
                        <a href="dashboard" class="btn btn-primary btn-lg">
                            <i class="bi bi-house-door me-2"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

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
    

</body>
</html>