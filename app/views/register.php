<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->
<head>
    <title>Register | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Register | GlobalSingleLine">
    <meta name="description" content="The platform for Networkers">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Register | GlobalSingleLine">
    <meta property="og:description" content="The platform for Networkers">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/register">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Register | GlobalSingleLine">
    <meta name="twitter:description" content="The platform for Networkers">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/register">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/register">
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
    <link rel="stylesheet" href="<?php echo $rootUrl ?>/public/assets/css/style-preset.css" />
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
        

    </style>

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-theme="light" data-pc-direction="ltr" data-pc-preset="preset-1" style="font-family:Public Sans, sans-serif">
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
          <a href="#"><img width="70" src="<?php echo $rootUrl ?>/public/assets/images/logo-new.png" alt="img"></a>
        </div>
        <div class="card my-5">
        <form name="registration">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-end mb-4">
              <h3 class="mb-0"><i class="fas fa-user-plus"></i>  <b>Sign up</b></h3>
              <a href="login" class="link-dark">Already registered ?</a>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label class="form-label">Username</label>
                  <input type="text" name="username" class="form-control" required placeholder="Username">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-3">
                  <label class="form-label">Email Address</label>
                  <input type="email" name="email" class="form-control" required placeholder="Email Address">
                </div>
              </div>
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Sponsor <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Username of who will be the sponsor"></i></label>
              <input type="text" name="sponsor" class="form-control" required placeholder="Sponsor" value="<?php echo $_GET['referral'] ?? '' ?>">
            </div>
           
            <div class="form-group mb-3">
              <label class="form-label">Bonus Username <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Username of who will be receiving the referral bonus"></i></label>
              <input type="text" name="bonus_username" class="form-control" required placeholder="Bonus username">
            </div>

            <div class="form-group mb-3">
              <label class="form-label">Select Country</label>
              <select required class="form-control" name="country" id="countrySelect">
                <option value="">Select Country</option>
              </select>
            </div>

            <input name="country" id="country" type="hidden" value="">
            
            <div class="form-group mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" required class="form-control" placeholder="Password">
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Repeat Password</label>
              <input type="password" name="repeat_password" required class="form-control" placeholder="Password">
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Wallet Username</label>
              <input type="text" required name="wallet_username" class="form-control" placeholder="Wallet Username">
            </div>
            <div class="form-group mb-3">
              <label class="form-label">Wallet Password</label>
              <input type="password" required name="wallet_password" class="form-control" placeholder="Wallet Password">
            </div>
            <p class="mt-4 text-sm text-muted">By Signing up, you agree to our <a href="#" class="text-primary"> Terms of Service </a> and <a href="#" class="text-primary"> Privacy Policy</a></p>
            <div class="d-grid mt-3">
              <button type="submit" class="btn btn-primary">Create Account</button>
            </div>
            
          </div>
        </form>
        </div>
        <div class="auth-footer row">
          <!-- <div class=""> -->
            <div class="col my-1">
              <p class="m-0">Copyright © <a href="#">Global Single Line</a></p>
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
  <script src="<?php echo $rootUrl ?>/public/assets/js/plugins/jquery-validate.js"></script>
  <script>layout_change('light');</script>
  <script>change_box_container('false');</script>
  <script>layout_rtl_change('false');</script>
  <script>preset_change("preset-1");</script>
  <script>font_change("Public-Sans");</script>
  <script>
    // Fetch the country data from the JSON file and populate the select element
    fetch("<?php echo $rootUrl ?>/public/assets/json/countries.json") // Adjust path if needed
        .then(response => response.json())
        .then(countries => {
            const select = document.getElementById('countrySelect');

            // Sort countries alphabetically by name
            countries.sort((a, b) => a.name.localeCompare(b.name));

            countries.forEach(country => {
                const option = document.createElement('option');
                option.value = country.code; // You can use country.name or phone too
                option.textContent = `${country.name} (${country.phone})`;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading countries:', error));

        $('#countrySelect').on('change', function() {
            var selectedText = $(this).find('option:selected').text();
            $("#country").val(selectedText);
            console.log("Selected Text: " + selectedText);
        });

        window.addEventListener('load', () => {
            const preloader = document.querySelector(".loader-container");
            //preloader.style.opacity = '0'; // Fade-out effect
            setTimeout(() => {
                preloader.style.display = 'none'; // Hide after fade-out
            }, 500); // Matches the CSS transition duration (if added)
        });

        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        console.log("User's Timezone: " + timezone);

        $("form[name='registration']").validate({
        // Specify validation rules
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function(form){
            
        var data = $("form[name='registration']").serialize();
        var spinner = document.querySelector(".loader-container");
        var loadingText = document.querySelector(".loading-text");
        data += '&timezone=' + encodeURIComponent(timezone);


        console.log(data);

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
                            url: "processRegistration",
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
                                    window.location.href = "login";
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

  </script>
 


</body>
</html>