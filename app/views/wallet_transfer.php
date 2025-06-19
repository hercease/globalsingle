<html><!-- [Head] start -->
<head>
    <title>Wallet Transfer | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Wallet Transfer | GlobalSingleLine">
    <meta name="description" content="Generating Success For Life">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Wallet Transfer | GlobalSingleLine">
    <meta property="og:description" content="Generating Success For Life">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo_new.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/wallet_transfer">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Wallet Transfer | GlobalSingleLine">
    <meta name="twitter:description" content="Generating Success For Life">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo_new.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/wallet_transfer">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/wallet_transfer">
    <link rel="manifest" href="manifest.json">

    <!-- [Favicon] icon -->
    <link rel="icon" href="<?php echo $rootUrl ?>/public/assets/images/favicon.png" type="image/x-icon"> <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&amp;display=swap" id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/tabler-icons.min.css">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/feather.css">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/fontawesome.css">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/fonts/material.css">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/css/style.css" id="main-style-link">
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/css/style-preset.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.28.1/tabler-icons.min.css" integrity="sha512-UuL1Le1IzormILxFr3ki91VGuPYjsKQkRFUvSrEuwdVCvYt6a1X73cJ8sWb/1E726+rfDRexUn528XRdqrSAOw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        body {
            background: #deebf1;
            background-size: cover;
            background-blend-mode: overlay;
            background-image: url('public/assets/images/background.png'); /* Replace with your image path */
            background-repeat: no-repeat; /* Prevents the image from repeating */
            background-position: center center; /* Centers the image */
        }
        
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

        @media (max-width: 576px) { /* Small devices */
            .card-custom-padding {
                padding: 6px 0px 0px 11px !important;
                border-left: solid;
            }
        }

        form .error {
            color: #ff0000;
        }

        .update-toast {
          z-index: 10000;
          max-width: 300px;
        }

         /* Custom tab styling */
         .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }
        
        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
            position: relative;
            transition: all 0.3s ease;
            border-top-left-radius: 0px !important;
            border-top-right-radius: 0px !important;
        }
        
        .nav-tabs .nav-link:hover {
            color:rgb(231, 235, 240);
            background-color: rgba(13, 110, 253, 0.05);
        }
        
        .nav-tabs .nav-link.active {
            color: white;
            background-color: #0a3a66;
            border: none;
            box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2);
        }
        
        /* Sliding underline animation */
        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color:rgb(144, 173, 218);
            transform-origin: left;
            animation: slideIn 0.3s ease-out forwards;
        }
        
        @keyframes slideIn {
            from { transform: scaleX(0); }
            to { transform: scaleX(1); }
        }
        
        /* Tab content animation */
        .tab-pane {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.4s ease;
        }

        .tab-pane.active {
            position: relative;
            opacity: 1;
            transform: translateX(0);
        }
        
        /* Container styling */
        .tab-container {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .tab-content {
            position: relative;
            overflow: hidden;
            min-height: 200px;
        }
        
        
        .tab-content {
            padding: 20px;
            background: white;
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
            NOTIFICATION_ACCESS: "<?php echo $userInfo['notification_access']; ?>",
            VAPID_PUBLIC_KEY: "<?php echo VAPID_PUBLIC_KEY ?>",
            ENDPOINT: "<?php echo $rootUrl ?>"
        };
    </script>

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

        <div class="loader-container">
            <div class="loader-wrapper">
                <div class="rotating-circle"></div>
                <img src="public/assets/images/favicon.png" alt="Logo" class="logo">
            </div>
            <div class="loading-text"></div>
        </div>

<body data-pc-theme="light" data-pc-direction="ltr" data-pc-preset="preset-1" style="font-family:Public Sans, sans-serif">
  <!-- [ Pre-loader ] start -->

<!-- [ Pre-loader ] End -->
 <!-- [ Sidebar Menu ] start -->
<!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
<!-- [ Sidebar Menu ] start -->
    <?php include("includes/sidebar.php"); ?>
    <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
    <?php include("includes/header.php"); ?>

  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">Users</a></li>
                <li class="breadcrumb-item" aria-current="page">Wallet Transfer</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Wallet Transfer</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->

        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-5 col-xl-5">
            <div class="tab-container d-flex flex-column align-items-center w-100">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs w-100 d-flex" id="myTab" role="tablist">
                    <li class="nav-item col-6  p-0" role="presentation">
                        <button class="nav-link active w-100" id="home-tab" data-bs-toggle="tab" 
                                data-bs-target="#home" type="button" role="tab" 
                                aria-controls="home" aria-selected="true">
                                <i class="fa fa-wallet"></i> Inter Transfer
                        </button>
                    </li>
                    <?php if($userInfo['vendor_access'] > 0){ ?>
                        <li class="nav-item col-6 p-0" role="presentation">
                            <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" 
                                    data-bs-target="#profile" type="button" role="tab" 
                                    aria-controls="profile" aria-selected="false">
                                    <i class="fa fa-wallet"></i> Intra Transfer
                            </button>
                        </li>
                    <?php } ?>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content p-4 border border-top-0 rounded-bottom" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h3>External Transfer</h3>
                        <div class="alert alert-primary"><i class="ti ti-info-circle"></i>
                        Enjoy FREE Wallet Transfer To Other Members And Receive Payment In Your Local Currency.</div>
                        <form name="inter_transfer">
                            <div class="form-group mb-3">
                                <label class="form-label">Receiver Username</label>
                                <input type="text" required name="receiver" class="form-control" placeholder="Receiver Username">
                            </div>
                          
                            <div class="form-group mb-3">
                                <label class="form-label">Select Wallet</label>
                                <select class="form-select" required name="wallet">
                                    <option value="">Select Wallet</option>
                                    <option value="earning">Earning Wallet - $<?php echo number_format($userInfo['earning_wallet'], 2) ?></option>
                                    <option value="registration">Registration Wallet - $<?php echo number_format($userInfo['reg_wallet'], 2) ?></option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Amount</label>
                                <input type="number" name="amount" required class="form-control" placeholder="Transfer amount">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Wallet Password</label>
                                <input type="password" required name="wallet_password" class="form-control" placeholder="Wallet Password">
                            </div>

                            <button class="btn btn-secondary btn-shadow w-100" name="submit" type="submit">Continue</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3>Internal Transfer</h3>
                        <div class="alert alert-primary"><i class="ti ti-info-circle"></i>
                        Transfer funds between your wallets, Kindly note that funds transferred from here drops into your registration wallet</div>
                        <form name="intra_transfer">
                            <div class="form-group mb-3">
                                <label class="form-label">Vendor Wallet Balance ($)</label>
                                <input type="text" readonly name="balance" class="form-control" value="<?php echo number_format($userInfo['vendor_wallet']) ?>" />
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Wallet Pieces</label>
                                <input type="number" required name="wallet_pieces" class="form-control" placeholder="Enter total wallets to transfer">
                                <small>Note : 1 wallet = $9</small>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Wallet Password</label>
                                <input type="password" required name="wallet_password" class="form-control" placeholder="Wallet Password">
                            </div>

                            <button class="btn btn-secondary btn-shadow w-100" name="submit" type="submit">Continue</button>
                        </form>

                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <h3>Contact Us</h3>
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Message</label>
                                <textarea class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
     
      <!-- [ Main Content ] end -->
    </div>
  </div>

  <a href="https://t.me/+rkqEln_UiqphMDM0" class="support-icon">
        <span><i class="fab fa-telegram"></i></span> <!-- Or use an icon (e.g., Font Awesome) -->
      </a>

  <!-- [ Main Content ] end -->
  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
        <div class="col-sm my-1">
          <p class="m-0">Crafted By:  <a href="#" >GSL TEAM</a></p>
        </div>
      </div>
    </div>
  </footer> <!-- Required Js -->

<script src="<?php echo $rootUrl ?>/public/assets/js/plugins/jquery.js"></script>
<script src="<?php echo $rootUrl ?>/public/assets/js/plugins/popper.min.js"></script>
<script src="<?php echo $rootUrl ?>/public/assets/js/plugins/simplebar.min.js"></script>
<script src="<?php echo $rootUrl ?>/public/assets/js/plugins/bootstrap.min.js"></script>
<script src="<?php echo $rootUrl ?>/public/assets/js/fonts/custom-font.js"></script>
<script src="<?php echo $rootUrl ?>/public/assets/js/plugins/jquery-validate.js"></script>
<script src="<?php echo $rootUrl ?>/public/assets/js/pcoded.js"></script>
<script src="<?php echo $rootUrl ?>/public/assets/js/plugins/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
<!--<script src="https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-window.prod.mjs" type="module"></script>-->
<script src="https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-window.prod.umd.js"></script>
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

    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    console.log("User's Timezone: " + timezone);

            $("form[name='inter_transfer']").validate({
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
                submitHandler: function(form){
                    
                    var data = $("form[name='inter_transfer']").serialize();
                    data += '&timezone=' + encodeURIComponent(timezone);
                    console.log(data);
                    iziToast.question({
                        timeout: 20000,
                        close: false,
                        overlay: true,
                        displayMode: 'once',
                        id: 'question',
                        title: 'Confirmation',
                        message: 'Are you sure you want to continue?',
                        position: 'center',
                        buttons: [
                            ['<button><b>Yes</b></button>', function (instance, toast) {
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                
                                console.log("Yes clicked");
                                var spinner = document.querySelector(".loader-container");
                                var loadingText = document.querySelector(".loading-text");
                                // Run your AJAX function here
                                $.ajax({
                                    type : 'POST',
                                    url : 'processwallettransfer',
                                    data : data,
                                    beforeSend: function(){
                                        spinner.style.display = "flex";
                                        loadingText.textContent = "Processing, Please wait....";
                                    },
                                    success : function(response){

                                        console.log(response);
                                        spinner.style.display = "none";
                                        loadingText.textContent = "Loading...";
                                        
                                        try {
                                            const res = JSON.parse(response); // Parse JSON response
                                            switch (res.status) {
                                                case true: // Success
                                                    iziToast.success({
                                                        title: 'Success',
                                                        message: res.message,
                                                    });
                                                    break;
                                                case false: // Error
                                                    iziToast.error({
                                                        title: 'Error',
                                                        message: res.message,
                                                    });
                                                    break;
                                                default: // Unknown response
                                                    iziToast.error({
                                                        title: 'Error',
                                                        message: "Unexpected response: " + res.message,
                                                    });
                                            }
                                        } catch (e) {
                                            iziToast.error({
                                                title: 'Error',
                                                message: 'Invalid response from server.',
                                            });
                                            console.error("Response parsing error:", e);
                                        }
                                    },
                                    error: function(xhr, status, error){
                                        // Handle error
                                        console.error(error);
                                        spinner.style.display = "none";
                                        loadingText.textContent = "Loading...";
                                        
                                        iziToast.error({
                                            title: 'Error',
                                            message: error,
                                        });
                                    }
                                });

                            }, true],
                            ['<button>No</button>', function (instance, toast) {
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            }]
                        ],
                        onClosing: function(instance, toast, closedBy){
                            console.info('Closing | closedBy: ' + closedBy);
                        },
                        onClosed: function(instance, toast, closedBy){
                            console.info('Closed | closedBy: ' + closedBy);
                        }
                    });
                },
        });

        $("form[name='intra_transfer']").validate({
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
                submitHandler: function(form){
                    
                    var data = $("form[name='intra_transfer']").serialize();
                    data += '&timezone=' + encodeURIComponent(timezone);
                    
                    iziToast.question({
                        timeout: 20000,
                        close: false,
                        overlay: true,
                        displayMode: 'once',
                        id: 'question',
                        title: 'Confirmation',
                        message: 'Are you sure you want to continue?',
                        position: 'center',
                        buttons: [
                            ['<button><b>Yes</b></button>', function (instance, toast) {
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                
                                console.log("Yes clicked");
                                var spinner = document.querySelector(".loader-container");
                                var loadingText = document.querySelector(".loading-text");
                                // Run your AJAX function here
                                $.ajax({
                                    type : 'POST',
                                    url : 'processintratransfer',
                                    data : data,
                                    beforeSend: function(){
                                        spinner.style.display = "flex";
                                        loadingText.textContent = "Processing, Please wait....";
                                    },
                                    success : function(response){

                                        console.log(response);
                                        spinner.style.display = "none";
                                        loadingText.textContent = "Loading...";
                                        
                                        try {
                                            const res = JSON.parse(response); // Parse JSON response
                                            switch (res.status) {
                                                case true: // Success
                                                    iziToast.success({
                                                        title: 'Success',
                                                        message: res.message,
                                                    });
                                                    break;
                                                case false: // Error
                                                    iziToast.error({
                                                        title: 'Error',
                                                        message: res.message,
                                                    });
                                                    break;
                                                default: // Unknown response
                                                    iziToast.error({
                                                        title: 'Error',
                                                        message: "Unexpected response: " + res.message,
                                                    });
                                            }
                                        } catch (e) {
                                            iziToast.error({
                                                title: 'Error',
                                                message: 'Invalid response from server.',
                                            });
                                            console.error("Response parsing error:", e);
                                        }
                                    },
                                    error: function(xhr, status, error){
                                        // Handle error
                                        console.error(error);
                                        spinner.style.display = "none";
                                        loadingText.textContent = "Loading...";
                                        
                                        iziToast.error({
                                            title: 'Error',
                                            message: error,
                                        });
                                    }
                                });

                            }, true],
                            ['<button>No</button>', function (instance, toast) {
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                            }]
                        ],
                        onClosing: function(instance, toast, closedBy){
                            console.info('Closing | closedBy: ' + closedBy);
                        },
                        onClosed: function(instance, toast, closedBy){
                            console.info('Closed | closedBy: ' + closedBy);
                        }
                    });
                },
            });
</script>
    
</body>
</html>