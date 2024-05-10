<?php
session_start();

// Database connection
$host = 'localhost';
$port = '3306';
$dbname = 'cybergpt';
$user = 'root';
$pass = '';

// Connect to database
$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);

// Retrieve user ID and script ID from session
$user_id = $_SESSION['user_id'];
$script_id = $_SESSION['script_id'];
$payload = $_POST['payload'] ?? '';

// Current date
$date = date('Y-m-d H:i:s');

// Insert into history table
$sql = "INSERT INTO history (user_id, script_id, payload, date) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$success = $stmt->execute([$user_id, $script_id, $payload, $date]);

// Return success status
echo json_encode(['success' => $success]);
?>
