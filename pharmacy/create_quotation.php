<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn() || !isPharmacy()) {
    redirect('../user/login.php');
}

$prescription_id = $_GET['id'];

if ($_POST) {
    $drugs = $_POST['drug'];
    $quantities = $_POST['quantity'];
    $unit_prices = $_POST['unit_price'];
    $total_amount = 0;

    try {
        for ($i = 0; $i < count($drugs); $i++) {
            $total_amount += $quantities[$i] * $unit_prices[$i];
        }

        $stmt = $pdo->prepare("INSERT INTO quotations (prescription_id, pharmacy_id, total_amount) VALUES (?, ?, ?)");
        $stmt->execute([$prescription_id, $_SESSION['user_id'], $total_amount]);

        $quotation_id = $pdo->lastInsertId();

        for ($i = 0; $i < count($drugs); $i++) {
            if (!empty($drugs[$i])) {
                $total_price = $quantities[$i] * $unit_prices[$i];
                $stmt = $pdo->prepare("INSERT INTO quotation_items (quotation_id, drug_name, quantity, unit_price, total_price) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$quotation_id, $drugs[$i], $quantities[$i], $unit_prices[$i], $total_price]);
            }
        }

        $stmt = $pdo->prepare("UPDATE prescriptions SET status = 'quoted' WHERE id = ?");
        $stmt->execute([$prescription_id]);

        $stmt = $pdo->prepare("SELECT u.email FROM prescriptions p JOIN users u ON p.user_id = u.id WHERE p.id = ?");
        $stmt->execute([$prescription_id]);
        $user = $stmt->fetch();

        $subject = "New Quotation Available";
        $message = "A new quotation has been prepared for your prescription. Please check your account.";
        sendEmail($user['email'], $subject, $message);

        redirect('view_prescription.php');
    } catch (PDOException $e) {
        $error = "Failed to create quotation.";
    }
}

$stmt = $pdo->prepare("SELECT * FROM prescriptions WHERE id = ?");
$stmt->execute([$prescription_id]);
$prescription = $stmt->fetch();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create Quotation</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>Create Quotation for Prescription #<?php echo $prescription_id; ?></h2>

        <form method="POST" id="quotationForm">
            <div id="drugItems">
                <div class="drug-item">
                    <input type="text" name="drug[]" placeholder="Drug Name" required>
                    <input type="number" name="quantity[]" placeholder="Quantity" min="1" required>
                    <input type="number" step="0.01" name="unit_price[]" placeholder="Unit Price" min="0" required>
                    <button type="button" onclick="removeDrug(this)">Remove</button>
                </div>
            </div>

            <button type="button" onclick="addDrug()">Add Drug</button>
            <button type="submit">Send Quotation</button>
        </form>
    </div>

    <script>
        function addDrug() {
            const drugItems = document.getElementById('drugItems');
            const newItem = document.createElement('div');
            newItem.className = 'drug-item';
            newItem.innerHTML = `
                <input type="text" name="drug[]" placeholder="Drug Name" required>
                <input type="number" name="quantity[]" placeholder="Quantity" min="1" required>
                <input type="number" step="0.01" name="unit_price[]" placeholder="Unit Price" min="0" required>
                <button type="button" onclick="removeDrug(this)">Remove</button>
            `;
            drugItems.appendChild(newItem);
        }

        function removeDrug(button) {
            if (document.querySelectorAll('.drug-item').length > 1) {
                button.parentElement.remove();
            }
        }
    </script>
</body>

</html>