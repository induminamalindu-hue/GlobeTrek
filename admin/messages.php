<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
    header('location:../login.php');
    exit();
}

if(isset($_GET['delete']) && is_numeric($_GET['delete'])){
    $delete_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM inquiries WHERE id = $delete_id");
    header('location: messages.php');
    exit();
}

$messages_result = mysqli_query($conn, "SELECT * FROM inquiries ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Messages | GlobeTrek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: #f4f7fe; font-family: 'Poppins', sans-serif; margin: 0; }
        .main-content { margin-left: 280px; padding: 40px; min-height: 100vh; }
        .message-card { background: white; border-radius: 20px; padding: 30px; box-shadow: 0 15px 40px rgba(0,0,0,0.05); }
        .table thead th { background: #eef6ff; border-bottom: none; text-transform: uppercase; letter-spacing: 0.03em; font-size: 0.8rem; }
        .message-text { max-width: 400px; white-space: pre-wrap; word-break: break-word; }
        .empty-state { color: #64748b; }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h2 class="fw-bold mb-1">Customer Messages</h2>
                <p class="text-muted small">Review inquiries sent through the contact page.</p>
            </div>
            <div class="bg-white p-3 rounded-3 shadow-sm text-center">
                <i class="bi bi-chat-left-text text-primary fs-4"></i>
                <div class="small text-muted">Total messages</div>
                <div class="fw-bold fs-5"><?php echo ($messages_result ? mysqli_num_rows($messages_result) : 0); ?></div>
            </div>
        </div>

        <div class="message-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($messages_result && mysqli_num_rows($messages_result) > 0): ?>
                            <?php while($msg = mysqli_fetch_assoc($messages_result)): ?>
                                <tr>
                                    <td>#<?php echo $msg['id']; ?></td>
                                    <td><?php echo htmlspecialchars($msg['name']); ?></td>
                                    <td><?php echo htmlspecialchars($msg['email']); ?></td>
                                    <td class="message-text text-muted small"><?php echo nl2br(htmlspecialchars($msg['message'])); ?></td>
                                    <td class="text-end">
                                        <a href="messages.php?delete=<?php echo $msg['id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Delete this message?');">
                                            <i class="bi bi-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 empty-state">
                                    <i class="bi bi-inbox fs-1 mb-3"></i>
                                    <div>No messages found.</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
