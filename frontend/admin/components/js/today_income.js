async function updateTodaysSales() {
    const salesDiv = document.getElementById("Total_sales_today");
    if (!salesDiv) return;

    // Uses api.js
    const result = await getApiResponse("http://localhost/software_engineering/backend/orders/rate_income");

    if (result && result.success && Array.isArray(result.data)) {
        const todayStr = new Date().toISOString().split('T')[0];
        const todayEntry = result.data.find(item => item.day === todayStr);

        const total = todayEntry ? parseFloat(todayEntry.total) : 0;
        salesDiv.textContent = `RM ${total.toFixed(2)}`;
    } else {
        salesDiv.textContent = "N/A";
    }
}
document.addEventListener('DOMContentLoaded', () => {
    updateTodaysSales();
    setInterval(updateTodaysSales, 10000);
});