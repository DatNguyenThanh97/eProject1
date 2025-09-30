<?php
require_once 'db_connect.php';
require_once 'site_data.php';
require_once 'theme.php';

$db = get_db();
$visitor_total = get_visitor_count($db);
$hero = get_hero_data($db);

$festivalClass = getFestivalClassFromDB();
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
      href="./assets/css/style.css"
      type="text/css"
      media="all"
    />
    <link
      rel="stylesheet"
      href="./assets/css/responsive.css"
      type="text/css"
      media="(max-width:1439px)"
    />
    <link
      rel="stylesheet"
      href="./assets/css/animations.css"
      type="text/css"
      media="all"
    />
    <link
      rel="stylesheet"
      href="./assets/css/gallery.css"
      type="text/css"
      media="all"
    />

    <!-- Font Awesome Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
  </head>

  <body class="<?php echo $festivalClass; ?>">
    <!-- Header -->
    <header class="header">
      <div class="container">
        <div class="header-content">
          <a href="#home" class="logo">
             <svg class="logo-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300.000000 275.000000">
              <g transform="translate(0.000000,275.000000) scale(0.100000,-0.100000)"fill="currentColor" stroke="none">
                <!-- ... toàn bộ <path> ... -->
                  <path d="M1715 2380 c11 -5 27 -9 35 -9 9 0 8 4 -5 9 -11 5 -27 9 -35 9 -9 0
                  -8 -4 5 -9z"/>
                  <path d="M1775 2360 c3 -5 34 -26 68 -46 225 -132 373 -301 448 -514 37 -104
                  48 -172 50 -315 1 -101 -3 -136 -25 -220 -51 -194 -165 -380 -293 -477 -117
                  -87 -237 -140 -461 -202 -200 -56 -484 -17 -667 92 -139 82 -236 191 -323 360
                  -28 54 -58 105 -67 112 -8 7 -15 27 -15 44 0 34 -38 237 -45 245 -3 2 -5 -56
                  -5 -130 0 -151 22 -268 58 -314 12 -16 22 -42 22 -60 0 -47 70 -179 140 -263
                  34 -40 93 -99 133 -130 39 -31 96 -80 127 -108 70 -64 99 -84 125 -84 24 0
                  221 -89 262 -118 l29 -21 43 24 c32 19 68 27 149 35 200 20 367 62 481 120
                  181 92 383 284 412 393 7 26 25 54 49 76 44 41 101 167 120 268 20 102 8 349
                  -22 453 -73 252 -248 486 -478 639 -135 90 -340 182 -315 141z m470 -292 c69
                  -77 163 -204 190 -259 90 -176 120 -309 111 -488 -3 -69 -9 -128 -14 -133 -11
                  -11 -46 39 -76 108 -13 33 -40 95 -60 139 -20 44 -36 93 -36 108 0 83 -49 254
                  -109 382 -33 69 -71 171 -71 189 0 17 23 0 65 -46z m190 -750 c67 -149 54
                  -265 -51 -477 -55 -111 -77 -143 -145 -216 -74 -77 -144 -133 -154 -123 -3 2
                  10 40 27 84 28 69 32 94 36 196 l4 118 49 40 c26 23 51 51 54 63 3 12 31 100
                  62 195 66 198 77 209 118 120z m-319 -520 c19 -30 -9 -151 -50 -222 -28 -48
                  -109 -127 -152 -149 -16 -8 -64 -22 -106 -31 -72 -16 -84 -16 -163 -1 l-85 16
                  -48 -25 c-94 -48 -162 -65 -222 -56 -30 5 -63 9 -72 9 -32 2 -19 19 40 51 31
                  18 81 50 110 72 40 30 74 45 135 59 217 52 402 135 532 239 66 53 70 56 81 38z
                  m-1331 -62 c147 -119 267 -177 439 -211 71 -14 132 -28 135 -31 10 -11 -61
                  -63 -107 -79 -25 -8 -77 -15 -115 -15 -63 0 -78 4 -146 41 -108 59 -214 134
                  -260 184 -50 54 -97 144 -79 149 7 3 20 6 28 9 22 6 60 -10 105 -47z"/>
                  <path d="M1174 2250 c-248 -65 -443 -250 -530 -505 -25 -73 -28 -94 -28 -230
                  -1 -199 18 -280 80 -340 30 -30 44 -53 49 -81 9 -57 15 -68 70 -132 47 -55
                  159 -140 234 -177 57 -29 220 -65 285 -64 l61 1 -52 13 c-102 25 -182 71 -258
                  149 -85 85 -143 180 -181 291 -37 110 -40 284 -7 390 62 196 233 350 449 405
                  147 38 282 23 424 -47 104 -52 263 -208 309 -305 35 -74 86 -123 97 -93 10 25
                  -23 178 -55 261 -92 235 -309 416 -566 469 -104 21 -291 19 -381 -5z m323 -32
                  c15 -7 46 -13 68 -13 51 -2 178 -42 218 -69 18 -12 42 -37 55 -56 13 -19 37
                  -40 53 -45 57 -20 134 -110 174 -202 42 -99 44 -137 3 -75 -47 70 -160 180
                  -193 187 -16 3 -41 13 -55 21 -60 36 -150 75 -210 90 -52 13 -91 15 -190 10
                  -122 -5 -126 -5 -170 20 l-45 26 -88 -93 c-49 -52 -116 -130 -150 -174 -34
                  -44 -97 -116 -140 -160 -46 -46 -98 -113 -125 -159 l-46 -79 -9 34 c-12 46 8
                  197 38 282 53 153 193 324 314 385 35 18 74 32 85 32 12 0 48 11 81 25 52 21
                  75 25 182 25 73 0 133 -5 150 -12z m-647 -560 c0 -6 -7 -50 -16 -97 -12 -63
                  -15 -123 -12 -226 4 -124 8 -151 37 -234 17 -52 30 -96 28 -98 -7 -6 -85 85
                  -130 151 -22 33 -49 81 -59 108 -17 44 -17 53 -2 129 21 113 47 176 95 232 40
                  47 59 58 59 35z"/>
                  <path d="M1478 1739 c-116 -27 -250 -135 -301 -242 -40 -85 -50 -137 -45 -235
                  6 -107 33 -180 97 -259 151 -188 417 -227 620 -92 326 218 238 723 -144 825
                  -56 15 -170 17 -227 3z"/>
                  <path d="M2162 1460 c-9 -18 -10 -37 -4 -65 l9 -40 7 36 c4 20 6 49 4 65 l-4
                  29 -12 -25z"/>
                  <path d="M262 1059 c2 -7 10 -15 17 -17 8 -3 12 1 9 9 -2 7 -10 15 -17 17 -8
                  3 -12 -1 -9 -9z"/>
                  <path d="M291 866 l-22 -24 30 -21 c31 -22 53 -21 46 2 -2 7 -6 24 -9 40 -8
                  33 -16 34 -45 3z"/>
                  <path d="M2402 518 c5 -15 28 -18 29 -3 0 6 -7 12 -17 13 -10 3 -15 -1 -12
                  -10z"/>
                  <path d="M2246 413 c-30 -44 -21 -63 30 -63 41 0 47 10 39 60 -9 52 -35 53
                  -69 3z"/>
                  <path d="M2544 389 c-3 -6 0 -15 7 -20 13 -7 28 5 29 24 0 11 -28 8 -36 -4z"/>
              </g>
            </svg>
            <span class="logo-text">MOONLIGHT EVENTS</span>
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
    <section id="home" class="hero" data-route="home <?php echo htmlspecialchars($hero["slug"]); ?>"
    style="background-image: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,1)), url('<?php echo htmlspecialchars($hero["bg"]); ?>');">
      <div class="container">
        <div class="hero-content">
          <h1><?php echo htmlspecialchars($hero["title"]); ?></h1>
          <p><?php echo htmlspecialchars($hero["desc"]); ?></p>
          <a href="#festivals" class="cta-button">Explore Festivals</a>
        </div>
      </div>
    </section>

    <!-- Featured Festivals Section -->
    <section class="featured-festivals" data-route="home">
      <div class="container">
        <h2 class="section-title">Upcoming Festivals</h2>
        <?php include './components/featured-festival-grid.php'; ?>
      </div>
    </section>

    <!-- Festival Categories -->
    <section id="festivals" class="festival-categories" data-route="festivals">
      <div class="container">
        <h2 class="section-title">All Festivals</h2>
        <div id="festivalsGridContainer">
          <?php include "./components/festival-grid.php"; ?>
        </div>
        <div id="filterInfo"></div>
      </div>
    </section>
    
    <!-- Festival Modal -->
    <div id="festivalModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeFestivalModal()">&times;</span>
        <div id="modalContent">
          <!-- Modal content will be loaded here -->
        </div>
      </div>
    </div>

    <!-- Festival Detail -->
    <section class="festival-detail" data-route="detail">
      <div class="container">
        <h2 class="section-title">Christmas</h2>
        <div class="detail">
          <?php include "./components/festival-detail.php"?>
        </div>
      </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="gallery" data-route="gallery">
      <div class="container">
        <h2 class="section-title">Festival Gallery</h2>
        <div id="galleryGridContainer">
          <?php include "./components/gallery-grid.php"; ?>
        </div>
      </div>
    </section>

    <!-- Gallery Modal -->
    <div id="galleryModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeGalleryModal()">&times;</span>
        <div id="galleryModalContent">
          <!-- Gallery modal content will be loaded here -->
        </div>
      </div>
    </div>

    <!-- Filters for both festivals and gallery -->
    <section class="filters" data-route="festivals gallery">
      <div class="container">
        <h3 style="text-align: center; margin-bottom: 2rem">
          Filter Festivals & Gallery
        </h3>
        <div class="filter-controls">
          <select class="filter-select" id="religionFilter">
            <option value="">All Religions</option>
            <?php 
            require_once __DIR__ . '/db_connect.php';
            $db = get_db();
            $res = $db->query("SELECT name FROM religion ORDER BY name ASC");
            while ($row = $res->fetch_assoc()):
            ?>
              <option value="<?= htmlspecialchars($row['name']) ?>">
                <?= htmlspecialchars($row['name']) ?>
              </option>
            <?php endwhile; ?>
          </select>

          <select class="filter-select" id="monthFilter">
            <option value="">All Months</option>
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
          </select>

          <select class="filter-select" id="countryFilter">
            <option value="">All Countries</option>
            <?php  
              $res = $db->query("SELECT name FROM country ORDER BY name ASC");
              while ($row = $res->fetch_assoc()):
            ?>
              <option value="<?= htmlspecialchars($row['name']) ?>">
                <?= htmlspecialchars($row['name']) ?>
              </option>
            <?php endwhile; ?>
          </select>
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
            >Download About Us</a
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
            <!-- Authentication Required Message (shown when not logged in) -->
            <div id="authRequiredMessage" class="auth-required-message">
              <h4><i class="fas fa-lock"></i> Login Required</h4>
              <p>Please sign in to send feedback and connect with our community.</p>
              <div class="auth-buttons-inline">
                <button class="btn" onclick="openAuthPopup('signin')">Sign In</button>
                <button class="btn" onclick="openAuthPopup('signup')">Sign Up</button>
              </div>
            </div>

            <!-- User Info Display (shown when logged in) -->
            <div id="userInfoDisplay" class="user-info-display" style="display: none;">
              <p><i class="fas fa-user"></i> Signed in as: <span class="user-name" id="currentUserName">User</span></p>
              <p><a href="#" onclick="signOut(); return false;" style="color: #e74c3c;">
                <i class="fas fa-sign-out-alt"></i> Sign Out
              </a></p>
            </div>
            <form id="feedbackForm" style="text-align: left; display: none;">
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

    <!-- Authentication Popup -->
    <div id="authPopup" class="auth-popup">
      <div class="auth-popup-content">
        <!-- <button class="auth-close" onclick="closeAuthPopup()">&times;</button> -->
        
        <!-- Sign In Form -->
        <div id="signinForm" class="auth-form">
          <div class="auth-popup-header">
            <h2>Sign In</h2>
            <button class="auth-close" onclick="closeAuthPopup()">&times;</button>
          </div>
          <div class="auth-popup-body">
            <form id="signinFormData">
              <div class="auth-form-group">
                <label for="signinUsername">Username or Email</label>
                <input type="text" id="signinUsername" name="username" required>
                <div class="auth-error" id="signinUsernameError"></div>
              </div>
              <div class="auth-form-group">
                <label for="signinPassword">Password</label>
                <input type="password" id="signinPassword" name="password" required>
                <div class="auth-error" id="signinPasswordError"></div>
              </div>
              <div class="auth-loading" id="signinLoading">
                <div class="auth-spinner"></div>
                <p>Signing in...</p>
              </div>
            </form>
          </div>
          <div class="auth-popup-footer">
            <button type="button" class="auth-btn" onclick="submitSignIn()"><span>Sign In</span></button>
            <div class="auth-switch">
              Don't have an account? <a href="#" onclick="switchToSignup()">Sign Up</a>
            </div>
          </div>
        </div>

        <!-- Sign Up Form -->
        <div id="signupForm" class="auth-form" style="display: none;">
          <div class="auth-popup-header">
            <h2>Sign Up</h2>
            <button class="auth-close" onclick="closeAuthPopup()">&times;</button>
          </div>
          <div class="auth-popup-body">
            <form id="signupFormData">
              <div class="auth-form-group">
                <label for="signupFullName">Full Name</label>
                <input type="text" id="signupFullName" name="full_name" required>
                <div class="auth-error" id="signupFullNameError"></div>
              </div>
              <div class="auth-form-group">
                <label for="signupUsername">Username</label>
                <input type="text" id="signupUsername" name="username" required>
                <div class="auth-error" id="signupUsernameError"></div>
              </div>
              <div class="auth-form-group">
                <label for="signupEmail">Email</label>
                <input type="email" id="signupEmail" name="email" required>
                <div class="auth-error" id="signupEmailError"></div>
              </div>
              <div class="auth-form-group">
                <label for="signupPassword">Password</label>
                <input type="password" id="signupPassword" name="password" required>
                <div class="auth-error" id="signupPasswordError"></div>
              </div>
              <div class="auth-loading" id="signupLoading">
                <div class="auth-spinner"></div>
                <p>Creating account...</p>
              </div>
            </form>
          </div>
          <div class="auth-popup-footer">
            <button type="button" class="auth-btn" onclick="submitSignUp()"><span>Sign Up</span></button>
            <div class="auth-switch">
              Already have an account? <a href="#" onclick="switchToSignin()">Sign In</a>
            </div>
          </div>
        </div>
      </div>
    </div>

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
            &copy; 2025 MOONLIGHT EVENTS. All rights reserved. | Promoting
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
        <span
          >Join us in celebrating diversity and cultural heritage
          worldwide!</span
        >
      </div>
    </div>

    <!-- FAQ Modal -->
    <div id="faqModal" class="faq-modal">
      <div class="faq-modal-content">
        <span span class="faq-close" onclick="closeFAQModal()">&times;</span>
        <h2>FAQ</h2>

        <div class="faq-item">
          <button class="faq-question">What information does this website provide about festivals?</button>
          <div class="faq-answer">
            <p>We provide the history, location, date, and main activities of each festival.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">Is the information on the website accurate?</button>
          <div class="faq-answer">
            <p>All information is for reference only. We strive to keep it updated, but details may change from year to year.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">How can I find festivals by country or date?</button>
          <div class="faq-answer">
            <p>You can use the filter in the Festivals section to search by country or specific time.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">Are there age limits or special requirements to participate?</button>
          <div class="faq-answer">
            <p>Most festivals are open to all ages. However, some have specific rules, such as age restrictions (18+), dress codes, or safety requirements. Please check the details before attending.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">Can I contribute information about a festival?</button>
          <div class="faq-answer">
            <p>Absolutely! If you know an interesting festival not listed, you can send detailed information to us via email or the feedback form on the website. We will review and add it for others to see.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">How can I contact the website?</button>
          <div class="faq-answer">
            <p>You can contact us directly via support email or fill out the feedback form on the website. Our team will respond as soon as possible.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">How can I avoid missing famous festivals?</button>
          <div class="faq-answer">
            <p>You can follow the festival calendar regularly updated on the website, subscribe to email notifications, or follow our social media pages to stay informed about exciting events.</p>
          </div>
        </div>
      </div>
    </div>


    <!-- JavaScript -->
    <script src="./assets/main.js"></script>
  </body>
</html>