/**
 * password_toggle.js
 * Handles toggling the visibility of password input fields using absolute positioning and Font Awesome icons.
 * * Must be called once the DOM is ready to attach event listeners.
 */
function setupPasswordToggle() {
    // Target the span that acts as the clickable button
    document.querySelectorAll('.password-toggle-icon.toggle-password').forEach(span => {
        span.addEventListener('click', function () {
            const targetId = this.dataset.target;
            const targetInput = document.getElementById(targetId);

            // Get the icon element (SVG or <i> tag)
            const icon = this.querySelector('svg') || this.querySelector('i');

            // Ensure we have both elements
            if (!targetInput || !icon) {
                console.error("Password toggle failed: Input or icon element missing.");
                return;
            }

            // Toggle the type attribute and the icon class
            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                targetInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
}

// Automatically initialize the toggle logic when the script loads
document.addEventListener('DOMContentLoaded', setupPasswordToggle);