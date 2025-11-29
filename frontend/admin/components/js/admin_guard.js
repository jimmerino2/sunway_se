/**
 * admin_guard.js
 * Protects pages from unauthorized access.
 * Runs immediately in <head>.
 */

const token = localStorage.getItem('authToken');
const loginPage = '../auth/login.php'; // Relative path fix
const displayElementId = 'sidenavUserEmail';
const validationEndpoint = 'http://localhost/software_engineering/backend/auth';

// 1. Immediate Check
if (!token) {
    window.location.replace(loginPage);
}

// 2. Periodic Validation
async function validateTokenPeriodically() {
    const currentToken = localStorage.getItem('authToken');
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
            const json = await response.json();
            if (json.data && json.data.name) {
                const userDisplay = document.getElementById(displayElementId);
                if (userDisplay) userDisplay.textContent = json.data.name;
                updateNavVisibility(json.data.role);
            }
        } else {
            forceLogout();
        }
    } catch (error) {
        console.error('Auth Check Failed', error);
        // Optional: forceLogout() on network error, or be lenient
    }
}

function updateNavVisibility(role) {
    const dashboardLink = document.getElementById('admin_dashboard');
    const ordersLink = document.getElementById('orders');
    const floorPlanLink = document.getElementById('floor_plan');

    if (!dashboardLink || !ordersLink || !floorPlanLink) return;

    // Reset
    dashboardLink.style.display = 'none';
    ordersLink.style.display = 'none';
    floorPlanLink.style.display = 'none';

    if (role === 'A') { // Admin
        dashboardLink.style.display = 'block';
        ordersLink.style.display = 'block';
        floorPlanLink.style.display = 'block';
    } else if (role === 'K') { // Kitchen
        ordersLink.style.display = 'block';
    } else if (role === 'C') { // Cashier
        floorPlanLink.style.display = 'block';
    }
}

function forceLogout() {
    localStorage.removeItem('authToken');
    localStorage.removeItem('username');
    localStorage.removeItem('role');
    window.location.replace(loginPage);
}

// Start Loop
setInterval(validateTokenPeriodically, 5000);
document.addEventListener('DOMContentLoaded', validateTokenPeriodically);