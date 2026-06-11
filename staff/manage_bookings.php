<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'staff'){
    header('location:../login.php');
    exit();
}

if(isset($_GET['id']) && isset($_GET['status'])){
    $id = $_GET['id'];
    $st = $_GET['status'];
    mysqli_query($conn, "UPDATE bookings SET status='$st' WHERE id='$id'");
    header("Location: manage_bookings.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings | GlobeTrek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        :root {
            --primary: #4361ee;
            --bg-light: #f8faff;
        }

        body { background: var(--bg-light); font-family: 'Plus Jakarta Sans', sans-serif; display: flex; margin: 0; }

        /* Sidebar Styles */
        .sidebar { 
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            height: 100vh; position: fixed; width: 280px; padding: 40px 25px; color: white;
            z-index: 1000;
        }

        .main-content { margin-left: 280px; padding: 50px; width: calc(100% - 280px); }

        .nav-link { 
            color: #94a3b8; padding: 15px 20px; border-radius: 16px; margin-bottom: 8px; 
            transition: 0.3s; font-weight: 500; display: flex; align-items: center; text-decoration: none;
        }

        .nav-link:hover, .nav-link.active { background: var(--primary); color: white; }

        .logout-btn { 
            position: absolute; bottom: 40px; left: 25px; right: 25px;
            border: 1px solid rgba(255,255,255,0.1); color: #ef4444; padding: 12px;
            text-align: center; border-radius: 12px; text-decoration: none; font-weight: 600;
        }

        /* Booking Card Styles */
        .booking-card { 
            background: white; border-radius: 20px; border: none; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.02); transition: 0.3s; 
            margin-bottom: 15px; overflow: hidden; 
        }
        
        .booking-card:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(0,0,0,0.05); }

        .status-badge { padding: 6px 14px; border-radius: 10px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
        .status-confirmed { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef9c3; color: #854d0e; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }

        .btn-approve { background: var(--primary); color: white; border-radius: 10px; font-weight: 600; padding: 8px 20px; border: none; }
        .btn-cancel { border-radius: 10px; font-weight: 600; padding: 8px 20px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="d-flex align-items-center mb-5">
        <i class="bi bi-compass-fill text-primary fs-3 me-3"></i>
        <h4 class="fw-800 m-0">GLOBETREK</h4>
    </div>
    
    <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php"><i class="bi bi-grid-fill me-3"></i>Overview</a>
        <a class="nav-link active" href="manage_bookings.php"><i class="bi bi-calendar2-check me-3"></i>Bookings</a>
        <a class="nav-link" href="update_packages.php"><i class="bi bi-box-seam me-3"></i>Packages</a>
        <a class="nav-link" href="messages.php"><i class="bi bi-chat-left-dots me-3"></i>Messages</a>
        <a class="nav-link" href="manage_payments.php"><i class="bi bi-credit-card me-3"></i>Payments History</a>
    </nav>

    <a href="../logout.php" class="logout-btn">Sign Out</a>
</div>

<div class="main-content">
    <div class="mb-5">
        <h1 class="fw-800 mb-1">Bookings Hub</h1>
        <p class="text-muted">Manage all customer travel reservations from your panel.</p>
    </div>

    <?php
    $sql = "SELECT bookings.*, users.fullname, packages.package_name 
            FROM bookings 
            JOIN users ON bookings.user_id = users.id 
            JOIN packages ON bookings.package_id = packages.id
            ORDER BY bookings.id DESC";
    $res = mysqli_query($conn, $sql);
    
    while($row = mysqli_fetch_assoc($res)){
        $stClass = 'status-pending';
        if($row['status'] == 'confirmed') $stClass = 'status-confirmed';
        if($row['status'] == 'cancelled') $stClass = 'status-cancelled';
    ?>
    <div class="booking-card">
        <div class="row align-items-center p-4">
            <div class="col-md-1 fw-bold text-muted">#<?php echo $row['id']; ?></div>
            <div class="col-md-3">
                <div class="small text-muted mb-1">Customer</div>
                <div class="fw-700"><?php echo strtoupper($row['fullname']); ?></div>
            </div>
            <div class="col-md-3">
                <div class="small text-muted mb-1">Package</div>
                <div class="fw-600 text-primary"><?php echo $row['package_name']; ?></div>
            </div>
            <div class="col-md-2">
                <span class="status-badge <?php echo $stClass; ?>"><?php echo $row['status']; ?></span>
            </div>
            <div class="col-md-3 text-end">
                <?php if($row['status'] != 'confirmed'): ?>
                    <a href="?id=<?php echo $row['id']; ?>&status=confirmed" class="btn btn-approve btn-sm me-1">Approve</a>
                <?php endif; ?>
                <?php if($row['status'] != 'cancelled'): ?>
                    <a href="?id=<?php echo $row['id']; ?>&status=cancelled" class="btn btn-outline-danger btn-sm btn-cancel">Cancel</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

</body>
</html>