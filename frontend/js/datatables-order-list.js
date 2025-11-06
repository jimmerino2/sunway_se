window.addEventListener('DOMContentLoaded', event => {
    // 1. Helper function to get status text
    function getStatusText(status) {
        switch (status) {
            case 'D':
                return 'Delivered';
            case 'O':
                return 'Cooking'; // From your DB 'O' (Ordered)
            case 'P':
                return 'Pending';
            default:
                return 'Unknown';
        }
    }

    // Helper function for status weight (used for pre-sorting)
    function getStatusWeight(status) {
        switch (status) {
            case 'P': return 0; // Pending first
            case 'O': return 1; // Cooking second
            case 'D': return 2; // Delivered third
            default: return 3; // Unknown last
        }
    }

    // 2. Helper function to create action buttons (MODIFIED)
    function getActionButtons(order) {
        // *** KEY: Store the entire order object as a JSON string for easy retrieval in the modals ***
        const orderData = JSON.stringify(order);

        return /*html*/`
            <button class="btn btn-primary btn-sm btn-change-status" data-bs-toggle="modal" data-bs-target="#changeStatusModal" data-order='${orderData}' title="Change Status">Change</button>
            <button class="btn btn-danger btn-sm btn-remove-order" data-bs-toggle="modal" data-bs-target="#removeOrderModal" data-order='${orderData}' title="Remove">Remove</button>
        `;
    }

    // --- Modal Prefill & Submission Logic ---

    // Function to prefill the Change Status modal
    function prefillChangeModal(order) {
        // Assuming 'order_id' exists in your order object for identification
        document.getElementById('changeOrderId').value = order.order_id || '';
        document.getElementById('currentOrderItem').value = order.item_name || 'N/A';
        document.getElementById('currentStatus').value = getStatusText(order.status);
        document.getElementById('newStatus').value = ''; // Reset selection
    }

    // Function to prefill the Remove Confirmation modal
    function prefillRemoveModal(order) {
        // Assuming 'order_id' exists in your order object for identification
        document.getElementById('removeOrderId').value = order.order_id || '';
        document.getElementById('removeOrderItem').textContent = order.item_name || 'this item';
    }

    // Function to set up modal event listeners
    function setupModalListeners(datatablesElement) {
        // 3. Event Delegation Listener for Action Buttons (handles clicks on the table)
        datatablesElement.addEventListener('click', function (e) {

            // Find the closest button that has the stored data and the necessary class
            const btn = e.target.closest('.btn-change-status, .btn-remove-order');
            if (!btn) return;

            try {
                // Parse the stored JSON string back into an object
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

        // 4. Status Change Submission Handler
        document.getElementById('saveStatusChange').addEventListener('click', function () {
            const orderId = document.getElementById('changeOrderId').value;
            const newStatus = document.getElementById('newStatus').value;

            if (!newStatus) {
                alert('Please select a new status.');
                return;
            }

            // --- Placeholder: Replace with actual Fetch/AJAX call ---
            console.log(`[ACTION] Updating Order ID: ${orderId} to Status: ${newStatus}`);
            // Example: fetch('YOUR_API_ENDPOINT/orders/' + orderId, { method: 'PUT', body: JSON.stringify({ status: newStatus }) }).then(...)

            // On successful update, manually hide the modal (requires Bootstrap JS)
            const changeModalElement = document.getElementById('changeStatusModal');
            if (changeModalElement) {
                const modalInstance = bootstrap.Modal.getInstance(changeModalElement);
                if (modalInstance) modalInstance.hide();
            }

            // ** IMPORTANT: You'll need to re-initialize or reload the table data here **
        });

        // 5. Remove Confirmation Submission Handler
        document.getElementById('confirmRemoveOrder').addEventListener('click', function () {
            const orderId = document.getElementById('removeOrderId').value;

            // --- Placeholder: Replace with actual Fetch/AJAX call ---
            console.log(`[ACTION] Sending DELETE request for Order ID: ${orderId}`);
            // Example: fetch('YOUR_API_ENDPOINT/orders/' + orderId, { method: 'DELETE' }).then(...)

            // On successful deletion, manually hide the modal (requires Bootstrap JS)
            const removeModalElement = document.getElementById('removeOrderModal');
            if (removeModalElement) {
                const modalInstance = bootstrap.Modal.getInstance(removeModalElement);
                if (modalInstance) modalInstance.hide();
            }

            // ** IMPORTANT: You'll need to re-initialize or reload the table data here **
        });
    }

    // --- DataTable Initialization ---

    const datatablesOrders = document.getElementById('datatablesOrders');

    // 6. Async function to fetch, process, and initialize the table
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
                    // Primary Sort: Status 
                    const statusWeightA = getStatusWeight(a.status);
                    const statusWeightB = getStatusWeight(b.status);

                    if (statusWeightA !== statusWeightB) {
                        return statusWeightA - statusWeightB;
                    }

                    // Secondary Sort: Time (Old to New)
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
                        getActionButtons(order) // Includes buttons with data
                    ];
                });

        } catch (error) {
            console.error('Failed to fetch or process order data:', error);
        }

        // 7. Initialize the DataTable 
        if (datatablesOrders) {
            new simpleDatatables.DataTable(datatablesOrders, {
                data: {
                    headings: [
                        "Item", "Category", "Quantity", "Table Number", "Time", "Cost", "Status", "Actions"
                    ],
                    data: dataForTable
                },
                perPageSelect: [10, 25, 50, 100],
                columns: [
                    // Disable sorting on the "Actions" column (index 7)
                    { select: 7, sortable: false }
                ]
            });

            // 8. Setup the modal listeners after the table is built
            setupModalListeners(datatablesOrders);
        }
    }

    // 9. Start the process
    initializeDataTable();
});