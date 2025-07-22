<?php
require_once 'db.php';
require_once 'auth-check.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['msg']) && 
    !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    
    $message = trim($_POST['msg']);
    
    // Double-check for empty message
    if (empty($message)) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Empty message']);
        exit;
    }
    
    $message = htmlspecialchars($message);
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $stmt = $conn->prepare("INSERT INTO messages (message, ip_address) VALUES (?, ?)");
    $stmt->bind_param("ss", $message, $ip);
    
    header('Content-Type: application/json');
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit;
}
?>

       

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="contact.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Crete+Round:ital@0;1&display=swap" rel="stylesheet">
        <title>Contact</title>
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
                <h2>Contact Us</h2>
            </div>
        </section>

    
        <section id="red">
            <div class="wrapper">
            <h1>Were're here for you</h1>
            <h5>Feel free to ask any question, share your feedback,
                 or express your opinion<br>our team will carefully review your message and respond to you promptly via email</h5>
            
                 <?php if (isset($success)): ?>
                 <div class="success-msg"><?= $success ?></div>
                 <?php elseif (isset($error)): ?>
                <div class="error-msg"><?= $error ?></div>
                <?php endif; ?>
                <form id="contactForm" method="POST">
                <textarea name="msg" required></textarea>
                     <input type="submit" value="Send message">
                     <div id="formMessage" style="margin-top: 15px;"></div>
                </form>

                 
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
        
        <script>
            document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const messageInput = document.querySelector('textarea[name="msg"]'); // Changed from input to textarea
    const messageDiv = document.getElementById('formMessage');
    const form = this;
    
    // Check if message is empty
    if (messageInput.value.trim() === '') {
        messageDiv.innerHTML = '<p style="color: red; margin-top: 15px;">Please enter a message before sending.</p>';
        return;
    }
    
    fetch('contact.php', {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            messageDiv.innerHTML = '<p style="color: #ff7a00; margin: 2% 0 0 3%;font-family: Crete Round;">Thank you! Your message has been submitted.</p>';
            form.reset();
        } else {
            messageDiv.innerHTML = '<p style="color: red; margin-top: 15px;">Error: ' + (data.error || 'Message not sent') + '</p>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        messageDiv.innerHTML = '<p style="color: red; margin-top: 15px;">Error: ' + error.message + '</p>';
    });
});
        </script>
    </body>
</html>