<?php
// delete-application.php
$host = 'localhost';
$dbname = 'ncc_dbatu';
$username = 'root';
$password = '';

if (isset($_GET['id']) && $_GET['id'] !== '') {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $registration_id = $_GET['id'];
        $stmt = $pdo->prepare("DELETE FROM ncc_applications WHERE registration_id = ?");
        $stmt->execute([$registration_id]);
    } catch (PDOException $e) {
        // Optionally log error
    }
}
header('Location: applications.php');
exit(); 