<html><!-- [Head] start -->
<head>
    <title>Fund Withdrawal | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Fund Withdrawal | GlobalSingleLine">
    <meta name="description" content="Generating Success For Life">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Fund Withdrawal | GlobalSingleLine">
    <meta property="og:description" content="Generating Success For Life">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/withdrawal">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Fund Withdrawal | GlobalSingleLine">
    <meta name="twitter:description" content="Generating Success For Life">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/withdrawal">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/withdrawal">
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
                <li class="breadcrumb-item" aria-current="page">Withdraw Fund</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Fund Withdrawal</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ sample-page ] start -->
         <div class="col-md-12 col-xl-6 mx-auto">
            <div class="card">
                <div style="padding: 16px;" class="card-header bg-blue-800 text-white rounded-3">
                <i class="ti ti-arrow-bar-to-down"></i> Fund Withdrawal
                </div>
                <div class="card-body">
                  <div class="alert alert-secondary"><i class="ti ti-info-circle"></i>
                  Withdraw fund to your wallet address, ensure you filled in the correct wallet USDT BEP20 address as we will not be liable for any loss that arises from this. <br> Kindly note that $1 transfer fee will be deducted from your wallet.</div>
                  <form name="wallet_withdrawal">
                    
                    <div class="form-group mb-3">
                        <label class="form-label">Earning Wallet Balance</label>
                        <input type="text" name="amount" disabled class="form-control" value="$<?php echo number_format($userInfo['earning_wallet'],2) ?>" />
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Enter to withdraw</label>
                        <input type="number" name="amount" required class="form-control" placeholder="Enter amount to withdraw" />
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">USDT BEP20 Address</label>
                        <input type="text" name="address" required class="form-control" placeholder="USDT BEP20 wallet address" />
                    </div>

                    <label class="form-label">Authentication Code</label>
                    <div class="input-group mb-3">
                        <input type="text" id="textInput" name="code" class="form-control" placeholder="Authentication code">
                        <button class="btn btn-secondary" id="send_code" type="button">Send Code</button>
                    </div>

                    <button class="btn btn-secondary btn-shadow w-100" name="submit" type="submit">Continue</button>
                </div>
            </div>
         </div>
        <div 

      </div>
      <!-- [ Main Content ] end -->
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <a href="support" class="support-icon">
      <span><i class="fas fa-headset"></i></span> <!-- Or use an icon (e.g., Font Awesome) -->
  </a>

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

    $('#send_code').on('click', function () {
        const $button = $(this);

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
                [
                    '<button><b>Yes</b></button>',
                    function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        
                        console.log("Yes clicked");

                        $button.prop("disabled", true).html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i> Processing...');

                        $.ajax({
                            url: 'sendAuthenticationCode', // Replace with actual endpoint
                            type: 'POST',
                            dataType: 'json',
                            timeout: 10000, // 10 seconds
                            success: function (data) {
                                $button.prop("disabled", false).html('Send Code');

                                if (data.status === true) {
                                    iziToast.success({ title: 'Success', message: data.message });
                                } else {
                                    iziToast.error({ title: 'Error', message: data.message });
                                }
                            },
                            error: function (xhr, status, error) {
                                $button.prop("disabled", false).html('Send Code');

                                if (xhr.status === 0) {
                                    iziToast.error({
                                        title: 'Network Error',
                                        message: 'No internet connection. Please check your network.'
                                    });
                                } else if (status === "timeout") {
                                    iziToast.error({
                                        title: 'Error',
                                        message: 'Request timeout. Please try again.'
                                    });
                                } else {
                                    iziToast.error({
                                        title: 'Error',
                                        message: 'An error occurred: ' + error
                                    });
                                }
                            }
                        });
                    },
                    true
                ],
                [
                    '<button>No</button>',
                    function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }
                ]
            ],
            onClosing: function (instance, toast, closedBy) {
                console.info('Closing | closedBy: ' + closedBy);
            },
            onClosed: function (instance, toast, closedBy) {
                console.info('Closed | closedBy: ' + closedBy);
            }
        });
    });


  $("form[name='wallet_withdrawal']").validate({
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
                submitHandler: function(form){
                    
                    var data = $("form[name='wallet_withdrawal']").serialize();
                    
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
                                    url : 'processwithdrawal',
                                    data : data,
                                    beforeSend: function(){
                                        spinner.style.display = 'flex';
                                        loadingText.textContent = "Please wait, processing...";
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

                                                    setTimeout(() => {
                                                        window.location.href = 'transaction_history'
                                                    }, 5000);

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
                                        loadingText.textContent = "Loading...";
                                        spinner.style.display = 'none';
                                        
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