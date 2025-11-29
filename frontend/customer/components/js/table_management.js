/**
 * table_management.js
 * Manages Table ID and session cleanup.
 */

const TableManager = {
    KEY_TABLE: "table_no",
    KEY_ORDERS_PREFIX: "orders_",
    KEY_CART_COUNT: "cart_count",

    /**
     * Get current table number (defaults to "1")
     */
    get: function () {
        return localStorage.getItem(this.KEY_TABLE) ?? "1";
    },

    /**
     * Set new table number.
     * Clears cart data if the table number is different from the stored one.
     */
    set: function (newTableNo) {
        const current = this.get();
        if (current != newTableNo) {
            // Clear specific table data to prevent mixing orders
            localStorage.removeItem(this.KEY_CART_COUNT);
            localStorage.removeItem(this.KEY_ORDERS_PREFIX + current);
            console.log(`Table changed from ${current} to ${newTableNo}. Cart cleared.`);
        }
        localStorage.setItem(this.KEY_TABLE, newTableNo);
        this.updateDisplay();
    },

    /**
     * Updates the UI element showing the table number
     */
    updateDisplay: function () {
        const el = document.getElementById('display-table-no');
        if (el) el.textContent = this.get();
    }
};

// Auto-run display update on load
document.addEventListener('DOMContentLoaded', () => TableManager.updateDisplay());