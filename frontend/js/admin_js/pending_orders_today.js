/**
 * Fetches order data, filters for pending orders (status "P"),
 * and updates the corresponding HTML element.
 */
async function displayPendingOrders() {
    // Note: The API URL is assumed to be the same as before
    const api_url = "http://localhost/software_engineering/backend/orders";
    const pendingOrdersElement = document.getElementById("Pending_Orders");

    // Check if the target element exists
    if (!pendingOrdersElement) {
        console.error("Target element with ID 'Pending_Orders' not found.");
        return;
    }

    // Display a loading state initially
    if (pendingOrdersElement.textContent === "" || pendingOrdersElement.textContent.includes("Failed")) {
        pendingOrdersElement.textContent = "Loading...";
    }

    try {
        // 1. Fetch the data from the API
        const response = await fetch(api_url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const json = await response.json();

        if (json.success && Array.isArray(json.data)) {

            // Filter the 'data' array for orders where the 'status' is "P" (Pending)
            const pendingOrders = json.data.filter(order =>
                order.status === "P"
            );

            // Count the number of pending orders
            const pendingCount = pendingOrders.length;

            // Update the HTML element with the result
            if (pendingCount === 1) {
                pendingOrdersElement.textContent = pendingCount + " Order";
            } else {
                pendingOrdersElement.textContent = pendingCount + " Orders";
            }

        } else {
            pendingOrdersElement.textContent = "Data Error";
            console.error("API response succeeded but data format is incorrect:", json);
        }
    } catch (error) {
        // Handle network errors or API failures
        pendingOrdersElement.textContent = "Failed to load";
        console.error("Error fetching or processing order data:", error);
    }
}

// --- Live Refresh Setup ---

// 1. Run the function immediately upon script load
displayPendingOrders();

// 2. Set a unique interval variable name (pendingOrdersRefreshInterval)
const pendingOrdersRefreshInterval = 10000; // 10 seconds in milliseconds

/**
 * Starts the automatic refresh for pending orders.
 * The interval ID is now unique (pendingOrdersIntervalId).
 */
const pendingOrdersIntervalId = setInterval(displayPendingOrders, pendingOrdersRefreshInterval);

// Optional: Log the interval start for confirmation in the console
// console.log(`Pending orders refresh started, running every ${pendingOrdersRefreshInterval / 1000} seconds. Interval ID: ${pendingOrdersIntervalId}`);