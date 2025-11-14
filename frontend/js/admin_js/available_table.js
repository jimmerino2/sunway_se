// Define the API URL
const api_url = "http://localhost/software_engineering/backend/seating?status=f";


// Get the element where the count will be displayed
const availableTablesElement = document.getElementById("Available_Tables");

/**
 * Fetches the free seating data and updates the display.
 */
async function updateAvailableTables() {
    // Check if the target element exists before proceeding
    if (!availableTablesElement) {
        console.error("Target element with ID 'Available_Tables' not found.");
        return;
    }

    // Set a temporary loading state, but only if it's not already displaying a count
    if (!availableTablesElement.textContent.includes("available")) {
        availableTablesElement.textContent = "Loading...";
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

        // 2. Check for a successful HTTP status (e.g., 200 OK)
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        // 3. Parse the JSON body of the response
        const apiData = await response.json();

        // 4. Validate the API response structure and 'success' flag
        if (apiData.success && Array.isArray(apiData.data)) {
            // The 'data' array contains all the free seats
            const freeTablesCount = apiData.data.length;

            // 5. Update the text content of the HTML element
            availableTablesElement.textContent = `${freeTablesCount} available`;
        } else {
            // Handle case where API response is not successful or data format is unexpected
            throw new Error(`API reported failure: ${apiData.message || 'Unknown error'}`);
        }

    } catch (error) {
        // 6. Handle any errors during the fetch or processing
        console.error("Error fetching available tables data:", error);
        availableTablesElement.textContent = "Error loading data"; // Display an error message to the user
    }
}

// --- Live Refresh Setup ---

// 1. Call the function to execute the data fetch and update immediately
updateAvailableTables();

// 2. Set the function to refresh every 10,000 milliseconds (10 seconds)
const refreshInterval = 10000; // 10 seconds

/**
 * Starts the automatic refresh for available tables.
 */
const intervalId = setInterval(updateAvailableTables, refreshInterval);

// Optional: Log the interval start for confirmation in the console
// console.log(`Available tables refresh started, running every ${refreshInterval / 1000} seconds. Interval ID: ${intervalId}`);