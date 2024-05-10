<?php
session_start(); // Start or resume a session
$_SESSION = array();

// Destroy the session
session_destroy();

require_once 'config/config.php'; // Include configuration file

// Basic routing mechanism
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'login':
        require 'pages/login.html';
        break;
    case 'register':
        require 'pages/register.html';
        break;
    case 'about':
        require 'pages/about_us.php';
        break;
    default:
        require 'pages/pentester.php';
        break;
}

?>