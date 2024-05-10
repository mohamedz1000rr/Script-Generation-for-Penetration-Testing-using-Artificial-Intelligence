<?php
session_start(); // Start a session at the very beginning
require_once '../config/config.php';
// Retrieve user input from POST request
$email = $_POST['username'];
$password = $_POST['password'];


// Attempt to connect to the database
try {
    $pdo = connect();
    // Prepare SQL query to fetch user by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Store user ID in session
            $_SESSION['user_id'] = $user['ID'];
            if ($user['verified'] == 0) {
                // Redirect back to login page with error message for unverified user
                header("Location: /grad/index.php?error=User not verified yet.");
                exit();
            }

            if ($email == "admin" && $password == "admin") {
                // Redirect to admin page
                header("Location: /grad/pages/admin.php");
                exit();
            } else {
                // Redirect to user dashboard page
                header("Location: /grad/pages/pentester.php");
                exit();
            }
        } else {
            // Redirect back to login page with error message for invalid password
            header("Location: /grad/index.php?error=Invalid email or password.");
            exit();
        }
    } else {
        // Redirect back to login page with error message for invalid email
        header("Location: /grad/index.php?error=Invalid email or password.");
        exit();
    }
} catch (PDOException $e) {
    // Display database connection error
    echo "Database connection failed: " . $e->getMessage();
    exit();
}
?>