<div class="sidebar d-flex flex-column">
    <div class="sidebar-header p-4">
        <h4 class="text-white fw-bold m-0"><i class="bi bi-globe-americas me-2"></i>GlobeTrek</h4>
    </div>

    <div class="nav flex-column px-3 flex-grow-1">
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
            <i class="bi bi-grid-fill me-2"></i> Dashboard
        </a>
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'add_package.php') ? 'active' : ''; ?>" href="add_package.php">
            <i class="bi bi-plus-circle-fill me-2"></i> Add Packages
        </a>
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'view_bookings.php') ? 'active' : ''; ?>" href="view_bookings.php">
            <i class="bi bi-calendar-event-fill me-2"></i> Manage Bookings
        </a>
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_customers.php') ? 'active' : ''; ?>" href="manage_customers.php">
            <i class="bi bi-people-fill me-2"></i> Manage Customers
        </a>
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'admin_profile.php') ? 'active' : ''; ?>" href="admin_profile.php">
            <i class="bi bi-person-circle me-2"></i> Profile
        </a>
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'messages.php') ? 'active' : ''; ?>" href="messages.php">
            <i class="bi bi-chat-dots-fill me-2"></i> Messages
        </a>
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_payments.php') ? 'active' : ''; ?>" href="manage_payments.php">
            <i class="bi bi-credit-card-fill me-2"></i> Payments History
        </a>
    </div>

    <div class="p-3 mt-auto border-top border-white-10">
        <a href="../logout.php" class="logout-link d-flex align-items-center">
            <i class="bi bi-box-arrow-right me-2"></i> Sign Out
        </a>
    </div>
</div>

<style>
    .sidebar {
        width: 280px;
        height: 100vh;
        background: #1e3a8a;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        overflow-y: auto; /* To scroll if there are many links */
    }

    .nav-link {
        color: rgba(255, 255, 255, 0.7) !important;
        padding: 12px 18px;
        border-radius: 12px;
        margin-bottom: 5px;
        transition: 0.3s;
        font-size: 0.95rem;
    }

    .nav-link:hover, .nav-link.active {
        background: rgba(255, 255, 255, 0.15);
        color: white !important;
    }

    .nav-link.active {
        background: #3b82f6;
    }

    .logout-link {
        color: #fca5a5;
        text-decoration: none;
        padding: 15px;
        width: 100%;
        display: block;
        font-weight: 500;
        transition: 0.3s;
    }

    .logout-link:hover {
        color: #f87171;
        background: rgba(239, 68, 68, 0.1);
        border-radius: 10px;
    }

    /* To beautify the scrollbar */
    .sidebar::-webkit-scrollbar { width: 5px; }
    .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }
</style>