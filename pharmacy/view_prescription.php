<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn() || !isPharmacy()) {
    redirect('../user/login.php');
}

$stmt = $pdo->prepare("
    SELECT p.*, u.name as user_name, u.email, u.contact_no 
    FROM prescriptions p 
    JOIN users u ON p.user_id = u.id 
    ORDER BY p.created_at DESC
");
$stmt->execute();
$prescriptions = $stmt->fetchAll();

include '../includes/header.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Prescriptions</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>Prescription Requests</h2>

        <?php foreach ($prescriptions as $prescription): ?>
            <div class="prescription-card">
                <h3>Prescription #<?php echo $prescription['id']; ?></h3>
                <p><strong>Patient:</strong> <?php echo $prescription['user_name']; ?></p>
                <p><strong>Contact:</strong> <?php echo $prescription['contact_no']; ?></p>
                <p><strong>Delivery Address:</strong> <?php echo $prescription['delivery_address']; ?></p>
                <p><strong>Delivery Time:</strong> <?php echo $prescription['delivery_time']; ?></p>
                <p><strong>Note:</strong> <?php echo $prescription['note']; ?></p>
                <p><strong>Status:</strong> <?php echo ucfirst($prescription['status']); ?></p>

                <!-- Display prescription images -->
                <?php
                $stmt = $pdo->prepare("SELECT * FROM prescription_images WHERE prescription_id = ?");
                $stmt->execute([$prescription['id']]);
                $images = $stmt->fetchAll();
                ?>

                <div class="prescription-images">
                    <?php foreach ($images as $image): ?>
                        <img src="<?php echo $image['image_path']; ?>" alt="Prescription" style="max-width: 200px; margin: 5px;">
                    <?php endforeach; ?>
                </div>

                <?php if ($prescription['status'] === 'pending'): ?>
                    <a href="create_quotation.php?id=<?php echo $prescription['id']; ?>" class="btn">Create Quotation</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>

<?php include '../includes/footer.php'; ?>