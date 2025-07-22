<?php
require_once 'db.php';

if (isset($_SESSION['user_id'])) {
    // PHP 5 compatible redirect - using ternary operator instead of ??
    $redirect = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'acceuil.php';
    header("Location: " . $redirect);
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            
            // PHP 5 compatible redirect
            $redirect = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'acceuil.php';
            header("Location: " . $redirect);
            exit();
        }
    }
    $error = "Invalid email or password!";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="login.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Crete+Round:ital@0;1&display=swap" rel="stylesheet">
        <title>Login</title>
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
                <h2>Login</h2>
                <p>Home<span class="orange" style="font-size:30px">.</span>Login</p>
            </div>
        </section>

        <section class="info">
            <div class="wrapper">
                <div id="i1">
                    <img src="image/ph14.png" width="500px" height="350px">
                </div>
                <div id="i2">
                    <h1>Welcome Again 👋</h1>
                    <form method="POST">
    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <input type="email" name="email" required>
    <input type="password" name="password" required>
    <input type="submit" value="Login">
</form>
<p>Don't have an account? <a href="signup.php">Sign up</a></p>
</div>
            </div>
            <div class="clear"> </div>
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