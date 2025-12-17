/**
 * admin_guard.js
 * Enforces role-based URL access control and token validation.
 * Must be included at the top of every protected page.
 */

const token = localStorage.getItem('authToken');
const loginPage = '../auth/login.php';
const displayElementId = 'sidenavUserEmail';
const validationEndpoint = 'http://localhost/software_engineering/backend/auth';

// Define Access Rules
// This map primarily defines what pages exist and who is allowed.
// The checkPageAccess function below enforces strict redirection for Cooks/Cashiers.
const PAGE_ACCESS = {
    'orders.php': ['A', 'K'],      // Admin, Cook
    'floor_plans.php': ['A', 'C'],  // Admin, Cashier
    'menu.php': ['A'],             // Admin only
    'users.php': ['A'],            // Admin only
    'dashboard.php': ['A']         // Admin only
};

function getRoleLandingPage(role) {
    if (role === 'K') {      // Cook
        return 'orders.php';
    } else if (role === 'C') { // Cashier
        return 'floor_plans.php';
    } else if (role === 'A') { // Admin
        return 'dashboard.php';
    }
    return loginPage;
}

// 1. Immediate Check (No Token)
if (!token) {
    window.location.replace(loginPage);
}

// 2. Periodic Validation and Access Control
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
                const role = json.data.role;

                // Step A: Enforce Page Access Check (Redirects if unauthorized)
                checkPageAccess(role);

                // Step B: Update UI
                const userDisplay = document.getElementById(displayElementId);
                if (userDisplay) userDisplay.textContent = json.data.name;
                updateNavVisibility(role);
            }
        } else {
            forceLogout();
        }
    } catch (error) {
        console.error('Auth Check Failed', error);
    }
}


/**
 * Enforces strict URL access: 
 * - Cook MUST be on orders.php
 * - Cashier MUST be on floor_plans.php
 * - Admin can be anywhere
 */
function checkPageAccess(role) {
    // Admins are authorized for every restricted page
    if (role === 'A') {
        return;
    }

    const currentPath = window.location.pathname;
    const currentPage = currentPath.substring(currentPath.lastIndexOf('/') + 1);

    // Get the only page the non-Admin user is REQUIRED to be on
    const requiredPage = getRoleLandingPage(role);

    // If the current page is NOT the page they are required to be on
    if (currentPage !== requiredPage) {

        const basePath = currentPath.substring(0, currentPath.lastIndexOf('/') + 1);
        window.location.replace(basePath + requiredPage);

        // Stop any further script execution
        throw new Error(`Unauthorized access. Redirecting.`);
    }
}


function updateNavVisibility(role) {
    const dashboardLink = document.getElementById('admin_dashboard');
    const ordersLink = document.getElementById('orders');
    const floorPlanLink = document.getElementById('floor_plans');
    const menuLink = document.getElementById('menu');
    const usersLink = document.getElementById('users');

    if (!dashboardLink || !ordersLink || !floorPlanLink || !menuLink || !usersLink) return;

    // Reset: Hide all links initially
    dashboardLink.style.display = 'none';
    ordersLink.style.display = 'none';
    floorPlanLink.style.display = 'none';
    menuLink.style.display = 'none';
    usersLink.style.display = 'none';

    if (role === 'A') { // Admin
        dashboardLink.style.display = 'block';
        ordersLink.style.display = 'block';
        floorPlanLink.style.display = 'block';
        menuLink.style.display = 'block';
        usersLink.style.display = 'block';
    } else if (role === 'K') { // Kitchen
        ordersLink.style.display = 'block';
    } else if (role === 'C') { // Cashier
        floorPlanLink.style.display = 'block';
    }
}

function forceLogout() {
    localStorage.removeItem('authToken');
    window.location.replace(loginPage);
}

// Start Loop for Periodic Validation
setInterval(validateTokenPeriodically, 5000);

// Run validation immediately after the DOM content loads
document.addEventListener('DOMContentLoaded', validateTokenPeriodically);