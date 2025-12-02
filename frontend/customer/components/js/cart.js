/**
 * cart.js
 * Logic for the Cart page (cart.php)
 */

let cartData = [];
let editingIndex = -1;
let currentEditBasePrice = 0;
let editOrderModal, comfirmOrderModal;

document.addEventListener('DOMContentLoaded', () => {
    editOrderModal = new bootstrap.Modal(document.getElementById('editOrderModal'));
    comfirmOrderModal = new bootstrap.Modal(document.getElementById('comfirmOrderModal'));
    loadCart();

    // Attach Event Listeners
    document.getElementById('btn-submit-order').onclick = () => {
        if (cartData.length > 0) comfirmOrderModal.show();
    };

    document.getElementById('btn-final-submit').onclick = submitOrder;

    // Modal Listeners
    document.getElementById('qty-plus').onclick = () => changeEditQty(1);
    document.getElementById('qty-minus').onclick = () => changeEditQty(-1);
    document.getElementById('btn-save-changes').onclick = saveEdit;
    document.getElementById('btn-delete-item').onclick = deleteEdit;
});

function loadCart() {
    const tableNo = TableManager.get();
    const stored = localStorage.getItem("orders_" + tableNo);
    cartData = stored ? JSON.parse(stored) : [];

    const list = document.getElementById('cart-list');
    const empty = document.getElementById('empty-state');
    const bar = document.getElementById('checkout-bar');

    list.innerHTML = '';
    let total = 0;

    if (cartData.length === 0) {
        // --- CART IS EMPTY ---
        empty.classList.remove('d-none'); // Show empty state image

        // Hide the checkout bar completely
        bar.classList.add('d-none');
        bar.classList.remove('d-flex');

    } else {
        // --- CART HAS ITEMS ---
        empty.classList.add('d-none'); // Hide empty state

        // Show the checkout bar with Flexbox
        bar.classList.remove('d-none');
        bar.classList.add('d-flex');

        cartData.forEach((item, index) => {
            const itemTotal = parseFloat(item.price) * parseInt(item.quantity);
            total += itemTotal;
            list.appendChild(renderCartItem(item, itemTotal, index));
        });
    }

    // Update Totals
    const totalStr = total.toFixed(2);
    document.getElementById('cart-total').textContent = totalStr;
    document.getElementById('confirm-total').textContent = totalStr;

    // Update Badge
    CartNotification.set(cartData.length);
}

function renderCartItem(item, totalCost, index) {
    const div = document.createElement('div');
    div.className = 'cart-card p-2 d-flex align-items-center gap-3';
    div.onclick = () => openEditModal(index);

    const imgSrc = item.image || 'https://dummyimage.com/100x100/dee2e6/6c757d.jpg';

    div.innerHTML = `
        <img src="${imgSrc}" class="cart-img flex-shrink-0">
        <div class="flex-grow-1" style="min-width:0;">
            <div class="d-flex justify-content-between align-items-start">
                <h6 class="fw-bold text-dark text-truncate mb-1">${item.name}</h6>
                <span class="fw-bold text-primary text-nowrap ms-2">RM ${totalCost.toFixed(2)}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-1">
                <small class="text-muted">RM ${parseFloat(item.price).toFixed(2)} / unit</small>
                <span class="badge bg-light text-dark border">x${item.quantity}</span>
            </div>
        </div>
        <div class="px-2 text-muted"><i class="bi bi-pencil-square"></i></div>
    `;
    return div;
}

// --- EDIT LOGIC ---

function openEditModal(index) {
    editingIndex = index;
    const item = cartData[index];
    currentEditBasePrice = parseFloat(item.price);

    document.getElementById('edit-name').textContent = item.name;
    document.getElementById('edit-img').src = item.image || 'https://dummyimage.com/600x400/dee2e6/6c757d.jpg';
    document.getElementById('qty-input').value = item.quantity;

    updateEditPriceDisplay(item.quantity);
    editOrderModal.show();
}

function changeEditQty(delta) {
    const input = document.getElementById('qty-input');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    input.value = val;
    updateEditPriceDisplay(val);
}

function updateEditPriceDisplay(qty) {
    document.getElementById('edit-price').textContent = (currentEditBasePrice * qty).toFixed(2);
}

function saveEdit() {
    if (editingIndex > -1) {
        cartData[editingIndex].quantity = parseInt(document.getElementById('qty-input').value);
        saveAndRender("Updated quantity");
        editOrderModal.hide();
    }
}

function deleteEdit() {
    if (editingIndex > -1) {
        cartData.splice(editingIndex, 1);
        saveAndRender("Item removed");
        editOrderModal.hide();
    }
}

function saveAndRender(msg) {
    localStorage.setItem("orders_" + TableManager.get(), JSON.stringify(cartData));
    loadCart();
    if (msg && window.showNotification) showNotification(msg);
}

// --- SUBMIT LOGIC ---

async function submitOrder() {
    const btn = document.getElementById('btn-final-submit');
    const tableNo = TableManager.get();

    btn.disabled = true;
    btn.textContent = "Processing...";

    try {
        // 1. Post Orders
        for (const order of cartData) {
            await getApiResponse("http://localhost/software_engineering/backend/orders", "POST", {
                item_id: order.item_id,
                quantity: order.quantity,
                status: 'P',
                is_complete: 'N',
                order_time: new Date().toISOString(),
                table_id: tableNo,
            });
        }

        // 2. Update Seating Status
        const seatRes = await getApiResponse("http://localhost/software_engineering/backend/seating?table_no=" + tableNo, "GET");
        if (seatRes?.data?.[0]) {
            await getApiResponse("http://localhost/software_engineering/backend/seating", "PATCH", {
                id: seatRes.data[0].id,
                table_no: tableNo,
                status: 'C'
            });
        }

        // 3. Cleanup
        localStorage.removeItem('orders_' + tableNo);
        CartNotification.set(0);
        comfirmOrderModal.hide();

        if (window.showNotification) showNotification("Order sent! 👨‍🍳");

        setTimeout(() => window.location.href = "orders.php", 1500);

    } catch (error) {
        console.error(error);
        if (window.showNotification) showNotification("Error submitting order.");
        btn.disabled = false;
        btn.textContent = "Confirm";
    }
}