<?php
session_start();

// Check if the 'user_id' is set in the session and if it equals '1'
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
    echo "User is admin.";
} else {
    echo "User is not admin.";
    header("Location: /grad/pages/login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="admin.php" class="logo"><img src="logo.png" alt="Logo"></a>
        </div>
        <div class="navbar-right">
            <a href="/grad/pages/admin.php">Home</a>
            <a href="/grad/pages/manage_users.php">Manages</a>
            <a href="/grad/pages/generate_scripts.php">Generate</a>
            <a href="/grad/pages/about_us.php">About Us</a>
            <a href="/grad/scripts/logout.php" class="logout-button">Logout</a>
        </div>
    </nav>
    <div class="admin-container">
        <div class="card">
            <h2>Manage Users</h2>
            <a href="/grad/pages/manage_users.php" class="btn">Go to Manage Users</a>
        </div>
        <div class="card">
            <h2>Generate Scripts</h2>
            <a href="/grad/pages/generate_scripts.php" class="btn">Go to Generate Scripts</a>
        </div>
    </div>
</body>

</html>