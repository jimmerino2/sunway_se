
document.addEventListener('DOMContentLoaded', () => {
    // API Base URL - all API calls will be prefixed with this
    // Adjust this path to match your API's location
    const API_BASE_URL = 'http://localhost/software_engineering/backend';

    // Main form inputs
    const registerForm = document.getElementById('registerForm');
    const inputName = document.getElementById('inputFirstName');
    const inputEmail = document.getElementById('inputEmail');
    const inputRole = document.getElementById('inputRole');
    const inputPassword = document.getElementById('inputPassword');
    const inputPasswordConfirm = document.getElementById('inputPasswordConfirm');
    const mainMessage = document.getElementById('mainMessage');

    // Modal elements
    const adminAuthModal = document.getElementById('adminAuthModal');
    const adminEmailInput = document.getElementById('adminEmail');
    const adminPasswordInput = document.getElementById('adminPassword');
    const adminAuthButton = document.getElementById('adminAuthenticateButton');
    const adminAuthError = document.getElementById('adminAuthError');
    const adminAuthErrorMsg = adminAuthError.querySelector('.alert');
    const bsAdminModal = new bootstrap.Modal(adminAuthModal);

    // Utility to show an error in the modal
    function showAdminError(message) {
        adminAuthErrorMsg.textContent = message;
        adminAuthError.classList.remove('d-none');
    }

    // Utility to hide the modal error
    function hideAdminError() {
        adminAuthError.classList.add('d-none');
    }

    // Utility to show a message on the main page (outside modal)
    function showMainMessage(message, type = 'success') {
        mainMessage.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
    }

    // Handle the final "Authenticate & Create" button click
    adminAuthButton.addEventListener('click', () => {
        // First, check if the main registration form is valid
        if (!registerForm.checkValidity()) {
            registerForm.reportValidity();
            showAdminError('Please fill out all fields on the main form first.');
            return;
        }

        // Check password match
        if (inputPassword.value !== inputPasswordConfirm.value) {
            showAdminError('Passwords on the main form do not match.');
            // Don't close modal, let them fix main form and try again
            return;
        }

        // Get values from main form
        const name = inputName.value;
        const email = inputEmail.value;
        const role = inputRole.value;
        const password = inputPassword.value;

        // Get values from admin modal form
        const adminEmail = adminEmailInput.value;
        const adminPassword = adminPasswordInput.value;

        if (!adminEmail || !adminPassword) {
            showAdminError('Please enter your admin email and password.');
            return;
        }

        // Hide old errors and show loading state
        hideAdminError();
        adminAuthButton.disabled = true;
        adminAuthButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Authenticating...';

        // Call the async function to perform the API calls
        handleCreateAccount(name, email, role, password, adminEmail, adminPassword);
    });

    // Main function to handle the two-step API call
    async function handleCreateAccount(name, email, role, password, adminEmail, adminPassword) {
        try {
            // === STEP 1: Authenticate Admin ===
            const loginResponse = await fetch(`${API_BASE_URL}/auth`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email: adminEmail,
                    password: adminPassword
                })
            });

            console.log('Admin Login Response (Raw):', loginResponse);
            console.log('Admin Login Status:', loginResponse.status);

            if (!loginResponse.ok) {
                let errorMsg = 'Invalid admin credentials.';
                try {
                    const errorData = await loginResponse.json();
                    console.log('Admin Login Error Data (Parsed JSON):', errorData);
                    // --- FIX: Check for error in data wrapper ---
                    errorMsg = errorData.data?.message || errorData.message || errorMsg;
                } catch (e) {
                    const errorText = await loginResponse.text();
                    console.log('Admin Login Error (Raw Text):', errorText);
                    errorMsg = `Server error: ${loginResponse.status}`;
                }
                throw new Error(errorMsg);
            }

            // If we are here, loginResponse.ok was true
            const loginData = await loginResponse.json();

            // --- NEW LOGGING ---
            console.log('Admin Login Data (Parsed JSON):', loginData);
            console.log('Checking for token at: loginData.data.token');
            // --- END LOGGING ---


            // --- FIX: Access the nested 'data' object, just like in login.js ---
            const adminToken = loginData.data ? loginData.data.token : undefined;

            // --- NEW LOGGING ---
            console.log('Extracted Token Value:', adminToken);
            // --- END LOGGING ---


            if (!adminToken) {
                // Updated error to be more specific
                throw new Error('Auth OK, but token was missing from response `data` object.');
            }

            // === STEP 2: Create New User (using admin token) ===
            const createUserResponse = await fetch(`${API_BASE_URL}/user`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${adminToken}`
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    password: password,
                    role: role
                })
            });

            console.log('Create User Response (Raw):', createUserResponse);
            console.log('Create User Status:', createUserResponse.status);

            if (!createUserResponse.ok) {
                let errorMsg = 'Could not create user.';
                try {
                    const errorData = await createUserResponse.json();
                    console.log('Create User Error Data (Parsed JSON):', errorData);
                    // --- FIX: Check for error in data wrapper (your user API uses 'error' key) ---
                    errorMsg = errorData.data?.error || errorData.error || errorMsg;
                } catch (e) {
                    const errorText = await createUserResponse.text();
                    console.log('Create User Error (Raw Text):', errorText);
                    errorMsg = `Server error: ${createUserResponse.status}`;
                }
                throw new Error(errorMsg);
            }

            const createUserData = await createUserResponse.json();
            console.log('Create User Data (Parsed JSON):', createUserData);

            // === SUCCESS! ===
            bsAdminModal.hide();
            // --- FIX: Access message from data wrapper ---
            const successMsg = createUserData.data?.message || 'Account created successfully!';
            showMainMessage(`${successMsg} Redirecting to login...`);
            registerForm.reset(); // Clear the form
            adminAuthForm.reset(); // Clear admin form

            // Redirect to login after a short delay
            setTimeout(() => {
                window.location.href = 'login.php';
            }, 2000);


        } catch (error) {
            console.error('Full error object in catch block:', error);
            // Show any error from Step 1 or Step 2 in the modal
            showAdminError(error.message);
        } finally {
            // Reset button state regardless of outcome
            adminAuthButton.disabled = false;
            adminAuthButton.innerHTML = 'Authenticate & Create';
        }
    }

    // Clear modal error when it's hidden
    adminAuthModal.addEventListener('hidden.bs.modal', () => {
        hideAdminError();
        adminAuthForm.reset();
        // Reset button state in case it was left in loading
        adminAuthButton.disabled = false;
        adminAuthButton.innerHTML = 'Authenticate & Create';
    });
});
