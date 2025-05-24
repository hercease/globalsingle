<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chat | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Chat | GlobalSingleLine">
    <meta name="description" content="The platform for Networkers">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Chat | GlobalSingleLine">
    <meta property="og:description" content="The platform for Networkers">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/chat/<?php echo $userdetails['id'] ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Chat | GlobalSingleLine">
    <meta name="twitter:description" content="The platform for Networkers">
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
            background: #deebf1;
            background-size: cover;
            background-blend-mode: overlay;
            background-image: url('<?php echo $rootUrl ?>/public/assets/images/background.png'); /* Replace with your image path */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            background-position: center center; /* Centers the image */
        }
        
        .chat-container {
            height: 80vh;
            max-width: 800px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .chat-container {
            background: 
                radial-gradient(circle at 10% 20%, rgba(255,255,255,0.9) 0%, rgba(240,242,245,0.9) 90%),
                url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="25" cy="25" r="2" fill="%23e4e8eb" opacity="0.5"/><circle cx="75" cy="25" r="2" fill="%23e4e8eb" opacity="0.5"/><circle cx="75" cy="75" r="2" fill="%23e4e8eb" opacity="0.5"/><circle cx="25" cy="75" r="2" fill="%23e4e8eb" opacity="0.5"/></svg>');
            background-size: cover, 60px 60px;
            border-radius: 12px;
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
            max-width: 100%;
            padding: 12px 20px;
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
            color: #6c757d;
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
            margin-bottom: 5px;
            font-style: italic;
            height: 20px;
            justify-content: flex-end;
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
        
    </style>
    <script>
        window.env = {
            NOTIFICATION_ACCESS: "<?php echo $userInfo['notification_access']; ?>",
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
    
<body data-pc-theme="light" data-pc-direction="ltr" data-currentUserAvatar="<?php echo htmlspecialchars($userInfo['avatar'] ?? ""); ?>" data-otherUserAvatar="<?php echo htmlspecialchars($userdetails['avatar'] ?? "");  ?>" data-pc-preset="preset-1" data-otherUserId="<?php echo htmlspecialchars($userdetails['id'] ?? ""); ?>" data-currentUserId="<?php echo htmlspecialchars($userInfo['id'] ?? ""); ?>" data-rootUrl="<?php echo htmlspecialchars($rootUrl); ?>" style="font-family:Public Sans, sans-serif">
    <!-- [ Pre-loader ] start -->

    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
    <!-- [ Sidebar Menu ] start -->



<div class="pc-container">
    <div class="pc-content">
     
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="chat-container">
                    <!-- Chat Header with Recipient Info -->
                    <div class="chat-header">
                        <div class="recipient-info">
                            <img src="<?php echo $rootUrl ?>/public/assets/images/user/<?php echo $userdetails['avatar'] ?>" alt="<?php echo $userdetails['username'] ?>" class="recipient-avatar">
                            <div>
                                <h6 class="recipient-name mb-0"><?php echo $userdetails['username']  ?></h6>
                                <div class="recipient-status text-success d-flex align-items-center">
                                    <span class="online-dot me-1"></span>
                                    <span>Online</span>
                                </div>
                            </div>
                        </div>
                        <div class="header-actions">
                            <button class="btn btn-sm rounded-circle">
                                <i class="fas fa-phone-alt"></i>
                            </button>
                            <button class="btn btn-sm rounded-circle">
                                <i class="fas fa-video"></i>
                            </button>
                            <button class="btn btn-sm rounded-circle">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Chat Messages -->
                    <div class="chat-messages">
                        <!-- Date divider 
                        <div class="text-center mb-3">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">Today</span>
                        </div>-->
                        
                        
                        <!-- Received message
                        <div class="message received">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sarah" class="message-avatar">
                            <div>
                                <div class="message-bubble">
                                    I'm doing well! Just finished my part of the project. Want to review it together later?
                                </div>
                                <div class="message-time">10:34 AM</div>
                            </div>
                        </div> -->
                        
                        <!-- Typing indicator -->
                        <!--<div style="display:none" class="typing-indicator">
                            <span class="typing-dots">
                                <span>.</span><span>.</span><span>.</span>
                            </span>
                        </div>-->
                    </div>
                    
                    <!-- Chat Input -->
                    <div class="chat-input">
                        <div class="input-group align-items-end">
                            <textarea class="form-control message-input" placeholder="Type your message..." rows="1"></textarea>
                            <button class="btn btn-primary rounded-end-pill send-btn" type="button">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
        <div class="row">
            <div class="col-sm my-1">
            <p class="m-0">Crafted By:  <a href="#" >GSL TEAM</a></p>
            </div>
        </div>
        </div>
  </footer> <!-- Required Js -->
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