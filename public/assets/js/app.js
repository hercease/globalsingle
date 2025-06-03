// Workbox Service Worker Registration
  // PWA Installation Prompt
  let deferredPrompt;
  
  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    showInstallPromotion();
  });
  
  // Install Button Component
  function showInstallPromotion() {
    const installContainer = document.createElement('div');
    installContainer.className = 'position-fixed bottom-0 end-0 p-3';
    installContainer.style.zIndex = '9999';
    
    const installButton = document.createElement('button');
    installButton.className = 'btn btn-primary btn-lg shadow-lg rounded-pill px-4 py-3 d-flex align-items-center';
    installButton.style.transition = 'all 0.3s ease';
    installButton.style.fontWeight = '600';
    installButton.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';
    installButton.style.background = 'linear-gradient(135deg, #141414 0%, rgb(37, 117, 252) 100%)';
    installButton.style.border = 'none';
    installButton.innerHTML = `
      <i class="fas fa-download me-2"></i>
      <span>Install App</span>
      <span class="badge bg-white text-primary ms-2">NEW</span>
    `;
    
    // Add animations
    addInstallButtonAnimations(installButton);
    
    installContainer.appendChild(installButton);
    document.body.appendChild(installContainer);
    addBounceAnimation();
  }
  
  function addInstallButtonAnimations(button) {
    button.addEventListener('mouseenter', () => {
      button.style.transform = 'translateY(-3px)';
      button.style.boxShadow = '0 6px 25px rgba(0,0,0,0.2)';
    });
    
    button.addEventListener('mouseleave', () => {
      button.style.transform = 'translateY(0)';
      button.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';
    });
    
    button.addEventListener('click', handleInstallClick);
  }
  
  function handleInstallClick(e) {
    e.preventDefault();
    const button = e.currentTarget;
    
    button.innerHTML = `
      <span class="spinner-border spinner-border-sm me-2" role="status"></span>
      Installing...
    `;
    button.disabled = true;
    button.style.animation = 'bounce 0.5s';
    
    setTimeout(() => {
      deferredPrompt.prompt().then(() => {
        return deferredPrompt.userChoice;
      }).then(choiceResult => {
        if (choiceResult.outcome === 'accepted') {
          button.innerHTML = `
            <i class="fas fa-check-circle me-2"></i>
            Installed!
          `;
          setTimeout(() => {
            button.parentElement.remove();
          }, 2000);
        } else {
          resetInstallButton(button);
        }
        deferredPrompt = null;
      });
    }, 500);
  }
  
  function resetInstallButton(button) {
    button.innerHTML = `
      <i class="fas fa-download me-2"></i>
      <span>Install App</span>
      <span class="badge bg-white text-primary ms-2">NEW</span>
    `;
    button.disabled = false;
    button.style.animation = '';
  }
  
  function addBounceAnimation() {
    const style = document.createElement('style');
    style.textContent = `
      @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
        40% {transform: translateY(-10px);}
        60% {transform: translateY(-5px);}
      }
    `;
    document.head.appendChild(style);
  }
  
  // Service Worker Update Handling
  
  
  function showUpdatePrompt(wb) {
    const updateToast = document.createElement('div');
    updateToast.className = 'update-toast position-fixed bottom-0 end-0 m-3 p-3 bg-light rounded shadow';
    updateToast.innerHTML = `
      <p>New version available!</p>
      <button class="btn btn-sm btn-primary" id="update-button">Update Now</button>
    `;
    document.body.appendChild(updateToast);
    
    document.getElementById('update-button').addEventListener('click', () => {
      wb.addEventListener('controlling', () => {
        window.location.reload();
      });
      
      // Send a message telling the service worker to skip waiting
      wb.messageSkipWaiting();
    });
  }

  console.log('Push subscription successful:', window.env.NOTIFICATION_ACCESS);
  
  // Push Notification System
  class PushNotificationManager {

    constructor() {
      this.VAPID_PUBLIC_KEY = window.env.VAPID_PUBLIC_KEY;
      this.BACKEND_ENDPOINT = window.env.ENDPOINT + '/savesubscription';
    }
  
    async init() {
      try {
        await this.requestNotificationPermission();
        console.log('Notification permission granted');
        if (Notification.permission === 'granted' && window.env.NOTIFICATION_ACCESS==0) {
          await this.registerPush();
        }
      } catch (error) {
        console.error('Push notification initialization failed:', error);
      }
    }
  
    async requestNotificationPermission() {
      if (!this.isSupported()) {
        this.handleUnsupported();
        return;
      }
  
      switch (Notification.permission) {
        case 'granted':
          console.log('Notifications already enabled');
          break;
        case 'denied':
          console.warn('Notifications blocked by user');
          break;
        case 'default':
          const permission = await Notification.requestPermission();
          if (permission === 'granted') {
              await this.registerPush();
              console.log('Notification permission granted and push registered');

          } else {
            console.warn('Notification permission denied');
          }
          break;
      }
    }

    async registerPush() {
      try{
      const registration = await navigator.serviceWorker.ready;
  
      let subscription = await registration.pushManager.getSubscription();
      if (!subscription) {
        subscription = await registration.pushManager.subscribe({
          userVisibleOnly: true,
          applicationServerKey: this.urlBase64ToUint8Array(this.VAPID_PUBLIC_KEY)
        });
        console.log('New subscription created');
      } else {
        console.log('Existing subscription reused');
      }
  
      await this.sendSubscriptionToServer(subscription);
      console.log('Push subscription successful:', subscription);
      } catch (err) {
        console.error('registerPush failed:', err);
      }
    }


  
    /*async registerPush() {
      try {
        const registration = await navigator.serviceWorker.ready;
    
        if (!registration.pushManager) {
          console.warn('Push manager not available');
          return;
        }
    
        const subscription = await registration.pushManager.subscribe({
          userVisibleOnly: true,
          applicationServerKey: this.urlBase64ToUint8Array(this.VAPID_PUBLIC_KEY)
        });
    
        console.log('Push subscription successful:', subscription);
        await this.sendSubscriptionToServer(subscription);
      } catch (err) {
        console.error('registerPush failed:', err);
      }
    }*/
    
  
    async sendSubscriptionToServer(subscription) {
      try {
        const response = await fetch(this.BACKEND_ENDPOINT, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ subscription })
        });
        
        if (!response.ok) throw new Error('Failed to save subscription');
        console.log('Subscription saved to server');
      } catch (err) {
        console.error('Error saving subscription:', err);
      }
    }
  
    urlBase64ToUint8Array(base64String) {
      const padding = '='.repeat((4 - base64String.length % 4) % 4);
      const base64 = (base64String + padding)
        .replace(/-/g, '+')
        .replace(/_/g, '/');
    
      const rawData = window.atob(base64);
      const outputArray = new Uint8Array(rawData.length);
    
      for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
      }
      return outputArray;
    }
  
    isSupported() {
      return 'Notification' in window && 'serviceWorker' in navigator && 'PushManager' in window;
    }
  
    handleUnsupported() {
      console.warn('Push notifications not supported');
    }
  }
  
  // Initialize everything when DOM is loaded
  document.addEventListener('DOMContentLoaded', () => {
    // Initialize push notifications
    const pushManager = new PushNotificationManager();
    pushManager.init();
    
    // Add any other initialization code here
  });

  // Add at the beginning of the DOMContentLoaded event:
