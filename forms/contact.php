<?php
// Start a session to pass the registration ID to the success page
session_start();

// --- Database Configuration ---
$db_host = 'localhost';
$db_user = 'root'; // Default XAMPP username
$db_pass = '';     // Default XAMPP password
$db_name = 'ncc_dbatu';

// --- Registration ID Configuration ---
$INSTITUTE = "DBATU";    // Your institute name
$DEPARTMENT = "NCC";     // Department or program

// Branch codes matching exactly with the form
$BRANCH_CODES = [
    "Computer Engineering" => "CSE",
    "Mechanical Engineering" => "MECH",
    "Electrical Engineering" => "EE",
    "Civil Engineering" => "CIVIL",
    "Chemical Engineering" => "CHEM"
];

// Create a database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check the connection
if ($conn->connect_error) {
    // For a real application, you would log this error, not display it
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- Sanitize and retrieve form data ---
    $name    = $conn->real_escape_string($_POST['name']);
    $email   = $conn->real_escape_string($_POST['email']);
    $phone   = $conn->real_escape_string($_POST['phone']);
    $branch  = $conn->real_escape_string($_POST['branch']);
    $year    = $conn->real_escape_string($_POST['year']);
    $gender  = $conn->real_escape_string($_POST['gender']);

    // --- Generate Registration ID ---
    // Format: DBATU/NCC/BRANCH/YEAR/SEQUENCE
    // Example: DBATU/NCC/CSE/2024/001
    
    // Get current year
    $current_year = date('Y');
    
    // Get branch code (or use GEN for unknown branches)
    $branch_code = isset($BRANCH_CODES[$branch]) ? $BRANCH_CODES[$branch] : "GEN";
    
    // Get the last sequence number for this branch and year
    $sequence_sql = "SELECT registration_id FROM ncc_applications 
                    WHERE registration_id LIKE ? 
                    ORDER BY registration_id DESC LIMIT 1";
    
    $pattern = "{$INSTITUTE}/{$DEPARTMENT}/{$branch_code}/{$current_year}/%";
    $stmt = $conn->prepare($sequence_sql);
    $stmt->bind_param("s", $pattern);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Get next sequence number
    if ($row = $result->fetch_assoc()) {
        $last_id = $row['registration_id'];
        $sequence = intval(substr($last_id, -3)) + 1;
    } else {
        $sequence = 1;
    }
    
    // Format sequence number with leading zeros (001, 002, etc.)
    $sequence_formatted = str_pad($sequence, 3, "0", STR_PAD_LEFT);
    
    // Create the final registration ID
    $registration_id = "{$INSTITUTE}/{$DEPARTMENT}/{$branch_code}/{$current_year}/{$sequence_formatted}";

    // --- Prepare and execute the SQL INSERT statement ---
    $sql = "INSERT INTO ncc_applications (registration_id, full_name, email, phone, branch, current_year, gender) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sssssss", $registration_id, $name, $email, $phone, $branch, $year, $gender);

    // Execute the statement
    if ($stmt->execute()) {
        // Success! Store the new ID in a session variable
        $_SESSION['new_registration_id'] = $registration_id;
        $_SESSION['applicant_name'] = $name;

        // Redirect to the success page
        header("Location: application-success.php");
        exit(); // Important to prevent further script execution

    } else {
        // For a real application, handle this error more gracefully
        die("Error executing statement: " . $stmt->error);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

} else {
    // If not a POST request, redirect back to the form or homepage
    header("Location: ../index.html");
    exit();
}
?>
