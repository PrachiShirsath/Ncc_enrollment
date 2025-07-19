<?php
// ini_set('display_errors', 0);
// error_reporting(0);
// Start the session to access session variables
session_start();

// Support both session and GET parameter for registration ID and applicant name
if (isset($_SESSION['new_registration_id']) && isset($_SESSION['applicant_name'])) {
    $registration_id = $_SESSION['new_registration_id'];
    $applicant_name = $_SESSION['applicant_name'];
    unset($_SESSION['new_registration_id']);
    unset($_SESSION['applicant_name']);
} elseif (isset($_GET['id']) && !empty($_GET['id'])) {
    $registration_id = $_GET['id'];
    $applicant_name = 'Applicant'; // fallback if name is not available
} else {
    header("Location: ../index.html");
    exit();
}
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
        .modal-dialog {
            max-width: 620px !important; /* 600px + 20px */
        }
        .modal-content {
            padding: 20px 20px 0 20px;
        }
    </style>
</head>
<body>
        <div class="container">
            <!-- Modal Popup for Success Message -->
            <div class="modal fade show" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-modal="true" role="dialog" style="display:block; background:rgba(0,0,0,0.4);">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title w-100 text-center" id="successModalLabel"><i class="bi bi-check-circle me-2"></i>Application Submitted Successfully!</h5>
                        </div>
                        <div class="modal-body text-center">
                            <h2 style="color: #4469d8; font-weight: 700; margin-bottom: 1rem;">Thank You, <?php echo htmlspecialchars($applicant_name); ?>!</h2>
                            <p style="font-size: 1.1rem; color: #495057;">Your application to join the DBATU NCC unit has been received successfully.</p>
                            <p style="font-size: 1.05rem; color: #6c757d;">Please save your Registration ID. You will need it to track the status of your application.</p>
                            <div class="reg-id-box my-3" id="regId">
                                <?php echo htmlspecialchars($registration_id); ?>
                            </div>
                            <div class="footer-note mt-3">
                                <i class="bi bi-info-circle me-2"></i>
                                A confirmation has been notionally sent to your email (as this is a project). You will be notified about the next steps of the selection process.
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <a href="../track-application.php" target="_blank" class="btn btn-primary me-3">
                                <i class="bi bi-search me-2"></i>Track Application
                            </a>
                            <a href="../index.html" class="btn btn-outline-primary">
                                <i class="bi bi-house me-2"></i>Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var modal = document.getElementById('successModal');
                    if (modal) {
                        modal.classList.add('show');
                        modal.style.display = 'block';
                    }
                });
            </script>
        </div>

    <!-- Bootstrap JS -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html> 


