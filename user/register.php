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
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, address, contact_no, dob) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $address, $contact_no, $dob]);
        $success = "Registration successful! Please login.";
    } catch (PDOException $e) {
        $error = "Email already exists or registration failed.";
    }
}

include '../includes/header.php';
?>

<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Register</h1>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" required placeholder="Enter your name">
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" required placeholder="Enter your email">
                </div>

                <div class="form-group password-input">
                    <div class="password-header">
                        <label for="password">Password</label>
                    </div>
                    <input type="password" name="password" required placeholder="Enter Password">
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea name="address" rows="3" required placeholder="Enter your address"></textarea>
                </div>

                <div class="form-group">
                    <label for="contact_no">Contact Number</label>
                    <input type="tel" name="contact_no" required placeholder="Enter your contact number">
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" required>
                </div>

                <button type="submit" class="login-button">Register</button>
            </form>

            <div class="register-link">
                Already have an account? <a href="login.php">Login</a>
            </div>
        </div>

        <footer class="login-footer">
            &copy; <?php echo date('Y'); ?> Medical Prescription System
        </footer>
    </div>