<?php
ini_set('display_errors', 0);
error_reporting(0);
// Database configuration
$host = 'localhost';
$dbname = 'ncc_dbatu';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Generate unique registration ID
function generateRegistrationId() {
    return 'NCC' . date('Y') . strtoupper(substr(md5(uniqid()), 0, 8));
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Generate unique registration ID
        $registration_id = generateRegistrationId();
        
        // Get form data
        $full_name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $branch = $_POST['branch'] ?? '';
        $current_year = $_POST['year'] ?? '';
        $gender = $_POST['gender'] ?? '';
        
        
        // Insert into database
        $sql = "INSERT INTO ncc_applications (registration_id, full_name, email, phone, branch, current_year, gender, motivation, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$registration_id, $full_name, $email, $phone, $branch, $current_year, $gender, $motivation]);
        
        // Send email with tracking link
        $tracking_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/track-application.php?id=" . $registration_id;
        
        $to = $email;
        $subject = "NCC Application Received - DBATU";
        $message = "
Dear $full_name,

Thank you for your interest in joining NCC at DBATU!

Your application has been received successfully.

📋 Application Details:
• Registration ID: $registration_id
• Name: $full_name
• Branch: $branch
• Year: $current_year

🔗 Track your application status here: $tracking_url

We will review your application and get back to you within 5-7 working days.

Best regards,
DBATU NCC Unit
Dr. Babasaheb Ambedkar Technological University, Lonere
        ";
        
        $headers = "From: ncc@dbatu.ac.in\r\n";
        $headers .= "Reply-To: ncc@dbatu.ac.in\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        mail($to, $subject, $message, $headers);
        
        // Redirect to success page
        header("Location: application-success.php?id=" . $registration_id);
        exit();
        
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?> 