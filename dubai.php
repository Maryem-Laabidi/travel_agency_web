<?php
require_once 'auth-check.php';
require_once 'db-config.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get destination name from filename
$current_file = basename($_SERVER['PHP_SELF'], '.php');
$destination_name = ucfirst($current_file);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_now'])) {
    $one_night_price = 200;
    $user_id = $_SESSION['user_id'];

    // Use isset() instead of ?? for compatibility
    $check_in_date = isset($_POST['check_in']) ? $_POST['check_in'] : null;
    $check_out_date = isset($_POST['check_out']) ? $_POST['check_out'] : null;
    $total_price = isset($_POST['total_price']) ? $_POST['total_price'] : 0;

    // Validate that both dates are provided
    if (empty($check_in_date)) {
        die("Check-in date is required");
    }

    if (empty($check_out_date)) {
        die("Check-out date is required");
    }

    // Calculate duration
    try {
        $start = new DateTime($check_in_date);
        $end = new DateTime($check_out_date);

        if ($end <= $start) {
            die("Check-out date must be after check-in date");
        }

        $interval = $start->diff($end);
        $duration = $interval->days;
    } catch (Exception $e) {
        die("Invalid date format: " . $e->getMessage());
    }

    if (isset($_POST['trip_id'])) {
        // Update existing trip
        $stmt = $conn->prepare("UPDATE user_trips SET 
            one_night_price = ?, 
            duration = ?,
            check_in_date = ?,
            check_out_date = ?,
            total_price = ?
            WHERE id = ? AND user_id = ?");
        $stmt->bind_param("dissdii",
            $one_night_price,
            $duration,
            $check_in_date,
            $check_out_date,
            $total_price,
            $_POST['trip_id'],
            $user_id);
    } else {
        // Insert new trip
        $stmt = $conn->prepare("INSERT INTO user_trips 
            (user_id, destination_name, one_night_price, duration, check_in_date, check_out_date, total_price) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isdissd",
            $user_id,
            $destination_name,
            $one_night_price,
            $duration,
            $check_in_date,
            $check_out_date,
            $total_price);
    }

    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    header("Location: bookin.php");
    exit();
}

