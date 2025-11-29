async function displayPendingOrders() {
    const el = document.getElementById("Pending_Orders");
    if (!el) return;

    const result = await getApiResponse("http://localhost/software_engineering/backend/orders");

    if (result && result.success && Array.isArray(result.data)) {
        const count = result.data.filter(o => o.status === "P").length;
        el.textContent = `${count} Orders`;
    } else {
        el.textContent = "Err";
    }
}
document.addEventListener('DOMContentLoaded', () => {
    displayPendingOrders();
    setInterval(displayPendingOrders, 10000);
});