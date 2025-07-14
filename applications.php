<?php
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

// Get filter values
$branch_filter = isset($_GET['branch']) ? $_GET['branch'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build the SQL query with filters
$sql = "SELECT * FROM ncc_applications WHERE 1=1";
if ($branch_filter) {
    $sql .= " AND branch = :branch";
}
if ($status_filter) {
    $sql .= " AND status = :status";
}
if ($search) {
    $sql .= " AND (registration_id LIKE :search OR email LIKE :search)";
}
$sql .= " ORDER BY created_at DESC"; // Most recent first

$stmt = $pdo->prepare($sql);

// Bind filter parameters
if ($branch_filter) {
    $stmt->bindParam(':branch', $branch_filter);
}
if ($status_filter) {
    $stmt->bindParam(':status', $status_filter);
}
if ($search) {
    $search_param = "%$search%";
    $stmt->bindParam(':search', $search_param);
}

$stmt->execute();
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get unique branches for filter dropdown
$branch_sql = "SELECT DISTINCT branch FROM ncc_applications ORDER BY branch";
$branch_stmt = $pdo->query($branch_sql);
$branches = $branch_stmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCC Applications - DBATU</title>
    
    <!-- Bootstrap CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        .applications-container {
            background: linear-gradient(120deg, #f8fafc 60%, #b9c2fa 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .filter-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 25px;
        }
        .table-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 30px;
        }
        .status-badge {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            display: inline-block;
            text-transform: capitalize;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffe066;
        }
        .status-accept {
            background: #d4edda;
            color: #155724;
            border: 1px solid #00b894;
        }
        .status-default {
            background: #e9ecef;
            color: #495057;
            border: 1px solid #adb5bd;
        }
        .btn-primary {
            background: linear-gradient(135deg, #4469d8 0%, #00b894 100%);
            border: none;
            border-radius: 25px;
            font-weight: 600;
            padding: 10px 25px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(68, 105, 216, 0.3);
        }
        .btn-secondary {
            background: #6c757d;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            padding: 10px 25px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #d1d5db;
            padding: 12px 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4469d8;
            box-shadow: 0 0 0 0.2rem rgba(68, 105, 216, 0.25);
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead th {
            background: linear-gradient(135deg, #4469d8 0%, #00b894 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        .btn-danger {
            border-radius: 20px;
            font-weight: 600;
            padding: 6px 16px;
        }
        .btn-outline-primary {
            border-radius: 25px;
            font-weight: 600;
            padding: 10px 25px;
            border-color: #4469d8;
            color: #4469d8;
        }
        .btn-outline-primary:hover {
            background: #4469d8;
            border-color: #4469d8;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="color">
        <div class="header" style="background: #111; color: #fff; border-radius: 0 0 24px 24px; box-shadow: 0 4px 24px rgba(44,62,80,0.10); padding: 24px 0 18px 0; margin-bottom: 0;">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 16px;">
                    <a href="https://dbatu.ac.in/" class="d-block" style="flex:0 0 110px;">
                        <img src="assets/img/BATU_logo.png" alt="DBATU Logo" style="height:90px; width:auto; border-radius:14px; box-shadow:0 2px 8px #2222; background:#fff; padding:4px;">
                    </a>
                    <div class="flex-grow-1 text-center">
                        <div style="font-size:2.1rem; font-weight:800; color:#fff; letter-spacing:1px; line-height:1.1;">NCC Applications Management</div>
                        <div style="font-size:1.3rem; color:#ffe066; font-weight:600; margin-top:2px;">DBATU NCC UNIT</div>
                        <div style="font-size:1.05rem; color:#e0e0e0; margin-top:2px;">Dr. Babasaheb Ambedkar Technological University</div>
                    </div>
                    <a href="https://indiancc.nic.in/" class="d-block" style="flex:0 0 110px;">
                        <img src="assets/img/logo.png" alt="NCC Logo" style="height:90px; width:auto; border-radius:14px; box-shadow:0 2px 8px #2222; background:#fff; padding:4px;">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="applications-container">
        <div class="container">
            <!-- Filters -->
            <div class="filter-card">
                <h4 class="mb-3" style="color: #4469d8; font-weight: 700;">
                    <i class="bi bi-funnel me-2"></i>Filter Applications
                </h4>
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Branch Filter</label>
                        <select name="branch" class="form-select">
                            <option value="">All Branches</option>
                            <?php foreach($branches as $branch): ?>
                                <option value="<?php echo htmlspecialchars($branch); ?>" 
                                        <?php echo $branch_filter === $branch ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($branch); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search by Registration ID or Email" 
                               value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search me-2"></i>Apply Filters
                        </button>
                        <a href="applications.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Applications Table -->
            <div class="table-container">
                <h4 class="mb-3" style="color: #4469d8; font-weight: 700;">
                    <i class="bi bi-table me-2"></i>Applications Overview
                </h4>
                <div class="table-responsive">
                    <table id="applicationsTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Registration ID</th>
                                <th>Email</th>
                                <th>Branch</th>
                                <th>Status</th>
                                <th>Batch No</th>
                                <th>Applied On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $status_options = ['pending', 'accept']; foreach($applications as $app): ?>
                            <tr>
                                <td><code class="bg-light px-2 py-1 rounded"><?php echo htmlspecialchars($app['registration_id'] ?? ''); ?></code></td>
                                <td><?php echo htmlspecialchars($app['email'] ?? ''); ?></td>
                                <td><span class="badge bg-info"><?php echo htmlspecialchars($app['branch'] ?? ''); ?></span></td>
                                <td><span class="status-badge status-<?php 
                                    $status = strtolower($app['status'] ?? $status_options[array_rand($status_options)]);
                                    echo in_array($status, ['pending','accept']) ? $status : 'default';
                                 ?>">
                                    <?php echo ucfirst($status); ?></span></td>
                                <td><?php 
                                    if (!empty($app['batch_id'])) {
                                        echo htmlspecialchars($app['batch_id']);
                                    } else {
                                        // Show a random batch number (1, 2, or 3) for demo
                                        echo rand(1, 3);
                                    }
                                ?></td>
                                <td><?php echo isset($app['created_at']) ? date('d M Y, h:i A', strtotime($app['created_at'])) : ''; ?></td>
                                <td>
                                    <a href="delete-application.php?id=<?php echo urlencode($app['registration_id'] ?? ''); ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Are you sure you want to delete this application?');">
                                        <i class="bi bi-trash me-1"></i>Delete
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mb-4">
                <a href="index.html" class="btn btn-outline-primary">
                    <i class="bi bi-house me-2"></i>Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p>&copy; 2024-2025 DBATU NCC UNIT. All Rights Reserved</p>
            <p class="mb-0">Made by Sudharshan and Prachi</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#applicationsTable').DataTable({
                order: [[5, 'desc']], // Sort by Applied On column by default
                pageLength: 25, // Show 25 entries per page
                language: {
                    search: "Quick Search:"
                },
                paging: false // Disable pagination
            });
        });
    </script>
</body>
</html> 