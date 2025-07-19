<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Track NCC Application - DBATU</title>
    
    <!-- Bootstrap CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        .tracking-container {
            background: linear-gradient(120deg, #f8fafc 60%, #b9c2fa 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .tracking-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 25px;
        }
        .status-badge {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-approved { background: #d4edda; color: #155724; }
        .status-rejected { background: #f8d7da; color: #721c24; }
        .status-assigned { background: #cce5ff; color: #004085; }
        .batch-info {
            background: linear-gradient(135deg, #4469d8 0%, #00b894 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-top: 20px;
        }
        .search-form {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .recent-applications {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 40px;
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
        .form-control {
            border-radius: 10px;
            border: 1px solid #d1d5db;
            padding: 12px 15px;
        }
        .form-control:focus {
            border-color: #4469d8;
            box-shadow: 0 0 0 0.2rem rgba(68, 105, 216, 0.25);
        }
        .input-group-text {
            background: #4469d8;
            color: white;
            border: none;
            border-radius: 10px 0 0 10px;
        }
        .alert {
            border-radius: 10px;
            border: none;
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
                        <div style="font-size:2.1rem; font-weight:800; color:#fff; letter-spacing:1px; line-height:1.1;">Track Your NCC Application</div>
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

    <div class="tracking-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Search Form -->
                    <div class="search-form mb-4">
                        <h3 class="text-center mb-4" style="color: #4469d8; font-weight: 700;">
                            <i class="bi bi-search me-2"></i>Track Your Application
                        </h3>
                        <form id="trackForm" method="GET" action="applications.php" class="text-center">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">
                                            <i class="bi bi-card-text"></i>
                                        </span>
                                        <input type="text" name="search" class="form-control form-control-lg" 
                                               placeholder="Enter your Registration ID" required>
                                        <button type="submit" class="btn btn-primary btn-lg px-4">
                                            <i class="bi bi-search me-2"></i>Track
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Registration ID Format Info -->
                    <div class="alert alert-info text-center" role="alert" style="font-size:1.08rem; margin-bottom: 1.5rem;">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Registration ID Format:</strong> <span style="font-family:monospace;">DBATU/NCC/BRANCH/YEAR/NUMBER</span><br>
                        <span style="font-size:0.98rem; color:#4469d8;">Example: <span style="font-family:monospace;">DBATU/NCC/CSE/2024/001</span></span>
                    </div>

                    <?php
                    // Database connection
                    $host = 'localhost';
                    $dbname = 'ncc_dbatu1';
                    $username = 'root';
                    $password = '';

                    try {
                        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch(PDOException $e) {
                        die("Connection failed: " . $e->getMessage());
                    }

                    // Get the registration ID from the URL
                    $registration_id = $_GET['id'] ?? '';

                    // MOCK DATA (replace with DB query in real use)
                    $mock_data = [
                        'DBATU/NCC/CSE/2024/001' => [
                            'name' => 'Rahul Sharma',
                            'batch' => 'NCC Batch 2024-01'
                        ],
                        'DBATU/NCC/MECH/2024/001' => [
                            'name' => 'Amit Kumar',
                            'batch' => 'NCC Batch 2024-02'
                        ],
                        // Add more mock entries as needed
                    ];

                    $showNoMatch = false;
                    if (isset($mock_data[$registration_id])) {
                        $student = $mock_data[$registration_id];
                        ?>
                        <div class="tracking-card">
                            <h4 class="mb-3" style="color: #4469d8; font-weight: 700;">
                                <i class="bi bi-check-circle me-2"></i>Application Found
                            </h4>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Registration ID</th>
                                            <th>Batch</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo htmlspecialchars($student['name']); ?></td>
                                            <td><code class="bg-light px-2 py-1 rounded"><?php echo htmlspecialchars($registration_id); ?></code></td>
                                            <td><span class="badge bg-success"><?php echo htmlspecialchars($student['batch']); ?></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                    } else if ($registration_id) {
                        $showNoMatch = true;
                    }
                    ?>
                    <?php if ($showNoMatch): ?>
                        <div class="alert alert-warning text-center" role="alert" style="font-size:1.15rem; margin-top: 1.5rem;">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            No application found for this Registration ID.
                        </div>
                    <?php endif; ?>
                    
                </div>
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

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#recentApplicationsTable').DataTable({
                order: [[5, 'desc']], // Sort by Applied On column by default
                pageLength: 10,
                searching: false, // Disable search
                lengthChange: false, // Disable page length options
                info: false // Disable showing table info
            });
        });
    </script>
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html> 