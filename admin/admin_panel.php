<?php
include '../config/db.php';
// Get details of all bookings, users and packages
$sql = "SELECT users.fullname, packages.package_name, bookings.booking_date, bookings.status 
        FROM bookings 
        JOIN users ON bookings.user_id = users.id 
        JOIN packages ON bookings.package_id = packages.id";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - GlobeTrek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Admin Dashboard - All Bookings</h2>
    <table class="table table-bordered shadow">
        <thead class="table-primary">
            <tr>
                <th>Customer Name</th>
                <th>Package</th>
                <th>Travel Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td><?php echo $row['fullname']; ?></td>
                <td><?php echo $row['package_name']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>