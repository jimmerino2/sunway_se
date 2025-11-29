/**
 * orders.js
 * Logic for the Orders/Bill page (orders.php)
 */

document.addEventListener('DOMContentLoaded', () => {
    loadOrders();
    // Auto-refresh every 10 seconds
    setInterval(loadOrders, 10000);
});

async function loadOrders() {
    const list = document.getElementById('order-list');
    const empty = document.getElementById('empty-state');
    const tableNo = TableManager.get();

    // Only show spinner if list is empty (first load)
    if (!list.hasChildNodes()) {
        list.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary"></div></div>';
    }

    try {
        const url = `http://localhost/software_engineering/backend/orders?table_no=${tableNo}&is_complete=N`;
        const res = await getApiResponse(url);

        list.innerHTML = '';
        let grandTotal = 0;
        let count = 0;

        if (res && res.data && res.data.length > 0) {
            empty.classList.add('d-none');

            res.data.forEach(order => {
                const cost = parseFloat(order.cost) || 0;
                grandTotal += cost;
                count += parseInt(order.quantity);

                const card = document.createElement('div');
                card.className = 'order-card';
                card.innerHTML = `
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-bold text-dark mb-0">${order.item_name}</h6>
                        <span class="fw-bold text-primary">RM ${cost.toFixed(2)}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        ${getStatusHtml(order.status)}
                        <span class="text-muted small fw-bold">Qty: ${order.quantity}</span>
                    </div>
                `;
                list.appendChild(card);
            });

            document.getElementById('total-bill').textContent = grandTotal.toFixed(2);
            document.getElementById('total-items').textContent = count;
        } else {
            empty.classList.remove('d-none');
            document.getElementById('total-bill').textContent = "0.00";
            document.getElementById('total-items').textContent = "0";
        }

    } catch (error) {
        console.error("Load Orders Error:", error);
    }
}

function getStatusHtml(status) {
    switch (status) {
        case 'P': return '<span class="status-badge status-pending"><i class="bi bi-hourglass-split me-1"></i> Ordered</span>';
        case 'O': return '<span class="status-badge status-cooking"><i class="bi bi-fire me-1"></i> Cooking</span>';
        case 'D': return '<span class="status-badge status-delivered"><i class="bi bi-check-circle-fill me-1"></i> Delivered</span>';
        default: return '<span class="status-badge bg-light text-dark">Unknown</span>';
    }
}