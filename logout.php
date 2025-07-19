<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: applications.php');
    exit();
}
session_unset();
session_destroy();
header('Location: applications.php');
exit(); 