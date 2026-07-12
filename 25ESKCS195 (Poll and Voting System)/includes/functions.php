<?php
/*
    functions.php
    ----------------------------------------------------
    Small reusable helper functions used across the site.
*/

// Start the session only if it hasn't been started yet.
// We need sessions to remember who is logged in.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clean up user input to help prevent XSS (cross-site scripting)
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check whether a normal user is logged in
function is_user_logged_in() {
    return isset($_SESSION['user_id']);
}

// Check whether an admin is logged in
function is_admin_logged_in() {
    return isset($_SESSION['admin_id']);
}

// Redirect a guest away from pages that require a user login
function require_user_login() {
    if (!is_user_logged_in()) {
        header("Location: login.php");
        exit();
    }
}

// Redirect away from pages that require an admin login
function require_admin_login() {
    if (!is_admin_logged_in()) {
        header("Location: login.php");
        exit();
    }
}
?>
