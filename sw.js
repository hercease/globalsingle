// Import Workbox from CDN
importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-sw.js');

// Debug mode (set to false in production)
workbox.setConfig({
  debug: true,
  modulePathPrefix: 'https://storage.googleapis.com/workbox-cdn/releases/6.5.4/'
});

// Define a versioned cache prefix
const CACHE_VERSION = 'v2';
const CACHE_PREFIX = 'globalsingle-cache';
const CACHE_NAME = `${CACHE_PREFIX}-${CACHE_VERSION}`;

// Apply cache naming conventions
workbox.core.setCacheNameDetails({
  prefix: CACHE_PREFIX,
  suffix: CACHE_VERSION
});

// Precache resources
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

// Cache strategy for static files
workbox.routing.registerRoute(
  /\.(?:html|css|js|json)$/,
  new workbox.strategies.StaleWhileRevalidate({
    cacheName: `${CACHE_NAME}-static`,
    plugins: [
      new workbox.expiration.ExpirationPlugin({
        maxEntries: 100,
        maxAgeSeconds: 30 * 24 * 60 * 60, // 30 days
      }),
    ],
  })
);

// Cache strategy for assets
workbox.routing.registerRoute(
  /\.(?:png|jpg|jpeg|svg|gif|webp|ico|woff2)$/,
  new workbox.strategies.CacheFirst({
    cacheName: `${CACHE_NAME}-assets`,
    plugins: [
      new workbox.expiration.ExpirationPlugin({
        maxEntries: 200,
        maxAgeSeconds: 60 * 24 * 60 * 60, // 60 days
      }),
    ],
  })
);

// Offline fallback
workbox.routing.setCatchHandler(({ event }) => {
  if (event.request.headers.get('accept').includes('text/html')) {
    return caches.match('/offline');
  }
  return Response.error();
});

// Push notification handler
self.addEventListener('push', (event) => {
  const payload = event.data?.json() || {
    title: 'New Message',
    body: 'You have a new message',
    icon: 'public/assets/icons/android/android-launchericon-192-192.png',
    data: { url: '/' },
  };

  event.waitUntil(
    self.registration.showNotification(payload.title, {
      body: payload.body,
      icon: payload.icon,
      vibrate: [200, 100, 200],
      data: payload.data,
    })
  );
});

// Notification click handler
self.addEventListener('notificationclick', (event) => {
  event.notification.close();

  const targetUrl = event.notification.data?.url || '/';

  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientsArr) => {
      const matchingClient = clientsArr.find((client) => client.url === self.location.origin + targetUrl);
      return matchingClient ? matchingClient.focus() : clients.openWindow(targetUrl);
    })
  );
});

// Listen for skip waiting message
self.addEventListener('message', (event) => {
  if (event.data && event.data.type === 'SKIP_WAITING') {
    self.skipWaiting();
  }
});

self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.add("/offline"))
  );
});


if (workbox) {
  if (workbox.navigationPreload.isSupported()) {
    workbox.navigationPreload.enable();
  }

  // Use StaleWhileRevalidate for all requests
  workbox.routing.registerRoute(
    new RegExp(".*"),
    new workbox.strategies.StaleWhileRevalidate({
      cacheName: CACHE_NAME,
    })
  );
} else {
  console.warn("Workbox failed to load.");
}

// Clean up old caches and activate immediately
self.addEventListener('activate', (event) => {
  event.waitUntil(
    Promise.all([
      caches.keys().then((cacheNames) => {
        return Promise.all(
          cacheNames.map((cacheName) => {
            if (!cacheName.includes(CACHE_VERSION)) {
              return caches.delete(cacheName);
            }
          })
        );
      }),
      self.clients.claim()
    ])
  );
});

