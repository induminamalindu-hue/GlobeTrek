<?php
session_start();
include '../config/db.php';

// Checking if Admin
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    header('location:../login.php');
    exit();
}

if(isset($_POST['add_trip'])){
    $name  = mysqli_real_escape_string($conn, $_POST['p_name']);
    $dest  = mysqli_real_escape_string($conn, $_POST['p_dest']);
    $price = mysqli_real_escape_string($conn, $_POST['p_price']);
    $desc  = mysqli_real_escape_string($conn, $_POST['p_desc']);

//SQL query to insert new package into the database 
    $sql = "INSERT INTO packages(package_name, destination, price, description)
            VALUES('$name', '$dest', '$price', '$desc')";

    if(mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Package added successfully!');
                window.location.href='dashboard.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Travel Package - GlobeTrek</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            background: #f8fafc;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            min-height: 100vh;
        }

        .main-content {
            margin-left: 280px; 
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .package-card {
            width: 100%;
            max-width: 650px;
            background: #ffffff;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .title { 
            font-size: 32px; 
            font-weight: 700; 
            color: #1e3a8a; 
            margin-bottom: 5px;
        }
        
        .subtitle { 
            color: #64748b; 
            margin-bottom: 35px; 
            font-size: 15px; 
        }
        
        .form-label { 
            font-weight: 600; 
            color: #475569; 
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .form-control {
            height: 55px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            background: #fcfdfe;
            padding-left: 15px;
            transition: all 0.3s ease;
        }

        textarea.form-control { 
            height: 120px; 
            resize: none; 
            padding-top: 15px; 
        }

        .form-control:focus {
            background: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .input-group-text {
            border: 1.5px solid #e2e8f0;
            border-radius: 12px 0 0 12px;
            background: #f1f5f9;
            color: #64748b;
        }

        .btn-publish {
            height: 55px;
            border-radius: 12px;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-publish:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(37, 99, 235, 0.3);
            color: white;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: #dbeafe;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #1e40af;
        }

        .btn-back {
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            color: #64748b;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background: #f1f5f9;
            color: #1e293b;
        }
    </style>
</head>
<body>
 
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="package-card">
            <div class="icon-box text-primary">
                <i class="bi bi-plus-square-fill"></i>
            </div>

            <h1 class="title">Add New Package</h1>
            <p class="subtitle">Enter the details below to create a new adventure for your travelers.</p>

            <form method="POST">
                <div class="mb-4">
                    <label class="form-label">Package Name</label>
                    <input type="text" name="p_name" class="form-control" placeholder="e.g. Dreamy Maldives Escape" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Destination</label>
                    <input type="text" name="p_dest" class="form-control" placeholder="e.g. Male, Maldives" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Price Per Person ($)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                        <input type="number" name="p_price" class="form-control" placeholder="0.00" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Description</label>
                    <textarea name="p_desc" class="form-control" placeholder="Describe the highlights and itinerary..." required></textarea>
                </div>

                <div class="d-grid gap-3">
                    <button type="submit" name="add_trip" class="btn btn-publish">
                        <i class="bi bi-check-circle-fill me-2"></i> Publish Trip
                    </button>
                    
                    <a href="dashboard.php" class="btn btn-back text-decoration-none">
                        <i class="bi bi-x-circle me-2"></i> Discard and Go Back
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>