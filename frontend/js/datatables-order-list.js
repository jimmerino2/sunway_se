window.addEventListener('DOMContentLoaded', event => {

    // Variable to hold the Simple-DataTables instance globally
    let simpleDataTableInstance = null;
    const datatablesOrders = document.getElementById('datatablesOrders');

    // --- Core Helper Functions ---

    // 1. Helper function to get status text
    function getStatusText(status) {
        switch (status) {
            case 'D':
                return 'Delivered';
            case 'O':
                return 'Cooking';
            case 'P':
                return 'Pending';
            default:
                return 'Unknown';
        }
    }

    // Helper function for status weight (used for pre-sorting)
    function getStatusWeight(status) {
        switch (status) {
            case 'P': return 0;
            case 'O': return 1;
            case 'D': return 2;
            default: return 3;
        }
    }

    // 2. Helper function to create action buttons
    function getActionButtons(order) {
        // Store the entire order object as a JSON string
        const orderData = JSON.stringify(order);

        return /*html*/`
            <button class="btn btn-primary btn-sm btn-change-status" data-bs-toggle="modal" data-bs-target="#changeStatusModal" data-order='${orderData}' title="Change Status">Change</button>
            <button class="btn btn-danger btn-sm btn-remove-order" data-bs-toggle="modal" data-bs-target="#removeOrderModal" data-order='${orderData}' title="Remove">Remove</button>
        `;
    }

    // --- Modal Prefill & Submission Logic ---

    function prefillChangeModal(order) {
        document.getElementById('changeOrderId').value = order.id || '';
        document.getElementById('currentOrderItem').value = order.item_name || 'N/A';
        document.getElementById('currentStatus').value = getStatusText(order.status);
        document.getElementById('newStatus').value = '';
    }

    function prefillRemoveModal(order) {
        document.getElementById('removeOrderId').value = order.id || '';
        document.getElementById('removeOrderItem').textContent = order.item_name || 'this item';
    }

    // Function to set up modal event listeners
    function setupModalListeners(tableElement) {

        // --- 3. Event Delegation Listener for Action Buttons (prefills modals) ---
        tableElement.addEventListener('click', function (e) {

            const btn = e.target.closest('.btn-change-status, .btn-remove-order');
            if (!btn) return;

            try {
                const orderData = JSON.parse(btn.getAttribute('data-order'));

                if (btn.classList.contains('btn-change-status')) {
                    prefillChangeModal(orderData);
                } else if (btn.classList.contains('btn-remove-order')) {
                    prefillRemoveModal(orderData);
                }

            } catch (error) {
                console.error('Error parsing order data from button:', error);
            }
        });

        // --- 4. Status Change Submission Handler (PATCH) ---
        document.getElementById('saveStatusChange').addEventListener('click', async function () {
            const orderId = document.getElementById('changeOrderId').value;
            const newStatus = document.getElementById('newStatus').value;

            if (!newStatus) {
                alert('Please select a new status.');
                return;
            }

            const apiEndpoint = 'http://localhost/software_engineering/backend/orders';

            try {
                const response = await fetch(apiEndpoint, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: orderId, status: newStatus })
                });

                if (response.ok) {
                    alert(`Order ${orderId} status updated successfully!`);

                    const changeModalElement = document.getElementById('changeStatusModal');
                    const modalInstance = bootstrap.Modal.getInstance(changeModalElement);
                    if (modalInstance) modalInstance.hide();

                    // Refresh the table data
                    await initializeDataTable();
                } else {
                    const errorData = await response.json();
                    alert(`Failed to update status: ${errorData.error || response.statusText}`);
                }
            } catch (error) {
                console.error('Network error updating status:', error);
                alert('A network error occurred while updating the status.');
            }
        });

        // 5. Remove Confirmation Submission Handler (DELETE - Using JSON Body)
        document.getElementById('confirmRemoveOrder').addEventListener('click', async function () {
            const orderId = document.getElementById('removeOrderId').value;

            // Base API endpoint without query string
            const apiEndpoint = `http://localhost/software_engineering/backend/orders`;

            try {
                const response = await fetch(apiEndpoint, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json', // Specify content type is JSON
                    },
                    // Send the ID in the request body
                    body: JSON.stringify({ id: orderId })
                });

                if (response.ok) {
                    alert(`Order ${orderId} removed successfully!`);
                    // ... (Modal close and refresh logic)
                    const removeModalElement = document.getElementById('removeOrderModal');
                    const modalInstance = bootstrap.Modal.getInstance(removeModalElement);
                    if (modalInstance) modalInstance.hide();
                    await initializeDataTable();
                } else {
                    const errorData = await response.json();
                    alert(`Failed to remove order: ${errorData.error || response.statusText}`);
                }
            } catch (error) {
                console.error('Network error removing order:', error);
                alert('A network error occurred while removing the order.');
            }
        });
    }

    // 6. Async function to fetch, process, and initialize/refresh the table (FIXED for flicker)
    async function initializeDataTable() {
        let dataForTable = [];

        try {
            const response = await fetch('http://localhost/software_engineering/backend/orders');
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const orders = await response.json();

            // Process and sort the data
            dataForTable = orders
                .filter(order => order != null)
                .sort((a, b) => {
                    const statusWeightA = getStatusWeight(a.status);
                    const statusWeightB = getStatusWeight(b.status);

                    if (statusWeightA !== statusWeightB) {
                        return statusWeightA - statusWeightB;
                    }
                    return (a.order_time ?? '').localeCompare(b.order_time ?? '');
                })
                .map(order => {
                    const cost = parseFloat(order.cost ?? '0.00');
                    const quantity = parseInt(order.quantity ?? 0, 10);

                    // Return the array for the table row
                    return [
                        String(order.item_name ?? 'N/A'),
                        String(order.category_name ?? 'N/A'),
                        String(quantity),
                        String(order.table_no ?? 0),
                        String(order.order_time ?? 'N/A'),
                        String(cost.toFixed(2)),
                        getStatusText(order.status),
                        getActionButtons(order)
                    ];
                });

        } catch (error) {
            console.error('Failed to fetch or process order data:', error);
            return;
        }

        // 7. Initialization/Refresh Logic
        if (datatablesOrders) {

            if (simpleDataTableInstance) {
                // SCENARIO 2: Table is already initialized (Refresh)

                // Destroy the old instance safely
                simpleDataTableInstance.destroy();

                // Re-insert the expected HTML structure for Simple-DataTables
                datatablesOrders.innerHTML = `
                    <thead>
                        <tr>
                            <th>Item</th><th>Category</th><th>Quantity</th>
                            <th>Table Number</th><th>Time</th><th>Cost</th>
                            <th>Status</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>`;
            }

            // SCENARIO 1 (or Re-Initialize after destroy)
            simpleDataTableInstance = new simpleDatatables.DataTable(datatablesOrders, {
                data: {
                    headings: [
                        "Item", "Category", "Quantity", "Table Number", "Time", "Cost", "Status", "Actions"
                    ],
                    data: dataForTable
                },
                perPageSelect: [10, 25, 50, 100],
                columns: [
                    { select: 7, sortable: false }
                ]
            });

            // Only set up listeners once on the initial load, OR ensure they are always attached
            // after the table element is rebuilt.
            setupModalListeners(datatablesOrders);
        }
    }

    // 9. Start the process
    initializeDataTable();
});