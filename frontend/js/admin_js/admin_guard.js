// 1. Core Variables
const token = localStorage.getItem('authToken');
const loginPage = '/software_engineering/frontend/auth/login.php';
const username = localStorage.getItem('username');
const role = localStorage.getItem('role');
const displayElementId = 'sidenavUserEmail';

//debug
console.log('User_token:', token);

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
    localStorage.removeItem('role');
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
    localStorage.removeItem('role');

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
            if (data.data && data.data.role && data.data.name) {
                // console.log('Session role:', data.data.role);
                const role_api = data.data.role;
                const name_api = data.data.name;

                // console.log('username_api:', name_api)
                // console.log('role_api:', role_api);
                console.info('session Authentication: Valid token');

                // Call displayUsername with the name fetched from the API
                displayUsername(name_api);
                // Update nav visibility based on the role
                updateNavVisibility(role_api);

            } else {
                console.warn('Session check OK, but role data was missing from response.');
                // Call displayUsername with null since no name was found
                displayUsername(null);
                updateNavVisibility(null);
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
function displayUsername(apiUsername) {
    const element = document.getElementById(displayElementId);

    if (element) {
        if (apiUsername) {
            // Success: Display the username from the API
            element.textContent = apiUsername;
        } else {
            // Failure: API data was missing the username
            element.textContent = 'User Unknown';
            console.warn("Session authenticated, but 'name' was not found in the API response.");
        }
    }
}

function updateNavVisibility(role) {
    // Get references to the navigation links
    const dashboardLink = document.getElementById('admin_dashboard');
    const ordersLink = document.getElementById('orders');
    const floorPlanLink = document.getElementById('floor_plan');

    // Exit if elements aren't on the page
    if (!dashboardLink || !ordersLink || !floorPlanLink) {
        console.warn('Could not find all navigation links to apply role visibility.');
        return;
    }

    // --- SAFER DEFAULT ---
    // 1. Hide all protected links first.
    dashboardLink.style.display = 'none';
    ordersLink.style.display = 'none';
    floorPlanLink.style.display = 'none';

    // 2. Selectively show links based on the role
    switch (role) {
        case 'A': // Admin: Show all
            dashboardLink.style.display = 'block';
            ordersLink.style.display = 'block';
            floorPlanLink.style.display = 'block';
            break;

        case 'K': // Kitchen: Show only Orders
            // Hides dashboard and floor_plan (as per step 1)
            ordersLink.style.display = 'block';
            break;

        case 'C': // Cashier: Show only Floor Plan
            // Hides dashboard and orders (as per step 1)
            floorPlanLink.style.display = 'block';
            break;

        default:
            // Unknown role or null (e.g., on initial load)
            // All links remain hidden (as per step 1)
            console.warn(`Role '${role}' is unknown or missing. Hiding all protected links.`);
            console.warn('Token validation failed with status:', response.status);
            forceLogout();
            break;
    }
}

// --- Execution: Wait for the DOM to be fully loaded ---
document.addEventListener('DOMContentLoaded', function () {


    validateTokenPeriodically();
    // 3. Set up the 5-second interval checker
    sessionValidationIntervalId = setInterval(validateTokenPeriodically, validationInterval);
});