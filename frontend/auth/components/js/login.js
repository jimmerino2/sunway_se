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
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(loginData) // Send the object
    })
        // 1. Always attempt to read the JSON, regardless of the HTTP status.
        .then(responseRaw => {
            // Return a promise that resolves with an object containing status, 
            // the JSON body, and the 'ok' status.
            return responseRaw.json()
                .then(jsonBody => ({
                    status: responseRaw.status,
                    body: jsonBody,
                    ok: responseRaw.ok
                }))
                // Catch any error during JSON parsing (e.g., if the server returns non-JSON text on error)
                .catch(() => ({
                    status: responseRaw.status,
                    body: null, // Body is null if parsing failed
                    ok: responseRaw.ok
                }));
        })
        .then(responseResult => {

            // Log the *entire* response object from the server
            console.log('Server Response Data:', responseResult.body);

            // --- Check for HTTP Errors (4xx or 5xx) first ---
            if (!responseResult.ok) {

                // If the server provided a detailed JSON body with a message (like "Account deactivated" on 403)
                if (responseResult.body && responseResult.body.message) {
                    errorMessage.textContent = responseResult.body.message;
                    errorMessage.style.display = 'block';
                    return; // Stop processing since we displayed the specific error
                }

                // If it was a non-200 status but no specific message in the body, 
                // throw the generic HTTP error that the catch block handles below.
                throw new Error(`HTTP Error: ${responseResult.status} ${responseResult.statusText}`);
            }

            // --- Proceed with 200 OK Response Logic ---
            const responseData = responseResult.body;

            // 1. Check the 'success' flag from the API response body
            if (responseData.success && responseData.data) {

                // 2. Extract token and name from the nested 'data' object
                const token = responseData.data.token;
                const name = responseData.data.name;
                const role = responseData.data.role;
                const basePath = '/software_engineering/frontend/admin/';
                let destinationPage = '';

                if (token) {
                    localStorage.setItem('authToken', token);
                    //debug
                    // localStorage.setItem('username', name);
                    // localStorage.setItem('role', role);

                    // Use if/else logic to determine the correct destination
                    if (role === 'A') {
                        destinationPage = 'index.php';
                    } else if (role === 'C') {
                        destinationPage = 'floor_plans.php';
                    } else if (role === 'K') {
                        destinationPage = 'orders.php';
                    } else {
                        // Fallback for safety, e.g., if role is null or an unexpected value
                        console.warn(`Unknown or missing role ('${role}'). Defaulting to admin dashboard.`);
                        destinationPage = 'index.php';
                    }

                    // Perform the redirect to the correct page
                    window.location.href = basePath + destinationPage;
                } else {
                    // This case handles a successful status but missing essential data
                    errorMessage.textContent = 'Login successful but token missing. (Check console for details)';
                    errorMessage.style.display = 'block';
                    console.error('Login Error: responseData.data exists, but responseData.data.token is missing or empty.', responseData.data);
                }
            } else {
                // 3. Handle unsuccessful login (e.g., wrong credentials)
                // Use message from nested data if available, or a default
                errorMessage.textContent = responseData.message || responseData.data?.message || 'Invalid email or password.';
                errorMessage.style.display = 'block';
            }
        })
        .catch(error => {
            // This catches network errors or the custom errors thrown above (e.g., HTTP error 500 without a body)
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