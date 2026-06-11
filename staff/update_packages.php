<?php
session_start();
include '../config/db.php';

// Checking if Staff is logged in
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'staff'){
    header('location:../login.php');
    exit();
}

// Handling package updates
if(isset($_POST['save_update'])){
    $p_id = $_POST['package_id'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    
    $sql = "UPDATE packages SET price='$price', duration='$duration' WHERE id='$p_id'";
    if(mysqli_query($conn, $sql)){
        echo "<script>
                alert('Success! Package updated successfully.');
                window.location.href='update_packages.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Packages | GlobeTrek Staff</title>
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

        /* Glass Card & Table Design */
        .glass-card {
            background: white; border-radius: 24px; border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03); padding: 30px;
        }

        .table thead th {
            background: #f8fafc; color: #64748b; font-weight: 700;
            text-transform: uppercase; font-size: 0.75rem; border: none; padding: 20px;
        }

        .custom-input {
            border: 2px solid #f1f5f9; border-radius: 12px; padding: 8px 12px;
            font-weight: 600; transition: 0.3s;
        }

        .custom-input:focus {
            border-color: var(--primary); box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1); outline: none;
        }

        .btn-save {
            background: var(--primary); color: white; border: none; border-radius: 12px;
            padding: 10px 20px; font-weight: 700; transition: 0.3s;
        }

        .btn-save:hover { background: #3730a3; transform: translateY(-2px); }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="d-flex align-items-center mb-5">
        <i class="bi bi-compass-fill text-primary fs-3 me-3"></i>
        <h4 class="fw-800 m-0 text-white">GLOBETREK</h4>
    </div>
    
    <nav class="nav flex-column">
        <a class="nav-link" href="dashboard.php"><i class="bi bi-grid-fill me-3"></i>Overview</a>
        <a class="nav-link" href="manage_bookings.php"><i class="bi bi-calendar2-check me-3"></i>Bookings</a>
        <a class="nav-link active" href="update_packages.php"><i class="bi bi-box-seam me-3"></i>Packages</a>
        <a class="nav-link" href="messages.php"><i class="bi bi-chat-left-dots me-3"></i>Messages</a>
        <a class="nav-link" href="manage_payments.php"><i class="bi bi-credit-card me-3"></i>Payments History</a>
    </nav>

    <a href="../logout.php" class="logout-btn">Sign Out</a>
</div>

<div class="main-content">
    <div class="mb-5">
        <h1 class="fw-800 mb-1">Travel Packages</h1>
        <p class="text-muted">Customize and update travel pricing and durations directly from here.</p>
    </div>

    <div class="glass-card">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Package Identity</th>
                        <th>Price (USD)</th>
                        <th>Duration</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM packages");
                    while($row = mysqli_fetch_assoc($res)){
                    ?>
                    <form method="POST">
                        <tr>
                            <td>
                                <span class="fw-bold d-block text-dark"><?php echo $row['package_name']; ?></span>
                                <small class="text-muted">ID: #TRV-0<?php echo $row['id']; ?></small>
                            </td>
                            <td>
                                <div class="input-group" style="max-width: 150px;">
                                    <span class="input-group-text bg-light border-0 text-muted">$</span>
                                    <input type="number" name="price" class="form-control custom-input" value="<?php echo $row['price']; ?>" required>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <input type="text" name="duration" class="form-control custom-input me-2" style="max-width: 100px;" value="<?php echo $row['duration']; ?>" required>
                                    <span class="text-muted small fw-bold">DAYS</span>
                                </div>
                            </td>
                            <td class="text-end">
                                <input type="hidden" name="package_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="save_update" class="btn btn-save">
                                    <i class="bi bi-arrow-repeat me-2"></i>Update
                                </button>
                            </td>
                        </tr>
                    </form>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>