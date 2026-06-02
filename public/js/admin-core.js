/**
 * Admin Core Interaction Engine - Mount Carmel
 * Focus: Modals, Filtering, and Reactive UI elements
 */

const AdminCore = {
    /**
     * Initialize all admin features
     */
    init() {
        this.initModals();
        this.initAutoFilters();
        this.initConfirmations();
    },

    /**
     * Modal Management System
     */
    initModals() {
        window.openAdminModal = (id) => {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        };

        window.closeAdminModal = (id) => {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        };
    },

    /**
     * Auto-submit for filter selects
     */
    initAutoFilters() {
        const autoFilters = document.querySelectorAll('.auto-submit-filter');
        autoFilters.forEach(select => {
            select.addEventListener('change', () => {
                select.closest('form').submit();
            });
        });
    },

    /**
     * Enhanced confirmation dialogs
     */
    initConfirmations() {
        const deleteButtons = document.querySelectorAll('[data-confirm-delete]');
        deleteButtons.forEach(btn => {
            btn.addEventListener('submit', (e) => {
                const message = btn.getAttribute('data-confirm-message') || 'Yakin ingin menghapus data ini?';
                if (!confirm(message)) {
                    e.preventDefault();
                }
            });
        });
    }
};

// Execute initialization
document.addEventListener('DOMContentLoaded', () => {
    AdminCore.init();
});
