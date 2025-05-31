<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activated - GlobalSingleLine</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.28.1/tabler-icons.min.css" integrity="sha512-UuL1Le1IzormILxFr3ki91VGuPYjsKQkRFUvSrEuwdVCvYt6a1X73cJ8sWb/1E726+rfDRexUn528XRdqrSAOw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .confirmation-card {
            max-width: 500px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .success-icon {
            font-size: 5rem;
            color: #198754;
            animation: bounce 1s;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-30px);}
            60% {transform: translateY(-15px);}
        }
        .btn-login {
            background-color: #198754;
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background-color: #157347;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card confirmation-card p-4 py-5 text-center">
                    <div class="card-body">
                        <!-- Success Icon -->
                        <div class="mb-4">
                            <i class="fas fa-check-circle success-icon"></i>
                        </div>
                        
                        <!-- Success Message -->
                        <h2 class="card-title mb-3">Account Activated!</h2>
                        <p class="card-text text-muted mb-4">
                            Congratulations! Your account has been successfully activated. 
                            You can now log in and start using our platform.
                        </p>
                        
                        <!-- Login Button -->
                        <div class="d-grid gap-2 col-md-6 mx-auto">
                            <a href="login" class="btn btn-login btn-lg text-white">
                                <i class="fas fa-sign-in-alt me-2"></i> Go to Login
                            </a>
                        </div>
                        
                        <!-- Additional Help -->
                        <p class="mt-4 mb-0 small text-muted">
                            Having trouble? <a href="support">Contact support</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>