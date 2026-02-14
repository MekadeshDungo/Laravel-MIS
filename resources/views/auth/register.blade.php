<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Disabled - Vet MIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .register-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #198754 0%, #0d6efd 100%);
        }
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <section class="register-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="register-card p-5 text-center">
                        <div class="display-4 text-danger mb-4">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Registration Disabled</h3>
                        <p class="text-muted mb-4">
                            Public registration has been disabled. This system is for admin access only.
                        </p>
                        <p class="text-muted mb-4">
                            Please contact the system administrator if you need access.
                        </p>
                        <a href="{{ route('login') }}" class="btn btn-success btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Go to Login
                        </a>
                    </div>

                    <div class="text-center mt-3">
                        <a href="{{ url('/') }}" class="text-white text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i>Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
