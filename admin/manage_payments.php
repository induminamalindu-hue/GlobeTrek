<?php
include '../config/db.php'; // Database සම්බන්ධතාවය
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payments | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc; 
            margin: 0;
            display: flex;
        }

        /* දකුණු පැත්තේ ප්‍රධාන කොටස */
        .main-content {
            margin-left: 280px; /* Sidebar එකේ පළලට අනුව මෙය වෙනස් කරන්න */
            width: 100%;
            padding: 40px;
            min-height: 100vh;
        }

        .table-container { 
            background: white; 
            padding: 30px; 
            border-radius: 24px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.03); 
            border: none;
        }

        .status-badge { 
            padding: 6px 14px; 
            border-radius: 50px; 
            font-size: 13px; 
            font-weight: 600; 
        }

        .bg-success-light { 
            background-color: #d1e7dd; 
            color: #0f5132; 
        }

        .table thead th {
            background-color: #f8fafc;
            border-bottom: none;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding: 15px;
        }

        .table tbody td {
            padding: 20px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            font-weight: 500;
        }

        .payment-id {
            color: #003580;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Payment History</h2>
                    <p class="text-muted small mb-0">Monitor and manage all incoming customer payments.</p>
                </div>
                <a href="dashboard.php" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Booking ID</th>
                            <th>Amount (USD)</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetching all payments from the database
                        $sql = "SELECT * FROM payments ORDER BY payment_id DESC";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td><span class='payment-id'>#PAY-" . $row['payment_id'] . "</span></td>";
                                echo "<td>#BK-" . $row['booking_id'] . "</td>";
                                echo "<td class='fw-bold'>$" . number_format($row['amount'], 2) . "</td>";
                                echo "<td><i class='bi bi-credit-card me-2 text-muted'></i>" . $row['payment_method'] . "</td>";
                                echo "<td><span class='status-badge bg-success-light text-capitalize'>" . $row['payment_status'] . "</span></td>";
                                echo "<td class='text-muted' style='font-size: 14px;'>" . date('M d, Y | h:i A', strtotime($row['payment_date'])) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center py-5 text-muted'>No payment records found.</td></tr>";
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