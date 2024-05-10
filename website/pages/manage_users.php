<?php
session_start();

require_once '../config/config.php';  // Adjust the path as necessary

// Check if the 'user_id' is set in the session and if it equals '1'
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
    echo "User is admin.";
} else {
    echo "User is not admin.";
    header("Location: /grad/pages/login.html");
    exit();
}

// Attempt to connect to the database
try {
    $pdo = connect();
    // Fetch users
    $stmt_users = $pdo->prepare("SELECT id, name, email FROM users WHERE verified = 1");
    $stmt_users->execute();
    $users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

    // Fetch pending registrations
    $stmt_pending = $pdo->prepare("SELECT id, name, email, s_serial FROM users WHERE verified = 0");
    $stmt_pending->execute();
    $pending_users = $stmt_pending->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>

    <style>
        .navbar {
            font-family: Arial, sans-serif;
            height: 50px;
            background-color: #343a40;
            padding: 10px 20px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
        }

        .navbar .logo img {
            height: 40px;
        }

        .logout-button {
            background-color: #dc3545;
            border-radius: 5px;
            margin-right: 40px;
        }

        .navbar a.logout-button:hover {
            background-color: darkred;
        }

        h2,
        h3 {
            font-family: Arial, sans-serif;

        }

        .manage-users-container table {
            padding-top: 55px;
            font-family: Arial, sans-serif;
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        th,
        td {
            font-family: Arial, sans-serif;

            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            font-family: Arial, sans-serif;

            background-color: #f2f2f2;
        }

        tbody tr:hover {
            font-family: Arial, sans-serif;

            background-color: #f5f5f5;
        }

        .action-buttons button {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 5px;
        }

        .action-buttons button:hover {
            background-color: #45a049;
        }

        .manage-users-container {
            padding-top: 55px;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="/grad/pages/admin.php" class="logo"><img src="/grad/assets/icons/background.jpg" alt="Logo"></a>
        </div>
        <div class="navbar-right">
            <a href="/grad/pages/admin.php">Home</a>
            <a href="/grad/pages/generate_scripts.php">Generate Scripts</a>
            <a href="/grad/scripts/logout.php" class="logout-button">Logout</a>
        </div>
    </nav>

    <div class="manage-users-container">
        <h2>Manage Users</h2>
        <h3>Users</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td class="action-buttons">
                            <button onclick="deleteUser(<?php echo $user['id']; ?>)">Delete</button>
                        </td>

                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h3>Pending Registrations</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Serial No#</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pending_users as $pending_user) { ?>
                    <tr>
                        <td><?php echo $pending_user['id']; ?></td>
                        <td><?php echo $pending_user['name']; ?></td>
                        <td><?php echo $pending_user['email']; ?></td>
                        <td><?php echo $pending_user['s_serial']; ?></td>
                        <td class="action-buttons">
                            <button onclick="acceptUser(<?php echo $pending_user['id']; ?>)">Accept</button>
                            <button onclick="rejectUser(<?php echo $pending_user['id']; ?>)">Reject</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<script>
    function acceptUser(userId) {
        var formData = new FormData();
        formData.append('userId', userId);
        formData.append('action', 'accept');

        fetch('/grad/scripts/user_action.php', {
            method: 'POST',
            body: formData
        }).then(response => response.text())
            .then(data => {
                alert(data);
                location.reload(); // Reload the page to reflect changes
            });
    }

    function rejectUser(userId) {
        var formData = new FormData();
        formData.append('userId', userId);
        formData.append('action', 'reject');

        fetch('/grad/scripts/user_action.php', {
            method: 'POST',
            body: formData
        }).then(response => response.text())
            .then(data => {
                alert(data);
                location.reload(); // Reload the page to reflect changes
            });
    }
    function deleteUser(userId) {
        if (confirm('Are you sure you want to delete this user?')) {
            var formData = new FormData();
            formData.append('userId', userId);
            formData.append('action', 'delete');

            fetch('/grad/scripts/user_action.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
                .then(data => {
                    alert(data);
                    location.reload(); // Reload the page to reflect changes
                });
        }
    }
</script>