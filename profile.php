<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db.php'; // Moved outside the function

function showProfileDropdown() {
    global $conn; // Must be inside the function

    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    $user_id = $_SESSION['user_id'];
    $query = "SELECT username, email FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        error_log("Database error: " . $conn->error);
        return false;
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $username = htmlspecialchars($user['username']);
        $email = htmlspecialchars($user['email']);

        return <<<HTML
        <div id="profileDropdown" class="profile-dropdown" style="display: none;">
            <div class="profile-info">
                <img src="image/pers.png" class="profile-img">
                <div class="info-section">
                    <p><strong>Name:</strong> $username</p>
                    <p><strong>Email:</strong> $email</p>
                    <form method="POST" action="logout.php">
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </div>
        </div>
HTML;
    }
    return false;
}
?>
