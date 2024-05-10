<?php
session_start();
require_once '../config/config.php';  // Adjust the path as necessary
if (!isset($_SESSION['user_id'])) {
    echo "Redirecting to login because user_id is not set in session.";
    header("Location: /grad/pages/login.html");
    exit();
}

try {
    $pdo = connect();
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

$user_id = $_SESSION['user_id'];
$sort_order = isset($_GET['sort']) ? $_GET['sort'] : 'asc'; // Default to ascending
$query = "SELECT h.payload, h.date, s.vulnerability_id
          FROM history h
          INNER JOIN scripts s ON h.script_id = s.id
          WHERE h.user_id = :user_id
          ORDER BY h.date $sort_order";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$history = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User History</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="/grad/pages/pentester.php" class="logo"><img src="/grad/assets/icons/background.jpg"
                    alt="Logo"></a>
        </div>
        <div class="navbar-right">
            <a href="/grad/pages/pentester.php">Home</a>
            <a href="/grad/pages/classify.php">Classify Scripts</a>
            <a href="/grad/pages/request_scripts.php">Request Scripts</a>
            <a href="/grad/pages/about_us.php">About Us</a>
            <a href="/grad/scripts/logout.php" class="logout-button">Logout</a>
        </div>
    </nav>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Vulnerability ID</th>
                    <th>Payload</th>
                    <th>Date
                        <div class="sort-buttons">
                            <a href="?sort=asc">&#x25B2;</a> <!-- Ascending -->
                            <a href="?sort=desc">&#x25BC;</a> <!-- Descending -->
                        </div>
                    </th>
            </thead>
            <tbody>
                <?php foreach ($history as $row): ?>
                    <tr
                        onclick='showModal(<?= json_encode($row["payload"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>, <?= json_encode($row["vulnerability_id"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>, <?= json_encode($row["date"], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>)'>
                        <td><?= htmlspecialchars($row['vulnerability_id']) ?></td>
                        <td><?= substr(htmlspecialchars($row['payload']), 0, 55) ?>...</td>
                        <td><?= $row['date'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                <h2 id="modal-title" style="margin-bottom: 5px;"></h2>
                <span id="modal-date" style="font-size: smaller; opacity: 0.75; margin-bottom: 10px;"></span>
                <textarea id="modal-text" readonly style="width: 100%;"></textarea>
            </div>
        </div>
    </div>


    <script>
        function showModal(payload, title, date) {
            console.log(payload, title, date);  // This will show the values in the browser console.
            document.getElementById('modal-text').value = payload;
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-date').textContent = date;
            document.getElementById('modal').style.display = 'block';
        }

        // Get the modal
        var modal = document.getElementById('modal');

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

    </script>
</body>

</html>