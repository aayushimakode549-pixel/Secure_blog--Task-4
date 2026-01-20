<?php
// Start session only once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "secure_blog_task4");

if ($conn->connect_error) {
    die("Database connection failed");
}

// Check login
if (!function_exists('isLoggedIn')) {
    function isLoggedIn() {
        return isset($_SESSION['user']);
    }
}

// Check admin
if (!function_exists('isAdmin')) {
    function isAdmin() {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }
}

// Escape output
if (!function_exists('e')) {
    function e($data) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}
