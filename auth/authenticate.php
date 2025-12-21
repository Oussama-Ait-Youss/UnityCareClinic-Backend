<?php
// auth/authenticate.php
session_start();
require '../config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // 1. Get user by email
    $query = "SELECT * FROM admins WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        
        // 2. Verify Password
        // We use password_verify() to compare the typed text with the hash in DB
        if (password_verify($password, $row['password'])) {
            
            // 3. Set Session Variables
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['first_name'] . ' ' . $row['last_name'];
            $_SESSION['logged_in'] = true;

            // 4. Redirect to Dashboard
            header("Location: ../dashboard/index.php");
            exit();

        } else {
            // Wrong Password
            header("Location: ../login.php?error=Incorrect password");
            exit();
        }
    } else {
        // User not found
        header("Location: ../login.php?error=User not found");
        exit();
    }
}
?>