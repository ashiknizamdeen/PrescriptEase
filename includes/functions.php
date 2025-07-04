<?php
session_start();

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function isPharmacy()
{
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'pharmacy';
}

function redirect($url)
{
    header("Location: " . $url);
    exit();
}

function sanitize($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

function sendEmail($to, $subject, $message)
{
    $logEntry = "[" . date('Y-m-d H:i:s') . "] Email to: $to | Subject: $subject | Message: $message\n";
    $logPath = dirname(__DIR__) . "../user/email_log.txt";
    error_log($logEntry, 3, $logPath);

    return true;
}

function sendEmail1($to, $subject, $message)
{
    $logEntry = "[" . date('Y-m-d H:i:s') . "] Email to: $to | Subject: $subject | Message: $message\n";
    $logPath = dirname(__DIR__) . "../pharmacy/email_log.txt";
    error_log($logEntry, 3, $logPath);

    return true;
}
