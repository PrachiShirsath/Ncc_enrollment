<?php
session_start();
$is_admin = (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true);
if (!$is_admin) {
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Login Required</title>';
    echo '<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">';
    echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
    echo '<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>';
    echo '</head><body>';
    echo '<div class="modal show" tabindex="-1" style="display:block; background:rgba(0,0,0,0.4); position:fixed; top:0; left:0; width:100vw; height:100vh; z-index:9999;">';
    echo '<div class="modal-dialog modal-dialog-centered">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header bg-warning"><h5 class="modal-title">Login Required</h5></div>';
    echo '<div class="modal-body text-center">';
    echo '<p class="mb-3">Login to change the status</p>';
    echo '<a href="login.php" class="btn btn-primary">Go to Login</a>';
    echo '</div></div></div></div>';
    echo '</body></html>';
    exit();
}
// change-status.php
$host = 'localhost';
$dbname = 'ncc_dbatu1';
$username = 'root';
$password = '';

if (isset($_POST['registration_id'], $_POST['status']) && $_POST['registration_id'] !== '' && $_POST['status'] !== '') {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $registration_id = $_POST['registration_id'];
        $status = $_POST['status'];
        $stmt = $pdo->prepare("UPDATE ncc_applications SET status = ? WHERE registration_id = ?");
        $stmt->execute([$status, $registration_id]);
    } catch (PDOException $e) {
        // Optionally log error
    }
}
header('Location: applications.php');
exit(); 