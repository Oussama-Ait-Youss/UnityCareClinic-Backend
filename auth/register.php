<?php
// auth/register.php
require '../config/connection.php'; // Adjust path if needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Sanitize Input
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $password   = $_POST['password'];

    // 2. Check if Email Already Exists
    $checkQuery = "SELECT id FROM admins WHERE email = '$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        header("Location: ../login.php?error=Email already exists");
        exit();
    }

    // 3. Hash the Password (SECURITY CRITICAL)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 4. Insert User
    $query = "INSERT INTO admins (first_name, last_name, email, password) 
              VALUES ('$first_name', '$last_name', '$email', '$hashed_password')";

    if (mysqli_query($conn, $query)) {
        // Success: Redirect to login with success message
        header("Location: ../login.php?error=Account created! Please log in.");
    } else {
        header("Location: ../login.php?error=Database error");
    }
}
?>