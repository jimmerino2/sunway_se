// 1. Core Variables
const token = localStorage.getItem('authToken');
const loginPage = '/software_engineering/frontend/auth/login.php';
const username = localStorage.getItem('username');
const displayElementId = 'sidenavUserEmail';

// --- NEW: API and Interval Vars ---
// This must match the endpoint in login.js, but just the route.
const validationEndpoint = 'http://localhost/software_engineering/backend/auth'; // We will use GET
const validationInterval = 5000; // 5000ms = 5 seconds
let sessionValidationIntervalId = null; // To store the interval ID

// 2. Authorization Check (The Guard)

if (!token) {
    // No token at all, immediate redirect.
    window.location.href = loginPage;
    //Clear the stored token and username immediately
    localStorage.removeItem('authToken');
    localStorage.removeItem('username');

}

function forceLogout() {
    console.warn('Session invalid, expired, or server unreachable. Forcing logout.');

    // Stop the interval checker to prevent loops
    if (sessionValidationIntervalId) {
        clearInterval(sessionValidationIntervalId);
    }

    // Clear local storage
    localStorage.removeItem('authToken');
    localStorage.removeItem('username');

    // Redirect to login
    // Use replace() so the user can't click "back" into the admin panel
    window.location.replace(loginPage);
}

async function validateTokenPeriodically() {
    const currentToken = localStorage.getItem('authToken');

    // If token is missing (e.g., cleared by another tab), log out
    if (!currentToken) {
        forceLogout();
        return;
    }

    try {
        const response = await fetch(validationEndpoint, {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + currentToken,
                'Content-Type': 'application/json'
            }
        });

        if (response.ok) {
            // Token is valid, session is active.
            const data = await response.json();

            // We must now look inside the nested 'data' object
            // This assumes Response.php wraps with {success: true, data: {...}}
            if (data.data && data.data.role) {
                console.log('Session validated:', data.data.role);
            } else {
                console.warn('Session check OK, but role data was missing from response.');
            }

        } else {
            // Token is invalid (e.g., 401 Unauthorized from our new endpoint)
            console.warn('Token validation failed with status:', response.status);
            forceLogout();
        }
    } catch (error) {
        // Network error or server is down
        console.error('Session validation network error:', error);
        forceLogout();
    }
}

// --- Helper function to display username ---
function displayUsername() {
    const element = document.getElementById(displayElementId);

    if (element) {
        if (username) {
            // Success: Display the stored username
            element.textContent = username;
        } else {
            // Failure: Token is present, but username key is missing/null
            element.textContent = 'User Unknown';
            console.warn("Auth token present, but 'username' not found in localStorage.");
        }
    }
}

// --- Execution: Wait for the DOM to be fully loaded ---
document.addEventListener('DOMContentLoaded', function () {
    // 1. Display the username immediately
    displayUsername();

    // 2. Run the validation check once on page load
    validateTokenPeriodically();

    // 3. Set up the 5-second interval checker
    sessionValidationIntervalId = setInterval(validateTokenPeriodically, validationInterval);
});