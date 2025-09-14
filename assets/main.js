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
function openFestivalModal(slug) {
  const modal = document.getElementById("festivalModal");
  const modalContent = document.getElementById("modalContent");

  // Gọi PHP để lấy nội dung festival
  const xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    "components/festival-modal.php?slug=" + encodeURIComponent(slug),
    true
  );
  xhr.onload = function () {
    if (xhr.status === 200) {
      modalContent.innerHTML = xhr.responseText;
      modal.style.display = "block";
    } else {
      modalContent.innerHTML = "<p>Không tải được dữ liệu festival.</p>";
      modal.style.display = "block";
    }
  };
  xhr.send();
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
  const route = routes.find((r) => hash.startsWith(r));
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
    header.style.background = "#190d53b8";
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
