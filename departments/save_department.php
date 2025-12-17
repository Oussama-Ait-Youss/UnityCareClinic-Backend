<?php
// save_department.php
require '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Collect Input
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    // 2. Validation
    if (empty($name)) {
        echo "<script>alert('Department Name is required'); location.href='departments.php';</script>";
        exit;
    }

    // 3. Decision: Insert or Update?
    if (empty($id)) {
        // --- CREATE NEW ---
        $query = "INSERT INTO departments (name, description, created_at) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $name, $description);
        $msg = "created";
    } else {
        // --- UPDATE EXISTING ---
        $query = "UPDATE departments SET name=?, description=?, updated_at=NOW() WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $name, $description, $id);
        $msg = "updated";
    }

    // 4. Execute
    if (mysqli_stmt_execute($stmt)) {
        header("Location: departments.php?msg=$msg");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);

} else {
    // If accessed directly without POST
    header("Location: departments.php");
}
?>