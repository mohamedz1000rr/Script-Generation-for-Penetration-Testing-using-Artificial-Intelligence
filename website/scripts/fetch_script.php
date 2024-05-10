<?php
session_start(); // Start the session to use session variables

// Database connection
$host = 'localhost';
$port = '3306';
$dbname = 'cybergpt';
$user = 'root';
$pass = '';

// Connect to database
$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);

// Get the script type from POST data
$vulnerability_id = $_POST['script-type'] ?? '';

// Prepare SQL query to fetch a random payload and ID
$sql = "SELECT ID, payload FROM scripts WHERE vulnerability_id = ? ORDER BY RAND() LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$vulnerability_id]);

// Fetch the payload and ID
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $_SESSION['script_id'] = $row['ID']; // Store the script ID in the session
    echo htmlspecialchars($row['payload']);
} else {
    echo "No script available for this type.";
}
?>
