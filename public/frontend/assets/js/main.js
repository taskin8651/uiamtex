// Set dynamic year in footer
const yearSpan = document.getElementById("year");
if (yearSpan) {
  yearSpan.textContent = new Date().getFullYear();
}

// Future custom JS (sliders, AJAX, etc.) can go here.

document.addEventListener('DOMContentLoaded', function () {
  const chips = document.querySelectorAll('.fp-chip');
  const cards = document.querySelectorAll('#featured-products .product-card');

  chips.forEach(chip => {
    chip.addEventListener('click', () => {
      const filter = chip.getAttribute('data-filter');

      // Active state on chip
      chips.forEach(c => c.classList.remove('active'));
      chip.classList.add('active');

      // Show / hide products
      cards.forEach(card => {
        const category = card.getAttribute('data-category');
        if (filter === 'all' || category === filter) {
          card.classList.remove('d-none');
        } else {
          card.classList.add('d-none');
        }
      });
    });
  });
});


// =================== QUICK ENQUIRY POPUP (FRONTEND DEMO HANDLER) ===================
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("quickEnquiryPopupForm");
  const msgBox = document.getElementById("qePopupMsg");

  if (!form) return;

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const fullName = form.querySelector('[name="full_name"]').value.trim();
    const phone = form.querySelector('[name="phone"]').value.trim();
    const message = form.querySelector('[name="message"]').value.trim();

    // Basic validation
    if (!fullName || !phone || !message) {
      msgBox.className = "qe-popup-msg error";
      msgBox.textContent = "Please fill Full Name, Phone Number and Message.";
      msgBox.classList.remove("d-none");
      return;
    }

    // TODO: Replace this with real API call (Laravel/QuickAdminPanel endpoint)
    msgBox.className = "qe-popup-msg success";
    msgBox.textContent = "Thanks! Your enquiry has been submitted. Our team will contact you shortly.";
    msgBox.classList.remove("d-none");

    // Reset form
    form.reset();

    // Auto close modal after 1.2s
    setTimeout(() => {
      const modalEl = document.getElementById("quickEnquiryModal");
      if (modalEl) {
        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.hide();
      }
      msgBox.classList.add("d-none");
    }, 1200);
  });
});

// =================== AUTO OPEN QUICK ENQUIRY POPUP AFTER 10s (INDEX ONLY) ===================
document.addEventListener("DOMContentLoaded", () => {
  // Run only on index page (safe check)
  const isIndex =
    window.location.pathname.endsWith("index.html") ||
    window.location.pathname === "/" ||
    window.location.pathname.endsWith("/");

  if (!isIndex) return;

  const modalEl = document.getElementById("quickEnquiryModal");
  if (!modalEl) return;

  // If you want it only once per user session, keep this enabled
  if (sessionStorage.getItem("qe_popup_shown") === "1") return;

  setTimeout(() => {
    // Don't open if modal already open
    if (modalEl.classList.contains("show")) return;

    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
    modal.show();

    // Mark as shown (so it won't open again on refresh in same tab/session)
    sessionStorage.setItem("qe_popup_shown", "1");
  }, 10000); // 10 seconds
});

window.addEventListener('load', () => {
    const loader = document.getElementById('premium-preloader');
    if (!loader) return;

    setTimeout(() => loader.classList.add('hide'), 350);
    setTimeout(() => loader.remove(), 900);
});

