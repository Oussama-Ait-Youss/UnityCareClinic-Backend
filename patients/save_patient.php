<?php
// save_patient.php
require '../config/connection.php';

// 1. Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 2. Collect and sanitize input data
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];

    // 3. Basic Validation (Server-side backup)
    if (empty($first_name) || empty($last_name) || empty($email)) {
        echo "<script>alert('Please fill in all required fields.'); location.href='patients.php';</script>";
        exit;
    }

    // 4. Decision: Create or Update?
    if (empty($id)) {
        // --- CREATE NEW PATIENT (INSERT) ---
        $query = "INSERT INTO patients (first_name, last_name, email, phone, gender, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
        
        $stmt = mysqli_prepare($conn, $query);
        // "sssss" = 5 Strings
        mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $email, $phone, $gender);

        $action_msg = "created";

    } else {
        // --- UPDATE EXISTING PATIENT (UPDATE) ---
        // We update the fields and the 'updated_at' timestamp
        $query = "UPDATE patients SET first_name=?, last_name=?, email=?, phone=?, gender=?, updated_at=NOW() WHERE id=?";
        
        $stmt = mysqli_prepare($conn, $query);
        // "sssssi" = 5 Strings, 1 Integer (the ID)
        mysqli_stmt_bind_param($stmt, "sssssi", $first_name, $last_name, $email, $phone, $gender, $id);

        $action_msg = "updated";
    }

    // 5. Execute the Query
    if (mysqli_stmt_execute($stmt)) {
        // Success: Redirect back to the list
        echo "<script>location.href='patients.php?msg={$action_msg}';</script>";
    } else {
        // Error: Show what went wrong
        echo "Error: " . mysqli_error($conn);
    }

    // 6. Cleanup
    mysqli_stmt_close($stmt);

} else {
    // If someone tries to open this file directly without submitting the form
    header("Location: patients.php");
    exit;
}
?>