<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <title>Congratulations | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Congratulations | GlobalSingleLine">
    <meta name="description" content="The platform for Networkers">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="`GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Congratulations | GlobalSingleLine">
    <meta property="og:description" content="The platform for Networkers">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/checkers">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Congratulations | GlobalSingleLine">
    <meta name="twitter:description" content="The platform for Networkers">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>">
    <meta name="theme-color" content="purple">
    <link rel="canonical" href="<?php echo $rootUrl ?>/checkers">
    <link rel="manifest" href="manifest.json">

     <!-- [Favicon] icon -->
    <link rel="icon" href="<?php echo $rootUrl ?>/public/assets/images/favicon.png" type="image/x-icon"> <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&amp;display=swap" id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@700&display=swap">
  
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
      --primary: #6c63ff;
      --secondary: #ff6584;
      --success: #4bb543;
      --gold: #ffc107;
      --dark: #2f2e41;
      --light: #f8f9fa;
    }
    
    body {
      background: radial-gradient(circle at top right, #f3f4ff, #eef1ff);
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
      min-height: 100vh;
      display: flex;
      align-items: center;
    }
    
    .celebration-card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 50px rgba(108, 99, 255, 0.2);
      overflow: hidden;
      position: relative;
      z-index: 10;
      border: none;
      transform-style: preserve-3d;
    }
    
    .celebration-card::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(108, 99, 255, 0.1) 0%, transparent 70%);
      z-index: -1;
      animation: pulse 6s infinite alternate;
    }

    .celebration-container {
      position: relative;
      overflow: hidden;
      border-radius: 20px;
    }
    
    .celebration-card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 15px 50px rgba(108, 99, 255, 0.2);
      position: relative;
      z-index: 10;
      overflow: hidden;
    }
    
    .confetti {
      position: absolute;
      width: 12px;
      height: 12px;
      animation: fall 5s linear infinite;
      z-index: 1;
    }
    
    @keyframes pulse {
      0% { transform: scale(0.8); opacity: 0.5; }
      100% { transform: scale(1.2); opacity: 0.8; }
    }
    
    .confetti {
      position: fixed;
      width: 12px;
      height: 12px;
      animation: fall 5s linear infinite;
      z-index: 2;
    }
    
    @keyframes fall {
      0% { transform: translateY(-100px) rotate(0deg); opacity: 1; }
      100% { transform: translateY(100vh) rotate(360deg); opacity: 0; }
    }
    
    .trophy-icon {
      font-size: 5rem;
      color: var(--gold);
      margin-bottom: 1.5rem;
      text-shadow: 0 3px 10px rgba(255, 193, 7, 0.4);
      animation: bounce 2s infinite alternate;
    }
    
    @keyframes bounce {
      0% { transform: translateY(0); }
      100% { transform: translateY(-15px); }
    }
    
    .congrats-title {
      font-family: 'Montserrat', sans-serif;
      font-size: 2.5rem;
      font-weight: 700;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 1.5rem;
    }
    
    .reward-badge {
      background: linear-gradient(135deg, var(--gold), #ffab00);
      color: white;
      font-weight: 600;
      padding: 8px 20px;
      border-radius: 50px;
      display: inline-block;
      margin: 15px 0;
      box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
    }
    
    .stage-card {
      background: rgba(108, 99, 255, 0.1);
      border-left: 4px solid var(--primary);
      border-radius: 8px;
      padding: 15px;
      margin: 20px 0;
    }
    
    .btn-celebrate {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      border: none;
      padding: 12px 30px;
      font-size: 1.1rem;
      font-weight: 600;
      border-radius: 50px;
      color: white;
      box-shadow: 0 5px 20px rgba(108, 99, 255, 0.3);
      transition: all 0.3s;
      position: relative;
      overflow: hidden;
    }
    
    .btn-celebrate:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(108, 99, 255, 0.4);
      color: white;
    }
    
    .btn-celebrate::after {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: rgba(255, 255, 255, 0.2);
      transform: rotate(45deg);
      transition: all 0.5s;
      pointer-events: none;
      opacity: 0;
    }
    
    .btn-celebrate:hover::after {
      left: 100%;
      opacity: 1;
    }
    
    .signature {
      font-family: 'Dancing Script', cursive;
      font-size: 1.8rem;
      color: var(--primary);
    }
  </style>
  <script>
        window.env = {
            NOTIFICATION_ACCESS: "<?php echo $userInfo['notification_access']; ?>",
            VAPID_PUBLIC_KEY: "<?php echo VAPID_PUBLIC_KEY ?>",
            ENDPOINT: "<?php echo $rootUrl ?>"
        };
    </script>
