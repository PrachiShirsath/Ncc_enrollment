<?php
session_start();

// If already logged in, redirect to applications.php
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: applications.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($email === 'admin@dbatu.edu' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: applications.php');
        exit();
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Login</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(90deg, #e0f7fa 0%, #b2ebf2 50%, #c8e6c9 100%);
            font-family: 'Montserrat', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 28px;
            box-shadow: 0 8px 32px 0 rgba(31,38,135,0.13);
            padding: 36px 32px;
            max-width: 400px;
            width: 100%;
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
    </style>
</head>
<body>
<div class="login-card">
    <h3 class="mb-4 text-center">Admin Login</h3>
    <?php if ($error): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <div class="text-center mt-3">
        </div>
    </form>
</div>
</body>
</html> 
