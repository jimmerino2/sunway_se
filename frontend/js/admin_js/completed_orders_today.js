/**
 * Fetches order data, filters for orders completed on the actual current date,
 * and updates the corresponding HTML element.
 */
async function displayCompletedOrdersToday() {
    const api_url = "http://localhost/software_engineering/backend/orders";
    const completedOrdersElement = document.getElementById("Completed_Orders_Today");

    // Check if the target element exists
    if (!completedOrdersElement) {
        console.error("Target element with ID 'Completed_Orders_Today' not found.");
        return;
    }

    // Display a loading state initially
    if (completedOrdersElement.textContent === "" || completedOrdersElement.textContent.includes("Failed")) {
        completedOrdersElement.textContent = "Loading...";
    }

    try {
        const response = await fetch(api_url);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const json = await response.json();

        // 1. Get the current date in YYYY-MM-DD format (to match the order_time format)
        const now = new Date();
        const year = now.getFullYear();
        // Month is 0-indexed, so we add 1 and pad with '0'
        const month = String(now.getMonth() + 1).padStart(2, '0');
        // Day is 1-indexed, so we pad with '0'
        const day = String(now.getDate()).padStart(2, '0');

        // This is the dynamic date string to match against the order_time field
        const todayDateString = `${year}-${month}-${day}`;

        console.log(`Checking for completed orders on: ${todayDateString}`);

        if (json.success && Array.isArray(json.data)) {

            // 2. Filter the data based on 'is_complete' and 'todayDateString'
            const completedOrdersToday = json.data.filter(order =>
                // Check if the order is completed
                order.is_complete === "Y" &&
                // Check if the timestamp starts with today's dynamic date string
                order.order_time.startsWith(todayDateString)
            );

            // 3. Count the result
            const completedCount = completedOrdersToday.length;

            // 4. Update the HTML
            if (completedOrdersElement) {
                if (completedCount === 1) {
                    completedOrdersElement.textContent = completedCount + " Order";
                } else {
                    completedOrdersElement.textContent = completedCount + " Orders";
                }
            }

        } else {
            completedOrdersElement.textContent = "Data Error";
            console.error("API response succeeded but data format is incorrect:", json);
        }
    } catch (error) {
        // Handle network errors or API failures
        completedOrdersElement.textContent = "Failed to load";
        console.error("Error fetching or processing order data:", error);
    }
}

// --- Live Refresh Setup ---

// 1. Run the function immediately upon script load
displayCompletedOrdersToday();

// 2. Set a unique interval variable name (completedOrdersRefreshInterval)
const completedOrdersRefreshInterval = 10000; // 10 seconds in milliseconds

/**
 * Starts the automatic refresh for completed orders.
 * The interval ID is now unique (completedOrdersIntervalId).
 */
const completedOrdersIntervalId = setInterval(displayCompletedOrdersToday, completedOrdersRefreshInterval);

// Optional: Log the interval start for confirmation in the console
console.log(`Completed orders today refresh started, running every ${completedOrdersRefreshInterval / 1000} seconds. Interval ID: ${completedOrdersIntervalId}`);