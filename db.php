<?php
// Check if a session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start the session only if it's not already started
}

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "web_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
