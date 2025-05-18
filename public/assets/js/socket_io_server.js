require('dotenv').config();
const express = require('express');
const { createServer } = require('http');
const { Server } = require('socket.io');
const cors = require('cors');

// Create server
const app = express();
app.use(cors());
const httpServer = createServer(app);

// Configure Socket.IO
const io = new Server(httpServer, {
  cors: {
    origin: process.env.SERVER_URL, // Your PHP server address
    methods: ["GET", "POST"],
    credentials: true
  }
});

// Track online users
const onlineUsers = new Map();

io.on('connection', (socket) => {
  console.log('New connection:', socket.id);
  
  // Authentication handler
  socket.on('authenticate', (userId) => {
    onlineUsers.set(userId, socket.id);
    console.log(`User ${userId} connected`);
    
    // Notify others
    socket.broadcast.emit('user-status', {
      userId,
      online: true
    });
  });

  // Message handler
  socket.on('send-message', (data) => {
    //console.log(data.receiver_id);
    const receiverSocketId = onlineUsers.get(data.receiver_id);
    
    if (receiverSocketId) {
      io.to(receiverSocketId).emit('new-message', data);
    }
    
    // Echo back to sender
    //socket.emit('message-sent', data);
  });

  //Typing handler
  socket.on('typing', (data) => {
    //console.log(data.receiver_id);
    const receiverSocketId = onlineUsers.get(data.receiverId);
    
    if (receiverSocketId) {
      io.to(receiverSocketId).emit('isTyping', data);
    }
    
    // Echo back to sender
    //socket.emit('message-sent', data);
  });

  //Typing handler
  socket.on('stop-typing', (data) => {
    //console.log(data.receiver_id);
    const receiverSocketId = onlineUsers.get(data.receiverId);
    
    if (receiverSocketId) {
      io.to(receiverSocketId).emit('stopTyping', data);
    }
    
    // Echo back to sender
    //socket.emit('message-sent', data);
  });

  socket.on('message-received', (data) => {
    console.log('Message Received:', data.senderId);
    const senderSocketId = onlineUsers.get(data.senderId);
    
    if (senderSocketId) {
      io.to(senderSocketId).emit('message-seen', data);
    }
    
    // Echo back to sender
    //socket.emit('message-sent', data);
  });



  // Disconnection handler
  socket.on('disconnect', () => {
    for (let [userId, socketId] of onlineUsers.entries()) {
      if (socketId === socket.id) {
        onlineUsers.delete(userId);
        socket.broadcast.emit('user-status', {
          userId,
          online: false
        });
        break;
      }
    }
  });
});

// Start server
const PORT = 7001;
httpServer.listen(PORT, () => {
  console.log(`Socket.IO server running at http://localhost:${PORT}`);
});