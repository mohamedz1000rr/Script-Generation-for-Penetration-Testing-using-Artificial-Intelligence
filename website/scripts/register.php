<?php

require_once '../config/config.php';

// Handle the POST request from the registration form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from POST request
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Retrieve password from form
    $s_serial = $_POST['s_serial'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    // Attempt to connect to the database
    try {
        $pdo = connect();

        // Prepare SQL query to insert new user
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, s_serial) VALUES (:name, :email, :password, :s_serial)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashed_password, 's_serial' => $s_serial]);

        // Redirect to login page or somewhere appropriate
        header("Location: login.html?success=Account created successfully.");
        exit();
    } catch (PDOException $e) {
        // Display database connection error
        echo "Database connection failed: " . $e->getMessage();
        exit();
    }
}
?>