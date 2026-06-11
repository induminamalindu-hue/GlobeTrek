<?php
session_start();
include '../config/db.php'; // Database connection

// Checking if Staff is logged in
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'staff'){
    header('location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Messages - Staff Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; display: flex; margin: 0; }
        .main-content { margin-left: 280px; width: calc(100% - 280px); padding: 40px; min-height: 100vh; }
        .table-container { background: white; padding: 30px; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h2 class="fw-bold mb-1">Customer Messages</h2>
        <p class="text-muted small mb-4">View and respond to inquiries submitted by visitors.</p>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM inquiries ORDER BY id DESC";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<tr>
                                        <td>#{$row['id']}</td>
                                        <td class='fw-bold'>{$row['name']}</td>
                                        <td>{$row['email']}</td>
                                        <td><p class='mb-0 small text-muted' style='max-width: 300px;'>{$row['message']}</p></td>
                                        <td>
                                            <a href='mailto:{$row['email']}' class='btn btn-sm btn-outline-primary rounded-pill px-3'>Reply</a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center py-4 text-muted'>No messages found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>