<?php
session_start();
include '../config/db.php';

// Checking if Admin
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    header('location:../login.php');
    exit();
}

// Getting the admin's ID from the session
$admin_id = $_SESSION['user_id'] ?? 0; 

// Fetching the admin's current details from the database
$query = "SELECT * FROM users WHERE id = '$admin_id'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Handling profile update form submission
if(isset($_POST['update_profile'])){
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    $update_sql = "UPDATE users SET fullname='$fullname', email='$email' WHERE id='$admin_id'";
    
    if(mysqli_query($conn, $update_sql)){
        echo "<script>alert('Profile updated successfully!'); window.location.href='admin_profile.php';</script>";
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile - GlobeTrek</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body { 
            background: #f8fafc; 
            font-family: 'Poppins', sans-serif; 
            margin: 0; 
            color: #1e293b;
        }

        .main-content { 
            margin-left: 280px; 
            padding: 40px; 
            min-height: 100vh; 
        }
        
        .profile-container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Profile Header Design */
        .profile-header-card {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            height: 200px;
            border-radius: 24px 24px 0 0;
            position: relative;
            box-shadow: 0 10px 25px -5px rgba(30, 58, 138, 0.2);
        }

        .profile-img-wrapper {
            position: absolute;
            bottom: -60px;
            left: 50px;
            z-index: 10;
        }

        .profile-img {
            width: 140px;
            height: 140px;
            border-radius: 30px;
            border: 6px solid white;
            background: white;
            object-fit: cover;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        /* Profile Body Design */
        .profile-content-card {
            background: white;
            padding: 80px 50px 50px 50px;
            border-radius: 0 0 24px 24px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .form-label { 
            font-weight: 600; 
            color: #475569; 
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 12px;
            padding: 14px 18px;
            background: #fcfdfe;
            border: 1.5px solid #e2e8f0;
            transition: all 0.3s;
        }

        .form-control:focus {
            background: white;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .input-group-text {
            background: #fcfdfe;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: #64748b;
        }

        .input-group .form-control {
            border-left: none;
        }

        .btn-update {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            border: none;
            border-radius: 12px;
            padding: 14px 35px;
            font-weight: 600;
            color: white;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(37, 99, 235, 0.3);
            color: white;
        }

        .badge-admin {
            background: #dbeafe;
            color: #1e40af;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold mb-1">Account Settings</h2>
                <p class="text-muted small">Manage your personal information and security settings.</p>
            </div>
        </div>

        <div class="profile-container">
            <div class="profile-header-card">
                <div class="profile-img-wrapper">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($admin['fullname']); ?>&background=3b82f6&color=fff&size=128&bold=true" 
                         alt="Admin" class="profile-img">
                </div>
            </div>

            <div class="profile-content-card">
                <div class="d-flex justify-content-between align-items-end mb-5">
                    <div>
                        <h3 class="fw-bold text-dark mb-2"><?php echo htmlspecialchars($admin['fullname'] ?? 'Administrator'); ?></h3>
                        <span class="badge-admin">Verified Administrator</span>
                    </div>
                </div>

                <form method="POST">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" name="fullname" class="form-control" 
                                       value="<?php echo htmlspecialchars($admin['fullname'] ?? ''); ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" name="email" class="form-control" 
                                       value="<?php echo htmlspecialchars($admin['email'] ?? ''); ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">System Privileges</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                                <input type="text" class="form-control bg-light" value="Full Access Control" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Internal Admin ID</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                <input type="text" class="form-control bg-light" value="GT-ADMIN-0<?php echo $admin['id'] ?? '0'; ?>" readonly>
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                            <button type="submit" name="update_profile" class="btn btn-update">
                                <i class="bi bi-arrow-clockwise me-2"></i> Update Profile Information
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>