<?php
include 'config/db.php'; // Database connection 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery | GlobeTrek Adventures</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap');
        
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
        
        .gallery-header {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('images/Sunny Maldives.jpg');
            background-size: cover;
            background-position: center;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 50px;
        }

        .gallery-item {
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: 0.3s ease-in-out;
            position: relative;
            background: #fff;
            height: 300px;
        }

        .gallery-item:hover { transform: translateY(-10px); }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .img-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: white;
            padding: 20px;
            opacity: 0;
            transition: 0.3s;
        }

        .gallery-item:hover .img-overlay { opacity: 1; }

        .nav-custom { background: #003580; padding: 15px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark nav-custom">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">GlobeTrek</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="index.php">Home</a>
            <a class="nav-link active" href="gallery.php">Gallery</a>
        </div>
    </div>
</nav>

<div class="gallery-header text-center">
    <h1 class="display-4 fw-bold">Global Destinations</h1>
</div>

<div class="container">
    <div class="row">
        <?php
        // Here is the query according to the column names in your database
        $res = mysqli_query($conn, "SELECT * FROM gallery ORDER BY image_id DESC");
        
        if(mysqli_num_rows($res) > 0){
            while($row = mysqli_fetch_assoc($res)){
        ?>
            <div class="col-md-4 col-sm-6">
                <div class="gallery-item">
                    <img src="images/<?php echo $row['image_url']; ?>" alt="<?php echo $row['image_title']; ?>">
                    
                    <div class="img-overlay">
                        <h5 class="fw-bold m-0"><?php echo $row['image_title']; ?></h5>
                        <p class="small m-0"><?php echo !empty($row['category']) ? $row['category'] : 'Destination'; ?></p>
                    </div>
                </div>
            </div>
        <?php 
            }
        } else {
            echo '<div class="col-12 text-center py-5">
                    <p class="mt-3 text-muted">No images found in your gallery yet.</p>
                  </div>';
        }
        ?>
    </div>
</div>

<footer class="text-center py-5 text-muted">
    <p>&copy; 2026 GlobeTrek Adventures. Crafted by Malindu.</p>
</footer>

</body>
</html>