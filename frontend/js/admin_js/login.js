document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const errorMessage = document.getElementById('errorMessage');
    errorMessage.style.display = 'none';

    // NOTE: Changed API endpoint to the full path as used in your orders fetch, 
    // assuming your login is on the same host. You might need to adjust this.
    const apiEndpoint = 'http://localhost/software_engineering/backend/auth';

    // Create the data object to be sent
    const loginData = {
        email: email,
        password: password
    };

    console.log('Sending JSON to backend:', loginData);

    fetch(apiEndpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(loginData) // Send the object
    })
        // Use responseRaw to check for HTTP status before trying to parse JSON
        .then(responseRaw => {
            // Check if the HTTP status is OK (200-299)
            if (!responseRaw.ok) {
                // Throw an error with the HTTP status text
                throw new Error(`HTTP Error: ${responseRaw.status} ${responseRaw.statusText}`);
            }
            return responseRaw.json();
        })
        .then(responseData => {

            // --- NEW DEBUGGING LINE ---
            // Log the *entire* response object from the server to see what we got
            console.log('Server Response Data:', responseData);
            // --- END OF DEBUGGING LINE ---

            // 1. Check the 'success' flag from the API response body
            if (responseData.success && responseData.data) {

                // 2. Extract token and name from the nested 'data' object
                // We will use lowercase 'token' and 'name'
                const token = responseData.data.token;
                const name = responseData.data.name;

                if (token) {
                    localStorage.setItem('authToken', token);
                    localStorage.setItem('username', name);
                    window.location.href = '/software_engineering/frontend/admin/admin_dashboard.php';
                } else {
                    // This case handles a successful status but missing essential data
                    errorMessage.textContent = 'Login successful but token missing. (Check console for details)';
                    errorMessage.style.display = 'block';
                    console.error('Login Error: responseData.data exists, but responseData.data.token is missing or empty.', responseData.data);
                }
            } else {
                // 3. Handle unsuccessful login (e.g., wrong credentials)
                // Use message from nested data if available, or a default
                errorMessage.textContent = responseData.data?.message || 'Invalid email or password.';
                errorMessage.style.display = 'block';
            }
        })
        .catch(error => {
            // This catches network errors or the custom errors thrown above (e.g., HTTP error)
            console.error('Login Error:', error);

            // Display a user-friendly error message
            if (error.message.startsWith('HTTP Error')) {
                errorMessage.textContent = 'Server connectivity issue or bad request.';
            } else {
                errorMessage.textContent = error.message;
            }
            errorMessage.style.display = 'block';
        });
});