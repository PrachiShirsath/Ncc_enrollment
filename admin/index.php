<?php
session_start();

// Database connection
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

// Simple authentication (in production, use proper authentication)
if (!isset($_SESSION['admin_logged_in'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Simple check (in production, use password_verify)
        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
        } else {
            $error = "Invalid credentials";
        }
    }
}

// Handle actions
if (isset($_SESSION['admin_logged_in']) && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    switch ($action) {
        case 'update_status':
            $app_id = $_POST['app_id'];
            $new_status = $_POST['new_status'];
            $batch_id = $_POST['batch_id'] ?? null;
            
            $sql = "UPDATE ncc_applications SET status = ?, batch_id = ?, assigned_date = ? WHERE id = ?";
            $assigned_date = ($new_status === 'assigned') ? date('Y-m-d') : null;
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$new_status, $batch_id, $assigned_date, $app_id]);
            
            $_SESSION['form_success'] = "Application status updated successfully!";
            $_SESSION['show_success_page'] = true;
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit();
            break;
            
        case 'create_batch':
            $batch_name = $_POST['batch_name'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $max_capacity = $_POST['max_capacity'];
            $description = $_POST['description'];
            
            $sql = "INSERT INTO ncc_batches (batch_name, start_date, end_date, max_capacity, description) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$batch_name, $start_date, $end_date, $max_capacity, $description]);
            
            $_SESSION['form_success'] = "New batch created successfully!";
            $_SESSION['show_success_page'] = true;
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit();
            break;
    }
}

// Get statistics
$stats = [];
$stmt = $pdo->query("SELECT COUNT(*) as total FROM ncc_applications");
$stats['total'] = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as pending FROM ncc_applications WHERE status = 'pending'");
$stats['pending'] = $stmt->fetch()['pending'];

$stmt = $pdo->query("SELECT COUNT(*) as approved FROM ncc_applications WHERE status = 'approved'");
$stats['approved'] = $stmt->fetch()['approved'];

$stmt = $pdo->query("SELECT COUNT(*) as assigned FROM ncc_applications WHERE status = 'assigned'");
$stats['assigned'] = $stmt->fetch()['assigned'];

// Get applications
$applications = $pdo->query("SELECT * FROM ncc_applications ORDER BY created_at DESC")->fetchAll();

