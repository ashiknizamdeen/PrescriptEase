<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

if ($_POST) {
    $quotation_id = $_POST['quotation_id'];
    $action = $_POST['action'];

    $status = ($action === 'accept') ? 'accepted' : 'rejected';

    // Update quotation status
    $stmt = $pdo->prepare("UPDATE quotations SET status = ? WHERE id = ?");
    $stmt->execute([$status, $quotation_id]);

    $stmt = $pdo->prepare("
        SELECT u.email FROM quotations q 
        JOIN users u ON q.pharmacy_id = u.id 
        WHERE q.id = ?
    ");
    $stmt->execute([$quotation_id]);
    $pharmacy = $stmt->fetch();

    $subject = "Quotation " . ucfirst($status);
    $message = "Your quotation has been " . $status . " by the customer.";
    sendEmail1($pharmacy['email'], $subject, $message);

    $success = "Quotation " . $status . " successfully!";
}

// Fetch user's quotations
$stmt = $pdo->prepare("
    SELECT q.*, p.id as prescription_id 
    FROM quotations q 
    JOIN prescriptions p ON q.prescription_id = p.id 
    WHERE p.user_id = ? 
    ORDER BY q.created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$quotations = $stmt->fetchAll();
include '../includes/header.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Quotations</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>My Quotations</h2>

        <?php if (isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php foreach ($quotations as $quotation): ?>
            <div class="quotation-card">
                <h3>Quotation for Prescription #<?php echo $quotation['prescription_id']; ?></h3>
                <p><strong>Total Amount:</strong> $<?php echo number_format($quotation['total_amount'], 2); ?></p>
                <p><strong>Status:</strong> <?php echo ucfirst($quotation['status']); ?></p>
                <p><strong>Date:</strong> <?php echo date('Y-m-d H:i', strtotime($quotation['created_at'])); ?></p>

                <!-- Display quotation items -->
                <?php
                $stmt = $pdo->prepare("SELECT * FROM quotation_items WHERE quotation_id = ?");
                $stmt->execute([$quotation['id']]);
                $items = $stmt->fetchAll();
                ?>

                <table>
                    <tr>
                        <th>Drug</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?php echo $item['drug_name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['unit_price'], 2); ?></td>
                            <td>$<?php echo number_format($item['total_price'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <?php if ($quotation['status'] === 'pending'): ?>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="quotation_id" value="<?php echo $quotation['id']; ?>">
                        <button type="submit" name="action" value="accept" class="btn-accept">Accept</button>
                        <button type="submit" name="action" value="reject" class="btn-reject">Reject</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>