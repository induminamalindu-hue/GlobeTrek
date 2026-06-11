<?php
include 'config/db.php';
if(isset($_POST['register'])){
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($checkEmail) > 0){
        echo "<script>alert('Email already exists!');</script>";
    } else {
        $sql = "INSERT INTO users(fullname, email, password) VALUES('$name', '$email', '$pass')";
        if(mysqli_query($conn, $sql)) {
            echo "<script>alert('Account Created Successfully!'); window.location='login.php';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join GlobeTrek Adventures</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        body { background: #f0f2f5; font-family: 'Poppins', sans-serif; min-height: 100vh; }
        
        /* Navbar */
        .navbar { background: #003580; padding: 15px 0; }
        
        .register-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 0;
        }
        .register-container {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            max-width: 900px;
            width: 100%;
            display: flex;
        }
        .register-image {
            background: url('https://images.unsplash.com/photo-1503220317375-aaad61436b1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80');
            background-size: cover;
            background-position: center;
            width: 50%;
            display: none;
        }
        @media (min-width: 768px) { .register-image { display: block; } }
        
        .register-form { padding: 50px; width: 100%; }
        @media (min-width: 768px) { .register-form { width: 50%; } }

        .btn-register {
            background: #003580; color: white; border-radius: 10px;
            padding: 12px; font-weight: 600; transition: 0.3s; border: none;
        }
        .btn-register:hover { background: #002244; transform: translateY(-2px); }
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #ddd; }
    </style>
</head>
<body>

<!-- Navbar is here -->
<nav class="navbar navbar-expand-lg navbar-dark shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-compass-fill me-2"></i>GlobeTrek</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="packages.php">Packages</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item ms-lg-3"><a class="btn btn-outline-light px-4 rounded-pill btn-sm" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="register-wrapper">
    <div class="register-container">
        <div class="register-image"></div>
        <div class="register-form">
            <h2 class="fw-bold mb-2">Create Account</h2>
            <p class="text-muted mb-4 small">Join us to explore the hidden gems of the world.</p>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">FULL NAME</label>
                    <input type="text" name="fullname" class="form-control" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">EMAIL ADDRESS</label>
                    <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
                </div>
                <div class="mb-4">
                    <label class="form-label text-secondary small fw-bold">PASSWORD</label>
                    <input type="password" name="password" class="form-control" placeholder="Create a password" required>
                </div>
                <button type="submit" name="register" class="btn btn-register w-100 shadow-sm">Sign Up</button>
            </form>
            
            <p class="mt-4 text-center text-muted small">
                Already have an account? <a href="login.php" class="text-primary text-decoration-none fw-bold">Login</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>