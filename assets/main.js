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

// Gallery Modal
function openGalleryModal(imageUrl, caption) {
  const modal = document.getElementById("galleryModal");
  const modalContent = document.getElementById("galleryModalContent");

  const xhr = new XMLHttpRequest();
  xhr.open(
    "GET",
    "components/gallery-modal.php?image_url=" +
      encodeURIComponent(imageUrl) +
      "&caption=" +
      encodeURIComponent(caption),
    true
  );
  xhr.onload = function () {
    if (xhr.status === 200) {
      modalContent.innerHTML = xhr.responseText;
      modal.style.display = "block";
    } else {
      modalContent.innerHTML = "<p>Không tải được ảnh.</p>";
      modal.style.display = "block";
    }
  };
  xhr.send();
}

function closeGalleryModal() {
  document.getElementById("galleryModal").style.display = "none";
}

// Close modal when clicking outside
window.addEventListener("click", function (event) {
  const modal = document.getElementById("festivalModal");
  if (event.target === modal) {
    modal.style.display = "none";
  }
});
window.addEventListener("click", function (event) {
  const modal = document.getElementById("galleryModal");
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
document.addEventListener("keydown", function (event) {
  if (event.key === "Escape") {
    closeGalleryModal();
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
  document.getElementById("faqModal").style.display = "flex";
}

function closeFAQModal() {
  document.getElementById("faqModal").style.display = "none";
}

// Đóng modal khi click ra ngoài
window.addEventListener("click", function (e) {
  const modal = document.getElementById("faqModal");
  if (e.target === modal) {
    modal.style.display = "none";
  }
});

// Accordion toggle
document.addEventListener("click", function (e) {
  if (e.target.classList.contains("faq-question")) {
    const answer = e.target.nextElementSibling;
    if (answer.style.maxHeight) {
      answer.style.maxHeight = null;
    } else {
      answer.style.maxHeight = answer.scrollHeight + "px";
    }
  }
});

// Site Map
function openSiteMap() {
  window.open("assets/site/sitemap.php");
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
const routes = ["home", "festivals", "gallery", "about", "contact", "detail"];
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
    const sectionRoutes = sec.getAttribute("data-route").split(" ");
    // Cho phép data-route bắt đầu bằng route
    sec.classList.toggle("active", sectionRoutes.includes(route));
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
    header.style.background = "var(--primary-color)";
    header.style.backdropFilter = "blur(10px)";
  } else {
    header.style.background =
      "linear-gradient(135deg, var(--primary-color), black, #462c68, #701762, #462c68, #06346f, black)";
    header.style.backdropFilter = "none";
  }
});

// Authentication System
let currentUser = null;

// Check authentication status on page load
document.addEventListener("DOMContentLoaded", function () {
  checkAuthStatus();
});

// Check if user is logged in
async function checkAuthStatus() {
  try {
    const response = await fetch("auth/check_auth.php");
    const data = await response.json();

    if (data.success && data.logged_in) {
      currentUser = data.user;
      // showUserMenu();
      updateContactUI(true);
    } else {
      // showAuthButtons();
      updateContactUI(false);
    }
  } catch (error) {
    console.error("Error checking auth status:", error);
    // showAuthButtons();
    updateContactUI(false);
  }
}

function updateContactUI(isLoggedIn) {
  const authRequiredMessage = document.getElementById("authRequiredMessage");
  const userInfoDisplay = document.getElementById("userInfoDisplay");
  const feedbackForm = document.getElementById("feedbackForm");

  if (isLoggedIn && currentUser) {
    // User is logged in - show form
    authRequiredMessage.style.display = "none";
    userInfoDisplay.style.display = "block";
    feedbackForm.style.display = "block";

    // Update user display
    document.getElementById("currentUserName").textContent =
      currentUser.full_name || currentUser.username;

    // Pre-fill form if needed
    document.getElementById("name").value = currentUser.full_name || "";
    document.getElementById("email").value = currentUser.email || "";
  } else {
    // User is not logged in - show auth required message
    authRequiredMessage.style.display = "block";
    userInfoDisplay.style.display = "none";
    feedbackForm.style.display = "none";
  }
}

// Show authentication buttons
// function showAuthButtons() {
//   document.getElementById("authButtons").style.display = "block";
//   document.getElementById("userMenu").style.display = "none";
// }

// Show user menu
// function showUserMenu() {
//   document.getElementById("authButtons").style.display = "none";
//   document.getElementById("userMenu").style.display = "block";
//   document.getElementById("userDisplayName").textContent =
//     currentUser.full_name || currentUser.username;
// }

// Open authentication popup
function openAuthPopup(type) {
  const popup = document.getElementById("authPopup");
  const signinForm = document.getElementById("signinForm");
  const signupForm = document.getElementById("signupForm");

  // Clear previous errors
  clearAuthErrors();

  if (type === "signin") {
    signinForm.style.display = "block";
    signupForm.style.display = "none";
  } else {
    signinForm.style.display = "none";
    signupForm.style.display = "block";
  }

  popup.classList.add("show");
  document.body.style.overflow = "hidden";
}

// Close authentication popup
function closeAuthPopup() {
  const popup = document.getElementById("authPopup");
  popup.classList.remove("show");
  document.body.style.overflow = "auto";
  clearAuthErrors();
  clearAuthForms();
}

// Switch between signin and signup forms
function switchToSignup() {
  document.getElementById("signinForm").style.display = "none";
  document.getElementById("signupForm").style.display = "block";
  clearAuthErrors();
}

function switchToSignin() {
  document.getElementById("signinForm").style.display = "block";
  document.getElementById("signupForm").style.display = "none";
  clearAuthErrors();
}

// Clear authentication errors
function clearAuthErrors() {
  document.querySelectorAll(".auth-error").forEach((error) => {
    error.classList.remove("show");
    error.textContent = "";
  });
  document.querySelectorAll(".auth-form-group input").forEach((input) => {
    input.classList.remove("error");
  });
}

// Clear authentication forms
function clearAuthForms() {
  document.getElementById("signinFormData").reset();
  document.getElementById("signupFormData").reset();
}

// Show authentication error
function showAuthError(fieldId, message) {
  const errorElement = document.getElementById(fieldId + "Error");
  const inputElement = document.getElementById(fieldId);

  if (errorElement && inputElement) {
    errorElement.textContent = message;
    errorElement.classList.add("show");
    inputElement.classList.add("error");
  }
}

// Show loading state
function showAuthLoading(formType) {
  document.getElementById(formType + "Loading").style.display = "block";
  document.querySelector(`#${formType}Form .auth-btn`).disabled = true;
}

// Hide loading state
function hideAuthLoading(formType) {
  document.getElementById(formType + "Loading").style.display = "none";
  document.querySelector(`#${formType}Form .auth-btn`).disabled = false;
}

// Submit sign in
async function submitSignIn() {
  const username = document.getElementById("signinUsername").value.trim();
  const password = document.getElementById("signinPassword").value;

  if (!username || !password) {
    showAuthError("signinUsername", "Please fill in all fields");
    return;
  }

  clearAuthErrors();
  showAuthLoading("signin");

  try {
    const response = await fetch("auth/signin.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ username, password }),
    });

    const data = await response.json();

    if (data.success) {
      currentUser = data.user;
      closeAuthPopup();
      updateContactUI(true);
      showNotification(
        "Welcome back, " + currentUser.full_name + "!",
        "success"
      );
    } else {
      showAuthError("signinUsername", data.message);
    }
  } catch (error) {
    console.error("Sign in error:", error);
    showAuthError("signinUsername", "An error occurred. Please try again.");
  } finally {
    hideAuthLoading("signin");
  }
}

// Submit sign up
async function submitSignUp() {
  const fullName = document.getElementById("signupFullName").value.trim();
  const username = document.getElementById("signupUsername").value.trim();
  const email = document.getElementById("signupEmail").value.trim();
  const password = document.getElementById("signupPassword").value;

  if (!fullName || !username || !email || !password) {
    showAuthError("signupFullName", "Please fill in all fields");
    return;
  }

  clearAuthErrors();
  showAuthLoading("signup");

  try {
    const response = await fetch("auth/signup.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ full_name: fullName, username, email, password }),
    });

    const data = await response.json();

    if (data.success) {
      showNotification(data.message, "success");
      switchToSignin();
    } else {
      // Parse error message to show specific field errors
      if (data.message.includes("Username already exists")) {
        showAuthError("signupUsername", data.message);
      } else if (data.message.includes("Email already exists")) {
        showAuthError("signupEmail", data.message);
      } else {
        showAuthError("signupFullName", data.message);
      }
    }
  } catch (error) {
    console.error("Sign up error:", error);
    showAuthError("signupFullName", "An error occurred. Please try again.");
  } finally {
    hideAuthLoading("signup");
  }
}

