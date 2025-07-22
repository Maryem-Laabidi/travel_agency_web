<?php
require_once 'auth-check.php';
require_once 'db-config.php';

if (isset($_GET['id'])) {
    $tripId = $_GET['id'];
    $userId = $_SESSION['user_id'];
    
    // Verify the trip belongs to the user before deleting
    $stmt = $conn->prepare("DELETE FROM user_trips WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $tripId, $userId);
    $stmt->execute();
    
    // Optional: Check if the deletion was successful
    if ($stmt->affected_rows === 0) {
        // No rows were deleted (trip didn't exist or didn't belong to user)
        // You might want to log this or handle it differently
    }
    
    $stmt->close();
}

header("Location: bookin.php");
exit();
?>