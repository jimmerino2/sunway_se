async function getApiResponse(url, method = "GET", body = null) {
    // 1. Get Token automatically
    const token = localStorage.getItem('authToken');

    const options = {
        method: method,
        headers: {
            "Content-Type": "application/json",
        },
    };

    // 2. Add Auth Header if token exists
    if (token) {
        options.headers['Authorization'] = `Bearer ${token}`;
    }

    // 3. Handle Body
    if (body && method !== "GET") {
        options.body = JSON.stringify(body);
    }

    try {
        const response = await fetch(url, options);

        // Handle non-JSON responses or network errors gracefully if needed
        if (!response.ok) {
            console.error(`API Error: ${response.status} ${response.statusText}`);
            // You can throw error or return null depending on preference
        }

        const rawData = await response.json();
        return rawData; // Return the full response so we can check .success property

    } catch (error) {
        console.error("Network Error:", error);
        return { success: false, message: "Network Error" };
    }
}