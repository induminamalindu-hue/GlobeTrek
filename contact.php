<?php
include 'config/db.php';
if(isset($_POST['send_inquiry'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO inquiries (name, email, message) VALUES ('$name', '$email', '$msg')";
    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Message Sent Successfully!'); window.location='contact.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - GlobeTrek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .contact-header {
            background: linear-gradient(rgba(0,53,128,0.8), rgba(0,53,128,0.8)), 
                        url('https://images.unsplash.com/photo-1523966211575-eb4a01e7dd51?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        .contact-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            border: none;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .info-box {
            background: #003580;
            color: white;
            padding: 50px;
            height: 100%;
        }
        .form-box { padding: 50px; }
        .info-item { display: flex; align-items: center; margin-bottom: 25px; }
        .info-item i { font-size: 1.5rem; margin-right: 20px; color: #00b4d8; }
        .form-control { border-radius: 10px; padding: 12px; border: 1px solid #eee; background: #fcfcfc; }
        .btn-send { background: #003580; color: white; border-radius: 10px; padding: 12px; font-weight: 600; transition: 0.3s; width: 100%; border: none; }
        .btn-send:hover { background: #00b4d8; transform: translateY(-3px); }
    </style>
</head>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-compass-fill me-2"></i>GlobeTrek</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="packages.php">Packages</a></li>
                <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
                <li class="nav-item ms-lg-3"><a class="btn btn-outline-light px-4 rounded-pill btn-sm" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>
<body>

<div class="contact-header">
    <div class="container">
        <h1 class="display-4 fw-bold">Get In Touch</h1>
        <p class="lead">Have questions? We're here to help you plan your next adventure.</p>
    </div>
</div>

<div class="container mt-n5 mb-5" style="margin-top: -50px;">
    <div class="contact-card shadow-lg">
        <div class="row g-0">
            <!-- Left Side: Info -->
            <div class="col-lg-5">
                <div class="info-box">
                    <h3 class="fw-bold mb-4">Contact Information</h3>
                    <p class="mb-5 text-light">Fill out the form and our team will get back to you within 24 hours.</p>
                    
                    <div class="info-item">
                        <i class="bi bi-geo-alt"></i>
                        <span>123 Adventure Lane, Colombo 07, Sri Lanka</span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-telephone"></i>
                        <span>+94 11 234 5678</span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-envelope"></i>
                        <span>hello@globetrek.com</span>
                    </div>
                    
                    <div class="mt-5">
                        <a href="#" class="text-white me-3 fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-3 fs-4"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Right Side: Form -->
            <div class="col-lg-7">
                <div class="form-box">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">YOUR NAME</label>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">YOUR EMAIL</label>
                                <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">MESSAGE</label>
                            <textarea name="message" class="form-control" rows="5" placeholder="How can we help you?" required></textarea>
                        </div>
                        <button type="submit" name="send_inquiry" class="btn btn-send">Send Message <i class="bi bi-send ms-2"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>