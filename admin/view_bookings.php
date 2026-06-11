<?php
session_start();
include '../config/db.php';

// Security: Checking if Admin
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    header('location:../login.php');
    exit();
}

// The logic of changing the Booking Status
if(isset($_GET['action']) && isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $new_status = mysqli_real_escape_string($conn, $_GET['action']); 
    
    $update_query = "UPDATE bookings SET status='$new_status' WHERE id='$id'";
    if(mysqli_query($conn, $update_query)){
        echo "<script>alert('Booking status updated to $new_status!'); window.location.href='view_bookings.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - GlobeTrek Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        
        body { 
            background: #f8fafc; 
            font-family: 'Poppins', sans-serif; 
            margin: 0;
        }

        .main-content { 
            margin-left: 280px; 
            padding: 40px; 
            min-height: 100vh;
        }
        
        .booking-table-card { 
            background: white; 
            border: none; 
            border-radius: 24px; 
            padding: 30px; 
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); 
        }

        /* Status Badges Styling */
        .status-badge { 
            padding: 8px 16px; 
            border-radius: 12px; 
            font-size: 0.75rem; 
            font-weight: 600; 
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending { background: #fffbeb; color: #b45309; border: 1px solid #fef3c7; }
        .status-confirmed { background: #f0fdf4; color: #15803d; border: 1px solid #dcfce7; }
        .status-cancelled { background: #fef2f2; color: #b91c1c; border: 1px solid #fee2e2; }

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
            background-color: #f1f5f9;
            transform: scale(1.002);
        }
        
        .action-btn { 
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            border-radius: 10px;
        }
        
        .action-btn:hover { transform: translateY(-2px); }

        .customer-id {
            background: #f1f5f9;
            padding: 4px 8px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold mb-1 text-dark">Travel Reservations</h2>
                <p class="text-muted small mb-0">Monitor and manage all customer bookings in real-time.</p>
            </div>
            <div class="text-end">
                <div class="bg-white px-4 py-2 rounded-4 shadow-sm border">
                    <span class="text-muted small d-block">Today's Date</span>
                    <span class="fw-600 text-primary small"><?php echo date('l, d M Y'); ?></span>
                </div>
            </div>
        </div>

        <div class="booking-table-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3 text-center">Ref ID</th>
                            <th>Customer Info</th>
                            <th>Destination Package</th>
                            <th>Booking Date</th>
                            <th>Current Status</th>
                            <th class="text-end pe-3">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT bookings.id, users.fullname, users.email, packages.package_name, bookings.booking_date, bookings.status 
                                FROM bookings 
                                JOIN users ON bookings.user_id = users.id 
                                JOIN packages ON bookings.package_id = packages.id 
                                ORDER BY bookings.id DESC";
                        $result = mysqli_query($conn, $sql);

                        if($result && mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $status = $row['status'];
                                $badge_class = "status-" . strtolower($status);
                                ?>
                                <tr>
                                    <td class="ps-3 text-center">
                                        <span class="customer-id text-primary">#<?php echo $row['id']; ?></span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark mb-0"><?php echo htmlspecialchars($row['fullname']); ?></div>
                                        <div class="text-muted" style="font-size: 0.7rem;"><?php echo htmlspecialchars($row['email']); ?></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-geo-alt-fill text-danger me-2 small"></i>
                                            <span class="fw-500 text-dark small"><?php echo htmlspecialchars($row['package_name']); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small text-secondary">
                                            <i class="bi bi-calendar-check me-1"></i> <?php echo date('Y-m-d', strtotime($row['booking_date'])); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge <?php echo $badge_class; ?>">
                                            <i class="bi bi-circle-fill" style="font-size: 6px;"></i>
                                            <?php echo ucfirst($status); ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <?php if($status == 'pending'): ?>
                                            <a href="view_bookings.php?action=confirmed&id=<?php echo $row['id']; ?>" 
                                               class="btn btn-success action-btn shadow-sm me-1" title="Approve Booking">
                                                <i class="bi bi-check-lg"></i>
                                            </a>
                                            <a href="view_bookings.php?action=cancelled&id=<?php echo $row['id']; ?>" 
                                               class="btn btn-outline-danger action-btn" title="Reject Booking">
                                                <i class="bi bi-trash3"></i>
                                            </a>
                                        <?php else: ?>
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm rounded-3 py-1 px-3 border text-muted small" type="button" disabled>
                                                    Locked
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center py-5'>
                                    <div class='py-4'>
                                        <i class='bi bi-folder-x fs-1 text-muted opacity-25'></i>
                                        <p class='text-muted mt-2'>No active bookings found in the database.</p>
                                    </div>
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