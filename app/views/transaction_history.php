<html><!-- [Head] start -->
<head>
    <title>Transaction History | GlobalSingleLine</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="Transaction History | GlobalSingleLine">
    <meta name="description" content="The platform for Networkers">
    <meta name="keywords" content="network marketing, single leg networking, referral marketing platform, MLM software, affiliate networking, residual income opportunities, entrepreneurs network, passive income ideas">
    <meta name="author" content="GlobalSingleLine">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Transaction History | GlobalSingleLine">
    <meta property="og:description" content="The platform for Networkers">
    <meta property="og:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta property="og:url" content="<?php echo $rootUrl ?>/transaction_history">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Transaction History | GlobalSingleLine">
    <meta name="twitter:description" content="The platform for Networkers">
    <meta name="twitter:image" content="<?php echo $rootUrl ?>/public/assets/images/logo.png">
    <meta name="twitter:site" content="<?php echo $rootUrl ?>/transaction_history">
    <meta name="theme-color" content="#0a3a66">
    <link rel="canonical" href="<?php echo $rootUrl ?>/transaction_history">
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
        
    </style>
    <script>
        window.env = {
            NOTIFICATION_ACCESS: "<?php echo $userInfo['notification_access']; ?>",
            VAPID_PUBLIC_KEY: "<?php VAPID_PUBLIC_KEY ?>",
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
                <li class="breadcrumb-item" aria-current="page">Transaction History</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Transaction History</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
      <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card transaction-card">
                    <!-- Card Header -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex">
                            <input type="text" name="search" id="search-transactions" class="form-control search-box me-2" placeholder="Search transactions...">
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="card-body p-0">
                        <!-- Transaction Filters -->
                        <div class="d-flex justify-content-between px-3 pt-3 pb-2 border-bottom">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary active filter-btn" data-type="all">All</button>
                                <button type="button" class="btn btn-sm btn-outline-primary filter-btn" data-type="credit">Credits</button>
                                <button type="button" class="btn btn-sm btn-outline-primary filter-btn" data-type="debit">Debits</button>
                            </div>
                        </div>
                        
                        <!-- Replace your transaction list section with this -->
                        <div id="transaction-list" class="list-group list-group-flush">
                            <!-- Transactions will be loaded here via AJAX -->
                        </div>

                    </div>
                    
                    <!-- Card Footer -->
                    <div id="transaction-pagination" class="card-footer bg-white border-top-0">
                        <!-- Pagination will be loaded here via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Details Modal -->
    <div class="modal fade" id="transactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="transactionDetails">
                <!-- Details will be loaded here via AJAX -->
                <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="printReceipt">
                <i class="fas fa-print me-2"></i>Print Receipt
                </button>
            </div>
            </div>
        </div>
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
          <p class="m-0">Crafted by Team <a>GlobalSingleLine</a></p>
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

        /*var usersDataTable = $('#all_history').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'responsive': true,
            'ajax': {
                'url':'fetchtransactionhistory',
                'error': function(xhr, error, thrown) {
                    console.error('DataTables AJAX error:', xhr.responseText);
                }
            },
            
            'columns': [

                { data: 'id' },
                { data: 'type' },
                { data: 'amount' },
                { data: 'description' },
                { data: 'date' },
                { data: 'action' },
               
            ]

        });*/

        $(document).ready(function() {
            // Load initial transactions
            loadTransactions();

            // Search and filter handlers
            $('#search-transactions').on('input', function() {
                loadTransactions();
            });

            $('.filter-btn').on('click', function() {
                $(this).addClass('active').siblings().removeClass('active');
                loadTransactions();
            });

            $('#status-filter').on('change', function() {
                loadTransactions();
            });

            // Pagination handler
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page) {
                    loadTransactions(page);
                }
            });
        });

        function loadTransactions(page = 1) {
            const search = $('#search-transactions').val();
            const type = $('.filter-btn.active').data('type') || 'all';
            const status = $('#status-filter').val() || 'all';

            $.ajax({
                url: 'fetchtransactionhistory',
                type: 'POST',
                data: {
                    page: page,
                    search: search,
                    type: type,
                    status: status
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#transaction-list').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>');
                },
                success: function(response) {
                    renderTransactions(response.transactions);
                    renderPagination(response.pagination);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", {
                        Status: status,
                        Error: error,
                        Response: xhr.responseText,
                        StatusCode: xhr.status,
                        ReadyState: xhr.readyState
                    });

                    // Display user-friendly error
                    let errorMsg = "An error occurred";
                    
                    // Try to parse PHP error if response is text/html
                    if (xhr.responseText) {
                        try {
                            // If PHP returns JSON error
                            const phpError = JSON.parse(xhr.responseText);
                            errorMsg = phpError.error || phpError.message || xhr.responseText;
                            console.log(errorMsg);
                        } catch (e) {
                            // If PHP returns plain text error
                            errorMsg = xhr.responseText;
                        }
                    }
        
                    $('#transaction-list').html(`
                        <div class="alert alert-danger alert-dismissible fade show">
                            ${errorMsg}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `);
                }
            });
        }

        function renderTransactions(transactions) {
            if (transactions.length === 0) {
                $('#transaction-list').html('<div class="text-center py-5 text-muted">No transactions found</div>');
                return;
            }

            let html = '';
            transactions.forEach(tx => {
                const typeClass = tx.type === 'credit' ? 'success' : 'danger';
                const statusClass = tx.status === 'Completed' ? 'success' :  'danger';
                
                html += `
                <div class="list-group-item transaction-item" data-txid="${tx.id}" style="cursor: pointer;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="transaction-icon icon-${tx.type} me-3">
                                <i class="fas ${tx.icon}"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">${tx.description}</h6>
                                <small class="text-muted">${tx.date}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-1 text-${typeClass}">${tx.type === 'credit' ? '+' : '-'}$${tx.amount}</h6>
                            <span class="badge bg-light text-${statusClass} badge-pill">${tx.status}</span>
                        </div>
                    </div>
                </div>`;
            });

            $('#transaction-list').html(html);

            // Add click handler for transaction items
            $('.transaction-item').on('click', function() {
                const txId = $(this).data('txid');
                loadTransactionDetails(txId);
            });
        }

        function renderPagination(pagination) {
            let html = `
            <small class="text-muted">Showing ${(pagination.current_page - 1) * pagination.per_page + 1} to 
            ${Math.min(pagination.current_page * pagination.per_page, pagination.total)} of ${pagination.total} transactions</small>
            <nav aria-label="Transaction pagination">
                <ul class="pagination pagination-sm mb-0">`;
            
            // Previous button
            html += `<li class="page-item ${pagination.current_page === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${pagination.current_page - 1}">Previous</a>
                    </li>`;
            
            // Page numbers
            const startPage = Math.max(1, pagination.current_page - 2);
            const endPage = Math.min(pagination.total_pages, pagination.current_page + 2);
            
            for (let i = startPage; i <= endPage; i++) {
                html += `<li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>`;
            }
            
            // Next button
            html += `<li class="page-item ${pagination.current_page === pagination.total_pages ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${pagination.current_page + 1}">Next</a>
                    </li>
                </ul>
            </nav>`;
            
            $('#transaction-pagination').html(html);
        }

        function loadTransactionDetails(txId) {

            const modal = new bootstrap.Modal(document.getElementById('transactionModal'));
            
            $.ajax({
                url: 'fetchtransactiondetails',
                type: 'POST',
                data: { id: txId },
                beforeSend: function() {
                    $('#transactionDetails').html(`
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                    `);
                    modal.show();
                },
                success: function(response) {
                    console.log(response);
                $('#transactionDetails').html(`
                    <div class="row mb-3">
                    <div class="col-6">
                        <small class="text-muted">Transaction ID</small>
                        <p>${response.id}</p>
                    </div>
                    <div class="col-6 text-end">
                        <small class="text-muted">Date</small>
                        <p>${response.date}</p>
                    </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                    <div>
                        <small class="text-muted">Type</small>
                        <p><span class="badge bg-${response.type === 'credit' ? 'success' : 'danger'}">
                        ${response.type.toUpperCase()}
                        </span></p>
                    </div>
                    <div class="text-end">
                        <small class="text-muted">Amount</small>
                        <h4 class="${response.type === 'credit' ? 'text-success' : 'text-danger'}">
                        ${response.type === 'credit' ? '+' : '-'}$${response.amount}
                        </h4>
                    </div>
                    </div>
                    
                    
                    <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Status</small>
                        <p><span class="badge bg-${getStatusClass(response.status)}">
                        ${response.status.toUpperCase()}
                        </span></p>
                    </div>
                    </div>
                    
                    ${response.description ? `
                    <div class="alert alert-light mt-3">
                    <small class="text-muted">Notes</small>
                    <p>${response.description}</p>
                    </div>` : ''}
                `);
                },
                error: function(xhr) {
                $('#transactionDetails').html(`
                    <div class="alert alert-danger">
                    Failed to load transaction details. Please try again.
                    </div>
                `);
                }
            });
            }

            function getStatusClass(status) {
                switch(status) {
                    case 'completed': return 'success';
                    case 'pending': return 'warning';
                    case 'failed': return 'danger';
                    default: return 'secondary';
                }
            }
</script>

</body>
</html>