<?php require_once 'auth-check.php';
include 'profile.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="destination.css">
        <link rel="stylesheet" href="profile.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Crete+Round:ital@0;1&display=swap" rel="stylesheet">
        <title>Destination</title>
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

        <section id="main_dest">
            <div class="wrapper">
                <h2>Destination</h2>
                
            </div>
        </section>

        <section class="photos">
            <div class="wrapper" id="photogrid">
                <div id="partie1">
                <ul>
                    <li id="ph1">
                        <a href="india.php" class="image-link">
                        <h5> Pahalgam</h5>
                        <p>India, 100 Trips</p>
                        </a>
                    </li>
                    <li id="ph2">
                        <a href="dubai.php" class="image-link">
                        <h5>Dubai Desert</h5>
                        <p>United Arab Emirates, 100 Trips</p>
                        </a>
                    </li>
                    <li id="ph3">
                        <a href="dubai.php" class="image-link">
                        <h5>Jumeirah Beach</h5>
                        <p>United Arab Emirates, 100 Trips</p>
                        </a>
                    </li>

                </ul>
                 </div>
                <div id="partie2">
                    <ul>
                        <li id="ph4">
                            <a href="austria.php" class="image-link">
                                <h5>Hallstatt</h5>
                                <p>Austria, 100 Trips</p>
                            </a>
                        </li>
                        <li id="ph5">
                            
                                <p class="orange">20% off on first travel</p>
                                <h5>It will be the best experience of your life</h5>
                            
                            <a class="button-2" href="bookin.php">Book now</a>
                        </li>
                    </ul>
                </div>

                <div id="partie3">
                    <ul>
                        <li id="ph6">
                            <a href="vietnam.php" class="image-link">
                            <h5>Cai Rang Floating Market</h5>
                            <p>Vietnam, 100 Trips</p>
                            </a>
                        </li>
                        <li id="ph7">
                            <a href="thailand.php" class="image-link">
                            <h5>Koh Tapu Island </h5>
                            <p>Thailand, 100 Trips</p>
                            </a>
                        </li>
                        <li id="ph8">
                            <a href="switzerland.php" class="image-link">
                            <h5>Lauterbrunnen</h5>
                            <p>Switzerland, 150 Trips</p>
                            </a>
                        </li>
    
                    </ul>
                     </div>
            </div>
            <div class="clear"></div>
        </section>


        
        <section class="know">
            <div class="wrapper">
                <div id="texte">
                    <p class="orange">GET TO KNOW US</p>
                    <h4 id="l1">Experience the World </h4> 
                    <h4 id="l2">With US</h4>
                    <p id="parag">Our travel website offers a seamless and exciting way to explore the world.
                 Whether you're looking for exotic destinations, </p>
                 <p id="parag2">adventure-packed getaways, or relaxing retreats,
                  we’ve got you covered.</p>
                </div>

                <div id="k2">
                    <img src="image/ph9.png" alt="Destination" width="490" height="300">

                </div>
                <div id="k3">
                    <ul>
                        <li>
                            <img src="image/ph10.png">
                            <h4>Luxury Trip</h4>
                            <p>Our algorithm connects you with like-minded partners using your interests.</p>
                        </li>
                        <li>
                            <img src="image/ph11.png">
                            <h4>Affordable Budget</h4>
                            <p>Your safety is a priority. We ensure strict security for your information.</p>
                        </li>
                        <li>
                            <img src="image/ph12.png">
                            <h4>Personalized approach</h4>
                            <p>Effortlessly navigate and find your perfect match </p>
                        </li>
                        <li>
                            <img src="image/ph13.png">
                            <h4>Experienced <br> Guide</h4>
                            <p>Our team is available 24/7 to assist you with any queries or concern.</p>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="clear"></div>

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
        <script src="profile.js"></script>

    </body>
</html>