<?php
require_once 'db.php';

// Destroy all session data
$_SESSION = [];
session_destroy();

// Redirect to home
header("Location: acceuil.php");
exit();
?>