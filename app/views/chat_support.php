<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Advanced Chat UI</title>
  <!-- Bootstrap 5 CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.2.0/mdb.min.css" integrity="sha512-7Gq9D0o4oucsdul8TfQEy1UtovxpFGnbR4je6T/pS6o31wM2HRDwZYScOQ9oVO5JFLI04EVB3WZMi1LG2dUNjg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome (for icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.28.1/tabler-icons.min.css" integrity="sha512-UuL1Le1IzormILxFr3ki91VGuPYjsKQkRFUvSrEuwdVCvYt6a1X73cJ8sWb/1E726+rfDRexUn528XRdqrSAOw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
  <!-- Custom CSS -->
  <style>
    body {
      background-color: #f8f9fa;
    }
    .chat-container {
      height: 70vh;
      overflow-y: auto;
      background-color: #f5f5f5;
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
      padding: 0 10px;
      background-color: #f5f5f5;
      position: relative;
      z-index: 1;
    }
    .chat-header {
      background-color: #ffffff;
      border-bottom: 1px solid #e9ecef;
      padding: 10px 15px;
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
  </style>
</head>
<body>
  <!-- Offcanvas Sidebar (Mobile) -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Recent Chats</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
      <ul class="list-group">
        <li class="list-group-item d-flex align-items-center">
          <img src="https://via.placeholder.com/40" class="avatar me-2">
          <div class="flex-grow-1">
            <div class="d-flex justify-content-between">
              <strong>John Doe</strong>
              <span class="text-muted small">2:30 PM</span>
            </div>
            <div class="last-message">See you tomorrow!</div>
          </div>
          <span class="unread-count">3</span>
        </li>
        <li class="list-group-item d-flex align-items-center active">
          <img src="https://via.placeholder.com/40" class="avatar me-2">
          <div class="flex-grow-1">
            <div class="d-flex justify-content-between">
              <strong>Jane Smith</strong>
              <span class="text-muted small">10:32 AM</span>
            </div>
            <div class="last-message">Almost done with the project</div>
          </div>
        </li>
      </ul>
    </div>
  </div>

    <div class="container-fluid vh-100">
    <div class="row h-100">
      <!-- Sidebar (Desktop) -->
      <div class="col-md-3 bg-light p-3 d-none d-md-block">
        <h4>Recent Chats</h4>
        <ul class="list-group">
          <li class="list-group-item d-flex align-items-center">
            <img src="https://via.placeholder.com/40" class="avatar me-2">
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between">
                <strong>John Doe</strong>
                <span class="text-muted small">2:30 PM</span>
              </div>
              <div class="last-message">See you tomorrow!</div>
            </div>
            <span class="unread-count">3</span>
          </li>
          <li class="list-group-item d-flex align-items-center active">
            <img src="https://via.placeholder.com/40" class="avatar me-2">
            <div class="flex-grow-1">
              <div class="d-flex justify-content-between">
                <strong>Jane Smith</strong>
                <span class="text-muted small">10:32 AM</span>
              </div>
              <div class="last-message">Almost done with the project</div>
            </div>
          </li>
        </ul>
      </div>

      <!-- Chat Area -->
      <div class="col-md-9 p-0 d-flex flex-column">
        <!-- Chat Header (With Mobile Menu Button) -->
        <div class="chat-header">
          <button class="btn mobile-menu-btn me-2" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
            <i class="fas fa-bars"></i>
          </button>
          <img src="https://via.placeholder.com/40" class="avatar">
          <div>
            <h5 class="mb-0">Jane Smith</h5>
            <small class="text-muted">Online</small>
          </div>
          <div class="ms-auto">
            <button class="btn btn-sm btn-outline-secondary">
              <i class="fas fa-phone"></i>
            </button>
            <button class="btn btn-sm btn-outline-secondary ms-1">
              <i class="fas fa-video"></i>
            </button>
          </div>
        </div>

        <!-- Messages Container -->
        <div class="chat-container p-3 flex-grow-1">
          <!-- Date Group: Today -->
          <div class="date-divider">
            <span>Today</span>
          </div>

          <!-- Received Message (Today) -->
          <div class="message received">
            <strong>Jane:</strong> Hey! How's the project going?
            <div class="message-time">10:30 AM · 2023</div>
          </div>

          <!-- Sent Message (Today - Read) -->
          <div class="message sent">
            <strong>You:</strong> Almost done! Just fixing the last few UI details.
            <div class="message-time">
              10:32 AM · 2023
              <span class="message-status read">
                <i class="fas fa-check-double"></i>
              </span>
            </div>
          </div>

          <!-- Date Group: Yesterday -->
          <div class="date-divider">
            <span>Yesterday</span>
          </div>

          <!-- Received Message (Yesterday) -->
          <div class="message received">
            <strong>Jane:</strong> Don’t forget to test the mobile responsiveness.
            <div class="message-time">4:15 PM · 2023</div>
          </div>

          <!-- Sent Message (Yesterday - Sent) -->
          <div class="message sent">
            <strong>You:</strong> I’ve already checked it on iOS and Android. Looks great!
            <div class="message-time">
              4:20 PM · 2023
              <span class="message-status sent">
                <i class="fas fa-check"></i>
              </span>
            </div>
          </div>

          <div class="typing-indicator" id="typingIndicator">
            <div class="typing-dots">
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            </div>
          </div>

        </div>

        <!-- Message Input -->
        <div class="p-3 border-top bg-white">
          <div class="input-group">
            <textarea class="form-control chat-input" placeholder="Type a message..." rows="1"></textarea>
            <button class="btn btn-primary">
              <i class="fas fa-paper-plane"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 
 <!-- Auto-resize textarea -->
   <script>
    // Auto-resize textarea
    const textarea = document.querySelector('.chat-input');
    textarea.addEventListener('input', function() {
      this.style.height = 'auto';
      this.style.height = (this.scrollHeight) + 'px';
    });

    // Typing indicator simulation
    const typingIndicator = document.getElementById('typingIndicator');
    const messageInput = document.querySelector('.chat-input');
    
    let typingTimeout;
    messageInput.addEventListener('input', () => {
      // Show typing indicator when user starts typing
      typingIndicator.style.display = 'block';
      
      // Hide after 2 seconds of inactivity
      clearTimeout(typingTimeout);
      typingTimeout = setTimeout(() => {
        typingIndicator.style.display = 'none';
      }, 2000);
    });

    // Simulate received typing (demo purposes)
    setInterval(() => {
      if(Math.random() > 0.7) {
        typingIndicator.style.display = 'block';
        setTimeout(() => {
          if(Math.random() > 0.5) {
            typingIndicator.style.display = 'none';
            // Add a new received message
            const chatContainer = document.querySelector('.chat-container');
            const newMessage = document.createElement('div');
            newMessage.className = 'message received';
            newMessage.innerHTML = `
              <strong>Jane:</strong> Just sent you a quick reply!
              <div class="message-time">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})} · ${new Date().getFullYear()}</div>
            `;
            chatContainer.appendChild(newMessage);
            chatContainer.scrollTop = chatContainer.scrollHeight;
          }
        }, 1500 + Math.random() * 2000);
      }
    }, 5000);
  </script>
</body>
</html>