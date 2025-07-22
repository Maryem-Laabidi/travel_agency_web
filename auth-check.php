<?php
require_once 'db.php';

// List of pages that don't require login
$public_pages = ['login.php', 'signup.php', 'acceuil.php'];

// Get current page name
$current_page = basename($_SERVER['PHP_SELF']);

// If trying to access protected page while not logged in
if (!isset($_SESSION['user_id']) && !in_array($current_page, $public_pages)) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; // Remember requested URL
    header("Location: login.php");
    exit();
}
?>