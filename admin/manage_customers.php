<?php
session_start();
include '../config/db.php';

// Checking if Admin
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    header('location:../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers - GlobeTrek Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        
        body { 
            background: #f8fafc; 
            font-family: 'Poppins', sans-serif; 
            margin: 0;
            color: #1e293b;
        }

        .main-content { 
            margin-left: 280px; 
            padding: 40px; 
            min-height: 100vh;
        }
        
        .customer-card { 
            background: white; 
            border: none; 
            border-radius: 24px; 
            padding: 30px; 
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); 
        }

        /* Avatar Styling */
        .user-avatar { 
            width: 48px; 
            height: 48px; 
            background: linear-gradient(135deg, #3b82f6 0%, #1e3a8a 100%); 
            color: white; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            border-radius: 14px; 
            font-weight: 600; 
            font-size: 1.2rem;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        }

        /* Table Styling */
        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1px;
            padding: 15px;
            border: none;
        }

        .table tbody tr {
            transition: all 0.2s;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .customer-count-badge {
            background: #dbeafe;
            color: #1e40af;
            font-weight: 600;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
        }

        .btn-details {
            border: 1.5px solid #e2e8f0;
            background: white;
            color: #475569;
            font-weight: 500;
            padding: 6px 20px;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .btn-details:hover {
            background: #f1f5f9;
            color: #1e293b;
            border-color: #cbd5e1;
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold mb-1 text-dark">Customer Directory</h2>
                <p class="text-muted small mb-0">Browse and manage all registered members of GlobeTrek.</p>
            </div>
            <div>
                <span class="customer-count-badge">
                    <i class="bi bi-people-fill me-1"></i> Active Users
                </span>
            </div>
        </div>

        <div class="customer-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Ref</th>
                            <th>Customer Profile</th>
                            <th>Email Contact</th>
                            <th>Registration Date</th>
                            <th class="text-end pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetching all customers from the database
                        $sql = "SELECT * FROM users WHERE user_role = 'customer' ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                ?>
                                <tr>
                                    <td class="ps-3">
                                        <span class="text-muted small fw-bold">#<?php echo $row['id']; ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">
                                                <?php echo strtoupper(substr($row['fullname'], 0, 1)); ?>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark"><?php echo htmlspecialchars($row['fullname']); ?></div>
                                                <div class="text-muted" style="font-size: 0.75rem;">Verified Member</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark small fw-500"><?php echo htmlspecialchars($row['email']); ?></div>
                                    </td>
                                    <td>
                                        <div class="text-secondary small">
                                            <i class="bi bi-calendar3 me-1"></i> 
                                            <?php echo isset($row['created_at']) ? date('Y-m-d', strtotime($row['created_at'])) : '2026-05-12'; ?>
                                        </div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-details btn-sm">
                                            <i class="bi bi-eye me-1"></i> Details
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center py-5 text-muted'>
                                    <i class='bi bi-people fs-1 d-block mb-2 opacity-25'></i>
                                    No customers registered yet.
                                  </td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>