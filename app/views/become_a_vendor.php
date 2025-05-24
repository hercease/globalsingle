<html><!-- [Head] start -->
<head>
    <title>Become A Vendor | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Become A Vendor | GlobalSingleLine">
    <meta name="description" content="The platform for Networkers">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Become A Vendor | GlobalSingleLine">
    <meta property="og:description" content="The platform for Networkers">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/allusers">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Become A Vendor | GlobalSingleLine">
    <meta name="twitter:description" content="The platform for Networkers">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/allusers">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/allusers">
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

        .transaction-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .card-header {
            /*background: linear-gradient(135deg, #6c63ff 0%, #4a42d6 100%);*/
            color: white;
            border-bottom: none;
            padding: 1.2rem;
        }
        .transaction-item {
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }
        .transaction-item:hover {
            background-color: #f9f9ff;
            border-left-color: #6c63ff;
            transform: translateX(5px);
        }
        .transaction-credit {
            border-left-color: #28a745;
        }
        .transaction-debit {
            border-left-color: #dc3545;
        }
        .transaction-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .icon-credit {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }
        .icon-debit {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        .badge-pill {
            border-radius: 10px;
            padding: 5px 10px;
            font-weight: 500;
        }
        .search-box {
            border-radius: 20px;
            padding-left: 15px;
            border: 1px solid #e0e0e0;
        }
        .filter-btn {
            border-radius: 20px;
            padding: 5px 15px;
        }

        .update-toast {
          z-index: 10000;
          max-width: 300px;
        }

        .circle-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .benefit-item {
            transition: transform 0.3s ease;
        }
        
        .benefit-item:hover {
            transform: translateX(10px);
        }
        
        #vendorModal .modal-header {
            background: linear-gradient(135deg, #0a3a66 0%, #1a6fd8 100%);
            border-bottom: none;
        }
        
        #vendorForm .form-control {
            border-radius: 8px;
            padding: 10px 15px;
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
    <?php
        // Helper function for status colors
        function getStatusColor($status) {
            switch ($status) {
                case 'approved': return 'success';
                case 'rejected': return 'danger';
                default: return 'primary'; // pending
            }
        }
    ?>

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
                <li class="breadcrumb-item" aria-current="page">Become A Vendor</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Become A Vendor</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
        <div class="container py-5">
      <?php if($checkVendor['count'] > 0){ ?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Application Status Card -->
                <div class="card shadow border-0">
                    <div class="card-header bg-<?php echo getStatusColor($checkVendor['data']['status']); ?> text-white">
                        <h3 class="mb-0 text-white">
                            <i class="fas fa-file-alt me-2"></i>
                            Vendor Application Status
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Status Badge -->
                        <div class="text-center mb-4">
                            <span class="badge bg-<?php echo getStatusColor($checkVendor['data']['status']); ?> py-2 px-3 fs-6">
                                Status: <?php echo strtoupper($checkVendor['data']['status']); ?>
                            </span>
                        </div>

                        <!-- Submitted Data -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <h5><i class="fas fa-id-card me-2"></i> ID Verification</h5>
                                <img src="<?php echo $checkVendor['data']['fileImage']; ?>" class="img-thumbnail mb-3" style="max-height: 200px;">
                                <p class="small text-muted">Uploaded on: <?php echo date('M d, Y', strtotime($checkVendor['data']['date'])); ?></p>
                            </div>
                            
                            <div class="col-12">
                                <h5><i class="fas fa-briefcase me-2"></i> Experience</h5>
                                <div class="bg-light p-3 rounded">
                                    <?php echo nl2br(htmlspecialchars($checkVendor['data']['experience'])); ?>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <h5><i class="fas fa-question-circle me-2"></i> Why applied for Vendor?</h5>
                                <div class="bg-light p-3 rounded">
                                    <?php echo nl2br(htmlspecialchars($checkVendor['data']['reason_why'])); ?>
                                </div>
                            </div>
                            
                            <?php if ($checkVendor['data']['admin_notes']): ?>
                                <div class="col-12">
                                    <h5><i class="fas fa-sticky-note me-2"></i> Admin Notes</h5>
                                    <div class="alert alert-warning">
                                        <?php echo nl2br(htmlspecialchars($checkVendor['data']['admin_notes'])); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Actions -->
                        <div class="text-center mt-4">
                            <?php if ($checkVendor['data']['status'] === 'rejected'): ?>
                                <div class=""alert alert-danger mb-3">Your application was rejected. Kindly come back to reapply in a 7 days time.</div>
                            <?php elseif ($checkVendor['data']['status'] === 'approved'): ?>    
                                <div class="alert alert-success mb-3">Congratulations! Your application has been approved.</div>
                            <?php else: ?>
                                <div class="alert alert-info mb-3">Your application is still under review. Please check back later.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }else{ ?>

            <div class="row justify-content-center">

                <div class="col-lg-12">
                <!-- Vendor Benefits Card -->
                <div class="card shadow-lg mb-5 border-0" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header bg-primary text-white py-2" style="background: linear-gradient(135deg, #0a3a66 0%, #1a6fd8 100%);">
                    <h3 class="mb-0 text-center text-white"><i class="fas fa-crown me-2"></i> BECOME A WORLDWIDE VENDOR</h3>
                    </div>
                    <div class="card-body p-5">
                    <div class="vendor-benefits">
                        <div class="benefit-item d-flex mb-4">
                        <div class="circle-icon bg-success bg-opacity-10 text-success me-4">
                            <i class="fas fa-wallet fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Earn 10% Commission</h5>
                            <p class="text-muted mb-0">On all registration wallet sales globally.</p>
                        </div>
                        </div>
                        
                        <div class="benefit-item d-flex mb-4">
                        <div class="circle-icon bg-info bg-opacity-10 text-info me-4">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">First-Class Training</h5>
                            <p class="text-muted mb-0">Access premium training, latest update and marketing insight.</p>
                        </div>
                        </div>
                        
                        <div class="benefit-item d-flex mb-4">
                        <div class="circle-icon bg-warning bg-opacity-10 text-warning me-4">
                            <i class="fas fa-bullhorn fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Marketing Toolkit</h5>
                            <p class="text-muted mb-0">Receive FREE Professional marketing materials.</p>
                        </div>
                        </div>
                        
                        <div class="benefit-item d-flex">
                        <div class="circle-icon bg-danger bg-opacity-10 text-danger me-4">
                            <i class="fas fa-handshake fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">PROMO Privilege</h5>
                            <p class="text-muted mb-0">You have automatic participation for any PROMOTION Event</p>
                        </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-5">
                        <button class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow" data-bs-toggle="modal" data-bs-target="#vendorModal" style="background: linear-gradient(135deg, #0a3a66 0%, #1a6fd8 100%);">
                            <i class="fas fa-rocket me-2"></i> Apply Now
                        </button>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <?php } ?>
        </div>

      <!-- [ Main Content ] end -->
    </div>
  </div>

    <div class="modal fade" id="vendorModal" tabindex="-1" aria-labelledby="vendorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="vendorModalLabel">Vendor Application Form</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="vendorForm">
                    <div class="alert alert-info">To Apply For Our Vendorship Program, Kindly note that a One Time Fee of $5 will be deducted from your Earning Wallet after Successful Verification.</div>
                <div class="row g-3">
                    <div class="col-md-12">
                    <label for="fullName" class="form-label">Upload Personal ID card</label>
                        <input type="file"name="imageFile" class="form-control" accepted="png,jpg,jpeg" required>
                    </div>
                    <div class="col-12">
                        <label for="experience" class="form-label">Network Marketing Experience</label>
                        <textarea class="form-control" name="experience" id="experience" rows="3" placeholder="Briefly describe your experience in network marketing"></textarea>
                    </div>
                    <div class="col-12">
                        <label for="whyVendor" class="form-label">Why Do You Want To Become a Vendor?</label>
                        <textarea class="form-control" name="why" id="whyVendor" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">
                        <span id="submitText">Submit Application</span>
                        <span id="submitSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
                </form>
            </div>
            </div>
        </div>
        </div>

        <!-- Floating Support Icon -->
    <a href="support" class="support-icon">
        <span><i class="fas fa-headset"></i></span> <!-- Or use an icon (e.g., Font Awesome) -->
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
<script src="https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-window.prod.mjs" type="module"></script>
<script src="sw.js"></script>
<script src="<?php echo $rootUrl ?>/public/assets/js/app.js"></script>
<script src="<?php echo $rootUrl ?>/public/assets/js/workboxreg.js"></script>
<script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

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

        $(document).ready(function() {
            // Form submission handling
            $('#vendorForm').validate({
                rules: {
                // Add validation rules here
                },
                submitHandler: function(form) {

                const submitBtn = $('#vendorForm button[type="submit"]');
                const submitText = $('#submitText');
                const spinner = $('#submitSpinner');
                
                // Show loading state
                const formData = new FormData(form);
                
                // Simulate form submission (replace with actual AJAX call)
                iziToast.question({
                timeout: false,
                close: false,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                title: 'Confirmation',
                message: 'Are you sure you want to continue?',
                position: 'center',
                buttons: [
                    ['<button><b>Yes</b></button>', function (instance, toast){
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        
                        // Run your AJAX function here
                        $.ajax({
                            type: "POST",
                            url: "submitVendorApplication",
                            data: formData,
                            contentType: false,
                            processData: false,
                            beforeSend: function () {
                                submitText.text('Processing...');
                                spinner.removeClass('d-none');
                                submitBtn.prop('disabled', true);
                            },
                            dataType: 'json',
                            success: function(data) {

                                submitBtn.prop('disabled', false);
                                // Close modal after 2 seconds
                                
                            
                            console.log(data);
                            if (data.status===true) {

                                setTimeout(() => {
                                    
                                    $('#vendorModal').modal('hide');
                                    submitText.text('Submit Application');
                                    submitBtn.prop('disabled', false);
                                    form.reset();

                                    iziToast.success({
                                        title: 'Success',
                                        message: data.message,
                                    });
                                
                                }, 2000);
                            
                            } else {
                                submitText.text('Submit Application');
                                submitBtn.prop('disabled', false);
                                spinner.addClass('d-none');

                                iziToast.warning({
                                    title: 'Error',
                                    message: data.message,
                                });

                            }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                submitText.text('Submit Application');
                                spinner.addClass('d-none');
                                submitBtn.prop('disabled', false);
                                iziToast.warning({
                                    title: 'Error',
                                    message: errorThrown,
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
                
                }
            });
        });
</script>


</body>
</html>