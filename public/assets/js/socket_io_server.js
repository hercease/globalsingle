/*require('dotenv').config();
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
});*/

require('dotenv').config();
const express = require('express');
const { createServer } = require('http');
const { Server } = require('socket.io');
const cors = require('cors');
const { createAdapter } = require('@socket.io/redis-adapter');
const redis = require('redis');

// Create server
const app = express();
app.use(cors());
const httpServer = createServer(app);

// Redis configuration with enhanced error handling
const redisOptions = {
  socket: {
    host: process.env.REDIS_HOST || '127.0.0.1',
    port: parseInt(process.env.REDIS_PORT) || 6379,
    reconnectStrategy: (retries) => Math.min(retries * 100, 5000)
  },
  password: process.env.REDIS_PASSWORD || '',
  legacyMode: false // Important for new Redis client behavior
};

// Create and connect Redis clients
const pubClient = redis.createClient(redisOptions);
const subClient = pubClient.duplicate();

// Redis connection event handlers
const handleRedisEvents = (client, name) => {
  client.on('connect', () => console.log(`${name} connected`));
  client.on('ready', () => console.log(`${name} ready`));
  client.on('error', (err) => console.error(`${name} error:`, err));
  client.on('end', () => console.log(`${name} disconnected`));
  client.on('reconnecting', () => console.log(`${name} reconnecting...`));
};

handleRedisEvents(pubClient, 'pubClient');
handleRedisEvents(subClient, 'subClient');

// Configure Socket.IO with Redis adapter
const io = new Server(httpServer, {
  cors: {
    origin: "*",
    methods: ["GET", "POST"],
    credentials: true
  },
  adapter: createAdapter(pubClient, subClient)
});

// Redis-based online users tracker
const ONLINE_USERS_KEY = 'online_users';
const redisClient = redis.createClient(redisOptions);
handleRedisEvents(redisClient, 'redisClient');

// Connection health check
async function checkRedisConnection() {
  if (!pubClient.isOpen || !subClient.isOpen || !redisClient.isOpen) {
    console.log('Reconnecting Redis clients...');
    try {
      if (!pubClient.isOpen) await pubClient.connect();
      if (!subClient.isOpen) await subClient.connect();
      if (!redisClient.isOpen) await redisClient.connect();
    } catch (err) {
      console.error('Redis reconnection failed:', err);
      throw err;
    }
  }
}

// Convert all IDs to strings for Redis
function ensureStringId(id) {
  return String(id);
}

// Add these helper functions at the top
function toRedisId(id) {
  return String(id); // Convert to string for Redis
}

function fromRedisId(id) {
  return Number(id); // Convert back to number for application
}


// Store both user ID and socket ID in Redis
async function setUserOnline(userId, socketId) {
  await checkRedisConnection();
  // Store mapping in both directions
  await redisClient.hSet(ONLINE_USERS_KEY, 
    `user:${userId}`,  // Key format: "user:123"
    socketId
  );
  await redisClient.hSet(ONLINE_USERS_KEY,
    `socket:${socketId}`,  // Key format: "socket:e2eGhflIiHSO51_eAAAH"
    userId
  );
}

// Get socket ID by user ID
async function getUserSocket(userId) {
  await checkRedisConnection();
  const socketId = await redisClient.hGet(ONLINE_USERS_KEY, `user:${String(userId)}`);
  return socketId; // Returns string (socket.id)
}

async function getUserIdBySocket(socketId) {
  await checkRedisConnection();
  const userIdStr = await redisClient.hGet(ONLINE_USERS_KEY, `socket:${String(socketId)}`);
  return userIdStr ? Number(userIdStr) : null; // Convert back to number
}

async function setUserOffline(userId) {
  await checkRedisConnection();
  await redisClient.hDel(ONLINE_USERS_KEY, ensureStringId(userId));
}

