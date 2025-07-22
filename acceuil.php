
<?php
session_start();
include 'profile.php'; 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="acceuil.css">
        <link rel="stylesheet" href="profile.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Crete+Round:ital@0;1&display=swap" rel="stylesheet">
        <title>Travel Agency</title>
    </head>
    <body>
       <header>
    <div class="wrapper">
        <h1>Travel Agency<span class="orange">.</span></h1>
        <nav>
            <ul>
                <li><a href="acceuil.php">ACCEUIL</a></li>
                <li><a href="#pos">DESTINATIONS</a></li>
                <li><a href="contact.php">CONTACT</a></li>
                <li id="l4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="#" style="cursor: pointer;">
                            <img src="image/pers.png" width="30px" height="30px">
                        </a>
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
<?php if (isset($_SESSION['user_id'])) echo showProfileDropdown(); ?>
        <section id="main-img">
            <div class="wrapper">

            <h2>organiser votre<br><strong>voyage sur mesure</strong></h2>
            <a href="destination.php" class="button-1">Par ici</a>
            </div>
        </section>
        <section id="steps">
            <div class="wrapper">
            <ul>
                <li id="step-1">
                    <h4>plannifier</h4>
                    <p>Confiez-nous vos rêves d'évasion : en famille ou entre amis, nous trouverons la formule qui comblera vos attentes.</p>
                </li>
                <li id="step-2">
                    <h4>organiser</h4>
                    <p>Bénéficiez de l'expertise de nos spécialistes de chaque destination, ils vous accompagnent dans la réalisation de votre voyage.</p>
                </li>
                <li id="step-3">
                    <h4>voyager</h4>
                    <p>Nous nous chargeons d'assurer votre sécurité et de veiller à votre pleine sérénité tout au long de votre voyage.</p>
                </li>
            </ul>
            </div>
            <div class="clear"></div>
        </section>
        <section id="pos">
            <div class="wrapper">
                <article style="background-image: url(image/article-image-1.jpg);">
                    <div class="overlay">
                        <h4>partez en famille</h4>
                        <p><small>Offrez le meilleur à ceux que vous aimez et partagez des moments fabuleux !</small></p>
                        <a class="button-2" href="bookin.php">Plus d'info</a>
                    </div>
                    
                </article>
                
                <article style="background-image: url(image/article-image-2.jpg);">
                    <div class="overlay">
                        <h4>envie de s'evader</h4>
                        <p><small>Parfois un peu d'évasion serait le bienvenue et ferait le plus grand bien !</small></p>
                        <a class="button-2" href="bookin.php">Plus d'info</a>
                    </div>
                    
                </article>
                <div class="clear"></div>
            </div>
        </section>
        <section id="cont">
            <div class="wrapper">
                <h3>contactez-nous</h3>
                <p>Chez Travel Agency nous savons que voyager est une aventure humaine mais également un engagement financier important pour vous. C'est pourquoi nous mettons un point d'honneur à prendre en compte chacune de vos attentes pour vous aider dans la préparation de votre séjour, circuit ou voyage sur mesure.</p>
                
                   
                    <a href="contact.php" class="button-3">send a message</a>
            

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