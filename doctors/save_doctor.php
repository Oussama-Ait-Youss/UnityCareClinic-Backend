<?php
// save_doctor.php
require '../config/connection.php';

// 1. Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 2. Collect and sanitize input data
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $specialty = trim($_POST['specialty']);
    $department_id = intval($_POST['department_id']); // Ensure this is a number

    // 3. Basic Validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($department_id)) {
        echo "<script>alert('Please fill in all required fields (Name, Email, Department).'); location.href='doctors.php';</script>";
        exit;
    }

    // 4. Decision: Create or Update?
    if (empty($id)) {
        // --- CREATE NEW DOCTOR (INSERT) ---
        $query = "INSERT INTO doctors (first_name, last_name, email, phone, specialty, department_id, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = mysqli_prepare($conn, $query);
        
        // Types: "sssssi" -> 5 Strings, 1 Integer (department_id)
        mysqli_stmt_bind_param($stmt, "sssssi", $first_name, $last_name, $email, $phone, $specialty, $department_id);

        $action_msg = "created";

    } else {
        // --- UPDATE EXISTING DOCTOR (UPDATE) ---
        $query = "UPDATE doctors SET first_name=?, last_name=?, email=?, phone=?, specialty=?, department_id=?, updated_at=NOW() WHERE id=?";
        
        $stmt = mysqli_prepare($conn, $query);
        
        // Types: "sssssii" -> 5 Strings, 1 Integer (dept_id), 1 Integer (row id)
        mysqli_stmt_bind_param($stmt, "sssssii", $first_name, $last_name, $email, $phone, $specialty, $department_id, $id);

        $action_msg = "updated";
    }

    // 5. Execute the Query
    if (mysqli_stmt_execute($stmt)) {
        // Success: Redirect back to the list
        echo "<script>location.href='doctors.php?msg={$action_msg}';</script>";
    } else {
        // Error: Show what went wrong
        echo "Error: " . mysqli_error($conn);
    }

    // 6. Cleanup
    mysqli_stmt_close($stmt);

} else {
    // If someone tries to open this file directly
    header("Location: doctors.php");
    exit;
}
?>