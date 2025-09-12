// Current Date and Time
function updateDateTime() {
  const now = new Date();
  const dateTimeString =
    now.toLocaleDateString("en-US", {
      weekday: "long",
      year: "numeric",
      month: "long",
      day: "numeric",
    }) +
    " | " +
    now.toLocaleTimeString("en-US", {
      hour: "2-digit",
      minute: "2-digit",
    });
  document.getElementById("currentDateTime").textContent = dateTimeString;
}
setInterval(updateDateTime, 1000);
updateDateTime();

// Geolocation
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(
    function (position) {
      const lat = position.coords.latitude;
      const lon = position.coords.longitude;
      document.getElementById(
        "currentLocation"
      ).textContent = `Location: ${lat.toFixed(2)}°, ${lon.toFixed(2)}°`;
    },
    function () {
      document.getElementById("currentLocation").textContent =
        "Location: Available";
    }
  );
} else {
  document.getElementById("currentLocation").textContent =
    "Location: Not supported";
}

// Festival Modal
function openFestivalModal(festivalType) {
  const modal = document.getElementById("festivalModal");
  const modalContent = document.getElementById("modalContent");

  let content = "";

  switch (festivalType) {
    case "india":
      content = `
            <h2>Indian Festivals</h2>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem;">
                <div>
                    <img src="./MOONLIGHT EVENTS - Global Festivals_files/india-festival.jpg" alt="Indian Festival" style="width: 100%; border-radius: 10px;">
                </div>
                <div>
                    <h3>Cultural Significance</h3>
                    <p>Indian festivals are deeply rooted in ancient traditions and religious beliefs, celebrating the diversity of cultures across the subcontinent.</p>
                    
                    <h3>Major Festivals</h3>
                    <ul style="margin: 1rem 0; padding-left: 2rem;">
                        <li><strong>Diwali:</strong> Festival of Lights (October/November)</li>
                        <li><strong>Holi:</strong> Festival of Colors (March)</li>
                        <li><strong>Navratri:</strong> Nine Nights of Dance (September/October)</li>
                        <li><strong>Raksha Bandhan:</strong> Bond of Protection (August)</li>
                    </ul>
                    
                    <h3>Historical Importance</h3>
                    <p>These festivals have been celebrated for thousands of years, preserving cultural heritage and promoting unity among diverse communities.</p>
                    
                    <a href="#" class="cta-button" onclick="downloadFestivalInfo('india')">Download Information (PDF)</a>
                </div>
            </div>
        `;
      break;

    case "japan":
      content = `
            <h2>Japanese Festivals</h2>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem;">
                <div>
                    <img src="./MOONLIGHT EVENTS - Global Festivals_files/japan-festival.jpg" alt="Japanese Festival" style="width: 100%; border-radius: 10px;">
                </div>
                <div>
                    <h3>Cultural Significance</h3>
                    <p>Japanese festivals (matsuri) reflect the country's deep connection with nature, seasons, and spiritual beliefs.</p>
                    
                    <h3>Major Festivals</h3>
                    <ul style="margin: 1rem 0; padding-left: 2rem;">
                        <li><strong>Hanami:</strong> Cherry Blossom Viewing (March/April)</li>
                        <li><strong>Tanabata:</strong> Star Festival (July 7)</li>
                        <li><strong>Obon:</strong> Festival of the Dead (August)</li>
                        <li><strong>Gion Matsuri:</strong> Kyoto's Grand Festival (July)</li>
                    </ul>
                    
                    <h3>Historical Importance</h3>
                    <p>These festivals showcase Japan's unique blend of Shinto and Buddhist traditions, celebrating the harmony between humans and nature.</p>
                    
                    <a href="#" class="cta-button" onclick="downloadFestivalInfo('japan')">Download Information (PDF)</a>
                </div>
            </div>
        `;
      break;

    default:
      content = `
            <h2>Festival Information</h2>
            <p>Detailed information about this festival will be available soon. Please check back later for updates.</p>
        `;
  }

  modalContent.innerHTML = content;
  modal.style.display = "block";
}

function closeFestivalModal() {
  document.getElementById("festivalModal").style.display = "none";
}

// Close modal when clicking outside
window.addEventListener("click", function (event) {
  const modal = document.getElementById("festivalModal");
  if (event.target === modal) {
    modal.style.display = "none";
  }
});

// Download functions
function downloadAboutPDF() {
  alert("About Us PDF download will be available soon!");
}

function downloadFestivalGuide() {
  alert("Festival Guide download will be available soon!");
}

function downloadFestivalInfo(festival) {
  alert(
    `${festival} festival information PDF download will be available soon!`
  );
}

// FAQ Modal
function openFAQModal() {
  alert("FAQ section will be available soon!");
}

// Site Map
function openSiteMap() {
  alert("Site Map will be available soon!");
}

// Feedback Form
const feedbackForm = document.getElementById("feedbackForm");
if (feedbackForm) {
  feedbackForm.addEventListener("submit", function (e) {
    e.preventDefault();
    alert("Thank you for your feedback! We will get back to you soon.");
    this.reset();
  });
}

// SPA Router (hash-based)
const routes = ["home", "festivals", "gallery", "about", "contact"];
function setActiveLink(route) {
  document.querySelectorAll(".nav-menu a").forEach((a) => {
    const href = a.getAttribute("href");
    const r = href && href.startsWith("#") ? href.slice(1) : "";
    a.classList.toggle("active-link", r === route);
  });
}
function renderRoute() {
  const hash = window.location.hash.replace("#", "");
  const route = routes.includes(hash) ? hash : "home";
  document.querySelectorAll("[data-route]").forEach((sec) => {
    // Cho phép data-route bắt đầu bằng route
    sec.classList.toggle(
      "active",
      sec.getAttribute("data-route").startsWith(route)
    );
  });
  setActiveLink(route);
  // scroll to top on route change
  window.scrollTo({ top: 0, behavior: "instant" });
}
window.addEventListener("hashchange", renderRoute);
// initialize only after DOM ready to ensure elements exist
if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", () => {
    if (!window.location.hash) {
      window.location.hash = "#home";
    }
    renderRoute();
  });
} else {
  if (!window.location.hash) {
    window.location.hash = "#home";
  }
  renderRoute();
}

// Header scroll effect
window.addEventListener("scroll", function () {
  const header = document.querySelector(".header");
  if (window.scrollY > 100) {
    header.style.background = "rgba(255, 107, 53, 0.95)";
    header.style.backdropFilter = "blur(10px)";
  } else {
    header.style.background =
      "linear-gradient(135deg, var(--primary-color), var(--accent-color))";
    header.style.backdropFilter = "none";
  }
});

// Filter functionality
document.querySelectorAll(".filter-select").forEach((select) => {
  select.addEventListener("change", function () {
    // Filter logic will be implemented here
    console.log("Filter changed:", this.value);
  });
});
