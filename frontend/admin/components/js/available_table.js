async function updateAvailableTables() {
    const el = document.getElementById("Available_Tables");
    if (!el) return;

    const result = await getApiResponse("http://localhost/software_engineering/backend/seating?status=f");

    if (result && result.success && Array.isArray(result.data)) {
        el.textContent = `${result.data.length} available`;
    } else {
        el.textContent = "Err";
    }
}
document.addEventListener('DOMContentLoaded', () => {
    updateAvailableTables();
    setInterval(updateAvailableTables, 10000);
});