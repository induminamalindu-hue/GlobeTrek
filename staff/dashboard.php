<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'staff'){ 
    header('location:../login.php'); 
    exit(); 
}

// Retrieving the actual data from the database
// 1. Number of Total Bookings
$total_bookings_query = mysqli_query($conn, "SELECT id FROM bookings");
$total_bookings = mysqli_num_rows($total_bookings_query);

// 2. Number of Active Packages
$total_packages_query = mysqli_query($conn, "SELECT id FROM packages");
$total_packages = mysqli_num_rows($total_packages_query);

// 3. Number of Pending Bookings
$pending_bookings_query = mysqli_query($conn, "SELECT id FROM bookings WHERE status='pending'");
$pending_bookings = mysqli_num_rows($pending_bookings_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Insights | GlobeTrek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        :root {
            --primary: #4361ee;
            --bg-light: #f8faff;
        }

        body { background: var(--bg-light); font-family: 'Plus Jakarta Sans', sans-serif; }

        .sidebar { 
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            height: 100vh; position: fixed; width: 280px; padding: 40px 25px; color: white;
        }

        .main-content { margin-left: 280px; padding: 50px; }

        .nav-link { 
            color: #94a3b8; padding: 15px 20px; border-radius: 16px; margin-bottom: 8px; 
            transition: 0.3s; font-weight: 500; display: flex; align-items: center; text-decoration: none;
        }

        .nav-link:hover, .nav-link.active { background: var(--primary); color: white; }

        .stat-card { 
            background: white; border-radius: 24px; padding: 35px; border: none; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.03); transition: 0.4s;
        }

        .stat-icon {
            width: 55px; height: 55px; border-radius: 15px; display: flex;
            align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 20px;
        }

        .icon-blue { background: #e0e7ff; color: #4361ee; }
        .icon-purple { background: #f3e8ff; color: #9333ea; }
        .icon-orange { background: #ffedd5; color: #f97316; }

        .logout-btn { 
            position: absolute; bottom: 40px; left: 25px; right: 25px;
            border: 1px solid rgba(255,255,255,0.1); color: #ef4444; padding: 12px;
            text-align: center; border-radius: 12px; text-decoration: none; font-weight: 600;
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="mb-5">
        <h1 class="fw-800">Dashboard Overview</h1>
        <p class="text-muted">Real-time statistics from your database.</p>
    </div>

    <div class="row g-4">
        <!-- Total Bookings -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon icon-blue"><i class="bi bi-journal-text"></i></div>
                <div class="text-muted small fw-bold text-uppercase">Total Bookings</div>
                <h2 class="fw-800 m-0"><?php echo $total_bookings; ?></h2>
            </div>
        </div>
        
        <!-- Active Packages -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon icon-purple"><i class="bi bi-images"></i></div>
                <div class="text-muted small fw-bold text-uppercase">Active Packages</div>
                <h2 class="fw-800 m-0"><?php echo $total_packages; ?></h2>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon icon-orange"><i class="bi bi-clock-history"></i></div>
                <div class="text-muted small fw-bold text-uppercase">Pending Bookings</div>
                <h2 class="fw-800 m-0 text-danger"><?php echo $pending_bookings; ?></h2>
            </div>
        </div>
    </div>
</div>

</body>
</html>