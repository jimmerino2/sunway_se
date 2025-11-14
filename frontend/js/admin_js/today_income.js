async function updateTodaysSales() {
    const apiUrl = "http://localhost/software_engineering/backend/orders/rate_income";
    const salesDiv = document.getElementById("Total_sales_today");

    if (!salesDiv) {
        console.error("Error: Div with ID 'Total_sales_today' not found.");
        return;
    }

    if (!token) {
        console.error("Authorization token not found.");
        salesDiv.textContent = "Login Required";
        return;
    }

    salesDiv.textContent = "Loading...";

    try {
        // --- 1. Determine Today's Date (YYYY-MM-DD format) ---
        const today = new Date();
        // Use a function to ensure two digits for month and day (e.g., 01, 09)
        const pad = (num) => num.toString().padStart(2, '0');

        const todayDateString = `${today.getFullYear()}-${pad(today.getMonth() + 1)}-${pad(today.getDate())}`;

        // --- 2. Fetch Data ---
        const response = await fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        });

        if (!response.ok) {
            if (response.status === 401) {
                salesDiv.textContent = "Access Denied";
                console.error("Authorization failed for API call.");
                return;
            }
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json();

        if (!result.success || !result.data || result.data.length === 0) {
            salesDiv.textContent = "N/A";
            console.warn("API response indicates failure or no data.");
            return;
        }

        const incomeData = result.data;

        // --- 3. Filter for Today's Entry ---
        // Find the single entry in the data array where the "day" property matches todayDateString
        const todayEntry = incomeData.find(item => item.day === todayDateString);

        if (todayEntry) {
            const todaysTotal = parseFloat(todayEntry.total);

            // --- 4. Format and Update ---
            if (!isNaN(todaysTotal)) {
                // Display today's sales
                salesDiv.textContent = `RM ${todaysTotal.toFixed(2)}`;
            } else {
                salesDiv.textContent = "Invalid Data";
            }
        } else {
            // No sales entry found for today's date
            salesDiv.textContent = "RM 0.00";
        }

    } catch (error) {
        salesDiv.textContent = "Error fetching data";
        console.error("Failed to fetch income data:", error);
    }
}

// Call the new function
document.addEventListener('DOMContentLoaded', updateTodaysSales);