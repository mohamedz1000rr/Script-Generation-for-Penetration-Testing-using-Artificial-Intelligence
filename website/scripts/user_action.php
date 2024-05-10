<?php
// Database connection parameters
$host = 'localhost';
$port = '3306';
$dbname = 'cybergpt';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['userId']) && isset($_POST['action'])) {
        $userId = $_POST['userId'];
        $action = $_POST['action'];

        switch ($action) {
            case 'accept':
                $query = "UPDATE users SET verified = 1 WHERE id = :userId";
                break;
            case 'reject':
                $query = "UPDATE users SET verified = NULL WHERE id = :userId";
                break;
            case 'delete':
                $query = "DELETE FROM users WHERE id = :userId";
                break;
            default:
                echo "Invalid action.";
                exit;
        }

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "Action '{$action}' completed successfully.";
        } else {
            echo "An error occurred.";
        }
    } else {
        echo "Required data not provided.";
    }
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
    die();
}
?>