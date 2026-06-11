<?php
include 'config/db.php';

// Getting the booking_id from the URL
$booking_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

// If a booking ID is available, fetch the corresponding amount from the database
$amount = "0.00";
if($booking_id > 0) {
    // Join the bookings and packages tables to get the price
    $query = "SELECT p.price FROM bookings b 
              JOIN packages p ON b.package_id = p.id 
              WHERE b.id = '$booking_id'";
    
    $result = mysqli_query($conn, $query);
    if($row = mysqli_fetch_assoc($result)) {
        $amount = $row['price'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | GlobeTrek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap');
        body { background-color: #f4f7f6; font-family: 'Plus Jakarta Sans', sans-serif; padding-top: 50px; }
        .payment-card { 
            max-width: 500px; 
            margin: auto; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
            background: white; 
            border: none;
        }
        .btn-pay {
            background: #003580;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
            transition: 0.3s;
        }
        .btn-pay:hover { background: #00255a; transform: translateY(-2px); }
        .price-display {
            background: #eef2f7;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="payment-card">
        <div class="text-center mb-4">
            <i class="bi bi-shield-lock-fill text-primary" style="font-size: 2.5rem;"></i>
            <h2 class="fw-bold mt-2">Secure Checkout</h2>
            <p class="text-muted small">Please complete your payment to finalize the booking.</p>
        </div>

        <div class="price-display">
            <span class="text-muted d-block small uppercase fw-bold">TOTAL PAYABLE</span>
            <h2 class="fw-bold text-primary mb-0">$ <?php echo number_format($amount, 2); ?></h2>
        </div>

        <form action="process_payment.php" method="POST">
            <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
            
            <input type="hidden" name="amount" value="<?php echo $amount; ?>">

            <div class="mb-3">
                <label class="form-label fw-bold small">Payment Method</label>
                <select name="method" class="form-select form-control-lg">
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small">Card Number</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-credit-card"></i></span>
                    <input type="text" class="form-control" placeholder="0000 0000 0000 0000" maxlength="19" required>
                </div>
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label fw-bold small">Expiry Date</label>
                    <input type="text" class="form-control" placeholder="MM/YY" required>
                </div>
                <div class="col-6 mb-4">
                    <label class="form-label fw-bold small">CVV</label>
                    <input type="password" class="form-control" placeholder="***" maxlength="3" required>
                </div>
            </div>

            <button type="submit" name="submit_payment" class="btn btn-primary btn-pay w-100">
                Confirm & Pay $<?php echo number_format($amount, 2); ?>
            </button>
            
            <p class="text-center mt-3 text-muted" style="font-size: 0.8rem;">
                <i class="bi bi-lock-fill"></i> Your payment information is encrypted and secure.
            </p>
        </form>
    </div>
</div>

</body>
</html>