// Get batches
$batches = $pdo->query("SELECT * FROM ncc_batches ORDER BY start_date")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>NCC Admin Panel - DBATU</title>
    
    <!-- Bootstrap CSS -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        .admin-container {
            background: linear-gradient(120deg, #f8fafc 60%, #b9c2fa 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .admin-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 20px;
        }
        .stat-card {
            background: linear-gradient(135deg, #4469d8 0%, #00b894 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
        }
        .login-form {
            max-width: 400px;
            margin: 100px auto;
        }
    </style>
</head>

<body>
    <?php if (!isset($_SESSION['admin_logged_in'])): ?>
    <!-- Login Form -->
    <div class="admin-container">
        <div class="container">
            <div class="login-form">
                <div class="admin-card">
                    <div class="text-center mb-4">
                        <h2 style="color: #4469d8;">NCC Admin Panel</h2>
                        <p class="text-muted">DBATU NCC Unit Management</p>
                    </div>
                    

                    
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">Demo: admin / admin123</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php else: ?>
    
    <?php if (isset($_GET['success'])): ?>
    <!-- Success Interface -->
    <div class="admin-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="admin-card text-center">
                        <div class="mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="text-success mb-3">Success!</h2>
                        <p class="lead mb-4">
                            <?php 
                            if (isset($_SESSION['form_success'])) {
                                echo $_SESSION['form_success'];
                                unset($_SESSION['form_success']);
                                unset($_SESSION['show_success_page']);
                            } else {
                                echo "Action completed successfully!";
                            }
                            ?>
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="?" class="btn btn-primary">Go to Dashboard</a>
                            <a href="?" class="btn btn-outline-secondary">Continue Working</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php else: ?>
    <!-- Admin Dashboard -->
    <div class="admin-container">
        <div class="container-fluid">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="admin-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 style="color: #4469d8; margin: 0;">NCC Admin Panel</h2>
                                <p class="text-muted mb-0">Welcome, <?php echo $_SESSION['admin_username']; ?></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            

            
            <!-- Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3><?php echo $stats['total']; ?></h3>
                        <p>Total Applications</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card" style="background: linear-gradient(135deg, #ffc107 0%, #ff6b35 100%);">
                        <h3><?php echo $stats['pending']; ?></h3>
                        <p>Pending Review</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                        <h3><?php echo $stats['approved']; ?></h3>
                        <p>Approved</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card" style="background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);">
                        <h3><?php echo $stats['assigned']; ?></h3>
                        <p>Assigned to Batch</p>
                    </div>
                </div>
            </div>
            
            <!-- Applications Table -->
            <div class="row">
                <div class="col-12">
                    <div class="admin-card">
                        <h4 style="color: #4469d8;">Applications Management</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Branch</th>
                                        <th>Year</th>
                                        <th>Status</th>
                                        <th>Applied On</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($applications as $app): ?>
                                    <tr>
                                        <td><code><?php echo $app['registration_id']; ?></code></td>
                                        <td>
                                            <strong><?php echo $app['full_name']; ?></strong><br>
                                            <small class="text-muted"><?php echo $app['email']; ?></small>
                                        </td>
                                        <td><?php echo $app['branch']; ?></td>
                                        <td><?php echo $app['current_year']; ?></td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $app['status'] === 'pending' ? 'warning' : 
                                                    ($app['status'] === 'approved' ? 'success' : 
                                                    ($app['status'] === 'assigned' ? 'primary' : 'secondary')); 
                                            ?>">
                                                <?php echo ucfirst($app['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d M Y', strtotime($app['created_at'])); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#appModal<?php echo $app['id']; ?>">
                                                <i class="bi bi-pencil"></i> Update
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    <!-- Modal for each application -->
                                    <div class="modal fade" id="appModal<?php echo $app['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Update Application Status</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="action" value="update_status">
                                                        <input type="hidden" name="app_id" value="<?php echo $app['id']; ?>">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Application Status</label>
                                                            <select name="new_status" class="form-select" required>
                                                                <option value="pending" <?php echo $app['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                                <option value="approved" <?php echo $app['status'] === 'approved' ? 'selected' : ''; ?>>Approved</option>
                                                                <option value="rejected" <?php echo $app['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                                                                <option value="assigned" <?php echo $app['status'] === 'assigned' ? 'selected' : ''; ?>>Assigned to Batch</option>
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Assign to Batch (if status is 'assigned')</label>
                                                            <select name="batch_id" class="form-select">
                                                                <option value="">Select Batch</option>
                                                                <?php foreach ($batches as $batch): ?>
                                                                <option value="<?php echo $batch['id']; ?>" <?php echo $app['batch_id'] == $batch['id'] ? 'selected' : ''; ?>>
                                                                    <?php echo $batch['batch_name']; ?> (<?php echo $batch['current_enrollment']; ?>/<?php echo $batch['max_capacity']; ?>)
                                                                </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update Status</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Create New Batch -->
            <div class="row">
                <div class="col-md-6">
                    <div class="admin-card">
                        <h4 style="color: #4469d8;">Create New Batch</h4>
                        <form method="POST">
                            <input type="hidden" name="action" value="create_batch">
                            
                            <div class="mb-3">
                                <label class="form-label">Batch Name</label>
                                <input type="text" name="batch_name" class="form-control" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Start Date</label>
                                        <input type="date" name="start_date" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">End Date</label>
                                        <input type="date" name="end_date" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Maximum Capacity</label>
                                <input type="number" name="max_capacity" class="form-control" value="50" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-success">Create Batch</button>
                        </form>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="admin-card">
                        <h4 style="color: #4469d8;">Current Batches</h4>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Batch Name</th>
                                        <th>Dates</th>
                                        <th>Enrollment</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($batches as $batch): ?>
                                    <tr>
                                        <td><?php echo $batch['batch_name']; ?></td>
                                        <td>
                                            <?php echo date('d M', strtotime($batch['start_date'])); ?> - 
                                            <?php echo date('d M Y', strtotime($batch['end_date'])); ?>
                                        </td>
                                        <td><?php echo $batch['current_enrollment']; ?>/<?php echo $batch['max_capacity']; ?></td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $batch['status'] === 'upcoming' ? 'warning' : 
                                                    ($batch['status'] === 'active' ? 'success' : 'secondary'); 
                                            ?>">
                                                <?php echo ucfirst($batch['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Bootstrap JS -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html> 