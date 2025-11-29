$(document).ready(function () {
    const API_SEATING = 'http://localhost/software_engineering/backend/seating';
    const API_ORDERS = 'http://localhost/software_engineering/backend/orders';
    let allOrders = [];

    // --- Data Loading ---
    async function loadData() {
        // Load Orders First
        const orderRes = await getApiResponse(API_ORDERS);
        if (orderRes.success) allOrders = orderRes.data;

        // Load Seating
        const seatRes = await getApiResponse(API_SEATING);
        if (seatRes.success) renderTables(seatRes.data);
    }

    function renderTables(tables) {
        // Clear containers
        ['private-room', 'solo-bar', 'group-work', 'lounge-seating', 'mini-bar', 'open-dining'].forEach(id => $(`#${id}-container`).empty());

        tables.forEach(t => {
            const html = getTableHtml(t);
            const container = getContainer(t);
            if (container) container.append(html);
        });

        // Add click listeners
        $('.clickable-seat').off('click').on('click', handleTableClick);
    }

    function getContainer(t) {
        if (t.floor == 1) {
            if (t.type === 'Private Room') return $('#private-room-container');
            if (t.type === 'Solo Work Bar') return $('#solo-bar-container');
            if (t.type === 'Group Work Table') return $('#group-work-container');
            if (t.type === 'Lounge') return $('#lounge-seating-container');
        } else {
            if (t.type === 'Minibar') return $('#mini-bar-container');
            if (t.type === 'Open Dining') return $('#open-dining-container');
        }
        return null;
    }

    function getTableHtml(t) {
        let cls = t.status === 'F' ? 'status-free' : (t.status === 'P' ? 'status-pending' : 'status-occupied');
        // Simplified HTML generation for brevity - matches your previous CSS classes
        if (t.ttype === 'Round') return `<div class="table-group clickable-seat" data-id="${t.id}" data-no="${t.table_no}" data-status="${t.status}"><div class="table-circle ${cls}"><span class="numbered-element">${t.table_no}</span></div></div>`;
        if (t.ttype === 'Square') return `<div class="table-group clickable-seat" data-id="${t.id}" data-no="${t.table_no}" data-status="${t.status}"><div class="table-square ${cls}"><span class="numbered-element">${t.table_no}</span></div></div>`;
        // ... Add other types (Long, Sofa) following same pattern ...
        return '';
    }

    // --- Interactions ---
    const editModal = new bootstrap.Modal(document.getElementById('editTableModal'));
    const checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal'));

    function handleTableClick() {
        const id = $(this).data('id');
        const no = $(this).data('no');
        const status = $(this).data('status');

        $('#editTableModalLabel').text(`Table ${no}`);
        $('#modal-current-status').text(status === 'F' ? 'Free' : (status === 'P' ? 'Pending' : 'Occupied'));

        // Filter orders for this table
        const tableOrders = allOrders.filter(o => o.table_id == id && o.is_complete === 'N');
        const list = $('#modal-order-list').empty();

        if (tableOrders.length > 0) {
            tableOrders.forEach(o => list.append(`<li class="list-group-item">${o.quantity}x ${o.item_name} <span class="badge bg-secondary">${o.status}</span></li>`));
            $('#checkout-btn-from-edit').show().data('id', id).data('no', no);
        } else {
            list.append('<li class="list-group-item text-muted">No active orders</li>');
            if (status === 'F') $('#checkout-btn-from-edit').hide();
        }

        editModal.show();
    }

    // Checkout Logic
    $('#checkout-btn-from-edit').click(function () {
        editModal.hide();
        const id = $(this).data('id');
        const tableOrders = allOrders.filter(o => o.table_id == id && o.is_complete === 'N');

        // Populate Checkout
        let total = 0;
        const list = $('#checkout-order-list').empty();
        tableOrders.forEach(o => {
            total += parseFloat(o.cost);
            list.append(`<li class="list-group-item d-flex justify-content-between"><span>${o.item_name}</span><span>RM ${o.cost}</span></li>`);
        });
        $('#checkout-total-cost').text(`RM ${total.toFixed(2)}`);
        $('#final-clear-table-btn').data('id', id);

        checkoutModal.show();
    });

    // Final Clear
    $('#final-clear-table-btn').click(async function () {
        const id = $(this).data('id');

        // 1. Clear Orders
        await getApiResponse(API_ORDERS, "PATCH", { table_id: id, action: "clear_table" });
        // 2. Free Table
        await getApiResponse(API_SEATING, "PATCH", { id: id, status: "F" });

        checkoutModal.hide();
        loadData(); // Refresh UI
    });

    loadData();
    setInterval(loadData, 10000);
});