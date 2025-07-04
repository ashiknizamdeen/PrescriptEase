<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if ($_POST) {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = sanitize($_POST['address']);
    $contact_no = sanitize($_POST['contact_no']);
    $dob = $_POST['dob'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, address, contact_no, dob, user_type) VALUES (?, ?, ?, ?, ?, ?, 'pharmacy')");
        $stmt->execute([$name, $email, $password, $address, $contact_no, $dob]);

        $success = "Pharmacy registration successful! You can now login.";
    } catch (PDOException $e) {
        $error = "Email already exists or registration failed.";
    }
}

$page_title = "Pharmacy Registration";
$css_path = "../css/";
$home_path = "../";
include '../includes/header.php';
?>

<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Pharmacy Registration</h1>

            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label>Pharmacy Name</label>
                    <input type="text" name="name" placeholder="Pharmacy Name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group password-input">
                    <div class="password-header">
                        <label for="password">Password</label>
                    </div>
                    <input type="password" name="password" placeholder="Enter Password" required>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea name="address" rows="3" placeholder="Pharmacy Address" required></textarea>
                </div>

                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="tel" name="contact_no" placeholder="Contact Number" required>
                </div>

                <div class="form-group">
                    <label>Establishment Date</label>
                    <input type="date" name="dob" required>
                </div>

                <button type="submit" class="login-button">Register Pharmacy</button>
            </form>

            <div class="register-link">
                Already have an account? <a href="../pharmacy/login.php">Login</a>
            </div>
        </div>

        <footer class="login-footer">
            &copy; <?php echo date('Y'); ?> Medical Prescription System
        </footer>
    </div>
</body>