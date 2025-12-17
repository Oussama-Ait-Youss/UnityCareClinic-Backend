<?php
    require_once __DIR__ . '/../vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../');
    $dotenv->safeLoad();     
    $HOST = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
    $USER = $_ENV['DB_USER'] ?? getenv('DB_USER');
    $PASS = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD');
    $DB   = $_ENV['DB_NAME'] ?? getenv('DB_NAME');

    $conn = mysqli_connect($HOST, $USER, $PASS, $DB);

    if (!$conn) {
        error_log("Connection error: " . mysqli_connect_error());
        die("Service unavailable.");
    }
?>