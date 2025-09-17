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
    "components/modal.php?slug=" + encodeURIComponent(slug),
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
// Close modal with Escape key
document.addEventListener("keydown", function (event) {
  if (event.key === "Escape") {
    closeFestivalModal();
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
  window.open("assets/site/sitemap.xml");
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
  if (!hash) {
    // Không có hash (ví dụ ?page=2) → bỏ qua, để server render
    return;
  }
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
      "linear-gradient(135deg, var(--primary-color), black, #462c68, #701762, #462c68, #06346f, black)";
    header.style.backdropFilter = "none";
  }
});

// Filter functionality
document.querySelectorAll(".filter-select").forEach((select) => {
  select.addEventListener("change", function () {
    const religionFilter = document.getElementById("religionFilter").value;
    const monthFilter = document.getElementById("monthFilter").value;
    const countryFilter = document.getElementById("countryFilter").value;

    // Check if all filters are empty (user selected "All")
    if (!religionFilter && !monthFilter && !countryFilter) {
      // Return to original paginated view
      clearFilters();
      return;
    }

    applyFilters();
    console.log("Filter changed:", this.value);
  });
});
function applyFilters() {
  const religion = document.getElementById("religionFilter").value;
  const month = document.getElementById("monthFilter").value;
  const country = document.getElementById("countryFilter").value;

  const params = new URLSearchParams();
  if (religion) params.set("religion", religion);
  if (month) params.set("month", month);
  if (country) params.set("country", country);

  // Festival grid
  const festivalsGrid = document.getElementById("festivalsGridContainer");
  if (festivalsGrid) {
    festivalsGrid.innerHTML =
      '<div style="text-align:center;padding:2rem;">Đang lọc...</div>';
    params.set("type", "festival");
    fetch("components/filter.php?" + params.toString())
      .then((res) => res.text())
      .then((html) => {
        festivalsGrid.innerHTML = html;
        document
          .getElementById("festivals")
          .scrollIntoView({ behavior: "smooth", block: "start" });
      });
  }

  // Gallery grid
  const galleryGrid = document.getElementById("galleryGridContainer");
  if (galleryGrid) {
    galleryGrid.innerHTML =
      '<div style="text-align:center;padding:2rem;">Đang lọc...</div>';
    params.set("type", "gallery");
    fetch("components/filter.php?" + params.toString())
      .then((res) => res.text())
      .then((html) => {
        galleryGrid.innerHTML = html;
      });
  }
}

function clearFilters() {
  // Reset all filters
  document.getElementById("religionFilter").value = "";
  document.getElementById("monthFilter").value = "";
  document.getElementById("countryFilter").value = "";

  // Festival grid
  const festivalsGrid = document.getElementById("festivalsGridContainer");
  if (festivalsGrid) {
    festivalsGrid.innerHTML =
      '<div style="text-align:center;padding:2rem;">Đang tải...</div>';

    fetch("components/filter.php?type=festival")
      .then((response) => response.text())
      .then((html) => {
        festivalsGrid.innerHTML = html;

        // Scroll lên đầu section festivals
        const target = document.getElementById("festivals");
        if (target) {
          setTimeout(() => {
            target.scrollIntoView({ behavior: "smooth", block: "start" });
          }, 50);
        }
      })
      .catch((error) => {
        console.error("Error loading festivals:", error);
        festivalsGrid.innerHTML =
          '<div style="text-align:center;padding:2rem;color:red;">Lỗi khi tải dữ liệu</div>';
      });
  }

  // Gallery grid
  const galleryGrid = document.getElementById("galleryGridContainer");
  if (galleryGrid) {
    galleryGrid.innerHTML =
      '<div style="text-align:center;padding:2rem;">Đang tải...</div>';

    fetch("components/filter.php?type=gallery")
      .then((response) => response.text())
      .then((html) => {
        galleryGrid.innerHTML = html;
      })
      .catch((error) => {
        console.error("Error loading gallery:", error);
        galleryGrid.innerHTML =
          '<div style="text-align:center;padding:2rem;color:red;">Lỗi khi tải dữ liệu</div>';
      });
  }
}
