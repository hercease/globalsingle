// chat.js - Complete Client-Side Implementation
document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const chatMessages = document.querySelector('.chat-container');
    const messageInput = document.querySelector('.chat-input');
    const sendBtn = document.querySelector('.send-btn');
    const chatPartnerName = document.querySelector('.chat-partner-name');
    const chatPartnerStatus = document.querySelector('.chat-partner-status');
    const typingIndicator = document.querySelector('.typing-indicator');
    const urlParams = new URLSearchParams(window.location.search);
    //console.log(document.body.dataset.rooturl);

    // Chat State
    let currentUserId = null;
    let otherUserId = null;
    let socket = null;
    let typingTimeout = null;
    let url = null;
    let senderAvatar = null;
    let receiverAvatar = null;

    let messageOffset = 0;
    const messageLimit = 100;
    let isLoadingMessages = false;
    let allMessagesLoaded = false;
    let lastDate = null;

    // Initialize the chat
    initChat();

    // Event Listeners
    sendBtn.addEventListener('click', sendMessage);
    messageInput.addEventListener('keypress', handleKeyPress);
    messageInput.addEventListener('input', handleTyping);

    // Initialize chat with data from PHP
    function initChat() {
        // Get user IDs from PHP (these would be injected via your template)
        currentUserId = parseInt(document.body.dataset.currentuserid);
        otherUserId = parseInt(document.body.dataset.otheruserid);
        url = document.body.dataset.rooturl;
        senderAvatar = document.body.dataset.currentuseravatar;
        receiverAvatar = document.body.dataset.otheruseravatar;
        
        // Set chat partner name (from PHP)
        //chatPartnerName.textContent = document.body.dataset.otherUserName;
        
        // Initialize Socket.IO connection
        //initSocket();
        
        // Load message history
        //loadMessages();

        loadOlderMessages();
        loadChats();
    }

    function loadChats() {
        $.ajax({
            url: '../fetchchathistory',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                console.log("chat list", response);
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
                        <img src="${url}/public/assets/images/user/${chat.avatar || 'https://via.placeholder.com/50'}" alt="${chat.username}" class="avatar me-3">
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

    // Initialize Socket.IO connection
   
    socket = io(window.env.CHAT_ENDPOINT, {
        withCredentials: true,
        transports: ['websocket'],
        extraHeaders: {
            "X-User-ID": currentUserId
        }
    });

    // Debug all events
    /*socket.onAny((event, ...args) => {
        console.log(`[Socket] ${event}`, args);
    });*/

    // Connection established
    socket.on('connect', () => {
        socket.emit('authenticate', currentUserId);
        //console.log('Connected to chat server', socket.id);
    });

    // Connection error
    socket.on('connect_error', (err) => {
        //console.error('Connection error:', err);
    });
    

    // New message received
    socket.on('new-message', (message) => {
        //console.log(message);
        if ((message.sender_id === otherUserId && message.receiver_id === currentUserId) || 
            (message.sender_id === currentUserId && message.receiver_id === otherUserId)) {

            addMessageToUI(message, message.sender_id === currentUserId);
            scrollToBottom();
            
            // Mark as read if we're the receiver
            /*if (message.receiver_id === currentUserId) {
                markAsRead(message.id);
            }*/

            loadChats();

        }

        if (document.hidden || message.receiver_id === otherUserId) {
            // Request notification permission if not granted
            if (Notification.permission === 'granted') {
              showChatNotification(message);
            } else if (Notification.permission !== 'denied') {
              Notification.requestPermission().then(permission => {
                if (permission === 'granted') showChatNotification(message);
              });
            }
          }
    });

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            //console.log("it worked");
            if (entry.isIntersecting) {
                const el = entry.target;
                const messageId = el.dataset.messageId;

                // Prevent multiple triggers
                if (messageId && el.dataset.isSeen === 'false') {
                    markAsRead(messageId); // Send to backend/socket
                    el.dataset.isSeen = 'true'; // Update in UI
                    obs.unobserve(el); // Stop observing it
                }

                // Only mark as read if the message is not already read
            }
        });
    }, {
        root: chatMessages,
        threshold: 0.5 // Message must be fully in view
    });

    function showChatNotification(message) {
        navigator.serviceWorker.ready.then(registration => {
          registration.showNotification(`New Message `, {
            body: message.content.length > 50 ? `${message.content.substring(0, 50)}...` : message.content,
            icon: message.senderAvatar || '/public/assets/images/user/avatar-1.jpg',
            data: { 
              url: `/chat/${message.sender_id}`,
              senderId: message.sender_id
            },
            vibrate: [200, 100, 200] // Vibration pattern
          });
        });
      }

    messageInput.addEventListener('input', () => {
        messageInput.style.height = 'auto';
        messageInput.style.height = messageInput.scrollHeight + 'px';
    });
    

    // User status updated
    socket.on('user-status', (data) => {
        if (data.userId === otherUserId) {
            //updateUserStatus(data.online);
        }
    });

    // Typing indicator
    socket.on('isTyping', (data) => {
        if (data.receiverId === currentUserId) {
            createTypingIndicator();
        }
    });

    // Stop typing indicator
    socket.on('stopTyping', (data) => {
        if (data.receiverId === currentUserId) {
            removeTypingIndicator();
        }
    });

    // Stop typing indicator
    socket.on('message-seen', (data) => {
        const tempElement = document.querySelector(`.message.sent[data-message-id="${data.message_id}"]`);
       // console.log("it runs");
            if (tempElement) {
                // Update with real database ID
                
                // Update status
                const statusIcon = tempElement.querySelector('.status-icon');
                if (statusIcon) {

                    statusIcon.innerHTML = getStatusIcon({
                        id: '',
                        is_read: 1 // or true if the server responds with that info
                    });

                }
            }
    });


    // Load message history from server
    /*function loadMessages() {
        fetch(`/api/get_messages.php?sender_id=${currentUserId}&receiver_id=${otherUserId}`)
            .then(response => response.json())
            .then(messages => {
                messages.forEach(message => {
                    addMessageToUI(message, message.sender_id === currentUserId);
                });
                scrollToBottom();
            })
            .catch(error => {
                console.error('Error loading messages:', error);
            });
    }*/

    // Send a new message
    /*function sendMessage() {
        const content = messageInput.value.trim();
        if (!content) return;
        const tempId = 'temp-' + Date.now();
        const message = {
            tempId: tempId,
            sender_id: currentUserId,
            receiver_id: otherUserId,
            content: content,
            created_at: getCurrentFormattedDate(),
            is_read: false
        };

        // Add to UI immediately (optimistic update)
        addMessageToUI(message, true);
        messageInput.value = '';
        scrollToBottom();

        // Send via Socket.IO
        socket.emit('send-message', message);

        // Save to database
        saveMessage(message);
    }*/

    function sendMessage() {

        const content = messageInput.value.trim();
        if (!content) return;
    
        const tempId = 'temp-' + Date.now();
    
        const message = {
            tempId: tempId,
            sender_id: currentUserId,
            receiver_id: otherUserId,
            content: content,
            created_at: getCurrentFormattedDate(),
            is_read: false
        };
    
        // Disable input to prevent spamming (optional)
        messageInput.disabled = true;
    
        // 💾 First, save the message to the server
        saveMessage(message);
        
    }
    

    function getCurrentFormattedDate() {

        const now = new Date();
    
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Month is 0-based
        const day = String(now.getDate()).padStart(2, '0');
    
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
    
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    // Add message to the UI
    function addMessageToUI(message, isSent) {
        
        const messageElement = document.createElement('div');
        messageElement.className = `message ${isSent ? 'sent' : 'received'}`;
        //messageElement.dataset.messageId = message.id;

        
        messageElement.dataset.messageId = message.id;
        

        const dateLabel = getDateLabel(message.created_at);
        
        if (dateLabel !== lastDate) {
            lastDate = dateLabel;

            const divider = document.createElement('div');
            divider.className = 'text-center mb-3';
            divider.innerHTML = `<span class="badge bg-secondary bg-opacity-10 text-secondary">${dateLabel}</span>`;
            chatMessages.appendChild(divider);

        }

        const time = new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + ' · ' + new Date().getFullYear();

        let avatar = message.sender_id === currentUserId ? senderAvatar : receiverAvatar;

        if (message.sender_id !== currentUserId) {
            messageElement.dataset.isSeen = 'false';
        }

        messageElement.innerHTML = `
           
                ${escapeHtml(message.content)}
                <div class="message-time">
                    ${time}
                    ${isSent ? `<span class="message-status sent status-icon">${getStatusIcon(message)}</span>` : ''}
                </div>
        `;

        //chatMessages.insertBefore(messageElement, typingIndicator);
        chatMessages.appendChild(messageElement);

        if (!isSent) {
            observer.observe(messageElement);
        }


    }

    // Save message to database via PHP API
    function saveMessage(message) {

        fetch(`${url}/send_message`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(message)
        })
        .then(response => response.json())
        .then(data => {
            messageInput.disabled = false;
            messageInput.value = '';
            messageInput.style.height = 'auto';
         
    
            if (data.success && data.message_id) {
                // Now attach the ID
                message.id = data.message_id;
    
                // Add to UI
                addMessageToUI(message, true);
                scrollToBottom();
    
                // Send to receiver via Socket.IO
                socket.emit('send-message', message);
            } else {
                //console.error('Failed to save message.');
                // Optionally show error state in UI
            }
        })
        .catch(error => {
            messageInput.disabled = false;
            //console.error('Error saving message:', error);
        });

    }


    // Mark message as read
    function markAsRead(Id) {
        fetch(`${url}/markasread`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message_id : Id })
        })
        .then(response => response.json())
        .then(data => {
         
            if (data.success && data.message_id) {
                // Find and update the temporary message
                const tempElement = document.querySelector(`.message.sent[data-message-id="${Id}"]`);
                if (tempElement) {
                    // Update with real database ID
                    ///tempElement.dataset.messageId = data.message_id;
                    
                    // Update status
                    const statusIcon = tempElement.querySelector('.message-status sent status-icon');
                    if (statusIcon) {
                        statusIcon.innerHTML = getStatusIcon({
                            id: '',
                            is_read: true // or true if the server responds with that info
                        });
                    }
                }
            }

            socket.emit('message-received', data);

        })
        .catch(error => {
            //console.error('Error saving message:', error);
            // Optionally show error state in UI
        });
    }

    // Handle typing detection
    function handleTyping() {
        //console.log("i'm typing");
        // Notify server that user is typing
        socket.emit('typing', {
            receiverId: otherUserId
        });

        // Clear previous timeout
        clearTimeout(typingTimeout);

        // Set timeout to stop typing indicator
        typingTimeout = setTimeout(() => {
            socket.emit('stop-typing', {
                receiverId: otherUserId
            });
        }, 2000);
    }

    // Handle Enter key press
    function handleKeyPress(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    }

    messageInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendBtn.click(); // Trigger send
        }
    });

    // Update user online status
    function updateUserStatus(online) {
        chatPartnerStatus.textContent = online ? 'Online' : 'Offline';
        chatPartnerStatus.className = online ? 'online' : 'offline';
    }

    function createTypingIndicator() {

        if (document.querySelector('.chat-container .typing-indicator')) return;

        const typingIndicator = document.createElement('div');
        typingIndicator.className = 'typing-indicator';
        typingIndicator.id = 'typingIndicator';
        typingIndicator.style.display = 'flex'; // Start hidden
        
        // Create dots container
        const typingDots = document.createElement('div');
        typingDots.className = 'typing-dots';
        
        // Create three dots
        for (let i = 0; i < 3; i++) {
            const dot = document.createElement('div');
            dot.className = 'typing-dot';
            typingDots.appendChild(dot);
        }
    
        typingIndicator.appendChild(typingDots);
    
        // Example: append it to the chat messages container
        chatMessages.appendChild(typingIndicator);
        scrollToBottom();
    
        //return typingIndicator; // in case you want to reference it later (e.g., to remove it)
    }


    setTimeout(() => {
        document.querySelectorAll('.message.received[data-is-seen="false"]').forEach(msg => {
          //console.log("Observing:", msg);
          observer.observe(msg);
        });
      }, 5000);
    
    
    function removeTypingIndicator() {
        const existing = document.querySelector('.chat-container .typing-indicator');
        if (existing) existing.remove();
    }
    

    // Scroll chat to bottom
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Helper function to escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Helper function to get status icon
    function getStatusIcon(message) {
        if (message.is_read===1) return '<i class="fas fa-check-double read"></i>';
        if (message.id) return '<i class="fas fa-check delivered"></i>';
        return '<i class="fas fa-clock sending"></i>';
    }


    // Load more messages when scrolling to top
    /*document.querySelector('.chat-messages').addEventListener('scroll', function() {
        if (this.scrollTop === 0 && !isLoadingMessages && !allMessagesLoaded) {
            loadOlderMessages();
        }
    });*/

    // Optional: Track last scrollTop to detect scroll direction
    let lastScrollTop = chatMessages.scrollTop;

    chatMessages.addEventListener('scroll', () => {
        const currentScrollTop = this.scrollTop;

        // Only trigger if user is scrolling **up** and is at the top
        if (
            currentScrollTop === 0 &&
            lastScrollTop > currentScrollTop && // user scrolled up
            !isLoadingMessages &&
            !allMessagesLoaded
        ) {
            loadOlderMessages();
        }

        lastScrollTop = currentScrollTop;
    });


    // Function to load older messages
        function loadOlderMessages() {
            if (isLoadingMessages || allMessagesLoaded) return;
            isLoadingMessages = true;

            const chatContainer = document.querySelector('.chat-container');
            if (!chatContainer) return;

            // Show loading indicator
            const loader = document.createElement('div');
            loader.className = 'message-loader';
            loader.innerHTML = 'Loading older messages...';
            chatContainer.insertBefore(loader, chatContainer.firstChild);

            const tempOffset = messageOffset;

            fetch(`${url}/getConversations?user1=${currentUserId}&user2=${otherUserId}&limit=${messageLimit}&offset=${tempOffset}`)
                .then(response => response.json())
                .then(response => {
                    document.querySelector('.message-loader')?.remove();

                    if (!response.success || !Array.isArray(response.data)) {
                        console.error('Unexpected response:', response);
                        isLoadingMessages = false;
                        return;
                    }

                    const messages = response.data;

                    if (messages.length === 0) {
                        allMessagesLoaded = true;
                        return;
                    }

                    const oldScrollHeight = chatContainer.scrollHeight;

                    renderMessagesWithDateDivider(messages);

                    const newScrollHeight = chatContainer.scrollHeight;
                    chatContainer.scrollTop = newScrollHeight - oldScrollHeight;

                    messageOffset = tempOffset;
                    isLoadingMessages = false;

                    // Set allMessagesLoaded if no more messages
                    if (response.meta && response.meta.has_more === false) {
                        allMessagesLoaded = true;
                    }
                })
                .catch(error => {
                    console.error('Error loading older messages:', error);
                    document.querySelector('.message-loader')?.remove();
                    isLoadingMessages = false;
                });
        }


    function getDateLabel(dateStr) {
        const messageDate = new Date(dateStr);
        const today = new Date();
        const yesterday = new Date();
        yesterday.setDate(today.getDate() - 1);
    
        const isSameDay = (d1, d2) => 
            d1.getFullYear() === d2.getFullYear() &&
            d1.getMonth() === d2.getMonth() &&
            d1.getDate() === d2.getDate();
    
        if (isSameDay(messageDate, today)) return 'Today';
        if (isSameDay(messageDate, yesterday)) return 'Yesterday';
    
        // Format like: Apr 20, 2025
        return messageDate.toLocaleDateString(undefined, {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }
    
    

    // Function to prepend messages (for older messages)
    /*function prependMessageToUI(message, isSent) {
        const messagesContainer = document.querySelector('.chat-messages');

        const messageElement = document.createElement('div');
        messageElement.className = `message ${isSent ? 'sent' : 'received'}`;
        
        const time = new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        messageElement.innerHTML = `
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sarah" class="message-avatar">
            <div>
                <div class="message-bubble">${message.content}</div>
                <div class="message-time">
                    ${time}
                    ${isSent ? `<span class="status-icon">${getStatusIcon(message)}</span>` : ''}
                </div>
            </div>
        `;
        
        messagesContainer.insertBefore(messageElement, messagesContainer.firstChild);
    }*/
    
       

        function prependMessageToUI(message, isSent) {
            let lastDateLabel = null;
            const messagesContainer = document.querySelector('.chat-messages');
            const messageDate = new Date(message.created_at);
            const currentDateLabel = getDateLabel(messageDate);

             // Check if we need a new date label BEFORE inserting message
            if (currentDateLabel !== lastDateLabel) {
                addDateLabel(messagesContainer, currentDateLabel);
                lastDateLabel = currentDateLabel;
            }

            // Now create and insert the message
            const messageElement = createMessageElement(message, isSent);
            messagesContainer.insertBefore(messageElement, messagesContainer.firstChild);
           
        }

        function getDateLabel(date) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            const messageDay = new Date(date);
            messageDay.setHours(0, 0, 0, 0);
            
            const diffDays = Math.round((today - messageDay) / (1000 * 60 * 60 * 24));
            
            if (diffDays === 0) return 'Today';
            if (diffDays === 1) return 'Yesterday';
            if (diffDays < 7) return messageDay.toLocaleDateString([], { weekday: 'long' });
            
            return messageDay.toLocaleDateString([], { month: 'short', day: 'numeric' });
        }

        function addDateLabel(container, labelText) {
            const label = document.createElement('div');
            label.className = 'date-label';
            label.textContent = labelText;
            container.insertBefore(label, container.firstChild);
        }

        function createMessageElement(message, isSent) {
            const messageElement = document.createElement('div');
            messageElement.className = `message ${isSent ? 'sent' : 'received'}`;
            
            const time = new Date(message.created_at).toLocaleTimeString([], { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
            
            messageElement.innerHTML = `
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User" class="message-avatar">
                <div>
                    <div class="message-bubble">${message.content}</div>
                    <div class="message-time">
                        ${time}
                        ${isSent ? `<span class="status-icon">✓✓</span>` : ''}
                    </div>
                </div>
            `;
            
            return messageElement;
            
        }

        function renderMessagesWithDateDivider(messages) {
            let lastDateLabel = null;
        
            messages.reverse().forEach(message => {
                const dateLabel = getDateLabel(message.created_at);
        
                if (dateLabel !== lastDate) {
                    lastDate = dateLabel;
        
                    const divider = document.createElement('div');
                    divider.className = 'date-divider';
                    divider.innerHTML = `<span class="badge bg-secondary bg-opacity-10 text-secondary">${dateLabel}</span>`;
                    chatMessages.appendChild(divider);
                }
                
                //let avatar = message.sender_id === currentUserId ? senderAvatar : receiverAvatar;

                //console.log(avatar);

                // Render the actua l message
                const msgEl = document.createElement('div');
                msgEl.className = message.sender_id === currentUserId ? 'message sent' : 'message received';
                msgEl.dataset.messageId = message.id ?? 'undefined';

                if (message.sender_id !== currentUserId) {
                    message.is_read === 0 ? msgEl.dataset.isSeen = 'false' : msgEl.dataset.isSeen = 'true';
                }

                msgEl.innerHTML = `
                   
                        ${message.content}
                        <div class="message-time">${new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })} · ${new Date().getFullYear()}
                           
                           ${message.sender_id === currentUserId ? `<span class="message-status sent status-icon">${getStatusIcon(message)}</span>` : ''}
                        </div>
                    
                `;
                chatMessages.appendChild(msgEl);
            });
        }

    
});