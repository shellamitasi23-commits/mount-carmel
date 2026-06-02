/**
 * ==========================================================================
 * MOUNT CARMEL — MASTER CLIENT LAYOUT JAVASCRIPT
 * ==========================================================================
 */

document.addEventListener("DOMContentLoaded", function() {
  // Mobile Menu Toggle Script
  const navToggle = document.getElementById('nav-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  if (navToggle && mobileMenu) {
    navToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }
});
