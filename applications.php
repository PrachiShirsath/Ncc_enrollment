<?php session_start(); ?>
<?php
$is_admin = (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true);
// Connect to the database and fetch all applications from ncc_applications
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
$applications = $pdo->query("SELECT * FROM ncc_applications ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>All Applications</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(90deg, #e0f7fa 0%, #b2ebf2 50%, #c8e6c9 100%);
            font-family: 'Montserrat', Arial, sans-serif;
            min-height: 100vh;
        }
        .main-card {
            background: rgba(255,255,255,0.98);
            border-radius: 28px;
            box-shadow: 0 8px 32px 0 rgba(31,38,135,0.13);
            padding: 0 0 32px 0;
            max-width: 1200px;
            margin: 56px auto 32px auto;
            overflow: hidden;
        }
        .card-header-bar {
            background: linear-gradient(90deg, #3a8dde 0%, #1de9b6 100%);
            padding: 36px 40px 24px 40px;
            border-radius: 28px 28px 0 0;
            box-shadow: 0 2px 12px rgba(44,62,80,0.08);
        }
        .main-title {
            font-size: 2.2rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 1px;
            margin-bottom: 0;
            text-shadow: 0 2px 8px #2222;
        }
        .accent-bar {
            height: 6px;
            width: 80px;
            background: linear-gradient(90deg, #ffe066 0%, #00b894 100%);
            border-radius: 8px;
            margin: 18px 0 0 0;
        }
        .table-responsive {
            padding: 32px 40px 0 40px;
        }
        .table {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 0;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table thead th {
            background: #e3eafe;
            color: #4469d8;
            font-weight: 700;
            border-bottom: 2px solid #b2ebf2;
        }
        .table tbody tr {
            transition: background 0.18s;
        }
        .table tbody tr:hover {
            background: #e0f7fa;
        }
        .btn-delete {
            background: linear-gradient(90deg, #e53935 0%, #ffb300 100%);
            color: #fff;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(229,57,53,0.10);
            transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .btn-delete:hover {
            background: linear-gradient(90deg, #b71c1c 0%, #ffb300 100%);
            box-shadow: 0 6px 24px rgba(229,57,53,0.18);
            transform: translateY(-2px) scale(1.04);
        }
        .reg-id {
            color:#e91e63;
            font-weight:600;
            font-size: 1.08rem;
            letter-spacing: 0.5px;
        }
        @media (max-width: 900px) {
            .main-card { max-width: 98vw; }
            .card-header-bar, .table-responsive { padding: 18px 4vw 0 4vw; }
        }
        @media (max-width: 600px) {
            .main-card { padding: 0; }
            .card-header-bar, .table-responsive { padding: 12px 2vw 0 2vw; }
            .main-title { font-size: 1.1rem; }
        }
    </style>
</head>
<body>
  <!-- Login/Logout Button Top Right -->
  <div style="position: fixed; top: 18px; right: 32px; z-index: 2000;">
    <?php if ($is_admin): ?>
      <a href="logout.php" class="btn btn-primary">Logout</a>
    <?php else: ?>
      <a href="login.php" class="btn btn-secondary">Login</a>
    <?php endif; ?>
  </div>
<div class="main-card">
    <div class="card-header-bar">
        <div class="main-title"><i class="bi bi-list-ul"></i> All Applications</div>
        <div class="accent-bar"></div>
    </div>
    <div class="table-responsive">
        <table id="appsTable" class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>Registration ID</th>
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
                    <td class="reg-id"><?= htmlspecialchars($app['registration_id']) ?></td>
                    <td><?= htmlspecialchars($app['full_name']) ?></td>
                    <td><?= htmlspecialchars($app['branch']) ?></td>
                    <td><?= htmlspecialchars($app['current_year']) ?></td>
                    <td>
                        <form method="POST" action="change-status.php" style="display:inline-block;">
                            <input type="hidden" name="registration_id" value="<?= htmlspecialchars($app['registration_id']) ?>">
                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm d-inline-block w-auto" style="vertical-align:middle;">
                                <option value="pending" <?= $app['status']==='pending'?'selected':'' ?>>Pending</option>
                                <option value="approved" <?= $app['status']==='approved'?'selected':'' ?>>Approved</option>
                                <option value="rejected" <?= $app['status']==='rejected'?'selected':'' ?>>Rejected</option>
                                <option value="assigned" <?= $app['status']==='assigned'?'selected':'' ?>>Assigned</option>
                            </select>
                        </form>
                    </td>
                    <td><?= date('d M Y, h:i A', strtotime($app['created_at'])) ?></td>
                    <td>
                        <a href="delete-application.php?id=<?= urlencode($app['registration_id']) ?>" class="btn btn-delete btn-sm" onclick="return confirm('Are you sure you want to delete this application?');"><i class="bi bi-trash"></i> Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#appsTable').DataTable();
});
</script>
</body>
</html>