// Load trip data if editing
$tripData = [];
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT *, 
        DATE_FORMAT(check_in_date, '%Y-%m-%d') as check_in_date,
        DATE_FORMAT(check_out_date, '%Y-%m-%d') as check_out_date
        FROM user_trips 
        WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $_GET['edit'], $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $tripData = $result->fetch_assoc();

    if (!$tripData) {
        header("Location: bookin.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="details.css">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Crete+Round:ital@0;1&display=swap" rel="stylesheet">
      <title>Dubai</title>
  </head>
  <body>
      <header>
          <div class="wrapper">
          
              <h1>Travel Agency<span class="orange">.</span></h1>
              <nav>
                  <ul>
                      <li><a href="acceuil.php">ACCEUIL</a></li>
                      <li><a href="destination.php">DESTINATIONS</a></li>
                      <li><a href="login.php">CONTACT</a></li>
                  </ul>
              </nav>
          </div>
      </header>

      <section id="main_dest" style="background: url('image/dubai4.png') no-repeat;">
          <div class="wrapper">
              <h2>Destination</h2>
              
          </div>
      </section>

      <section id="detphotos">
          <div class="wrapper">
          <div id="detp1">
              <img src="image/db1.jpg" >
          </div>
          <div id="det23">
              <ul>
                  <li><img src="image/db2.jpg" ></li>
                  <li><img src="image/db3.webp" ></li>
              </ul>
              
              
          </div>
          </div>
          <div class="clear"></div>
      </section>
      <section id="conteneur">
          <div class="wrapper">
      <section id="lf">
          
              <div id="part1">
              <ul>
                  <li class="blue">0.5</li>
                  <li class="pink">Perfect</li>
                  <li class="blue">Hotels</li>
                  <li class="pink">Building</li>
                  <li class="blue">Top value</li>
                  <li>⭐⭐⭐⭐⭐</li>
              </ul>
              <h1>Honouring History <br>and Heritage in Dubai UAE</h1>

              </div>
          <div id="part2">
              <ul>
                  <li><a href="#" data-target="description">Description</a></li>
                  <li><a href="#" data-target="features">Features</a></li>
                  <li><a href="#"  data-target="virtual">Virtual</a></li>
                  <li><a href="#" data-target="price">Price history</a></li>
              </ul>
              <div id="change">
                  <h5>🌆 Dubai – The City of Dreams</h5>

                  <p id="description" class="active">
                      Dubai is a dazzling destination where futuristic skyscrapers rise from golden sands, 
                      and luxury blends seamlessly with rich Arabian heritage. Located in the United Arab Emirates,
                       this vibrant city is known for its innovation, opulence, and unforgettable experiences. 
                       
                      
  
                  </p>
                  
                  <p id="features" class="hidden">
                      Dubai is a city of wonders where tradition meets innovation. From towering skyscrapers 
                      like the Burj Khalifa to luxurious shopping malls, pristine beaches, and thrilling desert safaris,
                       Dubai offers something for every traveler. Highlights include Dubai Marina, Palm Jumeirah, Dubai Mall,
                        the Dubai Fountain, and indoor skiing at Ski Dubai. 
                      
                  </p>
                  <p id="virtual" class="active">
                      Before you even book your flight, Dubai gives you a taste of its glamour through stunning virtual tours and
                       VR experiences. Visit the top of the Burj Khalifa,
                       walk through the immersive halls of the Dubai Aquarium, or glide across the desert in a virtual safari — all online.
                  </p>

                  <p id="price" class="hidden">
                      Dubai is known for its luxury, but it also offers travel experiences for a range of budgets. 
                      Over the last few years, a 4-day mid-range trip costs around $400 to $700 USD per person, covering hotel stays, transportation, and
                       basic activities. Luxury packages with premium hotels, desert tours, and exclusive attractions can exceed $1,500 USD.
                  </p>
              </div>

              
              
          </div>

          <div id="hotel">
              <h2>Hotel Features</h2>
              <ul>
                  <li>
                      <img src="image/h1.webp" >
                      <h5>Wifi</h5>
                  </li>
                  <li>
                      <img src="image/h2.png" >
                      <h5>Swimming</h5>
                  </li>
                  <li>
                      <img src="image/h3.jpg" >
                      <h5>Breakfast</h5>
                  </li>
                  <li>
                      <img src="image/h4.jpg">
                      <h5>Kids Bed</h5>
                  </li>
                  
                  <li>
                      <img src="image/h5.jpg">
                      <h5>4m x 6m</h5>
                  </li>
              </ul>
              <form>
                  <input type="button" value="More Details" class="hotelbutton">
              </form>
          </div>



          <div id="fleche">

          <div id="f1">
              <div class="titre">
                  <h2  class="t1">What destinations do we offer tours to ?</h2>
                  <h2><span class="arrow"> ᐳ</span></h2>
              </div>
              
              <p class="hidden">We offer tours to a diverse range of breathtaking destinations, each selected for its unique charm 
                  and unforgettable experiences. From the snowy peaks 
                  of Pahalgam in Kashmir to the golden deserts of Dubai, 
                  our tours cover a variety of landscapes and cultures.</p>
          </div>
          <div id="f2">
              <div class="titre">
                  <h2 class="t1">What types of services do we provide ? </h2>
                  <h2><span class="arrow"> ᐳ</span></h2>
              </div>
              <p class="hidden">Our travel agency provides a full range of services designed to make your trip smooth and memorable.
                   We handle transportation, accommodation bookings, guided tours, visa assistance, travel insurance,
                    and custom itinerary planning.
                   We also offer 24/7 support to ensure you have assistance at every step of your journey.</p>
          </div>
          <div id="f3">
              <div class="titre" >
                  <h2  class="t1">What is included in the tour package ? </h2>
                  <h2><span class="arrow"> ᐳ</span></h2>
              </div>
              
              
              <p class="hidden">Our tour packages are designed to offer a complete and stress-free experience.
                   Each package typically includes round-trip transportation, comfortable accommodations,
                    daily breakfast, guided sightseeing tours, and entry tickets to main attractions. Some packages may also include adventure activities,
                   cultural experiences, and airport transfers, depending on the destination.</p>
          </div>
          <div id="f4">
              <div class="titre">
                  <h2  class="t1">What should i pack for my trip ? </h2>
                  <h2><span class="arrow"> ᐳ</span></h2>
              </div>
              
             
              <p class="hidden">
                  Packing depends on your destination, but we recommend bringing comfortable clothes,
                   good walking shoes, and weather-appropriate gear (such as jackets for mountain regions or light clothing
                    for deserts).
                  Do not forget your passport, travel documents, personal medications, camera, and a power bank. 
              </p>

          </div>
              
          </div>
          
          
      </section>

      <section id="rt">
                  <div id="prix">
                      <h2>200$</h2>
                      <p>/one night</p>
                      <button>20% off</button>
                  </div>

                  <form method="POST" id="booking-form">
                      <div id="dates">
                          <div>
                              <label for="d1">Check In</label>
                              <input id="d1" type="date" name="check_in" 
                                     value="<?= !empty($tripData) ? htmlspecialchars($tripData['check_in_date']) : '' ?>" 
                                     required>
                          </div>
                          <div>
                              <label for="d2">Check Out</label>
                              <input id="d2" type="date" name="check_out" 
                                     value="<?= !empty($tripData) ? htmlspecialchars($tripData['check_out_date']) : '' ?>" 
                                     required>
                          </div>
                      </div>

                      <div id="guest">
                          <label>Travelers</label>
                          <select name="travelers">
                              <option value="1 Adulte">1 Adulte</option>
                              <option value="2 Adultes">2 Adultes</option>
                              <option value="2 Adultes , 1 bébé">2 Adultes , 1 bébé</option>
                              <option value="2 Adultes , 1 enfant">2 Adultes , 1 enfant</option>
                          </select>
                      </div>

                      <div id="extra">
                          <p>Extra Features</p>
                          <div>
                              <input type="checkbox" name="pet" id="pet"> <label for="pet">Allow to bring pet</label><br>
                              <input type="checkbox" name="parking" id="parking"> <label for="parking">Parking</label><br>
                              <input type="checkbox" name="pillow" id="pillow"> <label for="pillow">Extra pillow</label><br>
                          </div>
                      </div>

                      <div id="total">
                          <label>Price</label>
                          <ul>
                              <li>
                                  <p>Nights</p>
                                  <h5 id="number">0$</h5>
                              </li>
                              <li>
                                  <p>Discount 20%</p>
                                  <h5 id="discount">0$</h5>
                              </li>
                              <li>
                                  <p>Breakfast per person</p>
                                  <h5>10$</h5>
                              </li>
                              <li>
                                  <p>Service fee</p>
                                  <h5>5$</h5>
                              </li>
                          </ul>
                      </div>

                      <div id="book">
                          <h5>Total payment</h5>
                          <h5 id="totale">0$</h5>
                          <input type="hidden" name="check_in" id="check_in_hidden">
                          <input type="hidden" name="check_out" id="check_out_hidden">
                          <input type="hidden" name="nights" id="nights-hidden" value="<?= !empty($tripData) ? $tripData['duration'] : '1' ?>">
                          <input type="hidden" name="total_price" id="total_price_hidden" value="">
                          <?php if (!empty($tripData)): ?>
                              <input type="hidden" name="trip_id" value="<?= $tripData['id'] ?>">
                          <?php endif; ?>
                          <button type="submit" name="book_now" id="enregistrer">
                              <?= empty($tripData) ? 'Book Now' : 'Update Booking' ?>
                          </button>
                          <p>You will not get charged yet</p>
                      </div>
                  </form>
              </section>
      
      
    </div>
        <div class="clear"></div>
        </section>


        <section id="know">
            <div class="wrapper">
                <div id="texte">
                    <p class="orange">GET TO KNOW US</p>
                    <h4 >Experience the World<br> With US </h4> 
                    <p >Our travel website offers a seamless and exciting way to explore the world.
                 Whether you're looking for exotic destinations,adventure-packed getaways, or relaxing retreats,
                 we've got you covered. </p>
                  
                </div>
                <div id="k2">
                    <img src="image/t1-removebg-preview.png">
                </div>
            </div>
           
        </section>
        <div class="clear"></div>
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
                        <img src="image/g1.avif" width="300px" height="200px">
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

        

        <script src="details.js"></script>

    </body>
</html>
