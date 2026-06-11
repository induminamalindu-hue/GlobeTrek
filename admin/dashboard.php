<?php
session_start();
include '../config/db.php';

// Checking: Redirecting to Login if not an Admin
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    header('location:../login.php');
    exit();
}

// Retrieve data for reports
$total_users = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE user_role='customer'"));
$total_bookings = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM bookings"));
$total_packages = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM packages"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - GlobeTrek</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body { 
            background: #f8fafc; 
            font-family: 'Poppins', sans-serif; 
            margin: 0;
            padding: 0;
            color: #1e293b;
        }

        .main-content { 
            margin-left: 280px; 
            padding: 40px; 
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 40px;
            border-radius: 24px;
            color: white;
            box-shadow: 0 10px 25px rgba(30, 58, 138, 0.2);
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }

        .welcome-section::after {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        /* Stat Cards */
        .stat-card { 
            border: none; 
            border-radius: 20px; 
            padding: 25px; 
            background: #ffffff;
            transition: all 0.3s ease; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
        }
        
        .stat-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .icon-shape {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            margin-right: 20px;
            font-size: 24px;
        }

        .icon-blue { background: #dbeafe; color: #1e40af; }
        .icon-green { background: #dcfce7; color: #15803d; }
        .icon-orange { background: #ffedd5; color: #c2410c; }

        /* Overview Card */
        .overview-card {
            border: none;
            border-radius: 24px;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .overview-header {
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            padding: 25px 30px;
        }

        .btn-action {
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.2s;
        }

        @media (max-width: 992px) {
            .main-content { margin-left: 0; padding: 20px; }
            .sidebar { display: none; } /* Sidebar hidden on mobile for now */
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        
        <div class="welcome-section d-flex justify-content-between align-items-center">
            <div>
                <h1 class="fw-bold mb-2">Hello, Administrator! 👋</h1>
                <p class="mb-0 opacity-75">Welcome back to GlobeTrek. Here's a quick summary of your travel business.</p>
            </div>
            <div class="text-end">
                <div class="bg-warning text-dark px-4 py-2 rounded-pill shadow-sm fw-bold">
                    <i class="bi bi-calendar3 me-2"></i> <?php echo date('M d, Y'); ?>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="icon-shape icon-blue">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Total Customers</h6>
                        <h3 class="fw-bold mb-0"><?php echo number_format($total_users); ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="icon-shape icon-green">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Live Packages</h6>
                        <h3 class="fw-bold mb-0"><?php echo number_format($total_packages); ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="icon-shape icon-orange">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div>
                        <h6 class="text-muted fw-medium mb-1">Total Bookings</h6>
                        <h3 class="fw-bold mb-0"><?php echo number_format($total_bookings); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card overview-card mt-5">
            <div class="overview-header">
                <h5 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                    System Overview & Quick Actions
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <p class="text-muted mb-4 mb-lg-0">
                            Your dashboard is fully synchronized. Currently, the system is monitoring all bookings and packages in real-time. You can use the buttons on the right to manage your inventory or check customer requests.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="add_package.php" class="btn btn-primary btn-action me-2">
                            <i class="bi bi-plus-lg me-1"></i> New Package
                        </a>
                        <a href="view_bookings.php" class="btn btn-outline-secondary btn-action">
                            Manage All
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>