if ('serviceWorker' in navigator) {
  window.addEventListener('load', async () => {
    try {
      const registration = await navigator.serviceWorker.register('/sw.js');
      checkForUpdates(registration);
      
      // Listen for updates
      registration.addEventListener('updatefound', () => {
        const newWorker = registration.installing;
        newWorker.addEventListener('statechange', () => {
          if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
            // Show update prompt
            showUpdatePrompt(registration);
          }
        });
      });
    } catch (error) {
      console.error('Service Worker registration failed:', error);
    }
  });
}

// Modify the showUpdatePrompt function:
function showUpdatePrompt(registration) {
  // Check if toast already exists
  if (document.querySelector('.update-toast')) return;
  
  const updateToast = document.createElement('div');
  updateToast.className = 'update-toast position-fixed bottom-0 end-0 m-3 p-3 bg-light rounded shadow';
  updateToast.innerHTML = `
    <p>New version available!</p>
    <div class="d-flex gap-2">
      <button class="btn btn-sm btn-primary" id="update-button">Update Now</button>
      <button class="btn btn-sm btn-secondary" id="dismiss-button">Dismiss</button>
    </div>
  `;
  document.body.appendChild(updateToast);
  
  document.getElementById('update-button').addEventListener('click', () => {
    registration.waiting.postMessage({ type: 'SKIP_WAITING' });
  });
  
  document.getElementById('dismiss-button').addEventListener('click', () => {
    updateToast.remove();
  });
  
  // Auto-dismiss after 30 seconds
  setTimeout(() => updateToast.remove(), 30000);
}
  
  // Optional: Make forceUpdate available for debugging
  window.forceUpdate = function() {
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.getRegistration().then(registration => {
        if (registration) registration.update();
      });
    }
  };