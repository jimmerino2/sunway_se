// 1. Core Variables
const token = localStorage.getItem('authToken');
const loginPage = '/software_engineering/frontend/auth/login.php';

const username = localStorage.getItem('username');
console.log('Retrieved username from localStorage:', username);

const displayElementId = 'sidenavUserEmail';

// 2. Authorization Check (The Guard)
// IMPORTANT: This redirection MUST remain outside the listener 
// to execute immediately and block the page load if the token is missing.
if (!token) {
    window.location.href = loginPage;
}

// ---

// 3. Helper function for handling 401 Unauthorized errors (retained)
function handleUnauthorized(response) {
    if (response.status === 401) {
        console.warn('Unauthorized access: Token invalid or expired. Redirecting to login.');
        localStorage.removeItem('authToken');
        localStorage.removeItem('username');
        window.location.href = loginPage;
        return true;
    }
    return false;
}

// ---

// 4. Function to display the locally stored username (retained)
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

// 5. Execution: Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function () {
    // Now it is safe to call displayUsername() because the element 
    // inside layoutSidenav_nav.php is guaranteed to exist.
    displayUsername();

    // Other functions that rely on elements being present should also be called here:
    // fetchDashboardData(); 
});