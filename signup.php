<?php
require_once 'db.php'; // Ensure sessions are started via db.php

// Initialize variables
$error = '';

// Process form if submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $username = $_POST['username'];
    $birth_date = $_POST['birth_date'];
    $gender = $_POST['gender'];

    // Validate gender
    if ($gender !== 'male' && $gender !== 'female') {
        $error = "Please select Male or Female";
    }
    // Validate passwords
    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    }
    // If validation passes
    else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO users (email, password, username, birth_date, gender) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $email, $hashed_password, $username, $birth_date, $gender);

        // Execute query
        if ($stmt->execute()) {
            // AUTO-LOGIN AFTER SIGNUP
            $_SESSION['user_id'] = $stmt->insert_id; // Get the new user's ID
            $_SESSION['email'] = $email;
            session_regenerate_id(true); // Security measure

            // Redirect to originally requested page OR home (PHP 5.x compatible)
            $redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'acceuil.php';
            unset($_SESSION['redirect_url']); // Clear the redirect URL
            header("Location: " . $redirect_url);
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="signup.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Crete+Round:ital@0;1&display=swap" rel="stylesheet">
        <title>Sign up</title>
    </head>
    <body>
        

           <header>
                <div class="wrapper">
            
                    <h1>Travel Agency<span class="orange">.</span></h1>
                    <nav>
                        <ul>
                            <li><a href="acceuil.php">ACCEUIL</a></li>
                            <li><a href="destination.php">DESTINATIONS</a></li>
                        </ul>
                    </nav>
                </div>
            </header>
             
            
       
        

        <section id="main_log">
            <div class="wrapper">
                <h2>Sign up</h2>
            
            </div>
        </section>

       

        <section id="data">
            <div class="wrapper">
            <h1>Register Yourself</h1>
            <form method="POST" action="signup.php">
    <!-- Display error if any -->
    <?php if (!empty($error)): ?>
        <div style="color: red; padding: 10px; margin-bottom: 15px; border: 1px solid red;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <!-- Form fields -->
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    <input type="text" name="username" placeholder="Username" required>
    <label for="d3">Date of birth</label>
    <input id="d3" type="date" name="birth_date" required>
    
    <!-- Gender radio buttons (now with values) -->
    <div class="radio-group">
        <input type="radio" id="f" name="gender" value="female" required>
        <label for="f">Female</label>
        <input type="radio" id="m" name="gender" value="male">
        <label for="m">Male</label>
    </div>
    
    <input type="submit" value="Sign Up">
</form>
        </div>
        </section>






        <section class="offer">
            <div class="wrapper">
                <div id="par1">
                    <h2>Get our pro offers</h2>
                    <p>we bring you the best travel deals to make your trips affordable<br> and unforgettable.
                    We have the perfect offer for you!</p>
                </div>
                <div id="par2">
                    <form >
                
                        <input type="text" placeholder="Enter your Email" >
                        <input type="submit" value="Subscribe" class="newbutton">
                     </form>
                </div>
            </div>
            <div class="clear"></div>
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
                        <a href="#">📞	+012 345 67890</a>
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
    </body>
</html>