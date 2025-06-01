<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chat | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Chat | GlobalSingleLine">
    <meta name="description" content="Generating Success For Life">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Chat | GlobalSingleLine">
    <meta property="og:description" content="Generating Success For Life">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/chat/<?php echo $userdetails['id'] ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Chat | GlobalSingleLine">
    <meta name="twitter:description" content="Generating Success For Life">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/chat/<?php echo $userdetails['id'] ?>">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/chat/<?php echo $userdetails['id'] ?>">
    <link rel="manifest" href="<?php echo $rootUrl ?>/manifest.json">

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
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
        }
        
        body {
            font-family: 'Nunito Sans', sans-serif;
            background: #deebf1;
            background-size: cover;
            background-blend-mode: overlay;
            background-image: url('<?php echo $rootUrl ?>/public/assets/images/background.png'); /* Replace with your image path */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            background-position: center center; /* Centers the image */
        }

        html, body {
        height: 100%;
        overflow: hidden;
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
        
        .chat-container {
  flex-grow: 1;
  overflow-y: auto;
  background-color: #f5f5f5;
  padding: 15px;
}
        .message {
            max-width: 70%;
            margin-bottom: 15px;
            padding: 10px 15px;
            word-wrap: break-word;
            position: relative;
        }
            .received {
            background-color: #ffffff;
            border-radius: 15px 15px 15px 0;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            }
            .sent {
            background-color: #0d6efd;
            color: white;
            border-radius: 15px 15px 0 15px;
            margin-left: auto;
            }
            .message-time {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 5px;
            text-align: right;
            }
            .sent .message-time {
            color: rgba(255, 255, 255, 0.7);
            }
            .date-divider {
            text-align: center;
            margin: 20px 0;
            color: #6c757d;
            position: relative;
            }
            .date-divider::before,
            .date-divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #dee2e6;
            margin: auto 10px;
            }
            .date-divider span {
            background-color: #f5f5f5;
            position: relative;
            z-index: 1;
            }
            .chat-header {
            position: sticky;
            top: 0;
            background-color: #ffffff;
            z-index: 10;
            padding: 10px 15px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            }

            .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            }
            .chat-input {
            word-break: break-word;
            white-space: pre-wrap;
            resize: none;
            }
            /* Unread badge */
            .unread-count {
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            font-size: 0.7rem;
            padding: 3px 6px;
            margin-left: auto;
            }
            /* Last message excerpt */
            .last-message {
            font-size: 0.85rem;
            color: #6c757d;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
            }
            /* Message status ticks */
            .message-status {
            margin-left: 5px;
            font-size: 0.7rem;
            }
            .message-status.sent {
            color: rgba(255, 255, 255, 0.6);
            }
            .message-status.read {
            color: #53bdeb;
            }
            /* Mobile menu button */
            .mobile-menu-btn {
            display: none;
            }
            @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
            }

            .chat-input {
                resize: none;              /* Prevent manual resizing */
                overflow-y: auto;          /* Add scrollbar if needed */
                min-height: 38px;          /* Match input height */
                max-height: 100px;         /* Optional: limit height */
                line-height: 1.5;
            }

            .typing-indicator {
            background-color: #ffffff;
            border-radius: 15px 15px 15px 0;
            padding: 8px 12px;
            margin-bottom: 5px;
            width: fit-content;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            display: none; /* Hidden by default */
            }
            .typing-dots {
            display: flex;
            gap: 4px;
            }
            .typing-dot {
            width: 6px;
            height: 6px;
            background-color: #6c757d;
            border-radius: 50%;
            animation: typingAnimation 1.4s infinite ease-in-out;
            }
            .typing-dot:nth-child(1) { animation-delay: 0s; }
            .typing-dot:nth-child(2) { animation-delay: 0.2s; }
            .typing-dot:nth-child(3) { animation-delay: 0.4s; }
            @keyframes typingAnimation {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-5px); }
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

        .update-toast {
          z-index: 10000;
          max-width: 300px;
        }

        .message-input {
            resize: none;              /* Prevent manual resizing */
            overflow-y: auto;          /* Add scrollbar if needed */
            min-height: 38px;          /* Match input height */
            max-height: 100px;         /* Optional: limit height */
            line-height: 1.5;
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

             .back-button {
                margin-right: 10px;
                color: #0d6efd;
                background: none;
                border: none;
                font-size: 1.2rem;
            }
            @media (min-width: 768px) {
                
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

        .col-md-9 {
        height: 100dvh; /* or min-height */
        }
        
    </style>
    <script>
        window.env = {
            NOTIFICATION_ACCESS: "<?php echo $userInfo['notification_access'] ?? 1; ?>",
            VAPID_PUBLIC_KEY: "<?php echo VAPID_PUBLIC_KEY ?>",
            ENDPOINT: "<?php echo $rootUrl ?>",
            CHAT_ENDPOINT: "<?php echo CHAT_ENDPOINT ?>"
        };
    </script>
</head>

     <div class="loader-container">
        <div class="loader-wrapper">
            <div class="rotating-circle"></div>
            <img src="<?php echo $rootUrl ?>/public/assets/images/favicon.png" alt="Logo" class="logo">
        </div>
        <div class="loading-text"></div>
    </div>  
    <?php
        //print_r($userdetails);
    ?>
<body data-pc-theme="light" data-pc-direction="ltr" data-currentUserAvatar="<?php echo htmlspecialchars($userInfo['avatar'] ?? ""); ?>" data-otherUserAvatar="<?php echo htmlspecialchars($userdetails['avatar'] ?? "");  ?>" data-pc-preset="preset-1" data-otherUserId="<?php echo htmlspecialchars($userdetails['id'] ?? ""); ?>" data-currentUserId="<?php echo htmlspecialchars($userInfo['id'] ?? ""); ?>" data-rootUrl="<?php echo htmlspecialchars($rootUrl); ?>" style="font-family: Nunito Sans, sans-serif;">

    

<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Recent Chats</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div id="chat-list" class="list-group">
                    <!-- Sample Chat Item 1 -->
        </div>
      
    </div>
  </div>

    <div class="container-fluid vh-100">
    <div class="row h-100">
      <!-- Sidebar (Desktop) -->
      <div class="col-md-3 bg-light p-3 d-none d-md-block">
        <h4>Recent Chats</h4>
        <div id="chat-list" class="list-group">
                    <!-- Sample Chat Item 1 -->
        </div>
      </div>

      <!-- Chat Area -->
      <div class="col-md-9 p-0 d-flex min-vh-100 flex-column">
        <!-- Chat Header (With Mobile Menu Button) -->
        <div class="chat-header">
           <button class="back-button" id="backButton">
                <i class="fas fa-arrow-left"></i>
            </button>
            <!-- Mobile Menu Button (now appears after back button) -->
            <img src="<?php echo $rootUrl ?>/public/assets/images/user/<?php echo $userdetails['avatar'] ?>" alt="<?php echo $userdetails['username'] ?>" class="avatar">
          <div>
            <h5 class="mb-0 text-capitalize"><?php echo $userdetails['username']  ?></h5>
            <small class="text-muted">Online</small>
          </div>
          <div class="ms-auto">
             <button class="btn mobile-menu-btn me-2" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="fas fa-bars"></i>
            </button>
          </div>
        </div>

        <!-- Messages Container -->
        <div class="chat-container p-3 flex-grow-1">
          <!-- Date Group: Today -->
          


        </div>

        <!-- Message Input -->
        <div class="p-3 border-top bg-white">
          <div class="input-group">
            <textarea class="form-control chat-input" placeholder="Type a message..." rows="1"></textarea>
            <button class="btn btn-primary send-btn">
              <i class="fas fa-paper-plane"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
    

    <!-- Required Js -->
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/jquery.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/popper.min.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/simplebar.min.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/bootstrap.min.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/fonts/custom-font.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/jquery-validate.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/pcoded.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/feather.min.js"></script>
    <script src="https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-window.prod.mjs" type="module"></script>
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/node_modules/socket.io/client-dist/socket.io.js"></script>
    <script src="<?php echo $rootUrl ?>/sw.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/app.js"></script>
    <script src="<?php echo $rootUrl ?>/public/assets/js/chat.js"></script>
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

         document.getElementById('backButton').addEventListener('click', function() {
            // Replace with your actual dashboard URL or navigation logic
            window.location.href = '../dashboard'; 
            // Alternative: history.back() to go to previous page
        });

        function loadChats() {
            $.ajax({
                url: '../fetchchathistory',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
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
               window.location.href= `${userId}`
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
        // Auto-scroll to bottom of chat
        /*const chatMessages = document.querySelector('.chat-messages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        // Simulate typing indicator
        setTimeout(() => {
            const typingIndicator = document.querySelector('.typing-indicator');
            typingIndicator.style.display = 'none';
            
            // Add a new received message after typing stops
            const messagesContainer = document.querySelector('.chat-messages');
            const newMessage = document.createElement('div');
            newMessage.className = 'message received';
            newMessage.innerHTML = `
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sarah" class="message-avatar">
                <div>
                    <div class="message-bubble">
                        How about we meet at 3pm?
                    </div>
                    <div class="message-time">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                </div>
            `;
            messagesContainer.appendChild(newMessage);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }, 2000);*/
        
        // You would add more JavaScript here for actual chat functionality
    </script>
    
</body>
</html>