<?php
session_start();

function getNavbarLinks()
{
    // Check if user ID is set in the session
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['user_id'] == 1) {
            // Admin user links
            return array(
                array("url" => "/grad/pages/admin.php", "text" => "Home"),
                array("url" => "/grad/pages/manage_users.php", "text" => "Manages"),
                array("url" => "/grad/pages/generate_scripts.php", "text" => "Generate"),
                array("url" => "/grad/scripts/logout.php", "text" => "logout", "class" => "logout-button")
            );
        } else {
            // Regular user links
            return array(
                array("url" => "/grad/pages/pentester.php", "text" => "Home"),
                array("url" => "/grad/pages/classify.php", "text" => "Classify Scripts"),
                array("url" => "/grad/pages/request_scripts.php", "text" => "Request Scripts"),
                array("url" => "/grad/pages/history.php", "text" => "History"),
                array("url" => "/grad/scripts/logout.php", "text" => "Logout", "class" => "logout-button")
            );
        }
    } else {
        // Guest links (not logged in)
        return array(
            array("url" => "login.html", "text" => "Login")
        );
    }
}

$navbar_links = getNavbarLinks();  // Call function to get the appropriate links
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - cyberGPT</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
    <style>
        header {
            top: -22px;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding-top: 100px;
            color: #333;
            display: flex;
            flex-direction: column;
        }

        footer {
            width: 1500px;
        }

        .team-member {
            text-align: center;
        }

        .team-member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }
    </style>


</head>

<body>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="<?php echo (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) ? '/grad/pages/admin.php' : '/grad/pages/pentester.php'; ?>"
                class="logo"><img src="/grad/assets/icons/background.jpg" alt="Logo"></a>
        </div>
        <div class="navbar-right">
            <?php
            // Generate navigation links dynamically
            foreach ($navbar_links as $link) {
                echo '<a href="' . $link["url"] . '"';
                if (isset($link["class"])) {
                    echo ' class="' . $link["class"] . '"';
                }
                echo '>' . $link["text"] . '</a>';
            }
            ?>
        </div>
    </nav>
    <header>
        <br>
        <br>
        <h1>About cyberGPT</h1>
        <p>Your reliable partner in the realm of penetration testing and cybersecurity.</p>
    </header>

    <section id="about">
        <p>At cyberGPT, we specialize in generating customized web payload scripts designed to meet the specific needs
            of professional penetration testers (pentesters). Our platform not only crafts these essential tools but
            also provides an innovative classification feature that categorizes scripts based on their use-case and
            effectiveness, ensuring you get exactly what you need for any security assessment.</p>
        <p>Understanding the critical nature of security in the digital age, cyberGPT empowers pentesters by offering a
            user-centric approach where each registered user can store and access their requested scripts in a
            personalized repository. This allows for easy retrieval and reuse of scripts in various testing scenarios,
            improving efficiency and effectiveness in identifying vulnerabilities.</p>
        <p>Our mission is to streamline the penetration testing process by providing high-quality, tailor-made scripts
            that are both versatile and reliable. Whether you are conducting a routine security check or an in-depth
            vulnerability assessment, cyberGPT is here to equip you with the right tools to protect your or your
            clients' digital assets.</p>
        <p>Join us at cyberGPT, where advanced technology meets expert knowledge in the fight against cyber threats.</p>
    </section>

    <section id="team">
        <h2>Our Team</h2>
        <div class="team-member">
            <img src="../assets/icons/mahmoud.jpg" alt="Team Member 1">
            <p>Mahmoud Osama</p>

        </div>
        <div class="team-member">
            <img src="../assets/icons/nour.jpg" alt="Team Member 2">
            <p>Nour Nader</p>

        </div>
        <div class="team-member">
            <img src="../assets/icons/mohamedh.jpg" alt="Team Member 3">
            <p>Mohamed Hisham</p>

        </div>
    </section>

    <footer>
        <h3>Supervisor & TA</h3>
        <p>Supervisor : Dr. Heba Osama</p>
        <p>TA : Reem Khaled</p>
    </footer>
</body>

</html>