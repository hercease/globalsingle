<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Chats | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="My Chats | GlobalSingleLine">
    <meta name="description" content="Generating Success For Life">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="My Chats | GlobalSingleLine">
    <meta property="og:description" content="Generating Success For Life">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/my_chats">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="My Chats | GlobalSingleLine">
    <meta name="twitter:description" content="Generating Success For Life">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/my_chats">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/my_chats">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.28.1/tabler-icons.min.css" integrity="sha512-UuL1Le1IzormILxFr3ki91VGuPYjsKQkRFUvSrEuwdVCvYt6a1X73cJ8sWb/1E726+rfDRexUn528XRdqrSAOw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        :root {
            --primary-color: #7367f0;
            --hover-color: #5d50e6;
            --bg-color: #f8f7fa;
        }
        
        body {
            background: #deebf1;
            background-size: cover;
            background-blend-mode: overlay;
            background-image: url('public/assets/images/background.png'); /* Replace with your image path */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            background-position: center center; /* Centers the image */
        }
        
        .chat-card {
            transition: all 0.3s ease;
            border-radius: 10px;
            border-left: 4px solid var(--primary-color);
        }
        
        .chat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .avatar {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
        
        .unread-badge {
            background-color: var(--primary-color);
        }
        
        .timestamp {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box i {
            position: absolute;
            top: 12px;
            left: 15px;
            color: #6c757d;
        }
        
        .search-input {
            padding-left: 40px;
            border-radius: 20px;
            border: 1px solid #e0e0e0;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--hover-color);
            border-color: var(--hover-color);
        }

        .update-toast {
          z-index: 10000;
          max-width: 300px;
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

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light" style="font-family:Public Sans, sans-serif">

       
 <!-- [ Sidebar Menu ] start -->
<!-- [ Sidebar Menu ] start -->
  <?php include("includes/sidebar.php"); ?>
    <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
    <?php include("includes/header.php"); ?>

    <div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">Users</a></li>
                <li class="breadcrumb-item" aria-current="page">My chats</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">My chats</h2>
              </div>
            </div>
          </div>
        </div>
      </div>

    <!-- Main Content -->
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <!-- Search Box -->
                <div class="search-box mb-4">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control search-input" placeholder="Search conversations...">
                </div>
                
                <!-- Chat List -->
                <div id="chat-list" class="list-group">
                    <!-- Sample Chat Item 1 -->
                </div>
            </div>
            <!-- Chat Area (Visible on larger screens) -->
            
        </div>
    </div>
    </div>
    </div>

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
    <script src="https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-window.prod.mjs" type="module"></script>
    <script src="sw.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/app.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/workboxreg.js"></script>

    <script>layout_change('light');</script>
    <script>change_box_container('false');</script>
    <script>layout_rtl_change('false');</script>
    <script>preset_change("preset-1");</script>
    <script>font_change("Public-Sans");</script>
    <script>
       // Fetch and display chats
        function loadChats() {
            $.ajax({
                url: 'fetchchathistory',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        renderChats(response.chats);
                    } else {
                        console.error('Error loading chats:', response.message);
                        $('#chat-list').html('<div class="alert alert-danger">Error loading conversations</div>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                    $('#chat-list').html('<div class="alert alert-danger">Connection error</div>');
                }
            });
        }

        // Render chats to the UI
        function renderChats(chats) {
            const chatList = $('#chat-list');
            chatList.empty();

            if (chats.length === 0) {
                chatList.html('<div class="text-center py-4 text-muted">No conversations yet</div>');
                return;
            }

            chats.forEach(chat => {
                const unreadBadge = chat.unread_count > 0 
                    ? `<span class="badge bg-primary rounded-pill">${chat.unread_count}</span>`
                    : '';

                const chatItem = `
                <a href="#" class="list-group-item list-group-item-action p-3 mb-2 bg-white chat-card" data-user-id="${chat.user_id}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="<?php echo $rootUrl ?>/public/assets/images/user/${chat.avatar || 'https://via.placeholder.com/50'}" alt="${chat.username}" class="avatar me-3">
                            <div>
                                <h6 class="mb-0">${chat.username}</h6>
                                <p class="mb-0 text-muted small">${chat.last_message || 'No messages yet'}</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="timestamp d-block">${formatTime(chat.last_message_time)}</span>
                            ${unreadBadge}
                        </div>
                    </div>
                </a>
                `;
                chatList.append(chatItem);
            });

            // Add click event to load specific chat
            $('.chat-card').on('click', function(e) {
                e.preventDefault();
                const userId = $(this).data('user-id');
               window.location.href= `chat/${userId}`
            });
        }

        // Format timestamp
        function formatTime(timestamp) {
            if (!timestamp) return '';
            const date = new Date(timestamp);
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }

        // Initial load
        $(document).ready(function() {
            loadChats();
        });

        window.addEventListener('load', () => {
            const preloader = document.querySelector(".loader-container");
            //preloader.style.opacity = '0'; // Fade-out effect
            setTimeout(() => {
                preloader.style.display = 'none'; // Hide after fade-out
            }, 500); // Matches the CSS transition duration (if added)
        });
    </script>
</body>
</html>