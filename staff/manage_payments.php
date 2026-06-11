<?php
session_start();
include '../config/db.php';

// Checking if Staff is logged in
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'staff'){
    header('location: ../login.php');
    exit();
}

// Retrieving payment statistics and details from the database
$stats_query = "SELECT 
    COUNT(*) as total_payments,
    SUM(amount) as total_revenue
FROM payments";
$stats_result = mysqli_query($conn, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);

// Fetching all payment details (JOINing with bookings and users)
// Note: This query joins the payments table with bookings and users
$query = "SELECT p.*, b.booking_date, u.fullname 
          FROM payments p
          JOIN bookings b ON p.booking_id = b.id
          JOIN users u ON b.user_id = u.id
          ORDER BY p.payment_date DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Records - Staff Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc; 
            display: flex;
            margin: 0;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 280px;
            width: calc(100% - 280px);
            padding: 40px;
            min-height: 100vh;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        }

        .table-container { 
            background: white; 
            padding: 30px; 
            border-radius: 24px; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.03); 
        }

        .status-badge { 
            padding: 6px 14px; 
            border-radius: 50px; 
            font-size: 13px; 
            font-weight: 600;
            background-color: #d1e7dd;
            color: #0f5132;
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h2 class="fw-bold mb-4">Payment Management</h2>

        <div class="row mb-4">
            <div class="col-md-6 col-lg-4">
                <div class="stat-card">
                    <span class="text-muted small fw-bold">TOTAL TRANSACTIONS</span>
                    <h2 class="fw-bold text-primary mb-0"><?php echo $stats['total_payments']; ?></h2>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="stat-card">
                    <span class="text-muted small fw-bold">TOTAL REVENUE</span>
                    <h2 class="fw-bold text-success mb-0">$<?php echo number_format($stats['total_revenue'] ?? 0, 2); ?></h2>
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Transaction ID</th>
                            <th>Customer</th>
                            <th>Booking ID</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($result) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><code class="fw-bold"><?php echo $row['transaction_id']; ?></code></td>
                                    <td><span class="fw-semibold"><?php echo $row['fullname']; ?></span></td>
                                    <td><span class="badge bg-light text-dark">#BK-<?php echo $row['booking_id']; ?></span></td>
                                    <td class="fw-bold text-dark">$<?php echo number_format($row['amount'], 2); ?></td>
                                    <td><i class="bi bi-credit-card me-2 text-muted"></i><?php echo $row['payment_method']; ?></td>
                                    <td><span class="status-badge text-capitalize"><?php echo $row['payment_status']; ?></span></td>
                                    <td class="text-muted small"><?php echo date('M d, Y | h:i A', strtotime($row['payment_date'])); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No payment records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>