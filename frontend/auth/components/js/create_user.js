document.addEventListener('DOMContentLoaded', () => {
    // API Base URL - all API calls will be prefixed with this
    const API_BASE_URL = 'http://localhost/software_engineering/backend';

    // Main form inputs
    const registerForm = document.getElementById('registerForm');
    // NOTE: Ensure your HTML button has the ID 'registerSubmitButton' and type="submit"
    const registerSubmitButton = document.getElementById('registerSubmitButton');
    const inputName = document.getElementById('inputFirstName');
    const inputEmail = document.getElementById('inputEmail');
    const inputRole = document.getElementById('inputRole');
    const inputPassword = document.getElementById('inputPassword');
    const inputPasswordConfirm = document.getElementById('inputPasswordConfirm');
    const mainMessage = document.getElementById('mainMessage');

    // Modal elements
    const adminAuthModal = document.getElementById('adminAuthModal');
    const adminAuthForm = document.getElementById('adminAuthForm');
    const adminEmailInput = document.getElementById('adminEmail');
    const adminPasswordInput = document.getElementById('adminPassword');
    const adminAuthButton = document.getElementById('adminAuthenticateButton');
    const adminAuthError = document.getElementById('adminAuthError');
    const adminAuthErrorMsg = adminAuthError.querySelector('.alert');
    const bsAdminModal = new bootstrap.Modal(adminAuthModal);

    // Utility functions (showAdminError, hideAdminError, showMainMessage, hideMainMessage...)
    function showAdminError(message) {
        adminAuthErrorMsg.textContent = message;
        adminAuthError.classList.remove('d-none');
    }

    function hideAdminError() {
        adminAuthError.classList.add('d-none');
    }

    function showMainMessage(message, type = 'success') {
        mainMessage.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
    }

    function hideMainMessage() {
        mainMessage.innerHTML = '';
    }

    // =========================================================
    // 🎯 STEP 1: Validate Main Form on "Create Account" Click
    // =========================================================
    registerForm.addEventListener('submit', (event) => {
        event.preventDefault(); // Stop default form submission (Crucial!)

        // 1. Clear previous messages/styles
        hideMainMessage();
        inputPassword.classList.remove('is-invalid');
        inputPasswordConfirm.classList.remove('is-invalid');

        // 2. Check native validity (required fields)
        if (!registerForm.checkValidity()) {
            registerForm.reportValidity(); // Shows native browser errors
            return;
        }

        // 3. Custom check: Password match
        if (inputPassword.value !== inputPasswordConfirm.value) {
            showMainMessage('Passwords do not match.', 'danger');
            inputPassword.classList.add('is-invalid');
            inputPasswordConfirm.classList.add('is-invalid');
            return;
        }

        // 4. If all checks pass, OPEN THE MODAL
        bsAdminModal.show();
    });

    // =========================================================
    // 🎯 STEP 2: Validate Admin Credentials on "Authenticate & Create" Click
    // =========================================================
    adminAuthButton.addEventListener('click', () => {
        // Main form data is already validated and ready to use
        const name = inputName.value;
        const email = inputEmail.value;
        const role = inputRole.value;
        const password = inputPassword.value;

        // Get values from admin modal form
        const adminEmail = adminEmailInput.value;
        const adminPassword = adminPasswordInput.value;

        // 1. Check if admin credentials are provided
        if (!adminEmail || !adminPassword) {
            showAdminError('Please enter your admin email and password.');
            return;
        }

        // 2. Proceed to API calls
        hideAdminError();
        adminAuthButton.disabled = true;
        adminAuthButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Authenticating...';

        handleCreateAccount(name, email, role, password, adminEmail, adminPassword);
    });

    // Main function to handle the two-step API call
    async function handleCreateAccount(name, email, role, password, adminEmail, adminPassword) {
        try {
            // ... (API call logic for Admin Auth) ...
            const loginResponse = await fetch(`${API_BASE_URL}/auth`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: adminEmail, password: adminPassword })
            });

            if (!loginResponse.ok) {
                let errorMsg = 'Invalid admin credentials.';
                try {
                    const errorData = await loginResponse.json();
                    errorMsg = errorData.data?.message || errorData.message || errorMsg;
                } catch (e) { errorMsg = `Server error: ${loginResponse.status}`; }
                throw new Error(errorMsg);
            }

            const loginData = await loginResponse.json();
            const adminToken = loginData.data ? loginData.data.token : undefined;

            if (!adminToken) {
                throw new Error('Auth OK, but token was missing from response `data` object.');
            }

            // ... (API call logic for Create User) ...
            const createUserResponse = await fetch(`${API_BASE_URL}/user`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${adminToken}`
                },
                body: JSON.stringify({ name: name, email: email, password: password, role: role })
            });

            if (!createUserResponse.ok) {
                let errorMsg = 'Could not create user.';
                try {
                    const errorData = await createUserResponse.json();
                    errorMsg = errorData.data?.error || errorData.error || errorMsg;
                } catch (e) { errorMsg = `Server error: ${createUserResponse.status}`; }
                throw new Error(errorMsg);
            }

            const createUserData = await createUserResponse.json();

            // === SUCCESS! ===
            bsAdminModal.hide();
            const successMsg = createUserData.data?.message || 'Account created successfully!';
            showMainMessage(`${successMsg} Redirecting to login...`);
            registerForm.reset();
            adminAuthForm.reset();

            setTimeout(() => {
                window.location.href = 'login.php';
            }, 2000);

        } catch (error) {
            console.error('Full error object in catch block:', error);
            showAdminError(error.message);
        } finally {
            adminAuthButton.disabled = false;
            adminAuthButton.innerHTML = 'Authenticate & Create';
        }
    }

    // Clear modal error when it's hidden
    adminAuthModal.addEventListener('hidden.bs.modal', () => {
        hideAdminError();
        adminAuthForm.reset();
        adminAuthButton.disabled = false;
        adminAuthButton.innerHTML = 'Authenticate & Create';
    });
});