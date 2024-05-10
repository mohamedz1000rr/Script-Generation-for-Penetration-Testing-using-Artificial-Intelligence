<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Redirecting to login because user_id is not set in session.";
    header("Location: /grad/pages/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Scripts</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
</head>

<body>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="home.php" class="logo"><img src="/grad/assets/icons/background.jpg" alt="Logo"></a>
        </div>
        <div class="navbar-right">
            <a href="/grad/pages/pentester.php">Home</a>
            <a href="/grad/pages/classify.php">Classify Scripts</a>
            <a href="/grad/pages/history.php">History</a>
            <a href="/grad/pages/about_us.php">About Us</a>
            <a href="/grad/scripts/logout.php" class="logout-button">Logout</a>
        </div>
    </nav>

    <div class="generate-scripts-container">
        <h2>Request Scripts</h2>
        <form>
            <label for="script-type">Select Script Type:</label>
            <select name="script-type" id="script-type">
                <option value="XSS">Cross-Site Scripting (XSS)</option>
                <option value="CSRF">Cross-Site Request Forgery (CSRF)</option>
                <option value="SQL Injection">SQL Injection</option>
            </select>
            <button id="get-script" style="margin-bottom: 8px;">Request Script</button>

        </form>

        <textarea placeholder="Generated Script" readonly></textarea>
        <button id="copy-script">Copy Script</button>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector('form');
            const scriptTextArea = document.querySelector('textarea');

            form.addEventListener('submit', function (event) {
                event.preventDefault();
                const scriptType = document.getElementById('script-type').value;

                fetch('fetch_script.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'script-type=' + scriptType
                })
                    .then(response => response.text())
                    .then(data => {
                        scriptTextArea.value = data;
                    })
                    .catch(error => console.error('Error:', error));
            });

            const copyButton = document.getElementById('copy-script');
            copyButton.addEventListener('click', function () {
                scriptTextArea.select();
                document.execCommand('copy');
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector('form');
            const scriptTextArea = document.querySelector('textarea');

            form.addEventListener('submit', function (event) {
                event.preventDefault();
                const scriptType = document.getElementById('script-type').value;

                fetch('/grad/scripts/fetch_script.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'script-type=' + scriptType
                })
                    .then(response => response.text())
                    .then(data => {
                        scriptTextArea.value = data; // Set the fetched script in the textarea
                    })
                    .catch(error => console.error('Error:', error));
            });

            const copyButton = document.getElementById('copy-script');
            copyButton.addEventListener('click', function () {
                if (scriptTextArea.value === "") {
                    alert("No script to copy!");
                } else {
                    scriptTextArea.select();
                    document.execCommand('copy');

                    // Display a popup message
                    alert("Script copied to clipboard!");

                    // Send the log to the server
                    fetch('/grad/scripts/log_script.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'payload=' + encodeURIComponent(scriptTextArea.value)
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Log saved:', data);
                        })
                        .catch(error => console.error('Error logging script:', error));
                }
            });
        });      
    </script>

</body>

</html>