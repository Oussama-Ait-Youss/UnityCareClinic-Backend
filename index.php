<?php
// Root index.php - The "Traffic Cop"

session_start();

// 1. Check if the user is ALREADY logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // If logged in, go straight to Dashboard
    header("Location: dashboard/index.php");
} else {
    // If NOT logged in, go to Login Page
    header("Location: login.php");
}
exit();
?>