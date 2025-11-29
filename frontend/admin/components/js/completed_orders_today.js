async function displayCompletedOrdersToday() {
    const el = document.getElementById("Completed_Orders_Today");
    if (!el) return;

    const result = await getApiResponse("http://localhost/software_engineering/backend/orders");

    if (result && result.success && Array.isArray(result.data)) {
        const todayStr = new Date().toISOString().split('T')[0];
        const count = result.data.filter(o => o.is_complete === "Y" && o.order_time.startsWith(todayStr)).length;
        el.textContent = `${count} Orders`;
    } else {
        el.textContent = "Err";
    }
}
document.addEventListener('DOMContentLoaded', () => {
    displayCompletedOrdersToday();
    setInterval(displayCompletedOrdersToday, 10000);
});