<?php
    require '../config/connection.php';
    $id = $_GET['id'];
    $query = 'DELETE FROM doctors where id = ?';
    $stmt  = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt,"i",$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo "<script>location.href='doctors.php';</script>"



?>