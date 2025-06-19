<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vendors | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Vendors | GlobalSingleLine">
    <meta name="description" content="Generating Success For Life">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Vendors | GlobalSingleLine">
    <meta property="og:description" content="Generating Success For Life">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo_new.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/vendors">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Vendors | GlobalSingleLine">
    <meta name="twitter:description" content="Generating Success For Life">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo_new.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/vendors">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/vendors">
    <link rel="manifest" href="manifest.json">

    <!-- [Favicon] icon -->
    <link rel="icon" href="<?php echo $rootUrl ?>/public/assets/images/favicon.png" type="image/x-icon"> <!-- [Google Font] Family -->
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.28.1/tabler-icons.min.css" integrity="sha512-UuL1Le1IzormILxFr3ki91VGuPYjsKQkRFUvSrEuwdVCvYt6a1X73cJ8sWb/1E726+rfDRexUn528XRdqrSAOw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
        }
        
        body {
            background: #deebf1;
            background-size: cover;
            background-blend-mode: overlay;
            background-image: url('public/assets/images/background.png'); /* Replace with your image path */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            background-position: center center; /* Centers the image */
        }
        
        .chat-container {
            height: 80vh;
            max-width: 800px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: white;
        }
        
        .chat-header {
            /*background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));*/
            color: white;
            padding: 12px 20px;
            display: flex;
            align-items: center;
        }
        
        .recipient-info {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }
        
        .recipient-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 12px;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .recipient-name {
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .recipient-status {
            font-size: 0.75rem;
            opacity: 0.9;
        }
        
        .chat-messages {
            height: calc(100% - 120px);
            overflow-y: auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        
        .message {
            display: flex;
            margin-bottom: 15px;
            align-items: flex-end;
        }
        
        .message.received {
            justify-content: flex-start;
        }
        
        .message.sent {
            justify-content: flex-end;
        }
        
        .message-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            margin-bottom: 5px;
        }
        
        .message.sent .message-avatar {
            order: 1;
            margin-left: 10px;
            margin-right: 0;
        }
        
        .message-bubble {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 15px;
            position: relative;
            word-wrap: break-word;
            line-height: 1.4;
        }
        
        .received .message-bubble {
            background-color: white;
            color: var(--dark-color);
            border-bottom-left-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .sent .message-bubble {
            background-color: var(--primary-color);
            color: white;
            border-bottom-right-radius: 5px;
        }
        
        .message-time {
            font-size: 0.7rem;
            margin-top: 4px;
        }
        
        .received .message-time {
            color: #6c757d;
            text-align: left;
            padding-left: 15px;
        }
        
        .sent .message-time {
            color: rgba(255, 255, 255, 0.7);
            text-align: right;
            padding-right: 15px;
        }
        
        .chat-input {
            padding: 5px;
            background-color: white;
            border-top: 1px solid #e9ecef;
        }
        
        .typing-indicator {
            font-size: 0.8rem;
            color: #6c757d;
            padding-left: 62px;
            margin-bottom: 5px;
            font-style: italic;
            height: 20px;
        }
        
        .typing-dots span {
            animation: bounce 1.4s infinite ease-in-out;
            display: inline-block;
        }
        
        .typing-dots span:nth-child(1) {
            animation-delay: 0s;
        }
        
        .typing-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .typing-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }
        
        @keyframes bounce {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-3px); }
        }
        
        /* Custom scrollbar */
        .chat-messages::-webkit-scrollbar {
            width: 8px;
        }
        
        .chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .chat-messages::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }
        
        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }
        
        /* Animation for new messages */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .message {
            animation: fadeIn 0.3s ease-out;
        }
        
        .header-actions .btn {
            color: rgba(255, 255, 255, 0.8);
            padding: 5px 8px;
        }
        
        .header-actions .btn:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

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

        .message-loader {
            text-align: center;
            padding: 10px;
            color: #666;
            background-color: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }

        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --light-bg: #f8f9fa;
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .vendor-card {
            transition: all 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 15px;
        }
        
        .vendor-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        
        .vendor-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .vendor-username {
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
            margin-bottom: 0;
        }
        
        .vendor-rating {
            color: #ffc107;
            font-size: 0.8rem;
        }
        
        .chat-btn {
            background: linear-gradient(135deg, #475b91, #fdfdfd);
            border: none;
            border-radius: 20px;
            padding: 6px 15px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .chat-btn:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.3);
        }
        
        .online-status {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        
        .online {
            background-color: #28a745;
        }
        
        .offline {
            background-color: #6c757d;
        }
        
        .last-active {
            font-size: 0.75rem;
            color: #6c757d;
        }
        
        .search-box {
            border-radius: 30px;
            padding-left: 20px;
            border: 1px solid #e0e0e0;
        }
        
        .search-btn {
            border-radius: 0 30px 30px 0;
            background-color: var(--primary-color);
            border: none;
        }

        /* Previous CSS styles remain the same */
        .rating-stars {
            font-size: 1.5rem;
            color: #ddd;
            cursor: pointer;
        }
        .rating-stars .active {
            color: #ffc107;
        }
        .sort-options {
            cursor: pointer;
        }
        .sort-options.active {
            color: var(--primary-color);
            font-weight: bold;
        }

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

        .update-toast {
          z-index: 10000;
          max-width: 300px;
        }

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

        <div class="loader-container">
            <div class="loader-wrapper">
                <div class="rotating-circle"></div>
                <img src="public/assets/images/favicon.png" alt="Logo" class="logo">
            </div>
            <div class="loading-text"></div>
        </div>

<body data-pc-theme="light" data-pc-direction="ltr" data-pc-preset="preset-1" style="font-family:Public Sans, sans-serif">
  <!-- [ Pre-loader ] start -->

<!-- [ Pre-loader ] End -->
 <!-- [ Sidebar Menu ] start -->
<!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
<!-- [ Sidebar Menu ] start -->
    <?php include("includes/sidebar.php"); ?>
    <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
    <?php include("includes/header.php"); ?>

    <div class="pc-container">
        <div class="pc-content">

            <div class="page-header">
                <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Users</a></li>
                        <li class="breadcrumb-item" aria-current="page">Vendors</li>
                    </ul>
                    </div>
                    <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Vendors</h2>
                    </div>
                    </div>
                </div>
                </div>
            </div>

    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-md-8 mx-auto">
                <div class="input-group mb-3">
                    <input type="text" id="search-input" class="form-control search-box" placeholder="Search vendors...">
                    <button class="btn btn-primary search-btn" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="d-flex justify-content-end mb-3">
                    <span class="me-3 sort-options active" data-sort="rating">Top Rated</span>
                    <span class="sort-options" data-sort="name">Alphabetical</span>
                </div>
            </div>
        </div>
        
        <div class="row g-3" id="vendors-container">
            <!-- Vendors will be loaded here via AJAX -->
        </div>
    </div>


    <div class="modal fade" id="ratingModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rate Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="rating-stars mb-3" id="rating-stars">
                        <i class="fas fa-star" data-rating="1"></i>
                        <i class="fas fa-star" data-rating="2"></i>
                        <i class="fas fa-star" data-rating="3"></i>
                        <i class="fas fa-star" data-rating="4"></i>
                        <i class="fas fa-star" data-rating="5"></i>
                    </div>
                    <input type="hidden" id="selected-rating" value="0">
                    <input type="hidden" id="current-vendor-id" value="">
                    <button id="submit-rating" class="btn btn-primary">Submit Rating</button>
                </div>
            </div>
        </div>
    </div>

    <a href="https://t.me/+rkqEln_UiqphMDM0" class="support-icon">
        <span><i class="fab fa-telegram"></i></span> <!-- Or use an icon (e.g., Font Awesome) -->
      </a>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/jquery.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/popper.min.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/simplebar.min.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/fonts/custom-font.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/jquery-validate.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/pcoded.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
     <!--<script src="https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-window.prod.mjs" type="module"></script>-->
    <script src="https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-window.prod.umd.js"></script>
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
        
        let currentSort = 'rating';
        const ratingModal = new bootstrap.Modal('#ratingModal');
        
        // Load vendors on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadVendors();
            
            // Search functionality
            document.querySelector('.search-btn').addEventListener('click', loadVendors);
            document.getElementById('search-input').addEventListener('keyup', function(e) {
                loadVendors();
            });
            
            // Sort options
            document.querySelectorAll('.sort-options').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.sort-options').forEach(opt => opt.classList.remove('active'));
                    this.classList.add('active');
                    currentSort = this.dataset.sort;
                    loadVendors();
                });
            });
            
            // Rating stars interaction
            document.querySelectorAll('#rating-stars i').forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    document.getElementById('selected-rating').value = rating;
                    
                    // Highlight selected stars
                    document.querySelectorAll('#rating-stars i').forEach((s, index) => {
                        s.classList.toggle('active', index < rating);
                    });
                });
            });
            
            // Submit rating
            document.getElementById('submit-rating').addEventListener('click', function() {
                const vendorId = document.getElementById('current-vendor-id').value;
                const rating = document.getElementById('selected-rating').value;
                
                if (rating > 0) {

                    fetch('insertratings', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            rate: true,
                            vendor_id: vendorId,
                            rating: rating
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            ratingModal.hide();
                            loadVendors(); // Refresh the list
                        }
                    });

                }
            });
        });
        
        function loadVendors() {
            const search = document.getElementById('search-input').value;
            
            fetch(`fetchVendors?search=${encodeURIComponent(search)}&sort=${currentSort}`)
                .then(response => response.json())
                .then(vendors => {
                    const container = document.getElementById('vendors-container');
                    container.innerHTML = '';
                    
                    vendors.forEach(vendor => {
                        const card = document.createElement('div');
                        card.className = 'col-md-6 col-lg-4';
                        card.innerHTML = `
                            <div class="vendor-card card">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative me-3">
                                            <img src="public/assets/images/user/${vendor.avatar}" class="vendor-img" alt="${vendor.username}">
                                        </div>
                                        <div>
                                            <p class="vendor-username mb-0 text-uppercase">${vendor.username}</p>
                                            <div class="vendor-rating" data-vendor-id="${vendor.id}">
                                                ${renderStars(vendor.rating)}
                                                <span class="ms-1">${vendor.rating} (${vendor.rating_count})</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm chat-btn" onclick="startChat(${vendor.id})">
                                            <i class="fas fa-comment-dots me-1"></i> Chat
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        container.appendChild(card);
                        
                        // Add click event to ratings
                        card.querySelector('.vendor-rating').addEventListener('click', function() {
                            document.getElementById('current-vendor-id').value = vendor.id;
                            ratingModal.show();
                        });
                    });
                });
        }
        
        function renderStars(rating) {
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 >= 0.5;
            let stars = '';
            
            for (let i = 1; i <= 5; i++) {
                if (i <= fullStars) {
                    stars += '<i class="fas fa-star"></i>';
                } else if (i === fullStars + 1 && hasHalfStar) {
                    stars += '<i class="fas fa-star-half-alt"></i>';
                } else {
                    stars += '<i class="far fa-star"></i>';
                }
            }
            
            return stars;
        }
        
        function startChat(vendorId) {
            //alert(`Chat initiated with vendor ID: ${vendorId}`);
            // Implement your actual chat functionality here
            window.location.href = `chat/${vendorId}`
        }
    </script>
</body>
</html>