// Import Workbox from CDN (or use npm module if bundling)
importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-sw.js');

// Set Workbox config
workbox.setConfig({
  debug: true, // Set to true for development
  modulePathPrefix: 'https://storage.googleapis.com/workbox-cdn/releases/6.5.4/'
});

// Cache name
const CACHE_NAME = '1';
workbox.core.setCacheNameDetails({
  prefix: CACHE_NAME,
});

// Precaching - Auto-generated if using Workbox build tools
workbox.precaching.precacheAndRoute([
  { url: '/', revision: '3' },
  { url: '/manifest.json', revision: '3' },
  { url: 'public/assets/js/plugins/jquery.js', revision: '3' },
  { url: 'public/assets/js/plugins/bootstrap.min.js', revision: '3' },
  { url: 'public/assets/css/style.css', revision: '3' },
  { url: 'public/assets/icons/android/android-launchericon-48-48.png', revision: null },
  { url: 'public/assets/icons/android/android-launchericon-72-72.png', revision: null },
  { url: 'public/assets/icons/android/android-launchericon-96-96.png', revision: null },
  { url: 'public/assets/icons/android/android-launchericon-144-144.png', revision: null },
  { url: 'public/assets/icons/android/android-launchericon-192-192.png', revision: null },
  { url: 'public/assets/icons/android/android-launchericon-512-512.png', revision: null },
  { url: 'public/assets/icons/ios/16.png', revision: null },
  { url: 'public/assets/icons/ios/20.png', revision: null },
  { url: 'public/assets/icons/ios/29.png', revision: null },
  { url: 'public/assets/icons/ios/32.png', revision: null },
  { url: 'public/assets/icons/ios/40.png', revision: null },
  { url: 'public/assets/icons/ios/50.png', revision: null },
  { url: 'public/assets/icons/ios/57.png', revision: null },
  { url: 'public/assets/icons/ios/58.png', revision: null },
  { url: 'public/assets/icons/ios/60.png', revision: null },
  { url: '/offline', revision: '3' }
]);

// Cache strategies
workbox.routing.registerRoute(
  /\.(?:html|css|js|json)$/,
  new workbox.strategies.StaleWhileRevalidate({
    cacheName: `${CACHE_NAME}-static`,
    plugins: [
      new workbox.expiration.ExpirationPlugin({
        maxEntries: 100,
        maxAgeSeconds: 30 * 24 * 60 * 60, // 30 Days
      }),
    ],
  })
);

workbox.routing.registerRoute(
  /\.(?:png|jpg|jpeg|svg|gif|webp|ico|woff2)$/,
  new workbox.strategies.CacheFirst({
    cacheName: `${CACHE_NAME}-assets`,
    plugins: [
      new workbox.expiration.ExpirationPlugin({
        maxEntries: 200,
        maxAgeSeconds: 60 * 24 * 60 * 60, // 60 Days
      }),
    ],
  })
);

// Network-first for API calls
/*workbox.routing.registerRoute(
  new workbox.strategies.NetworkFirst({
    cacheName: `${CACHE_NAME}-api`,
    networkTimeoutSeconds: 3,
    plugins: [
      new workbox.expiration.ExpirationPlugin({
        maxEntries: 50,
        maxAgeSeconds: 5 * 60, // 5 minutes
      }),
    ],
  })
);*/

// Offline page fallback
workbox.routing.setCatchHandler(({event}) => {
  if (event.request.headers.get('accept').includes('text/html')) {
    return caches.match('/offline');
  }
  return Response.error();
});

// Push notifications
self.addEventListener('push', (event) => {
  const payload = event.data?.json() || {
    title: 'New Message',
    body: 'You have a new message',
    icon: 'public/assets/icons/android/android-lauchericon-192x192.png',
    data: { url: '/' }
  };

  event.waitUntil(
    self.registration.showNotification(payload.title, {
      body: payload.body,
      icon: payload.icon,
      vibrate: [200, 100, 200],
      data: payload.data
    })
  );
});

// Notification click handler
self.addEventListener('notificationclick', (event) => {
  event.notification.close();
  
  const targetUrl = event.notification.data?.url || '/';
  
  event.waitUntil(
    clients.matchAll({type: 'window', includeUncontrolled: true})
    .then(windowClients => {
      const existingClient = windowClients.find(client => 
        client.url === self.location.origin + targetUrl
      );
      
      if (existingClient) {
        return existingClient.focus();
      } else {
        return clients.openWindow(targetUrl);
      }
    })
  );
});

// Skip waiting and claim clients
self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});

self.addEventListener('activate', (event) => {
  // Clean up old caches
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName.startsWith('globalsingle-cache-') && cacheName !== CACHE_NAME) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
  
  // Claim clients immediately
  event.waitUntil(clients.claim());
});