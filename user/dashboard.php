<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$stmt = $pdo->prepare("SELECT COUNT(*) as total_prescriptions FROM prescriptions WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$stats = $stmt->fetch();

$stmt = $pdo->prepare("SELECT COUNT(*) as pending_quotations FROM quotations q JOIN prescriptions p ON q.prescription_id = p.id WHERE p.user_id = ? AND q.status = 'pending'");
$stmt->execute([$_SESSION['user_id']]);
$pending = $stmt->fetch();

$page_title = "User Dashboard";
$css_path = "../css/";
$home_path = "../";
$logout_path = "../";
include '../includes/header.php';
?>

<div class="container">
    <div class="dashboard-header">
        <h1>Welcome, <?php echo $_SESSION['user_name']; ?>!</h1>
        <p>Manage your prescriptions and quotations</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3><?php echo $stats['total_prescriptions']; ?></h3>
            <p>Total Prescriptions</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $pending['pending_quotations']; ?></h3>
            <p>Pending Quotations</p>
        </div>
    </div>

    <div class="action-grid">
        <div class="action-card">
            <h3>Upload New Prescription</h3>
            <p>Upload your prescription images and get quotes from pharmacies</p>
            <a href="upload_prescription.php" class="btn btn-primary">Upload Prescription</a>
        </div>

        <div class="action-card">
            <h3>View Quotations</h3>
            <p>Check and manage quotations received from pharmacies</p>
            <a href="view_quotation.php" class="btn btn-secondary">View Quotations</a>
        </div>
    </div>

    <div class="recent-section">
        <h2>Recent Prescriptions</h2>
        <?php
        $stmt = $pdo->prepare("SELECT * FROM prescriptions WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
        $stmt->execute([$_SESSION['user_id']]);
        $recent = $stmt->fetchAll();
        ?>

        <?php if (empty($recent)): ?>
            <p>No prescriptions uploaded yet. <a href="upload_prescription.php">Upload your first prescription</a></p>
        <?php else: ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Delivery Address</th>
                            <th>Delivery Time</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent as $prescription): ?>
                            <tr>
                                <td>#<?php echo $prescription['id']; ?></td>
                                <td><?php echo substr($prescription['delivery_address'], 0, 50) . '...'; ?></td>
                                <td><?php echo $prescription['delivery_time']; ?></td>
                                <td><span class="status status-<?php echo $prescription['status']; ?>"><?php echo ucfirst($prescription['status']); ?></span></td>
                                <td><?php echo date('M j, Y', strtotime($prescription['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>