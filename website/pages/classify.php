<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Redirecting to login because user_id is not set in session.";
    header("Location: /grad/pages/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Optionally, you can retrieve additional user information from the database using $user_id
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Script Classifier</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
    <style>
        input[type="text"] {
            border-radius: 5px;
            width: 94%;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f3f3f3;
            border: 1px solid #ccc;
        }

        button {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="/grad/pages/pentester.php" class="logo"><img src="/grad/assets/icons/background.jpg"
                    alt="Logo"></a>
        </div>
        <div class="navbar-right">
            <a href="/grad/pages/pentester.php">Home</a>
            <a href="/grad/pages/request_scripts.php">Request Scripts</a>
            <a href="/grad/pages/history.php">History</a>
            <a href="/grad/pages/about_us.php">About Us</a>
            <a href="/grad/scripts/logout.php" class="logout-button">Logout</a>
        </div>
    </nav>
    <div class="generate-scripts-container">
        <h2>Script Classifier</h2>
        <form>
            <input type="text" id="classificationResult" readonly>
            <textarea id="scriptInput" placeholder="Enter A Script"></textarea>
            <button type="submit">Classify</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('form').addEventListener('submit', function (event) {
                event.preventDefault();
                var script = document.getElementById('scriptInput').value;
                fetch('http://127.0.0.1:5000/classify', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'script=' + encodeURIComponent(script)
                }).then(response => response.json())
                    .then(data => {
                        document.getElementById('classificationResult').value = 'Classification: ' + data.classification;
                    });

            });
        });
    </script>
</body>

</html>