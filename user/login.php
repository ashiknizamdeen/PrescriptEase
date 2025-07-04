<?php
require_once '../config/database.php';
require_once '../includes/functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isLoggedIn()) {
    redirect($_SESSION['user_type'] === 'pharmacy' ? '../pharmacy/dashboard.php' : 'dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = htmlspecialchars($user['name']);
            $_SESSION['user_type'] = $user['user_type'];

            redirect($user['user_type'] === 'pharmacy' ? '../pharmacy/dashboard.php' : 'dashboard.php');
        } else {
            $error = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        $error = "System error. Please try later.";
    }
}

include '../includes/header.php';
?>

<body>
    <div class="login-container">
        <div class="login-card">
            <h1>Login</h1>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <div class="password-header">
                        <label for="password">Password</label>
                    </div>
                    <div class="password-input">
                        <input type="password" id="password" name="password" placeholder="Enter Password" required>
                        <button type="button" class="show-password" aria-label="Show password">Show</button>
                    </div>
                </div>
                <button type="submit" class="login-button">Login</button>
            </form>

            <div class="register-link">
                Don't have an account? <a href="register.php">Register Now</a>
            </div>
        </div>

        <footer class="login-footer">
            Copyright &copy; <?php echo date('Y'); ?> Medical Prescription System
        </footer>
    </div>