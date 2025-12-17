<?php
// delete_department.php
require '../config/connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // STEP 1: SAFETY CHECK
    // Check if any doctors are currently assigned to this department
    $check_query = "SELECT COUNT(*) as count FROM doctors WHERE department_id = ?";
    $stmt_check = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt_check, "i", $id);
    mysqli_stmt_execute($stmt_check);
    $result = mysqli_stmt_get_result($stmt_check);
    $row = mysqli_fetch_assoc($result);
    $doctor_count = $row['count'];
    mysqli_stmt_close($stmt_check);

    // STEP 2: LOGIC
    if ($doctor_count > 0) {
        // FAIL: Doctors exist, cannot delete.
        echo "<script>
            alert('Cannot delete this department! There are $doctor_count doctors assigned to it. Please reassign or delete them first.');
            location.href='departments.php';
        </script>";
    } else {
        // SUCCESS: No doctors, safe to delete.
        $delete_query = "DELETE FROM departments WHERE id = ?";
        $stmt_delete = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($stmt_delete, "i", $id);
        
        if (mysqli_stmt_execute($stmt_delete)) {
            header("Location: departments.php?msg=deleted");
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt_delete);
    }

} else {
    header("Location: departments.php");
}
?>