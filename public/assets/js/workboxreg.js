if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      const wb = new Workbox('/sw.js');
      
      // Track service worker lifecycle events
      wb.addEventListener('installed', (event) => {
        if (!event.isUpdate) {
          console.log('Service Worker installed for the first time');
        }
      });
  
      wb.addEventListener('waiting', (event) => {
        console.log('A new service worker has installed, but waiting to activate');
        showUpdatePrompt(wb);
      });
  
      wb.addEventListener('activated', (event) => {
        if (!event.isUpdate) {
          console.log('Service Worker activated');
        }
      });

      function checkForUpdates(registration) {
        setInterval(() => {
          registration.update().catch(err => {
            console.log('Update check failed:', err);
          });
        }, 60 * 60 * 1000); // Check hourly
      }
  
      // Register the service worker
      wb.register()
        .then(registration => {
          console.log('ServiceWorker registration successful');
          checkForUpdates(registration);
        })
        .catch(err => {
          console.log('ServiceWorker registration failed: ', err);
        });
    });
  }
  