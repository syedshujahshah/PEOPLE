<?php
// Database configuration for local MySQL
$host = 'localhost';
$dbname = 'dbujpptd4ylgpq';
$username = 'uac1gp3zeje8t';
$password = 'hk8ilpc7us2e';

try {
    // Connect to local MySQL
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // Optional: Log successful connection
    error_log("Database connection successful", 3, 'logs/db_errors.log');
} catch (PDOException $e) {
    // Log error
    error_log("Connection failed: " . $e->getMessage(), 3, 'logs/db_errors.log');
    echo "Unable to connect to the database. Please check the logs for details.";
    exit;
}
?>
