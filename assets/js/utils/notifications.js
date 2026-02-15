/**
 * NotificationService - Handlers for premium custom alerts
 */
const NotificationService = {
    overlay: null,
    modal: null,
    errorAlert: null,
    successAlert: null,
    errorText: null,
    successText: null,

    init() {
        this.overlay = document.getElementById('notification-overlay');
        this.modal = document.getElementById('notification-modal');
        this.errorAlert = document.getElementById('error-alert');
        this.successAlert = document.getElementById('success-alert');
        this.errorText = document.getElementById('error-message-text');
        this.successText = document.getElementById('success-message-text');
    },

    showError(message) {
        if (!this.overlay) this.init();

        this.errorText.textContent = message;
        this.errorAlert.classList.remove('hidden');
        this.successAlert.classList.add('hidden');

        this.show();
    },

    showSuccess(message, callback = null) {
        if (!this.overlay) this.init();

        this.successText.textContent = message;
        this.successAlert.classList.remove('hidden');
        this.errorAlert.classList.add('hidden');

        const closeBtn = document.getElementById('success-close-btn');
        if (callback) {
            closeBtn.onclick = () => {
                this.hide();
                callback();
            };
        } else {
            closeBtn.onclick = () => this.hide();
        }

        this.show();
    },

    show() {
        this.overlay.classList.remove('hidden');
        this.overlay.classList.add('show'); // Uses styles.css .modal.show

        setTimeout(() => {
            this.modal.classList.remove('scale-95', 'opacity-0');
            this.modal.classList.add('scale-100', 'opacity-100');
        }, 10);
    },

    hide() {
        this.modal.classList.remove('scale-100', 'opacity-100');
        this.modal.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            this.overlay.classList.remove('show');
            this.overlay.classList.add('hidden');
        }, 300);
    }
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    NotificationService.init();
});
