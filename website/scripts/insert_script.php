<?php
// Database configuration
$host = 'localhost';
$port = '3306'; // MySQL default port
$dbname = 'cybergpt';
$user = 'root';
$pass = '';

// Create connection
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Error message in JSON format
    header('Content-Type: application/json');
    echo json_encode(["error" => "Could not connect to the database.", "details" => $e->getMessage()]);
    exit;
}

// Set Content-Type header
header('Content-Type: application/json');

// Get the JSON POST data
$data = json_decode(file_get_contents('php://input'), true);

$vulnerability_id = $data['vulnerability_id'];
$payload = $data['payload'];
$evaluated = isset($data['evaluated']) ? (int) $data['evaluated'] : null; // Cast to int for boolean/binary values

// Prepare SQL and bind parameters
$stmt = $pdo->prepare("INSERT INTO scripts (vulnerability_id, payload, evaluated) VALUES (:vulnerability_id, :payload, :evaluated)");
$stmt->bindParam(':vulnerability_id', $vulnerability_id);
$stmt->bindParam(':payload', $payload);
$stmt->bindParam(':evaluated', $evaluated, PDO::PARAM_INT); // Explicitly set type as INT

if ($stmt->execute()) {
    echo json_encode(["message" => "Script inserted successfully."]);
} else {
    // Since $stmt->execute() only returns true/false, for more detailed error handling, consider using PDO errorInfo()
    echo json_encode(["message" => "An error occurred during script insertion."]);
}
?>