<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Medical Prescription System'; ?></title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-brand">Medical Prescription System</a>
            <div class="nav-menu">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['user_type'] === 'pharmacy'): ?>
                        <a href="../pharmacy/dashboard.php" class="nav-link">Dashboard</a>
                        <a href="../pharmacy/view_prescription.php" class="nav-link">Prescriptions</a>
                    <?php else: ?>
                        <a href="../user/dashboard.php" class="nav-link">Dashboard</a>
                        <a href="../user/upload_prescription.php" class="nav-link">Upload Prescription</a>
                        <a href="../user/view_quotations.php" class="nav-link">My Quotations</a>
                    <?php endif; ?>
                    <a href="../logout.php" class="nav-link">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="main-content">