<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn() || !isPharmacy()) {
    redirect('../user/login.php');
}

// Get pharmacy statistics
$stmt = $pdo->prepare("SELECT COUNT(*) as total_prescriptions FROM prescriptions WHERE status != 'pending' OR id IN (SELECT prescription_id FROM quotations WHERE pharmacy_id = ?)");
$stmt->execute([$_SESSION['user_id']]);
$total = $stmt->fetch();

$stmt = $pdo->prepare("SELECT COUNT(*) as pending_prescriptions FROM prescriptions WHERE status = 'pending'");
$stmt->execute();
$pending = $stmt->fetch();

$stmt = $pdo->prepare("SELECT COUNT(*) as my_quotations FROM quotations WHERE pharmacy_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$quotations = $stmt->fetch();

$page_title = "Pharmacy Dashboard";
$css_path = "../css/";
$home_path = "../";
$logout_path = "../";
include '../includes/header.php';
?>

<div class="container">
    <div class="dashboard-header">
        <h1>Pharmacy Dashboard</h1>
        <p>Welcome, <?php echo $_SESSION['user_name']; ?>!</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3><?php echo $pending['pending_prescriptions']; ?></h3>
            <p>Pending Prescriptions</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $quotations['my_quotations']; ?></h3>
            <p>My Quotations</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $total['total_prescriptions']; ?></h3>
            <p>Total Processed</p>
        </div>
    </div>

    <div class="action-grid">
        <div class="action-card">
            <h3>View Prescriptions</h3>
            <p>Browse and review prescription requests from patients</p>
            <a href="./view_prescription.php" class="btn btn-primary">View Prescriptions</a>
        </div>
    </div>

    <!-- Recent prescriptions -->
    <div class="recent-section">
        <h2>Recent Prescription Requests</h2>
        <?php
        $stmt = $pdo->prepare("
            SELECT p.*, u.name as user_name, u.contact_no 
            FROM prescriptions p 
            JOIN users u ON p.user_id = u.id 
            WHERE p.status = 'pending'
            ORDER BY p.created_at DESC 
            LIMIT 5
        ");
        $stmt->execute();
        $recent = $stmt->fetchAll();
        ?>

        <?php if (empty($recent)): ?>
            <p>No new prescription requests.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>Contact</th>
                            <th>Delivery Time</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent as $prescription): ?>
                            <tr>
                                <td>#<?php echo $prescription['id']; ?></td>
                                <td><?php echo $prescription['user_name']; ?></td>
                                <td><?php echo $prescription['contact_no']; ?></td>
                                <td><?php echo $prescription['delivery_time']; ?></td>
                                <td><?php echo date('M j, Y', strtotime($prescription['created_at'])); ?></td>
                                <td>
                                    <a href="create_quotation.php?id=<?php echo $prescription['id']; ?>" class="btn btn-sm">Quote</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>