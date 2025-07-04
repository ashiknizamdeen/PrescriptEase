<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

if ($_POST) {
    $note = sanitize($_POST['note']);
    $delivery_address = sanitize($_POST['delivery_address']);
    $delivery_time = sanitize($_POST['delivery_time']);

    try {
        // Insert prescription
        $stmt = $pdo->prepare("INSERT INTO prescriptions (user_id, note, delivery_address, delivery_time) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $note, $delivery_address, $delivery_time]);

        $prescription_id = $pdo->lastInsertId();

        // Handle file uploads
        $upload_dir = '../uploads/prescriptions/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
            if ($_FILES['images']['error'][$i] === 0) {
                $file_name = time() . '_' . $_FILES['images']['name'][$i];
                $file_path = $upload_dir . $file_name;

                if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $file_path)) {
                    $stmt = $pdo->prepare("INSERT INTO prescription_images (prescription_id, image_path) VALUES (?, ?)");
                    $stmt->execute([$prescription_id, $file_path]);
                }
            }
        }

        $success = "Prescription uploaded successfully!";
    } catch (PDOException $e) {
        $error = "Upload failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Upload Prescription</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>Upload Prescription</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Prescription Images (Max 5):</label>
            <input type="file" name="images[]" multiple accept="image/*" max="5" required>

            <label>Note:</label>
            <textarea name="note" placeholder="Additional notes"></textarea>

            <label>Delivery Address:</label>
            <textarea name="delivery_address" placeholder="Delivery address" required></textarea>

            <label>Delivery Time:</label>
            <select name="delivery_time" required>
                <option value="">Select Time Slot</option>
                <option value="8:00 AM - 10:00 AM">8:00 AM - 10:00 AM</option>
                <option value="10:00 AM - 12:00 PM">10:00 AM - 12:00 PM</option>
                <option value="12:00 PM - 2:00 PM">12:00 PM - 2:00 PM</option>
                <option value="2:00 PM - 4:00 PM">2:00 PM - 4:00 PM</option>
                <option value="4:00 PM - 6:00 PM">4:00 PM - 6:00 PM</option>
                <option value="6:00 PM - 8:00 PM">6:00 PM - 8:00 PM</option>
            </select>

            <button type="submit">Upload Prescription</button>
        </form>

        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>

</html>