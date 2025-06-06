<html><!-- [Head] start -->
<head>
    <title>Account Profile | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Account Profile | GlobalSingleLine">
    <meta name="description" content="Generating Success For Life">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Account Profile | GlobalSingleLine">
    <meta property="og:description" content="Generating Success For Life">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo_new.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/account_profile">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Account Profile | GlobalSingleLine">
    <meta name="twitter:description" content="Generating Success For Life">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo_new.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/account_profile">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/account_profile">
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

        /* Rotating Circle */
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
    <?php include("includes/sidebar.php"); ?>
    <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
    <?php include("includes/header.php"); ?>
    <!-- [ Header ] end -->



  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">Users</a></li>
                <li class="breadcrumb-item" aria-current="page">Account Profile</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Account Profile</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-md-12 col-xl-10 mx-auto">
          <div class="card">
            <div class="card-header pb-0">
              <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="nav-link active" id="profile-tab-1" data-bs-toggle="tab" href="#profile-1" role="tab" aria-selected="true">
                    <i class="ti ti-user me-2"></i>Profile
                  </a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="profile-tab-4" data-bs-toggle="tab" href="#profile-4" role="tab" aria-selected="false" tabindex="-1">
                    <i class="ti ti-lock me-2"></i>Change Password
                  </a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="nav-link" id="profile-tab-6" data-bs-toggle="tab" href="#profile-6" role="tab" aria-selected="false" tabindex="-1">
                    <i class="ti ti-settings me-2"></i>Settings
                  </a>
                </li>
              </ul>
            </div>
           
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active show" id="profile-1" role="tabpanel" aria-labelledby="profile-tab-1">
                  <div class="row">
                    <div class="col-lg-4 col-xxl-3">
                      <div class="card">
                        <div class="card-body position-relative">
                          <div class="position-absolute end-0 top-0 p-3">
                            <span class="badge bg-warning">Stage 1</span>
                          </div>
                          <div class="text-center mt-3">
                            <div class="chat-avtar d-inline-flex mx-auto">
                              <img class="rounded-circle img-fluid wid-70" src="<?php echo $rootUrl ?>/public/assets/images/user/<?php echo $userInfo['avatar'] ?>" alt="User image">
                            </div>
                            
                            <hr class="my-3">
                            <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                              <i class="ti ti-mail"></i>
                              <p class="mb-0"><?php echo $userInfo['email'] ?></p>
                            </div>
                            <div class="d-inline-flex align-items-center justify-content-between w-100 mb-3">
                              <i class="ti ti-map-pin"></i>
                              <p class="mb-0"><?php echo $userInfo['country'] ?></p>
                            </div>
                            <div class="d-inline-flex align-items-center justify-content-between w-100">
                              <i class="ti ti-link"></i>
                              <a href="#" class="link-primary">
                                <p class="mb-0"><?php echo $rootUrl ?>/register?referral=<?php echo $userInfo['username'] ?></p>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-8 col-xxl-9">
                      <div class="card">
                        <div class="card-header">
                          <h5>Account Details</h5>
                        </div>
                        <div class="card-body">
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 pt-0">
                              <div class="row">
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Username</p>
                                  <p class="mb-0"><?php echo $userInfo['username'] ?></p>
                                </div>
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Email</p>
                                  <p class="mb-0"><?php echo $userInfo['email'] ?></p>
                                </div>
                              </div>
                            </li>
                            <li class="list-group-item px-0">
                              <div class="row">
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Sponsor</p>
                                  <p class="mb-0"><?php echo $fetchSponsor['sponsor'] ?? ""; ?></p>
                                </div>
                                <div class="col-md-6">
                                  <p class="mb-1 text-muted">Country</p>
                                  <p class="mb-0"><?php echo $userInfo['country'] ?></p>
                                </div>
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                  <div class="card">
                    <div class="card-header">
                      <h5>Change Password</h5>
                    </div>
                    <form name="change_password">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Old Password</label>
                                <input class="form-control" id="old_password" required name="old_password" type="password" placeholder="Enter old password" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <input class="form-control" id="new_password" required name="new_password" type="password" placeholder="Enter new password" />
                            </div>
                            <div class="form-group">
                                <label class="form-label">Confirm Password</label>
                                <input class="form-control" id="repeat_password" required name="repeat_password" type="password" placeholder="Confirm New password" />
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="card-footer text-end btn-page">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                  </div>
                </div>
                <div class="tab-pane" id="profile-6" role="tabpanel" aria-labelledby="profile-tab-6">
                  <div class="row">
                    <!--<div class="col-md-6">
                      <div class="card">
                        <div class="card-header">
                          <h5>Withdrawal Settings</h5>
                        </div>
                        <div class="card-body">
                        <form name="update_wallet">
                          <div class="form-group">
                            <label class="form-label">Wallet Address(USDT TRC20)</label>
                            <input type="text" value="<?php echo $userInfo['wallet_address'] ?? '' ?>" name="wallet_address" required placeholder="Enter your USDT TRC20 Address" class="form-control">
                          </div>
                          <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                        </div>
                      </div>
                    </div>-->

                    <!--<div class="col-md-6">
                      <div class="card">
                        <div class="card-header">
                          <h5>Notification Settings</h5>
                        </div>
                        <div class="card-body">
                          <h6 class="mb-4">Setup Email Notification</h6>
                          <div class="d-flex align-items-center justify-content-between mb-1">
                            <div>
                              <p class="text-muted mb-0">Notification</p>
                            </div>
                            <div class="form-check form-switch p-0">
                              <input class="m-0 form-check-input h5 position-relative notify_access" data-id="<?php echo $userInfo['id']; ?>" type="checkbox" role="switch" <?php if($userInfo['notification_access'] === 1){ echo "checked"; }else{ echo ""; } ?> />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>-->

                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-header">
                          <h5>Set Wallet Password</h5>
                        </div>
                        <div class="card-body">
                            <form name="update_wallet_password">
                                <div class="form-group">
                                    <label class="form-label">Enter Password</label>
                                    <input type="password" name="password" required placeholder="Enter password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Repeat Password</label>
                                    <input type="password" name="repeat_password" required placeholder="Repeat password" class="form-control">
                                </div>
                                
                                <label class="form-label">Authentication Code</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="textInput" name="code" class="form-control" placeholder="Authentication code">
                                    <button class="btn bg-orange-500" id="send_code" type="button">Send Code</button>
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit">Continue</button>
                            </form>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- [ sample-page ] end -->
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
<script src="https://storage.googleapis.com/workbox-cdn/releases/6.6.0/workbox-window.prod.mjs"></script>
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

    $(function(){

        $("form[name='change_password']").validate({
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
                submitHandler: function(form){
                    
                    var data = $("form[name='change_password']").serialize();
                    
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
                                // Run your AJAX function here
                                $.ajax({
                                    type : 'POST',
                                    url : 'processChangePassword',
                                    data : data,
                                    beforeSend: function(){
                                        spinner.style.display = "flex";
                                    },
                                    success : function(response){
                                        console.log(response);
                                        spinner.style.display = "none";
                                        
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

            $("form[name='update_wallet']").validate({
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
                submitHandler: function(form){
                    
                    var data = $("form[name='update_wallet']").serialize();
                    
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
                                // Run your AJAX function here
                                $.ajax({
                                    type : 'POST',
                                    url : 'updateWalletAddress',
                                    data : data,
                                    beforeSend: function(){
                                        spinner.style.display = "flex";
                                    },
                                    success : function(response){
                                        console.log(response);
                                        spinner.style.display = "none";
                                        
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

                $('#send_code').on('click', function () {
                    // Save the button element for use in callbacks
                    const $button = $(this);
                    // Disable the button and show a spinner

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
                                $button.prop("disabled", true).html('<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i> Processing...');
                                // Run your AJAX function here
                                $.ajax({
                                    url: 'sendAuthenticationCode', // Replace with your backend endpoint
                                    type: 'POST', // or 'GET' depending on your API
                                    dataType: 'json',
                                    timeout: 10000, // 5 seconds timeout
                                    success: function (data) {
                                        // Re-enable the button and reset text
                                        $button.prop("disabled", false).html('Send Code');

                                        if (data.status === true) {

                                            iziToast.success({ title: 'Success', message: data.message });

                                        } else {
                                            // Enable the submit button and populate the results container
                                            iziToast.error({ title: 'Error', message: data.message });
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        // Re-enable the button and handle errors
                                        $button.prop("disabled", false).html('Send Code');

                                        if (xhr.status === 0) {
                                            iziToast.error({
                                                title: 'Network Error',
                                                message: 'No internet connection. Please check your network.'
                                            });
                                        } else if(status === "timeout") {
                                            iziToast.error({
                                                title: 'Error',
                                                message: 'Oooops, Request timeout, please try again'
                                            });
                                        } else {
                                            iziToast.error({
                                                title: 'Error',
                                                message: 'An error occurred: ' + xhr
                                            });
                                        }
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

            // Perform AJAX request
           
        });

        $("form[name='update_wallet_password']").validate({
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
                submitHandler: function(form){
                    
                    var data = $("form[name='update_wallet_password']").serialize();
                    
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
                                // Run your AJAX function here
                                $.ajax({
                                    type : 'POST',
                                    url : 'updateWalletPassword',
                                    data : data,
                                    beforeSend: function(){
                                        spinner.style.display = "flex";
                                    },
                                    success : function(response){
                                        console.log(response);
                                        spinner.style.display = "none";
                                        
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

            $(document).on("click", ".notify_access", function(e){
                e.preventDefault();
                var id = $(this).data('id');
                var isChecked = $(this).prop('checked');
                console.log(isChecked);
                //var heck = $(this).prop('checked', false);
                var msg = (isChecked==true) ? "Are you sure you want to enable notification ?" : "Are you sure you want to disable notification ?";
                
                iziToast.question({
                        timeout: 20000,
                        close: false,
                        overlay: true,
                        displayMode: 'once',
                        id: 'question',
                        title: 'Confirmation',
                        message: msg,
                        position: 'center',
                        buttons: [
                            ['<button><b>Yes</b></button>', function (instance, toast) {
                              
                                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                                
                                console.log("Yes clicked");
                                var spinner = document.querySelector(".loader-container");
                                // Run your AJAX function here
                                $.ajax({
                                    type : 'POST',
                                    url : 'updatenotification',
                                    data : { id : id, checked : isChecked },
                                    beforeSend: function(){

                                        spinner.style.display = "flex";

                                    },
                                    success : function(response){

                                        console.log(response);
                                        spinner.style.display = "none";
                                        
                                        try {
                                            const res = JSON.parse(response); // Parse JSON response
                                            switch (res.status) {
                                                case true: // Success

                                                    iziToast.success({
                                                        title: 'Success',
                                                        message: res.message,
                                                    });

                                                    $('input[type="checkbox"][data-id="'+id+'"]').prop('checked', true);

                                                    break;
                                                case false: // Error

                                                    iziToast.error({
                                                        title: 'Error',
                                                        message: res.message,
                                                    });

                                                    $('input[type="checkbox"][data-id="'+id+'"]').prop('checked', false);

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
                
              });
        

    });

    
</script>

</body>
</html>