// Socket.IO connection handlers
io.on('connection', (socket) => {
  console.log('New connection:', socket.id);

  // Modified authenticate handler
  socket.on('authenticate', async (userId) => {
    try {
      await setUserOnline(userId, socket.id);
      console.log(`User ${userId} connected`);
      socket.broadcast.emit('user-status', { 
        userId: fromRedisId(userId), // Convert back to number
        online: true
      });
    } catch (err) {
      console.error('Authentication error:', err);
    }
  });

  // Modified message handler
  socket.on('send-message', async (data) => {
    try {
      const receiverSocketId = await getUserSocket(data.receiver_id);
      const status = receiverSocketId ? true : false;
      if (receiverSocketId) {
        io.to(receiverSocketId).emit('new-message', {
          ...data,
          receiver_id: fromRedisId(data.receiver_id), // Convert back
          offlineStatus: status,
        });
      }
    } catch (err) {
      console.error('Message send error:', err);
    }
  });

  // Modified typing handlers
  socket.on('typing', async (data) => {
    try {
      // 1. First validate the incoming data
      if (!data.receiverId) {
        console.error('Missing receiverId in typing event');
        return;
      }
  
      // 2. Get the sender's userId from Redis using socket.id
      const senderUserId = await getUserIdBySocket(socket.id);
      if (!senderUserId) {
        console.error('Sender not authenticated');
        return;
      }
  
      // 3. Get receiver's socket ID
      const receiverSocketId = await getUserSocket(data.receiverId);
      console.log(`User ${socket.id} typing to ${receiverSocketId}`);
  
      // 4. Send the typing notification
      if (receiverSocketId) {
        io.to(receiverSocketId).emit('isTyping', data);
      }
    } catch (err) {
      console.error('Typing indicator error:', err);
    }
  });

  socket.on('stop-typing', async (data) => {
    try {
      const stringReceiverId = ensureStringId(data.receiverId);
      const receiverSocketId = await getUserSocket(stringReceiverId);
      if (receiverSocketId) {
        io.to(receiverSocketId).emit('stopTyping', {
          ...data,
          receiverId: fromRedisId(stringReceiverId)
        });
      }
    } catch (err) {
      console.error('Stop typing error:', err);
    }
  });

  socket.on('message-received', async (data) => {
    try {
      const stringSenderId = ensureStringId(data.senderId);
      console.log('Message Received from:', stringSenderId);
      const senderSocketId = await getUserSocket(stringSenderId);
      if (senderSocketId) {
        io.to(senderSocketId).emit('message-seen', {
          ...data,
          senderId: fromRedisId(stringSenderId)
        });
      }
    } catch (err) {
      console.error('Message receipt error:', err);
    }
  });

  // Remove both mappings
  async function setUserOffline(userId, socketId) {
    await checkRedisConnection();
    await redisClient.hDel(ONLINE_USERS_KEY, `user:${userId}`);
    await redisClient.hDel(ONLINE_USERS_KEY, `socket:${socketId}`);
  }

  // Updated disconnect handler
  socket.on('disconnect', async () => {
    try {
      const userId = await getUserIdBySocket(socket.id);
      if (userId) {
        await setUserOffline(userId, socket.id);
        socket.broadcast.emit('user-status', {
          userId: fromRedisId(userId),
          online: false
        });
      }
    } catch (err) {
      console.error('Disconnection error:', err);
    }
  });

});

// Graceful shutdown
process.on('SIGINT', async () => {
  console.log('\nShutting down gracefully...');
  try {
    await pubClient.quit();
    await subClient.quit();
    await redisClient.quit();
    httpServer.close();
    process.exit(0);
  } catch (err) {
    console.error('Shutdown error:', err);
    process.exit(1);
  }
});

// Start server
const PORT = process.env.PORT || 7001;
Promise.all([
  pubClient.connect(),
  subClient.connect(),
  redisClient.connect()
])
.then(() => {
  httpServer.listen(PORT, () => {
    console.log(`Socket.IO server with Redis running on port ${PORT}`);
    console.log(`Allowed origins: ${process.env.SERVER_URL || '*'}`);
  });
})
.catch(err => {
  console.error('Server startup failed:', err);
  process.exit(1);
});