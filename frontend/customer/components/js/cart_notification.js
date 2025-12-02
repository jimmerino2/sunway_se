/**
 * cart_notification.js
 * Manages the red notification badge on the UI.
 */

const CartNotification = {
    KEY_COUNT: "cart_count",
    ID_BADGE: "bottom-cart-badge",

    /**
     * Updates the UI badge based on localStorage
     */
    update: function () {
        const count = localStorage.getItem(this.KEY_COUNT) || 0;
        const badge = document.getElementById(this.ID_BADGE);

        if (badge) {
            if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }
        }
    },

    /**
     * Helper to set count and update UI immediately
     * @param {number} count 
     */
    set: function (count) {
        localStorage.setItem(this.KEY_COUNT, count);
        this.update();
    }
};

// Auto-run on load
document.addEventListener('DOMContentLoaded', () => CartNotification.update());