</head>
<body>

<!-- Dynamic Confetti -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const colors = ['#6c63ff', '#ff6584', '#4bb543', '#ffc107', '#20c997'];
    
    for(let i = 0; i < 150; i++) {
      let confetti = document.createElement("div");
      confetti.classList.add("confetti");
      confetti.style.left = Math.random() * 100 + "vw";
      confetti.style.animationDuration = (Math.random() * 3 + 2) + "s";
      confetti.style.animationDelay = (Math.random() * 5) + "s";
      confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
      confetti.style.width = (Math.random() * 10 + 8) + "px";
      confetti.style.height = (Math.random() * 10 + 8) + "px";
      confetti.style.borderRadius = Math.random() > 0.5 ? "50%" : "0";
      document.body.appendChild(confetti);
    }
  });
</script>

<!-- Main Content -->
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="p-4 p-md-5 animate__animated animate__fadeIn">
      
        <div class="text-center">
          <!-- Trophy Icon with Animation -->
          <div class="trophy-icon animate__animated animate__bounceIn">
            <i class="fas fa-trophy"></i>
          </div>
          
          <!-- Title -->
          <h1 class="congrats-title animate__animated animate__fadeInDown">
            Congratulations <span class="text-dark">[Username]!</span>
          </h1>
          
          <!-- Reward Badge -->
          <div class="reward-badge animate__animated animate__zoomIn animate__delay-1s">
            <i class="fas fa-medal me-2"></i> $<?php echo $reward ?> Reward Earned!
          </div>
        </div>
        
        <!-- Progress Arrow -->
        <div class="text-center my-4 animate__animated animate__fadeIn animate__delay-1s">
          <i class="fas fa-arrow-down text-primary fa-2x"></i>
        </div>
        
        <!-- Stage Promotion Card -->
        <div class="stage-card animate__animated animate__fadeInUp animate__delay-1s">
          <h5 class="text-primary mb-3"><i class="fas fa-level-up-alt me-2"></i> Stage Promotion!</h5>
          <p class="mb-0">
            You've successfully completed <strong>Stage <?php echo $currentStage ?></strong> and are now being promoted to <strong>Stage <?php echo $currentStage + 1 ?></strong> with greater opportunities!
          </p>
        </div>
        
        <!-- Message -->
        <div class="text-center mt-4 animate__animated animate__fadeIn animate__delay-2s">
          <p class="lead">
            Your dedication and teamwork have brought you this achievement. 
            This is just the beginning of your journey to greater rewards and impact!
          </p>
          
          <p class="fw-light">
            Keep the momentum going, stay focused, and continue inspiring others in our network.
          </p>
          
          <p class="mt-4">
            <span class="signature animate__animated animate__fadeIn animate__delay-3s">— The GlobalSingleLine Team</span>
          </p>
        </div>
        
        <!-- CTA Button -->
        <div class="text-center mt-5 animate__animated animate__zoomIn animate__delay-3s">
          <a href="/dashboard" class="btn btn-celebrate btn-lg">
            <i class="fas fa-rocket me-2"></i> Continue to Dashboard
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/pages/dashboard-default.js"></script>
  <!-- [Page Specific JS] end -->
  <!-- Required Js -->
  <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/popper.min.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/simplebar.min.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/bootstrap.min.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/fonts/custom-font.js"></script>


  <script src="<?php echo $rootUrl ?>/public/assets/js/pcoded.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/feather.min.js"></script>

  <script src="https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-window.prod.mjs" type="module"></script>
  <script src="sw.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/app.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/workboxreg.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
</body>
</html>
