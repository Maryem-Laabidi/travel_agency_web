<?php 
require_once 'auth-check.php';
require_once 'db-config.php';
include 'profile.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user_id exists in session
if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

// Fetch user trips with all necessary fields
$sql = "SELECT *, 
        total_price,
        duration,
        DATE_FORMAT(check_in_date, '%Y-%m-%d') as check_in_date,
        DATE_FORMAT(check_out_date, '%Y-%m-%d') as check_out_date,
        DATEDIFF(check_out_date, check_in_date) as calculated_nights
        FROM `user_trips` 
        WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $_SESSION['user_id']);

if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->error);
}

$result = $stmt->get_result();
$trips = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bookin.css">
        <link rel="stylesheet" href="profile.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Crete+Round:ital@0;1&display=swap" rel="stylesheet">
        <title>Book In</title>
    </head>
    <body>
    <header>
    <div class="wrapper">
        <h1>Travel Agency<span class="orange">.</span></h1>
        <nav>
            <ul>
                <li><a href="acceuil.php">ACCEUIL</a></li>
                <li><a href="destination.php">DESTINATIONS</a></li>
                <li><a href="contact.php">CONTACT</a></li>
                <li id="l4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="#" style="cursor: pointer;">
                            <img src="image/pers.png" width="30px" height="30px">
                        </a>
                        <?php echo showProfileDropdown(); ?>
                    <?php else: ?>
                        <a href="login.php" style="cursor: pointer;">
                            <img src="image/pers.png" width="30px" height="30px">
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </div>
</header>

        <section id="texte">
            <div class="wrapper" id="t">
                <div id="t1">
                    <p>Start Travelling with us</p>
                    <h1>Let's enjoy your desired trip with Tourice</h1>
                    <p>The traveller where you can select your desired activity and destinations of your choice for vacations.</p>
                </div>
                <div id="t2">
                    <img src="image/t1-removebg-preview.png">
                </div>
            </div>
            <div class="clear"></div>
        </section>

        <section class="booking-table">
            <div class="wrapper">
                <h2>Your Booked Trips</h2>
                <?php if (count($trips) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Destination</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Nights</th>
                                <th>Price/Night</th>
                                <th>Total Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($trips as $trip): ?>
                            <tr>
                                <td><?= htmlspecialchars($trip['destination_name']) ?></td>
                                <td><?= date('M j, Y', strtotime($trip['check_in_date'])) ?></td>
                                <td><?= date('M j, Y', strtotime($trip['check_out_date'])) ?></td>
                                <td><?= $trip['duration'] ?></td>
                                <td>$<?= number_format($trip['one_night_price'], 2) ?></td>
                                <td>$<?= number_format($trip['total_price'], 2) ?></td>
                                <td class="action-buttons">
                                    <a href="<?= strtolower($trip['destination_name']) ?>.php?edit=<?= $trip['id'] ?>" class="edit-btn">Edit</a>
                                    <a href="#" onclick="confirmDelete(<?= $trip['id'] ?>)" class="delete-btn">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-trips">
                        <p>You haven't booked any trips yet. Start by exploring our <a href="destination.php">destinations</a>!</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section id="cat">
            <p>CATEGORIES</p>
            <h1>We Offer The Best</h1>
            <h1>✨Service✨</h1>
            <ul>
                <li>
                    <img src="image/c1.png" width="100px" height="100px">
                    <h4>Calculated Weather</h4>
                    <p>Built Wicket longer admire do<br> barton vanity itself do in it</p>
                </li>
                <li>
                    <img src="image/c2.png" width="100px" height="100px">
                    <h4>Best Flight</h4>
                    <p>Engrossed listening. Park<br> gate sell they west hard for</p>
                </li>
                <li>
                    <img src="image/c3.png" width="100px" height="100px">
                    <h4>Local Events</h4>
                    <p>Barton vanity itself do in it.<br> Preferd to men it engrossed</p>
                </li>
                <li>
                    <img src="image/cat4.png" width="100px" height="100px">
                    <h4>Customize Tour</h4>
                    <p>We deliver outsourced<br> aviation services for</p>
                </li>
            </ul>
        </section>

        <section id="aj1">
            <div class="wrapper">
                <div id="fun1">
                    <img src="image/c5-removebg-preview.png">
                </div>
                <div class="right-section">
                    <div id="fun2">
                        <ul>
                            <li><img src="image/c6-removebg-preview.png" width="100px" height="109.5px"></li>
                            <li><img src="image/c7-removebg-preview.png" width="150px" height="129.5px"></li>
                            <li><img src="image/c8-removebg-preview.png" width="150px" height="129.5px"></li>
                        </ul>
                    </div>
                    <div id="words">
                        <p>ABOUT US</p>
                        <h1>We Are The Best Travel Agency</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="final">
            <div class="wrapper">
                <ul>
                    <li id="name">
                        <h1>Travel Agency<span class="orange">.</span></h1>
                        <p>Hello, we are Lift Media. Our goal is to translate the positive effects from revolutionizing</p>
                        <img src="image/ph15.jpg" width="180px" height="75.6px">
                    </li>
                    <li>
                        <h1>About</h1>
                        <a href="#">About Us</a>
                        <a href="#">Our Services</a>
                        <a href="#">Privacy Policy</a>
                        <a href="#">Termes & Conditions</a>
                    </li>
                    <li>
                        <h1>Contact</h1>
                        <a href="#">📞 +012 345 67890</a>
                        <a href="#">📧 cxqxs@example.com</a>
                        <a href="#">📍 123 Street, New York, USA</a>
                    </li>
                    <li>
                        <h1>Gallery</h1>
                        <img src="image/g1.avif" width="250px" height="150px">
                    </li>
                </ul>
            </div>
        </section>

        <footer>
            <div class="wrapper">
                <h1>Travel Agency<span class="orange">.</span></h1>
                <div id="Copyright">Copyright © Tous droits réservés.</div>
            </div>
        </footer>

        <script>
        function confirmDelete(tripId) {
            if (confirm('Are you sure you want to delete this trip?')) {
                window.location.href = 'delete-trip.php?id=' + tripId;
            }
        }
        </script>
        <script src="profile.js"></script>
    </body>
</html>