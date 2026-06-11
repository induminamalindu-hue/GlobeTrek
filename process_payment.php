<?php
session_start();
include 'config/db.php';

// Checking if the customer is logged in
if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}

if(isset($_POST['submit_payment'])){
    // Taking the data from the form into variables
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $status = "Success"; 

    // Creating a unique number (Transaction ID) for each payment
    // This completely eliminates the Duplicate Entry Error
    $transaction_id = "TRX" . time() . rand(10, 99);

    // Query to enter data into the database
    // Here we also include the transaction_id column
    $sql = "INSERT INTO payments (booking_id, amount, payment_method, payment_status, transaction_id) 
            VALUES ('$booking_id', '$amount', '$method', '$status', '$transaction_id')";

    if(mysqli_query($conn, $sql)){
        // Displaying a message after successfully entering data
        echo "<script>
                alert('Payment Successful! Thank you for booking with GlobeTrek.');
                window.location.href='index.php';
              </script>";
    } else {
        // If something goes wrong, take care of it (eg if a column name is wrong).
        echo "<div style='color:red; padding:20px; background:#fff;'>";
        echo "<h4>Error occurred while processing payment:</h4>";
        echo "mysqli_error: " . mysqli_error($conn);
        echo "</div>";
    }
} else {
    // An attempt to access this page directly redirects to the home page
    header('location:index.php');
    exit();
}
?>