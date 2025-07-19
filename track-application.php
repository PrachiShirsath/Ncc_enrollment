<?php
// Database connection
$host = 'localhost';
$dbname = 'ncc_dbatu1';
$username = 'root';
$password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("<div style='color:#c00; font-weight:600; margin-top:24px;'>Connection failed: " . $e->getMessage() . "</div>");
}

// Get the registration ID from the form input
$registration_id = $_GET['search'] ?? '';

$student = null;
if (!empty($registration_id)) {
    $stmt = $pdo->prepare("SELECT * FROM ncc_applications WHERE registration_id = ?");
    $stmt->execute([$registration_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Track NCC Application</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(90deg, #e0f7fa 0%, #b2ebf2 50%, #c8e6c9 100%);
            font-family: 'Montserrat', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .main-card {
            background: rgba(255,255,255,0.97);
            border-radius: 32px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
            padding: 56px 64px 40px 64px;
            max-width: 900px;
            width: 100%;
            margin: 48px auto;
        }
        .main-title {
            font-size: 2rem;
            font-weight: 700;
            color: #3a3a6a;
            letter-spacing: 1px;
            margin-bottom: 32px;
            text-align: center;
        }
        .input-group-lg > .form-control, .input-group-lg > .input-group-text, .input-group-lg > .btn {
            font-size: 1.25rem;
            border-radius: 2rem;
            padding: 18px 24px;
        }
        .input-group-text {
            background: #e3eafe;
            color: #4469d8;
            border: none;
            border-radius: 2rem 0 0 2rem !important;
        }
        .form-control:focus {
            border-color: #1de9b6;
            box-shadow: 0 0 0 0.2rem rgba(29,233,182,.10);
        }
        .btn-gradient {
            background: linear-gradient(90deg, #3a8dde 0%, #1de9b6 100%);
            color: #fff;
            border: none;
            font-weight: 700;
            border-radius: 2rem;
            padding: 0 32px;
            transition: box-shadow 0.2s, transform 0.2s;
            box-shadow: 0 2px 8px rgba(29,233,182,0.10);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-gradient:hover, .btn-gradient:focus {
            background: linear-gradient(90deg, #1de9b6 0%, #3a8dde 100%);
            box-shadow: 0 6px 24px rgba(29,233,182,0.18);
            transform: translateY(-2px) scale(1.03);
            color: #fff;
        }
        .info-box {
            background: #e0f7fa;
            border-radius: 16px;
            padding: 18px 24px;
            margin: 24px 0 0 0;
            font-size: 1.1rem;
            color: #006064;
            text-align: left;
            box-shadow: 0 2px 8px rgba(44,62,80,0.06);
        }
        .info-box strong { color: #00838f; }
        .info-box a { color: #4469d8; text-decoration: underline; }
        .tracking-card {
            background: #fff;
            border-radius: 18px;
            padding: 32px 24px;
            box-shadow: 0 4px 18px rgba(106,130,251,0.08);
            margin-top: 32px;
        }
        .alert-warning {
            margin-top: 32px;
            font-size: 1.1rem;
        }
        @media (max-width: 1100px) {
            .main-card { max-width: 98vw; padding: 32px 8px; }
        }
        @media (max-width: 600px) {
            .main-card { padding: 18px 2vw; }
            .main-title { font-size: 1.2rem; }
        }
    </style>
</head>
<body>
    <div class="main-card">
        <div class="main-title">
            <i class="bi bi-search"></i> Track Your NCC Application
        </div>
        <form method="GET" action="" class="mb-0">
            <div class="input-group input-group-lg mb-3">
                <span class="input-group-text">
                    <i class="bi bi-card-text"></i>
                </span>
                <input type="text" name="search" class="form-control" placeholder="Enter your Registration ID" required value="<?= htmlspecialchars($registration_id) ?>">
                <button type="submit" class="btn btn-gradient px-4"><i class="bi bi-search"></i> Track</button>
            </div>
        </form>
        <div class="info-box mt-3">
            <i class="bi bi-info-circle"></i>
            <strong> Registration ID Format:</strong> DBATU/NCC/BRANCH/YEAR/NUMBER<br>
            <span style="margin-left:2.2em;">Example: <a href="#" style="color:#4469d8;">DBATU/NCC/CSE/2024/001</a></span>
        </div>
        <?php if ($student): ?>
            <div class="tracking-card mt-4">
                <h4 class="mb-3 text-success"><i class="bi bi-check-circle"></i> Application Found</h4>
                <table class="table table-borderless mb-0">
                    <tr><th>Name</th><td><?= htmlspecialchars($student['full_name']) ?></td></tr>
                    <tr><th>Registration ID</th><td><?= htmlspecialchars($student['registration_id']) ?></td></tr>
                    <tr><th>Email</th><td><?= htmlspecialchars($student['email']) ?></td></tr>
                    <tr><th>Phone</th><td><?= htmlspecialchars($student['phone']) ?></td></tr>
                    <tr><th>Branch</th><td><?= htmlspecialchars($student['branch']) ?></td></tr>
                    <tr><th>Year</th><td><?= htmlspecialchars($student['current_year']) ?></td></tr>
                    <tr><th>Gender</th><td><?= htmlspecialchars($student['gender']) ?></td></tr>
                    <tr><th>Status</th><td><?= htmlspecialchars($student['status']) ?></td></tr>
                    <tr><th>Applied On</th><td><?= htmlspecialchars($student['created_at']) ?></td></tr>
                    <tr><th>Last Updated</th><td><?= htmlspecialchars($student['updated_at']) ?></td></tr>
                </table>
            </div>
        <?php elseif (!empty($registration_id)): ?>
            <div class="alert alert-warning text-center">
                <i class="bi bi-exclamation-triangle"></i> No application found for this Registration ID.
            </div>
        <?php endif; ?>
    </div>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
