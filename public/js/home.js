/**
 * ==========================================================================
 * MOUNT CARMEL — BUYER HOMEPAGE JAVASCRIPT
 * ==========================================================================
 */

/**
 * Toggles a FAQ item open or closed
 * @param {HTMLButtonElement} btn - The button inside the target FAQ header
 */
function toggleFaq(btn) {
  const item = btn.closest('.faq-item');
  if (!item) return;
  const isOpen = item.classList.contains('open');
  
  // Close any other open FAQ items for clean focus
  document.querySelectorAll('.faq-item.open').forEach(el => el.classList.remove('open'));
  
  if (!isOpen) {
    item.classList.add('open');
  }
}
