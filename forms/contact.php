<?php
// Start a session to pass the registration ID to the success page
session_start();

// --- Database Configuration ---
$db_host = 'localhost';
$db_user = 'root'; // Default XAMPP username
$db_pass = '';     // Default XAMPP password
$db_name = 'ncc_dbatu1';

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
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $conn->real_escape_string($_POST['name']);
    $email   = $conn->real_escape_string($_POST['email']);
    $phone   = $conn->real_escape_string($_POST['phone']);
    $branch  = $conn->real_escape_string($_POST['branch']);
    $current_year = $conn->real_escape_string($_POST['year']);
    $gender  = $conn->real_escape_string($_POST['gender']);

    $status = 'pending';
    $batch_id = NULL;
    $assigned_date = NULL;
    $created_at = date('Y-m-d H:i:s');
    $updated_at = $created_at;

    // Registration ID generation
    $INSTITUTE = "DBATU";
    $DEPARTMENT = "NCC";
    $BRANCH_CODES = [
        "Computer Engineering" => "CSE",
        "Mechanical Engineering" => "MECH",
        "Electrical Engineering" => "EE",
        "Civil Engineering" => "CIVIL",
        "Chemical Engineering" => "CHEM"
    ];
    $branch_code = isset($BRANCH_CODES[$branch]) ? $BRANCH_CODES[$branch] : "GEN";
    $year = date('Y');
    $pattern = "$INSTITUTE/$DEPARTMENT/$branch_code/$year/%";

    // Find the highest sequence number for this branch and year
    $sequence_sql = "SELECT registration_id FROM ncc_applications WHERE registration_id LIKE ? ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($sequence_sql);
    if (!$stmt) {
        die("Prepare failed (sequence_sql): (" . $conn->errno . ") " . $conn->error);
    }
    $stmt->bind_param("s", $pattern);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $last_id = $row['registration_id'];
        $last_seq_str = substr($last_id, strrpos($last_id, '/') + 1);
        if (is_numeric($last_seq_str)) {
            $sequence = intval($last_seq_str) + 1;
        } else {
            $sequence = 1;
        }
    } else {
        $sequence = 1;
    }
    $sequence_formatted = str_pad($sequence, 3, "0", STR_PAD_LEFT);
    $registration_id = "$INSTITUTE/$DEPARTMENT/$branch_code/$year/$sequence_formatted";

    $sql = "INSERT INTO ncc_applications (registration_id, full_name, email, phone, branch, current_year, gender, status, batch_id, assigned_date, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed (insert): (" . $conn->errno . ") " . $conn->error);
    }
    $stmt->bind_param("ssssssssssss", $registration_id, $full_name, $email, $phone, $branch, $current_year, $gender, $status, $batch_id, $assigned_date, $created_at, $updated_at);
    if ($stmt->execute()) {
        $_SESSION['new_registration_id'] = $registration_id;
        $_SESSION['applicant_name'] = $full_name;
        header("Location: application-success.php");
        exit();
    } else {
        die("Error executing statement: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
} else {
    // Show the form (no registration_id field)
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>NCC Application Form</title>
        <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container mt-5">
        <h2>Apply for NCC</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Phone:</label>
                <input type="text" name="phone" class="form-control" required pattern="\d{10}">
            </div>
            <div class="mb-3">
                <label>Year:</label>
                <select name="year" class="form-control" required>
                    <option value="">Select Year</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <!-- Add more years as needed -->
                </select>
            </div>
            <div class="mb-3">
                <label>Branch:</label>
                <select name="branch" class="form-control" required>
                    <option value="">Select Branch</option>
                    <option value="Computer Engineering">Computer Engineering</option>
                    <option value="Mechanical Engineering">Mechanical Engineering</option>
                    <option value="Electrical Engineering">Electrical Engineering</option>
                    <option value="Civil Engineering">Civil Engineering</option>
                    <option value="Chemical Engineering">Chemical Engineering</option>
                    <!-- Add more branches as needed -->
                </select>
            </div>
            <div class="mb-3">
                <label>Gender:</label>
                <select name="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Apply</button>
        </form>
    </div>
    </body>
    </html>
    <?php
    exit();
}
?>
