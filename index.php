<?php
require_once 'config/database.php';
require_once 'includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Prescription Upload System</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <header class="main-header">
            <h1>Medical Prescription Upload System</h1>
            <p>Upload your prescriptions and get quotes from pharmacies</p>
        </header>

        <div class="main-content">
            <div class="feature-grid">
                <div class="feature-card">
                    <h3>For Patients</h3>
                    <p>Upload your prescription images and get competitive quotes from multiple pharmacies</p>
                    <ul>
                        <li>Upload up to 5 prescription images</li>
                        <li>Choose delivery time slots</li>
                        <li>Compare pharmacy quotes</li>
                        <li>Accept/reject quotations</li>
                    </ul>
                    <div class="button-group">
                        <a href="user/login.php" class="btn btn-primary">Patient Login</a>
                        <a href="user/register.php" class="btn btn-secondary">Register as Patient</a>
                    </div>
                </div>

                <div class="feature-card">
                    <h3>For Pharmacies</h3>
                    <p>View prescription requests and provide competitive quotations to customers</p>
                    <ul>
                        <li>View uploaded prescriptions</li>
                        <li>Create detailed quotations</li>
                        <li>Manage customer requests</li>
                        <li>Track order status</li>
                    </ul>
                    <div class="button-group">
                        <a href="pharmacy/login.php" class="btn btn-primary">Pharmacy Login</a>
                        <a href="admin/create_pharmacy.php" class="btn btn-secondary">Register Pharmacy</a>
                    </div>
                </div>
            </div>

            <div class="how-it-works">
                <h2>How It Works</h2>
                <div class="steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <h4>Upload Prescription</h4>
                        <p>Take photos of your prescription and upload them with delivery details</p>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <h4>Get Quotes</h4>
                        <p>Pharmacies review your prescription and provide detailed quotations</p>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <h4>Choose & Confirm</h4>
                        <p>Compare quotes and accept the best offer for home delivery</p>
                    </div>
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <p>&copy; 2025 Medical Prescription Upload System by Ashik. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>