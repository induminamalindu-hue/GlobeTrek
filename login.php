<?php
session_start();
include 'config/db.php';

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Checking the user's email address
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        
        // Checking the password (compared to a hashed password)
        if(password_verify($password, $row['password'])){
            
            // Saving data in the session

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['fullname'];
            $_SESSION['user_role'] = $row['user_role']; 

            // Redirecting to the relevant page based on the user's role
            if($row['user_role'] == 'admin'){
                header('location: admin/dashboard.php');
            } elseif($row['user_role'] == 'staff'){
                header('location: staff/dashboard.php');
            } else {
                header('location: index.php');
            }
            exit(); 
            // --------------------------------------------------------

        } else {
            echo "<script>alert('Invalid Password!');</script>";
        }
    } else {
        echo "<script>alert('No user found with this email!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GlobeTrek Adventures</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        body { background: #f0f2f5; font-family: 'Poppins', sans-serif; min-height: 100vh; }
        
        /* Simple Navbar */
        .navbar { background: #003580; padding: 15px 0; }

        .login-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 0;
        }
        .login-container {
            background: #fff;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 900px;
            width: 100%;
            display: flex;
        }
        .login-image {
            background: url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            width: 50%;
            display: none;
        }
        @media (min-width: 768px) { .login-image { display: block; } }
        
        .login-form { padding: 60px; width: 100%; }
        @media (min-width: 768px) { .login-form { width: 50%; } }

        .btn-login {
            background: #003580; color: white; border-radius: 12px;
            padding: 14px; font-weight: 600; transition: 0.3s; border: none;
            width: 100%;
        }
        .btn-login:hover { background: #00b4d8; }
        .form-control { border-radius: 12px; padding: 12px; border: 1px solid #eee; background: #f8f9fa; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="index.php"><i class="bi bi-compass-fill me-2"></i>GlobeTrek</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="packages.php">Packages</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item ms-lg-3"><a class="btn btn-light px-4 rounded-pill btn-sm fw-bold" href="register.php">Register</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="login-wrapper">
    <div class="login-container">
        <div class="login-image"></div>
        <div class="login-form text-center">
            <h2 class="fw-bold mb-3">Welcome Back!</h2>
            <p class="text-muted mb-5">Login to continue your adventure.</p>
            
            <form method="POST">
                <div class="mb-4 text-start">
                    <label class="form-label small fw-bold text-muted">EMAIL</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <div class="mb-5 text-start">
                    <label class="form-label small fw-bold text-muted">PASSWORD</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>
                <button type="submit" name="login" class="btn btn-login mb-4">Login</button>
            </form>
            
            <p class="text-muted small">
                New to GlobeTrek? <a href="register.php" class="text-primary text-decoration-none fw-bold">Create Account</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>