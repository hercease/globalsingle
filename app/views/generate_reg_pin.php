<html><!-- [Head] start -->
<head>
    <title>Generate Pin | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Generate Pin | GlobalSingleLine">
    <meta name="description" content="Generating Success For Life">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Generate Pin | GlobalSingleLine">
    <meta property="og:description" content="Generating Success For Life">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/generate_reg_pin">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Generate Pin | GlobalSingleLine">
    <meta name="twitter:description" content="Generating Success For Life">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/generate_reg_pin">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/generate_reg_pin">
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
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css" rel="stylesheet">
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
                <li class="breadcrumb-item" aria-current="page">Generate Pin</li>
              </ul>
            </div>
            <div class="d-flex">
              <div class="page-header-title">
                <h2 class="mb-0">Generate Pin</h2>
              </div>
              <button class="btn btn-primary btn-sm ms-auto" data-bs-toggle='modal' data-bs-target='#modalCentered'>
                <i class="ti ti-plus"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
      <div class="container py-5">
        <div class="row justify-content-center">

            <div class="col-lg-12 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        
                        <table id="registration_pins" class="table table-striped caption-top">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Pin</th>
                                    <th scope="col">Date Created</th>
                                    <th scope="col">Used By</th>
                                    <th scope="col">Date Used</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
      <!-- [ Main Content ] end -->
    </div>
  </div>

  <a href="support" class="support-icon">
      <span><i class="fas fa-headset"></i></span> <!-- Or use an icon (e.g., Font Awesome) -->
  </a>

  <div class="modal fade" id="modalCentered" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Reg Pin Gneration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form name="reg_pin_form" id="reg_pin_form">
                    <div class="modal-body">
                        <!-- Textarea for reason -->
                        <div class="mb-3">
                            <label for="reason" class="form-label">Enter no pin/s</label>
                            <input type="number" class="form-control" name="pin_no" required placeholder="Enter number of pin to generate" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary px-4">
                            <span id="submitText">Contnue</span>
                            <span id="submitSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
           
        </div>
    </div>
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
<script src="https://storage.googleapis.com/workbox-cdn/releases/6.5.4/workbox-window.prod.mjs" type="module"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.js"></script>
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

        var usersDataTable = $('#registration_pins').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'responsive': true,
            'ajax': {
                'url':'fetchgeneratedpins',
                'error': function(xhr, error, thrown) {
                    console.error('DataTables AJAX error:', xhr.responseText);
                }
            },
            
            'columns': [

                { data: 'id' },
                { data: 'pin' },
                { data: 'created_on' },
                { data: 'used_by' },
                { data: 'used_on' },
                { data: 'status' },

            ]

        });


        $(document).ready(function() {
            // Form submission handling
            $('#reg_pin_form').validate({
                rules: {
                // Add validation rules here
                },

                submitHandler: function(form) {

                const submitBtn = $('#reg_pin_form button[type="submit"]');
                const submitText = $('#submitText');
                const spinner = $('#submitSpinner');
                
                // Show loading state
                
                var data = $("form[name='reg_pin_form']").serialize();
                data += '&timezone=' + encodeURIComponent(timezone);
                
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
                            url: "generateregpin",
                            data: data,
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

                              
                                    
                                    $('#modalCentered').modal('hide');
                                    submitText.text('Continue');
                                    submitBtn.prop('disabled', false);
                                    form.reset();

                                    iziToast.success({
                                        title: 'Success',
                                        message: data.message,
                                    });

                                    usersDataTable.ajax.reload();
                                
                            
                            } else {

                                submitText.text('Continue');
                                submitBtn.prop('disabled', false);
                                spinner.addClass('d-none');

                                iziToast.warning({
                                    title: 'Error',
                                    message: data.message,
                                });

                            }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                submitText.text('Continue');
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