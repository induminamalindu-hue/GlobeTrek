<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlobeTrek Adventures | Explore the World</title>
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        body { font-family: 'Poppins', sans-serif; overflow-x: hidden; }

        /* Navbar */
        .navbar { background: #003580; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }

        /* Navigation Search Strip */
        .search-strip {
            background: #f1f4f8;
            padding: 15px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .search-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .search-input-group {
            display: flex;
            background: white;
            border-radius: 50px;
            overflow: hidden;
            border: 1px solid #cbd5e0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .search-input-group input {
            border: none;
            padding: 10px 25px;
            flex-grow: 1;
            font-size: 0.95rem;
        }

        .search-input-group input:focus { outline: none; }

        .search-btn {
            background: #00b4d8;
            color: white;
            border: none;
            padding: 0 30px;
            font-weight: 600;
            transition: 0.3s;
        }

        .search-btn:hover { background: #0077b6; }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), 
                        url('https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            height: 70vh; /* සර්ච් එක අයින් කරපු නිසා උස ටිකක් අඩු කළා */
            display: flex;
            align-items: center;
            color: white;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
        }

        .hero h1 { font-size: 4rem; font-weight: 700; }

        .btn-explore {
            background: #00b4d8; color: white; border: none;
            padding: 12px 40px; border-radius: 50px; font-weight: 600;
            transition: 0.3s ease;
        }
        .btn-explore:hover { background: white; color: #003580; transform: scale(1.05); }

        /* Features Section */
        .feat-card {
            border: none; border-radius: 20px; transition: 0.4s;
            background: #f8f9fa; padding: 30px;
        }
        .feat-card:hover { transform: translateY(-10px); background: #fff; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .feat-icon { font-size: 3rem; color: #00b4d8; margin-bottom: 20px; }

        /* CTA Section */
        .cta-box {
            background: #003580; color: white; border-radius: 30px; padding: 60px;
            text-align: center; margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="bi bi-compass-fill me-2"></i>GlobeTrek</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="packages.php">Packages</a></li>
                <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item ms-lg-3"><a class="btn btn-outline-light px-4 rounded-pill" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Search Strip (Exactly below Nav) -->
<div class="search-strip">
    <div class="container">
        <div class="search-container">
            <form action="packages.php" method="GET" class="search-input-group shadow-sm">
                <span class="d-flex align-items-center ps-3 text-muted">
                    <i class="bi bi-geo-alt-fill"></i>
                </span>
                <input type="text" name="search" placeholder="Search your dream destination (e.g. Ella, Bali, London)" required>
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>
    </div>
</div>

<!-- Hero Section -->
<section class="hero">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="mb-4">Nature's Best <span style="color: #00b4d8;">Awaits You</span></h1>
                <p class="lead fs-4 mb-4">Escape the ordinary and dive into breathtaking landscapes across the globe.</p>
                <a href="packages.php" class="btn btn-explore shadow-lg">Start Your Journey <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Stats / Services -->
<section class="py-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="feat-card h-100">
                    <i class="bi bi-shield-check feat-icon"></i>
                    <h3>Safe Travel</h3>
                    <p class="text-muted">We prioritize your safety with certified guides and secure bookings.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feat-card h-100">
                    <i class="bi bi-map feat-icon"></i>
                    <h3>Unique Paths</h3>
                    <p class="text-muted">Explore destinations that are off the beaten track and truly unique.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feat-card h-100">
                    <i class="bi bi-wallet2 feat-icon"></i>
                    <h3>Best Value</h3>
                    <p class="text-muted">Premium experiences at prices that make traveling accessible to all.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<div class="container mb-5">
    <div class="cta-box shadow-lg">
        <h2 class="display-5 fw-bold mb-3">Ready for your next trip?</h2>
        <p class="mb-4 fs-5">Sign up today and get 10% off on your first international booking!</p>
        <a href="register.php" class="btn btn-light btn-lg px-5 rounded-pill fw-bold" style="color: #003580;">Join Now</a>
    </div>
</div>

<footer class="py-4 text-center text-muted border-top">
    <p>&copy; 2026 GlobeTrek Adventures. Designed for Explorers.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>