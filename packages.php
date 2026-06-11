<?php include 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Packages - GlobeTrek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary: #003580; --accent: #00b4d8; }
        body { background-color: #f4f7f6; font-family: 'Poppins', sans-serif; }
        .navbar { background-color: var(--primary); padding: 15px 0; }
        
        .package-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            border: none;
            transition: all 0.4s ease;
            height: 100%;
        }
        .package-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .img-container {
            position: relative;
            height: 220px;
            overflow: hidden;
        }
        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .package-card:hover .img-container img { transform: scale(1.1); }
        
        .price-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255,255,255,0.9);
            padding: 5px 15px;
            border-radius: 50px;
            font-weight: bold;
            color: var(--primary);
        }
        .btn-book {
            background: var(--primary);
            color: white;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }
        .btn-book:hover { background: var(--accent); color: white; }

        /* No Results Styling */
        .no-results {
            padding: 50px;
            background: white;
            border-radius: 20px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="index.php">GlobeTrek</a>
        <div class="navbar-nav ms-auto align-items-center">
            <a class="nav-link" href="index.php">Home</a>
            <a class="nav-link active" href="packages.php">Packages</a>
            <a class="nav-link" href="contact.php">Contact</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">
            <?php 
            // If a search has been done, show it
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                echo "Search Results for: '" . htmlspecialchars($_GET['search']) . "'";
            } else {
                echo "Discover Your Next Destination";
            }
            ?>
        </h1>
        <p class="text-muted">Handpicked travel experiences for every kind of traveler.</p>
    </div>

    <div class="row g-4">
        <?php
        // PHP Logic for Search
        $sql = "SELECT * FROM packages";
        
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $s = mysqli_real_escape_string($conn, $_GET['search']);
            $sql .= " WHERE destination LIKE '%$s%' OR package_name LIKE '%$s%'";
        }

        $res = mysqli_query($conn, $sql);

        // Let's see the results
        if (mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)){
        ?>
            <div class="col-md-6 col-lg-4">
                <div class="package-card shadow-sm">
                    <div class="img-container">
                        <img src="<?php echo $row['image_url']; ?>" alt="Travel Destination">
                        <div class="price-badge">$<?php echo number_format($row['price'], 2); ?></div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-primary small fw-bold"><i class="bi bi-geo-alt-fill"></i> <?php echo strtoupper($row['destination']); ?></span>
                        </div>
                        <h4 class="fw-bold mb-3"><?php echo $row['package_name']; ?></h4>
                        <p class="text-muted small mb-4"><?php echo substr($row['description'], 0, 110); ?>...</p>
                        <div class="d-grid">
                            <a href="booking.php?id=<?php echo $row['id']; ?>" class="btn btn-book">Book This Trip <i class="bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            } 
        } else {
            // If there is no data related to the searched word
            echo '
            <div class="col-12 text-center no-results shadow-sm">
                <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                <h3 class="mt-3">Sorry, no packages found!</h3>
                <p class="text-muted">Try searching with a different destination or keyword.</p>
                <a href="packages.php" class="btn btn-outline-primary rounded-pill mt-2">View All Packages</a>
            </div>';
        }
        ?>
    </div>
</div>

<footer class="bg-dark text-white text-center py-5 mt-5">
    <div class="container">
        <p class="mb-0">&copy; 2026 GlobeTrek Adventures. Making dreams come true.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>