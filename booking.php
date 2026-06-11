<?php
session_start();
include 'config/db.php';

// Checking if user is logged in
if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}

// Getting the package ID from the URL (if available)
$package_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

if(isset($_POST['confirm_booking'])){
    $user_id = $_SESSION['user_id'];
    $travel_date = $_POST['travel_date'];

    // 1. Entering the booking into the database (status as pending)
    $sql = "INSERT INTO bookings (user_id, package_id, booking_date, status) VALUES ('$user_id', '$package_id', '$travel_date', 'pending')";
    
    if(mysqli_query($conn, $sql)){
        // 2. Getting the latest Booking ID
        $last_booking_id = mysqli_insert_id($conn);

        // 3. Redirecting to the Payment page with that ID
        header("Location: payment.php?id=" . $last_booking_id);
        exit();
    } else {
        echo "<script>alert('Error: Could not complete booking.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Booking - GlobeTrek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        
        body { 
            background: #f4f7f6; 
            font-family: 'Poppins', sans-serif; 
            min-height: 100vh;
        }

        /* Navbar */
        .navbar { background: #003580; padding: 15px 0; }
        
        /* Booking Card */
        .booking-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border: none;
            max-width: 500px;
            width: 100%;
            padding: 40px;
            margin-top: 80px;
        }

        .btn-confirm {
            background: #003580;
            color: white;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            width: 100%;
            border: none;
            transition: 0.3s ease;
        }

        .btn-confirm:hover {
            background: #00b4d8;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 180, 216, 0.3);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ddd;
            margin-top: 8px;
        }

        .cancel-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .cancel-link:hover { color: #dc3545; }

        .icon-box {
            font-size: 3rem;
            color: #003580;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark shadow">
    <div class="container justify-content-center">
        <a class="navbar-brand fw-bold fs-3" href="index.php">
            <i class="bi bi-compass-fill me-2"></i>GlobeTrek
        </a>
    </div>
</nav>

<div class="container d-flex justify-content-center">
    <div class="booking-card text-center">
        <div class="icon-box">
            <i class="bi bi-calendar-check"></i>
        </div>
        <h2 class="fw-bold mb-2">Complete Your Booking</h2>
        <p class="text-muted mb-4">Please select your preferred travel date to finalize the arrangement.</p>
        
        <form method="POST">
            <div class="text-start mb-4">
                <label class="form-label small fw-bold text-muted">SELECT TRAVEL DATE</label>
                <input type="date" name="travel_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
            </div>
            
            <button type="submit" name="confirm_booking" class="btn btn-confirm shadow">
                Confirm My Booking
            </button>
            
            <a href="index.php" class="cancel-link">Cancel and Go Back</a>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>