// Sign out
async function signOut() {
  try {
    const response = await fetch("auth/signout.php");
    const data = await response.json();

    if (data.success) {
      currentUser = null;
      // showAuthButtons();
      updateContactUI(false);
      showNotification("You have been signed out successfully.", "info");
    }
  } catch (error) {
    console.error("Sign out error:", error);
  }
}

// Toggle user menu dropdown
// function toggleUserMenu() {
//   const dropdown = document.getElementById("userDropdown");
//   dropdown.classList.toggle("show");
// }

// Close user menu when clicking outside
// document.addEventListener("click", function (event) {
//   const userMenu = document.getElementById("userMenu");
//   const dropdown = document.getElementById("userDropdown");

//   if (userMenu && !userMenu.contains(event.target)) {
//     dropdown.classList.remove("show");
//   }
// });

// User menu functions
// function showUserProfile() {
//   showNotification("User profile feature coming soon!", "info");
//   document.getElementById("userDropdown").classList.remove("show");
// }

// function showUserSettings() {
//   showNotification("User settings feature coming soon!", "info");
//   document.getElementById("userDropdown").classList.remove("show");
// }

// Show notification
function showNotification(message, type = "info") {
  // Create notification element
  const notification = document.createElement("div");
  notification.className = `notification notification-${type}`;
  notification.textContent = message;

  // Style the notification
  notification.style.cssText = `
    position: fixed;
    top: 20px;
    right: 20px;
    background: ${
      type === "success" ? "#27ae60" : type === "error" ? "#e74c3c" : "#3498db"
    };
    color: white;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    z-index: 1001;
    animation: slideInRight 0.3s ease-out;
  `;

  document.body.appendChild(notification);

  // Remove notification after 3 seconds
  setTimeout(() => {
    notification.style.animation = "slideOutRight 0.3s ease-in";
    setTimeout(() => {
      if (notification.parentNode) {
        notification.parentNode.removeChild(notification);
      }
    }, 300);
  }, 3000);
}

