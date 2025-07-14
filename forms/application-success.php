<?php
ini_set('display_errors', 0);
error_reporting(0);
// Start the session to access session variables
session_start();

// Check if the registration ID is set in the session. If not, redirect to homepage.
if (!isset($_SESSION['new_registration_id']) || !isset($_SESSION['applicant_name'])) {
    header("Location: ../index.html");
    exit();
}

// Get the details from the session
$registration_id = $_SESSION['new_registration_id'];
$applicant_name = $_SESSION['applicant_name'];

// Unset the session variables so they can't be reused
unset($_SESSION['new_registration_id']);
unset($_SESSION['applicant_name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted Successfully - DBATU NCC</title>
    
    <!-- Bootstrap CSS -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    
    <style>
        .success-container {
            background: linear-gradient(120deg, #f8fafc 60%, #b9c2fa 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .success-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 30px;
            margin: 20px auto;
            max-width: 600px;
            text-align: center;
        }
        .reg-id-box {
            background: linear-gradient(135deg, #4469d8 0%, #00b894 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            margin: 25px auto;
            letter-spacing: 1px;
            user-select: all;
            box-shadow: 0 5px 15px rgba(68, 105, 216, 0.3);
            overflow-wrap: break-word;
            word-break: break-all;
        }
        .btn-primary {
            background: linear-gradient(135deg, #4469d8 0%, #00b894 100%);
            border: none;
            border-radius: 25px;
            font-weight: 600;
            padding: 12px 30px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(68, 105, 216, 0.3);
        }
        .btn-outline-primary {
            border-radius: 25px;
            font-weight: 600;
            padding: 12px 30px;
            border-color: #4469d8;
            color: #4469d8;
        }
        .btn-outline-primary:hover {
            background: #4469d8;
            border-color: #4469d8;
        }
        .alert-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-weight: 600;
        }
        .footer-note {
            font-size: 0.95rem;
            color: #6c757d;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="color">
        <div class="header" style="background: #111; color: #fff; border-radius: 0 0 24px 24px; box-shadow: 0 4px 24px rgba(44,62,80,0.10); padding: 24px 0 18px 0; margin-bottom: 0;">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 16px;">
                    <!-- Removed DBATU and NCC logo images from header -->
                    <div class="flex-grow-1 text-center">
                        <div style="font-size:2.1rem; font-weight:800; color:#fff; letter-spacing:1px; line-height:1.1;">Application Submitted Successfully</div>
                        <div style="font-size:1.3rem; color:#ffe066; font-weight:600; margin-top:2px;">DBATU NCC UNIT</div>
                        <div style="font-size:1.05rem; color:#e0e0e0; margin-top:2px;">Dr. Babasaheb Ambedkar Technological University</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="success-container">
        <div class="container">
            <div class="success-card">
                <!-- Success Alert -->
                 <div class="alert alert-success text-center" role="alert" style="font-size:1.15rem; font-weight:600; margin-bottom: 1.5rem;">
                    <i class="bi bi-check-circle me-2"></i>
                    Application Submitted Successfully!
                </div>
                
                <h2 style="color: #4469d8; font-weight: 700; margin-bottom: 1rem;">Thank You, <?php echo htmlspecialchars($applicant_name); ?>!</h2>
                
                <p class="text-center mb-3" style="font-size: 1.1rem; color: #495057;">
                    Your application to join the DBATU NCC unit has been received successfully.
                </p>
                
                <p class="text-center mb-4" style="font-size: 1.05rem; color: #6c757d;">
                    Please save your Registration ID. You will need it to track the status of your application.
                </p>
                
                <div class="reg-id-box" id="regId">
                    <?php echo htmlspecialchars($registration_id); ?>
                </div>
                
                <div class="footer-note">
                    <i class="bi bi-info-circle me-2"></i>
                    A confirmation has been notionally sent to your email (as this is a project). You will be notified about the next steps of the selection process.
                </div>
                
                <div class="mt-4">
                    <a href="track-application.php" class="btn btn-primary me-3">
                        <i class="bi bi-search me-2"></i>Track Application
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p>&copy; 2024-2025 DBATU NCC UNIT. All Rights Reserved</p>
            <p class="mb-0">Made by Sudharshan and Prachi</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html> 