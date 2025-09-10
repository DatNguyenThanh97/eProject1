<?php
  include 'db_connect.php';
  $db = get_db();
  $db->query("UPDATE visitor_count SET total_visits = total_visits + 1 WHERE id = 1"); 
  $visitor_total = 0; 
  if ($res = @$db->query("SELECT total_visits FROM visitor_count WHERE id = 1")) { 
    if ($row = $res->fetch_assoc()) { 
      $visitor_total = (int)$row['total_visits']; 
    } 
    $res->free(); 
  }
?>
<!DOCTYPE html>
<html lang="en-US" class="js scheme_light">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="format-detection" content="telephone=no" />
    <title>MOONLIGHT EVENTS - Global Festivals Around the World</title>
    <meta
      name="description"
      content="MOONLIGHT EVENTS organizes festivals worldwide, collaborating with cities and local city associations to promote cultural understanding and tolerance among youth."
    />
    <meta name="robots" content="noindex, nofollow" />

    <!-- CSS Files -->
    <link
      rel="stylesheet"
      href="./MOONLIGHT EVENTS - Global Festivals_files/style.css"
      type="text/css"
      media="all"
    />
    <link
      rel="stylesheet"
      href="./MOONLIGHT EVENTS - Global Festivals_files/responsive.css"
      type="text/css"
      media="(max-width:1439px)"
    />
    <link
      rel="stylesheet"
      href="./MOONLIGHT EVENTS - Global Festivals_files/animations.css"
      type="text/css"
      media="all"
    />
    <link
      rel="stylesheet"
      href="./MOONLIGHT EVENTS - Global Festivals_files/gallery.css"
      type="text/css"
      media="all"
    />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cardo:wght@400;700&family=Work+Sans:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <!-- Font Awesome Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
  </head>

  <body>
    <!-- Header -->
    <header class="header">
      <div class="container">
        <div class="header-content">
          <a href="#" class="logo">
            <i class="fas fa-moon"></i>
            <span>MOONLIGHT EVENTS</span>
          </a>

          <nav>
            <ul class="nav-menu">
              <li><a href="#home">Home</a></li>
              <li><a href="#festivals">Festivals</a></li>
              <li><a href="#gallery">Gallery</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </nav>

          <div class="visitor-count">
            <i class="fas fa-users"></i>
            <span id="visitorCount"
              ><?php echo number_format($visitor_total); ?></span
            >
            visitors
          </div>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero" data-route="home">
      <div class="container">
        <div class="hero-content">
          <h1>Global Festivals Around the World</h1>
          <p>
            MOONLIGHT EVENTS organizes festivals worldwide, promoting cultural
            understanding and tolerance among youth through the celebration of
            diverse traditions and artistic expressions.
          </p>
          <a href="#festivals" class="cta-button">Explore Festivals</a>
        </div>
      </div>
    </section>

    <!-- Festival Categories by Country -->
    <section id="festivals" class="festival-categories" data-route="festivals">
      <div class="container">
        <h2 class="section-title">Festivals by Country</h2>

        <div class="categories-grid">
          <div class="category-card">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/india-festival.jpg"
              alt="Indian Festivals"
            />
            <div class="category-content">
              <h3>India</h3>
              <p>
                Experience the vibrant colors and rich traditions of Diwali,
                Holi, and other cultural celebrations.
              </p>
              <a href="#" class="btn" onclick="openFestivalModal('india')"
                >Learn More</a
              >
            </div>
          </div>

          <div class="category-card">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/japan-festival.jpg"
              alt="Japanese Festivals"
            />
            <div class="category-content">
              <h3>Japan</h3>
              <p>
                Discover the beauty of Cherry Blossom festivals, Tanabata, and
                traditional matsuri celebrations.
              </p>
              <a href="#" class="btn" onclick="openFestivalModal('japan')"
                >Learn More</a
              >
            </div>
          </div>

          <div class="category-card">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/brazil-festival.jpg"
              alt="Brazilian Festivals"
            />
            <div class="category-content">
              <h3>Brazil</h3>
              <p>
                Immerse yourself in the energy of Carnival, Festa Junina, and
                other Brazilian cultural events.
              </p>
              <a href="#" class="btn" onclick="openFestivalModal('brazil')"
                >Learn More</a
              >
            </div>
          </div>

          <div class="category-card">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/mexico-festival.jpg"
              alt="Mexican Festivals"
            />
            <div class="category-content">
              <h3>Mexico</h3>
              <p>
                Celebrate Dia de los Muertos, Cinco de Mayo, and other vibrant
                Mexican traditions.
              </p>
              <a href="#" class="btn" onclick="openFestivalModal('mexico')"
                >Learn More</a
              >
            </div>
          </div>

          <div class="category-card">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/thailand-festival.jpg"
              alt="Thai Festivals"
            />
            <div class="category-content">
              <h3>Thailand</h3>
              <p>
                Experience Songkran, Loy Krathong, and other beautiful Thai
                cultural celebrations.
              </p>
              <a href="#" class="btn" onclick="openFestivalModal('thailand')"
                >Learn More</a
              >
            </div>
          </div>

          <div class="category-card">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/italy-festival.jpg"
              alt="Italian Festivals"
            />
            <div class="category-content">
              <h3>Italy</h3>
              <p>
                Discover Carnevale di Venezia, Palio di Siena, and other Italian
                cultural treasures.
              </p>
              <a href="#" class="btn" onclick="openFestivalModal('italy')"
                >Learn More</a
              >
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Festival Categories by Religion -->
    <section class="festival-categories" style="background: var(--white)" data-route="festivals">
      <div class="container">
        <h2 class="section-title">Festivals by Religion</h2>

        <div class="categories-grid">
          <div class="category-card">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/hindu-festival.jpg"
              alt="Hindu Festivals"
            />
            <div class="category-content">
              <h3>Hindu Festivals</h3>
              <p>
                Celebrate Diwali, Holi, Navratri, and other sacred Hindu
                celebrations.
              </p>
              <a href="#" class="btn" onclick="openFestivalModal('hindu')"
                >Learn More</a
              >
            </div>
          </div>

          <div class="category-card">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/christian-festival.jpg"
              alt="Christian Festivals"
            />
            <div class="category-content">
              <h3>Christian Festivals</h3>
              <p>
                Experience Christmas, Easter, and other Christian religious
                celebrations.
              </p>
              <a href="#" class="btn" onclick="openFestivalModal('christian')"
                >Learn More</a
              >
            </div>
          </div>

          <div class="category-card">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/islamic-festival.jpg"
              alt="Islamic Festivals"
            />
            <div class="category-content">
              <h3>Islamic Festivals</h3>
              <p>
                Celebrate Eid al-Fitr, Eid al-Adha, and other Islamic cultural
                events.
              </p>
              <a href="#" class="btn" onclick="openFestivalModal('islamic')"
                >Learn More</a
              >
            </div>
          </div>

          <div class="category-card">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/buddhist-festival.jpg"
              alt="Buddhist Festivals"
            />
            <div class="category-content">
              <h3>Buddhist Festivals</h3>
              <p>
                Discover Vesak, Songkran, and other Buddhist cultural
                celebrations.
              </p>
              <a href="#" class="btn" onclick="openFestivalModal('buddhist')"
                >Learn More</a
              >
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Filters Section -->
    <section class="filters" data-route="festivals" data-route="gallery">
      <div class="container">
        <h3 style="text-align: center; margin-bottom: 2rem">
          Filter Festivals
        </h3>
        <div class="filter-controls">
          <select class="filter-select" id="religionFilter">
            <option value="">All Religions</option>
            <option value="hindu">Hindu</option>
            <option value="christian">Christian</option>
            <option value="islamic">Islamic</option>
            <option value="buddhist">Buddhist</option>
            <option value="secular">Secular</option>
          </select>

          <select class="filter-select" id="monthFilter">
            <option value="">All Months</option>
            <option value="january">January</option>
            <option value="february">February</option>
            <option value="march">March</option>
            <option value="april">April</option>
            <option value="may">May</option>
            <option value="june">June</option>
            <option value="july">July</option>
            <option value="august">August</option>
            <option value="september">September</option>
            <option value="october">October</option>
            <option value="november">November</option>
            <option value="december">December</option>
          </select>

          <select class="filter-select" id="collectionFilter">
            <option value="">All Collections</option>
            <option value="cultural">Cultural</option>
            <option value="religious">Religious</option>
            <option value="seasonal">Seasonal</option>
            <option value="historical">Historical</option>
          </select>
        </div>
      </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="gallery" data-route="gallery">
      <div class="container">
        <h2 class="section-title">Festival Gallery</h2>
        <div class="gallery-grid">
          <div class="gallery-item" onclick="openFestivalModal('gallery1')">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/gallery1.jpg"
              alt="Festival Image 1"
            />
            <div class="gallery-overlay">
              <h4>Holi Festival - India</h4>
              <p>Festival of Colors</p>
            </div>
          </div>

          <div class="gallery-item" onclick="openFestivalModal('gallery2')">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/gallery2.jpg"
              alt="Festival Image 2"
            />
            <div class="gallery-overlay">
              <h4>Cherry Blossom - Japan</h4>
              <p>Hanami Celebration</p>
            </div>
          </div>

          <div class="gallery-item" onclick="openFestivalModal('gallery3')">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/gallery3.jpg"
              alt="Festival Image 3"
            />
            <div class="gallery-overlay">
              <h4>Carnival - Brazil</h4>
              <p>Rio de Janeiro</p>
            </div>
          </div>

          <div class="gallery-item" onclick="openFestivalModal('gallery4')">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/gallery4.jpg"
              alt="Festival Image 4"
            />
            <div class="gallery-overlay">
              <h4>Dia de los Muertos - Mexico</h4>
              <p>Day of the Dead</p>
            </div>
          </div>

          <div class="gallery-item" onclick="openFestivalModal('gallery5')">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/gallery5.jpg"
              alt="Festival Image 5"
            />
            <div class="gallery-overlay">
              <h4>Songkran - Thailand</h4>
              <p>Water Festival</p>
            </div>
          </div>

          <div class="gallery-item" onclick="openFestivalModal('gallery6')">
            <img
              src="./MOONLIGHT EVENTS - Global Festivals_files/gallery6.jpg"
              alt="Festival Image 6"
            />
            <div class="gallery-overlay">
              <h4>Carnevale - Italy</h4>
              <p>Venice Carnival</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- About Us Section -->
    <section
      id="about"
      class="festival-categories"
      style="background: var(--bg-light)"
      data-route="about"
    >
      <div class="container">
        <h2 class="section-title">About MOONLIGHT EVENTS</h2>
        <div style="max-width: 800px; margin: 0 auto; text-align: center">
          <p style="font-size: 1.1rem; line-height: 1.8; margin-bottom: 2rem">
            MOONLIGHT EVENTS organizes festivals worldwide, collaborating with
            cities and local city associations where we have been organizing
            festivals for many years. Our festivals aim to strengthen young
            people's understanding of different cultures, develop their
            tolerance towards cultural differences, and respect ethnic
            characteristics and unique forms of artistic creativity.
          </p>
          <p style="font-size: 1.1rem; line-height: 1.8; margin-bottom: 2rem">
            Our main goal is to disseminate information about local festivals
            and discover talents, supporting their creativity. Festivals are
            organized to encourage academic, professional, and cultural exchange
            between groups.
          </p>
          <a href="#" class="cta-button" onclick="downloadAboutPDF()"
            >Download About Us (PDF)</a
          >
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section
      id="contact"
      class="festival-categories"
      style="background: var(--white)"
      data-route="contact"
    >
      <div class="container">
        <h2 class="section-title">Contact Us</h2>
        <div style="max-width: 600px; margin: 0 auto; text-align: center">
          <div style="margin-bottom: 2rem">
            <h3 style="color: var(--primary-color); margin-bottom: 1rem">
              Get in Touch
            </h3>
            <p style="margin-bottom: 1rem">
              <i
                class="fas fa-envelope"
                style="color: var(--primary-color); margin-right: 10px"
              ></i>
              <strong>Email:</strong> info@moonlightevents.com
            </p>
            <p style="margin-bottom: 1rem">
              <i
                class="fas fa-phone"
                style="color: var(--primary-color); margin-right: 10px"
              ></i>
              <strong>Phone:</strong> +1 (555) 123-4567
            </p>
            <p style="margin-bottom: 1rem">
              <i
                class="fas fa-map-marker-alt"
                style="color: var(--primary-color); margin-right: 10px"
              ></i>
              <strong>Address:</strong> 123 Festival Street, Cultural District,
              Global City, GC 12345
            </p>
          </div>

          <div style="margin-bottom: 2rem">
            <h3 style="color: var(--primary-color); margin-bottom: 1rem">
              Send Feedback
            </h3>
            <form id="feedbackForm" style="text-align: left">
              <div style="margin-bottom: 1rem">
                <label
                  for="name"
                  style="display: block; margin-bottom: 5px; font-weight: 500"
                  >Name:</label
                >
                <input
                  type="text"
                  id="name"
                  name="name"
                  required
                  style="
                    width: 100%;
                    padding: 10px;
                    border: 2px solid #ddd;
                    border-radius: 5px;
                  "
                />
              </div>
              <div style="margin-bottom: 1rem">
                <label
                  for="email"
                  style="display: block; margin-bottom: 5px; font-weight: 500"
                  >Email:</label
                >
                <input
                  type="email"
                  id="email"
                  name="email"
                  required
                  style="
                    width: 100%;
                    padding: 10px;
                    border: 2px solid #ddd;
                    border-radius: 5px;
                  "
                />
              </div>
              <div style="margin-bottom: 1rem">
                <label
                  for="message"
                  style="display: block; margin-bottom: 5px; font-weight: 500"
                  >Message:</label
                >
                <textarea
                  id="message"
                  name="message"
                  rows="4"
                  required
                  style="
                    width: 100%;
                    padding: 10px;
                    border: 2px solid #ddd;
                    border-radius: 5px;
                    resize: vertical;
                  "
                ></textarea>
              </div>
              <button type="submit" class="cta-button" style="width: 100%">
                Send Feedback
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <div class="footer-content">
          <div class="footer-section">
            <h3>Quick Links</h3>
            <a href="#home">Home</a>
            <a href="#festivals">Festivals</a>
            <a href="#gallery">Gallery</a>
            <a href="#about">About Us</a>
            <a href="#contact">Contact</a>
          </div>

          <div class="footer-section">
            <h3>Festival Categories</h3>
            <a href="#festivals">By Country</a>
            <a href="#festivals">By Religion</a>
            <a href="#festivals">By Month</a>
            <a href="#festivals">By Collection</a>
          </div>

          <div class="footer-section">
            <h3>Resources</h3>
            <a href="#" onclick="downloadAboutPDF()">About Us PDF</a>
            <a href="#" onclick="downloadFestivalGuide()">Festival Guide</a>
            <a href="#" onclick="openFAQModal()">FAQ</a>
            <a href="#" onclick="openSiteMap()">Site Map</a>
          </div>

          <div class="footer-section">
            <h3>Connect With Us</h3>
            <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
            <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
            <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
            <a href="#"><i class="fab fa-youtube"></i> YouTube</a>
          </div>
        </div>

        <div
          style="
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #444;
          "
        >
          <p>
            &copy; 2024 MOONLIGHT EVENTS. All rights reserved. | Promoting
            Global Cultural Understanding
          </p>
        </div>
      </div>
    </footer>

    <!-- Scrolling Ticker -->
    <div class="scrolling-ticker">
      <div class="ticker-content">
        <span id="currentDateTime"></span> |
        <span id="currentLocation"></span> |
        <span>MOONLIGHT EVENTS - Connecting Cultures Through Festivals</span> |
        <span>Next Festival: Holi Celebration in India - March 25, 2024</span> |
        <span
          >Join us in celebrating diversity and cultural heritage
          worldwide!</span
        >
      </div>
    </div>

    <!-- Festival Modal -->
    <div id="festivalModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeFestivalModal()">&times;</span>
        <div id="modalContent">
          <!-- Modal content will be loaded here -->
        </div>
      </div>
    </div>

    <!-- JavaScript -->
    <!-- JavaScript -->
    <script src="./MOONLIGHT EVENTS - Global Festivals_files/main.js"></script>
  </body>
</html>