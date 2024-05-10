<?php
// Database configuration settings
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'cybergpt');
define('DB_USER', 'root');
define('DB_PASS', '');

// Create a function to establish a PDO connection
function connect()
{
    try {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
        $options = array(
            PDO::ATTR_PERSISTENT => true,  // Use persistent connection
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  // Throw exceptions on errors
        );

        // Create a new PDO instance
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        die("Error!: " . $e->getMessage());
    }
}
?>