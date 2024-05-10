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
    <title>Generate Scripts</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
    <style>
        #button_insert {
            background-color: green;
            width: 50%;
            margin-left: 5px
        }

        #button_eval {
            width: 50%;
            margin-right: 5px
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
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
            <a href="/grad/pages/manage_users.php">Manage Users</a>
            <a href="/grad/scripts/logout.php" class="logout-button">Logout</a>
        </div>
    </nav>
    <div class="generate-scripts-container">
        <h2>Generate Scripts</h2>
        <form>
            <label for="script-type">Select Script Type:</label>
            <select name="script-type" id="script-type">
                <option value="XSS">Cross-Site Scripting (XSS)</option>
                <option value="CSRF">Cross-Site Request Forgery (CSRF)</option>
                <option value="SQL Injection">SQL Injection</option>
            </select>
            <button type="submit">Generate Script</button>
        </form>

        <textarea placeholder="Generated Script" readonly></textarea>
        <div class="button-group">
            <button id="button_eval">Evaluate</button>

            <button id="button_insert">Insert</button>
        </div>
        <label for="evaluated">Evaluated</label>
        <input type="checkbox" id="evaluated" name="evaluated">
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('form').addEventListener('submit', function (event) {
                event.preventDefault();
                const scriptType = document.querySelector('#script-type').value;

                fetch('http://127.0.0.1:5000/generate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ prompt: scriptType }),
                })
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('textarea').value = data.generated_text;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            document.getElementById('button_insert').addEventListener('click', function () {
                const scriptText = document.querySelector('textarea').value;
                const scriptType = document.querySelector('#script-type').value;
                const evaluated = document.querySelector('#evaluated').checked ? 1 : null;

                fetch('/grad/scripts/insert_script.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        payload: scriptText,
                        vulnerability_id: scriptType,
                        evaluated: evaluated
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
            document.getElementById('button_eval').addEventListener('click', function () {
                const scriptText = document.querySelector('textarea').value;
                fetch('http://127.0.0.1:5000/evaluate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ script: scriptText }),
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</body>

</html>