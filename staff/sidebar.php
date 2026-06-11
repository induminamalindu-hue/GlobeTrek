<div class="sidebar">
    <div class="d-flex align-items-center mb-5">
        <i class="bi bi-compass-fill text-primary fs-3 me-3"></i>
        <h4 class="fw-800 m-0">GLOBETREK</h4>
    </div>
    
    <nav class="nav flex-column">
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
            <i class="bi bi-grid-fill me-3"></i>Overview
        </a>
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_bookings.php') ? 'active' : ''; ?>" href="manage_bookings.php">
            <i class="bi bi-calendar2-check me-3"></i>Bookings
        </a>
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'update_packages.php') ? 'active' : ''; ?>" href="update_packages.php">
            <i class="bi bi-box-seam me-3"></i>Packages
        </a>
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'messages.php') ? 'active' : ''; ?>" href="messages.php">
            <i class="bi bi-chat-left-dots me-3"></i>Messages
        </a>
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_payments.php') ? 'active' : ''; ?>" href="manage_payments.php">
            <i class="bi bi-credit-card me-3"></i>Payments History
        </a>
    </nav>

    <a href="../logout.php" class="logout-btn">Sign Out</a>
</div>

<style>
    /* The CSS related to the sidebar should be here */
    .sidebar { 
        background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
        height: 100vh; position: fixed; width: 280px; padding: 40px 25px; color: white;
        z-index: 1000;
    }
    .nav-link { 
        color: #94a3b8; padding: 15px 20px; border-radius: 16px; margin-bottom: 8px; 
        transition: 0.3s; font-weight: 500; display: flex; align-items: center; text-decoration: none;
    }
    .nav-link:hover, .nav-link.active { background: #4361ee; color: white; }
    .logout-btn { 
        position: absolute; bottom: 40px; left: 25px; right: 25px;
        border: 1px solid rgba(255,255,255,0.1); color: #ef4444; padding: 12px;
        text-align: center; border-radius: 12px; text-decoration: none; font-weight: 600;
    }
</style>