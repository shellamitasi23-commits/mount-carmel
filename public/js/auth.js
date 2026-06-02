/**
 * ==========================================================================
 * MOUNT CARMEL — PREMIUM AUTHENTICATION JAVASCRIPT
 * ==========================================================================
 */

/**
 * Toggle Password Visibility
 * @param {string} inputId - ID of the target password input field
 * @param {HTMLButtonElement} btn - Trigger button element containing the eye icon
 */
function togglePass(inputId, btn) {
  const input = document.getElementById(inputId);
  if (!input) return;
  const icon = btn.querySelector('i');
  if (input.type === 'password') {
    input.type = 'text';
    if (icon) icon.className = 'bi bi-eye-slash';
  } else {
    input.type = 'password';
    if (icon) icon.className = 'bi bi-eye';
  }
}

/**
 * Modal System Controller
 */
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;
  modal.style.display = 'flex';
  setTimeout(() => {
    modal.classList.add('active');
  }, 10);
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (!modal) return;
  modal.classList.remove('active');
  setTimeout(() => {
    modal.style.display = 'none';
  }, 300);
}

function closeModalOnBackdrop(event, modalId) {
  if (event.target.id === modalId) {
    closeModal(modalId);
  }
}

/**
 * Setup Submit Loading States on DOM Load
 */
document.addEventListener("DOMContentLoaded", function() {
  // Login Form Submission Indicator
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function() {
      const btn = document.getElementById('btnLogin');
      if (btn) {
        btn.textContent = 'Memproses masuk...';
        btn.style.opacity = '.75';
        btn.style.pointerEvents = 'none';
      }
    });
  }

  // Register Form Submission Indicator
  const registerForm = document.getElementById('registerForm');
  if (registerForm) {
    registerForm.addEventListener('submit', function() {
      const btn = document.getElementById('btnRegister');
      if (btn) {
        btn.textContent = 'Memproses pendaftaran...';
        btn.style.opacity = '.75';
        btn.style.pointerEvents = 'none';
      }
    });
  }
});