// Feedback form submission with real backend
document.addEventListener("DOMContentLoaded", function () {
  const feedbackForm = document.getElementById("feedbackForm");
  if (feedbackForm) {
    feedbackForm.addEventListener("submit", function (e) {
      e.preventDefault();

      if (currentUser) {
        const formData = new FormData(this);

        // Add user information
        formData.append("user_id", currentUser.id);

        // Submit feedback to backend
        fetch("submit_feedback.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              showNotification(
                "Thank you for your feedback! We will get back to you soon.",
                "success"
              );
              this.reset();
              // Pre-fill user info again after reset
              document.getElementById("name").value =
                currentUser.full_name || "";
              document.getElementById("email").value = currentUser.email || "";
            } else {
              showNotification(
                "Error submitting feedback. Please try again.",
                "error"
              );
            }
          })
          .catch((error) => {
            console.error("Error:", error);
            showNotification(
              "Error submitting feedback. Please try again.",
              "error"
            );
          });
      } else {
        showNotification("Please sign in to submit feedback.", "error");
      }
    });
  }
});

// Close popup when clicking outside
window.addEventListener("click", function (event) {
  const authPopup = document.getElementById("authPopup");
  if (event.target === authPopup) {
    closeAuthPopup();
  }
});

// Close popup with Escape key
document.addEventListener("keydown", function (event) {
  if (event.key === "Escape") {
    const authPopup = document.getElementById("authPopup");
    if (authPopup.classList.contains("show")) {
      closeAuthPopup();
    }
  }
});

// Notification animations
const style = document.createElement("style");
style.textContent = `
@keyframes slideInRight {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

@keyframes slideOutRight {
  from {
    transform: translateX(0);
    opacity: 1;
  }
  to {
    transform: translateX(100%);
    opacity: 0;
  }
}
`;
document.head.appendChild(style);

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
        document
          .getElementById("gallery")
          .scrollIntoView({ behavior: "smooth", block: "start" });
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

// Pagination filter preservation
document.addEventListener("click", function (e) {
  if (e.target.matches(".pagination a")) {
    e.preventDefault();
    const url = new URL(e.target.href, window.location.origin);
    const page = url.searchParams.get("page") || 1;
    const isFestival = e.target.href.includes("#festivals");

    const religion = document.getElementById("religionFilter").value;
    const month = document.getElementById("monthFilter").value;
    const country = document.getElementById("countryFilter").value;

    const params = new URLSearchParams();
    if (religion) params.set("religion", religion);
    if (month) params.set("month", month);
    if (country) params.set("country", country);
    params.set("page", page);
    params.set("type", isFestival ? "festival" : "gallery");

    const container = isFestival
      ? document.getElementById("festivalsGridContainer")
      : document.getElementById("galleryGridContainer");

    container.innerHTML =
      '<div style="text-align:center;padding:2rem;">Đang tải...</div>';
    fetch("components/filter.php?" + params.toString())
      .then((res) => res.text())
      .then((html) => (container.innerHTML = html));
  }
});
