<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->
<head>
    <title>Login | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Login | GlobalSingleLine">
    <meta name="description" content="Generating Success For Life">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Login | GlobalSingleLine">
    <meta property="og:description" content="Generating Success For Life">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/login">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Login | GlobalSingleLine">
    <meta name="twitter:description" content="Generating Success For Life">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/login">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/login">
    <link rel="manifest" href="manifest.json">

    <!-- [Favicon] icon -->
    <link rel="icon" href="<?php echo $rootUrl ?>/public/assets/images/favicon.png" type="image/x-icon"> <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/tabler-icons.min.css" >
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/feather.css" >
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/fontawesome.css" >
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/material.css" >
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/css/style.css" id="main-style-link" >
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/css/style-preset.css" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <style>

body {
            background: #deebf1;
            background-size: cover;
            background-blend-mode: overlay;
            background-image: url('public/assets/images/background.png'); /* Replace with your image path */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            background-position: center center; /* Centers the image */
        }

        .auth-wrapper.v3 {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .form-control:focus {
            background-color: white;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(1, 54, 88, 0.25);
        }

        /* Keep your existing styles below */
        :root {
            --primary-color: #013658;
            --dark-color: #2f2e41;
            --light-color: #f8f9fa;
        }
        


        form .error {
            color: #ff0000;
        }
        
       /* Centering the loader */
        /* Centering the loader */
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

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 9px 25px;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #0c6ba8;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.3);
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

            .support-icon {
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
                background-color: #3498db; /* Adjust color */
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                font-size: 24px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
                z-index: 9999;
                transition: transform 0.3s, background-color 0.3s;
                }

                .support-icon:hover {
                transform: scale(1.1);
                background-color: #2980b9; /* Darker shade on hover */
                }

                /* Optional: Animation */
                @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.1); }
                100% { transform: scale(1); }
                }
                .support-icon {
                animation: pulse 2s infinite;
                }
        

    </style>
    <script>
        window.env = {
            NOTIFICATION_ACCESS: "<?php echo $userInfo['notification_access'] ?? 1; ?>",
            VAPID_PUBLIC_KEY: "<?php echo VAPID_PUBLIC_KEY ?>",
            ENDPOINT: "<?php echo $rootUrl ?>"
        };
    </script>
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body>
  <!-- [ Pre-loader ] start -->
    
        <div class="loader-container">
            <div class="loader-wrapper">
                <div class="rotating-circle"></div>
                <img src="public/assets/images/favicon.png" alt="Logo" class="logo">
            </div>
            <div class="loading-text"></div>
        </div>

  <!-- [ Pre-loader ] End -->

  <div class="auth-main">
    <div class="auth-wrapper v3">
      <div class="auth-form">
        <div class="auth-header">
          <a href="#"><img width="70" src="<?php echo $rootUrl ?>/public/assets/images/logo_new.png" alt="img" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2))"></a>
        </div>
        <div class="card my-5" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(8px);">
        <form name="login">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-end mb-4">
              <h3 class="mb-0"><i class="fas fa-sign-in-alt"></i> <b>Login</b></h3>
              <a href="register" class="link-dark">Don't have an account?</a>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" required class="form-control" placeholder="Enter your Username">
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" required class="form-control" placeholder="Enter your Password">
            </div>
            <div class="d-flex mt-1 justify-content-between">
              <div class="form-check">
                <input class="form-check-input input-dark" type="checkbox" id="customCheckc1" checked="">
                <label class="form-check-label text-muted" for="customCheckc1">Keep me sign in</label>
              </div>
              <h6 class="f-w-400"><a class="text-dark" href="forgot_password">Forgot Password?</a></h6>
            </div>
            <div class="d-grid mt-4">
              <button type="submit" id="submit" class="btn btn-primary">Login</button>
            </div>
          </div>
        </form>
        </div>

        

        <div class="auth-footer row">
          <!-- <div class=""> -->
            <div class="col my-1">
              <p class="m-0">Crafted By:  <a href="#" >GSL TEAM</a></p>
            </div>
            <div class="col-auto my-1">
              <ul class="list-inline footer-link mb-0">
                <li class="list-inline-item"><a href="#">Home</a></li>
                <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                <li class="list-inline-item"><a href="#">Contact us</a></li>
              </ul>
            </div>
          <!-- </div> -->
        </div>
      </div>
    </div>
  </div>

  <a href="support" class="support-icon">
          <span><i class="fas fa-headset"></i></span> <!-- Or use an icon (e.g., Font Awesome) -->
        </a>
  <!-- [ Main Content ] end -->
  <!-- Required Js -->
  <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/jquery.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/popper.min.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/simplebar.min.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/bootstrap.min.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/fonts/custom-font.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/pcoded.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/feather.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
  <script type="text/javascript" src="<?php echo $rootUrl ?>/public/assets/js/plugins/jquery-validate.js"></script>
  <script src="https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-window.prod.mjs" type="module"></script>
  <script src="sw.js"></script>
  <script src="<?php echo $rootUrl ?>/public/assets/js/app.js"></script>
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

        $("form[name='login']").validate({
            // Specify validation rules
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function(form){
                
            var data = $("form[name='login']").serialize();
            var spinner = document.querySelector(".loader-container");
            var loadingText = document.querySelector(".loading-text");

            console.log(data);

            $.ajax({
                type: "POST",
                url: "processLogin",
                data: data,
                beforeSend: function () {
                    $('#submit').attr("disabled", true);
                    spinner.style.display = 'flex';
                    loadingText.textContent = "Please wait, processing...";
                },
                dataType: 'json',
                success: function(data) {

                $('#submit').attr("disabled", false);
                spinner.style.display = "none";
                loadingText.textContent = "Loading...";
                
                console.log(data);
                if (data.status===true) {

                    iziToast.success({
                        title: 'Success',
                        message: data.message,
                    });

                    setTimeout(() => {
                        window.location.href = "dashboard";
                    }, 5000);
                
                } else {
                    iziToast.warning({
                        title: 'Error',
                        message: data.message,
                    });
                }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#submit').attr("disabled", false);
                    loadingText.textContent = "Loading...";
                    spinner.style.display = 'none';
                    iziToast.warning({
                        title: 'Error',
                        message: 'An error occurred, kindly check your network',
                    });
                }
            }); 

                
            
            }
        });

</script>

  
</body>

</html>