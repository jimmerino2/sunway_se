async function updateLatestMonthlySales() {
    const apiUrl = "http://localhost/software_engineering/backend/orders/rate_income";
    const salesDiv = document.getElementById("Total_sales_today");

    // Initial check for the HTML element
    if (!salesDiv) {
        console.error("Error: Div with ID 'Total_sales_today' not found.");
        return;
    }

    // Set a loading indicator while fetching
    salesDiv.textContent = "Loading...";

    try {
        const response = await fetch(apiUrl);

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const result = await response.json();

        // 1. Validate the API response
        if (!result.success || !result.data || result.data.length === 0) {
            salesDiv.textContent = "N/A";
            console.error("API response indicates failure or no data.");
            return;
        }

        const incomeData = result.data;

        // 2. Get the last element of the array (the latest month's total)
        const latestEntry = incomeData[incomeData.length - 1];

        const latestTotal = parseFloat(latestEntry.total);
        const latestMonth = latestEntry.month;

        // 3. Format the output and update the div content
        if (!isNaN(latestTotal)) {
            // Update the text with the formatted total
            salesDiv.textContent = `RM ${latestTotal.toFixed(2)}`;

            // // Optional: Update the card-body to clarify it's the latest month, not today
            // const cardBody = salesDiv.closest('.card-footer').previousElementSibling;
            // if (cardBody) {
            //     cardBody.innerHTML = `**Latest Sales (${latestMonth})**`;
            // }

            console.log(`Successfully updated sales: RM ${latestTotal.toFixed(2)} for ${latestMonth}`);
        } else {
            salesDiv.textContent = "Invalid Data";
        }

    } catch (error) {
        // Display error message in the div
        salesDiv.textContent = "Error fetching data";
        console.error("Failed to fetch income data:", error);
    }
}

// Call the function to execute the process once the document is ready
document.addEventListener('DOMContentLoaded', updateLatestMonthlySales);