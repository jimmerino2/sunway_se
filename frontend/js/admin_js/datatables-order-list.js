window.addEventListener('DOMContentLoaded', event => {

    // Variable to hold the Simple-DataTables instance globally
    let simpleDataTableInstance = null;
    const datatablesOrders = document.getElementById('datatablesOrders');

    // --- Core Helper Functions ---

    // 1. Helper function to get status text (MODIFIED for hidden sort key)
    function getStatusText(status) {
        let colorClass = 'bg-secondary';
        let customClass = 'order-status-unknown';
        let text = 'Unknown';
        let sortKey = '3'; // Default (Unknown)

        switch (status) {
            case 'D':
                colorClass = 'bg-success';
                customClass = 'order-status-delivered';
                text = 'Delivered';
                sortKey = '2'; // Delivered last
                break;
            case 'O':
                colorClass = 'bg-warning text-dark';
                customClass = 'order-status-cooking';
                text = 'Cooking';
                sortKey = '1'; // Cooking middle
                break;
            case 'P':
                colorClass = 'bg-danger';
                customClass = 'order-status-pending';
                text = 'Pending';
                sortKey = '0'; // Pending first
                break;
        }

        // 🛠️ FIX: Add a hidden span for sorting.
        // The library will sort based on this text: "0", "1", etc.
        // The .trim() is added to clean up whitespace from the template literal.
        return `
            <span style="display: none;">${sortKey}</span>
            <span class="badge ${colorClass} order-status-badge ${customClass}">${text}</span>
        `.trim();
    }

    // Helper function to get completion status text (MODIFIED for hidden sort key)
    function getCompletionStatusText(isComplete) {
        let colorClass, text, customClass, sortKey;

        if (isComplete === 'Y') {
            colorClass = 'bg-success';
            text = 'Yes';
            customClass = 'order-complete-y';
            sortKey = '1'; // Yes
        } else if (isComplete === 'N') {
            colorClass = 'bg-danger';
            text = 'No';
            customClass = 'order-complete-n';
            sortKey = '0'; // No (sorts before Yes)
        } else {
            colorClass = 'bg-secondary';
            text = 'N/A';
            customClass = 'order-complete-na';
            sortKey = '2'; // N/A (sorts last)
        }

        // 🛠️ FIX: Add a hidden span for sorting.
        return `
            <span style="display: none;">${sortKey}</span>
            <span class="badge ${colorClass} order-status-badge ${customClass}">${text}</span>
        `.trim();
    }

    // Helper function for status weight (USED ONLY for pre-sorting)
    function getStatusWeight(status) {
        switch (status) {
            case 'P': return 0;
            case 'O': return 1;
            case 'D': return 2;
            default: return 3;
        }
    }

    // Helper function for completion weight (USED ONLY for pre-sorting)
    function getCompletionWeight(isComplete) {
        switch (isComplete) {
            case 'N': return 0; // 'No' comes first
            case 'Y': return 1; // 'Yes' comes second
            default: return 2;  // 'N/A' or others come last
        }
    }

    // 2. Helper function to create action buttons
    function getActionButtons(order) {
        // Store the entire order object as a JSON string
        const orderData = JSON.stringify(order);

        return /*html*/`
            <button class="btn btn-success btn-sm btn-change-status" data-bs-toggle="modal" data-bs-target="#changeStatusModal" data-order='${orderData}' title="Change Status/Quantity"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger btn-sm btn-remove-order" data-bs-toggle="modal" data-bs-target="#removeOrderModal" data-order='${orderData}' title="Remove"><i class="fa-solid fa-trash"></i></button>
        `;
    }

    // --- Modal Prefill & Submission Logic (Unchanged) ---

    function prefillChangeModal(order) {
        document.getElementById('changeOrderId').value = order.id || '';
        document.getElementById('currentOrderItem').value = order.item_name || 'N/A';
        document.getElementById('newQuantity').value = order.quantity || 1;

        // Retrieve plain text for the input value
        let currentStatusText = '';
        switch (order.status) {
            case 'D': currentStatusText = 'Delivered'; break;
            case 'O': currentStatusText = 'Cooking'; break;
            case 'P': currentStatusText = 'Pending'; break;
            default: currentStatusText = 'Unknown'; break;
        }
        document.getElementById('currentStatus').value = currentStatusText;
        document.getElementById('newStatus').value = '';
    }

    function prefillRemoveModal(order) {
        document.getElementById('removeOrderId').value = order.id || '';
        document.getElementById('removeOrderItem').textContent = order.item_name || 'this item';
    }

    // Function to set up modal event listeners
    function setupModalListeners(tableElement) {

        // Event Delegation Listener for Action Buttons (prefills modals)
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

        // Status/Quantity Change Submission Handler (PATCH)
        document.getElementById('saveStatusChange').addEventListener('click', async function () {
            const orderId = document.getElementById('changeOrderId').value;
            const newStatus = document.getElementById('newStatus').value;
            const newQuantity = document.getElementById('newQuantity').value;

            if (!newQuantity || parseInt(newQuantity) < 1) {
                alert('Quantity must be 1 or more.');
                return;
            }

            const apiEndpoint = 'http://localhost/software_engineering/backend/orders';

            try {
                const response = await fetch(apiEndpoint, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: orderId,
                        status: newStatus,
                        quantity: newQuantity
                    })
                });

                if (response.ok) {
                    alert(`Order ${orderId} updated successfully (Status: ${newStatus || 'unchanged'}, Quantity: ${newQuantity})!`);

                    const changeModalElement = document.getElementById('changeStatusModal');
                    const modalInstance = bootstrap.Modal.getInstance(changeModalElement);
                    if (modalInstance) modalInstance.hide();

                    await initializeDataTable();
                } else {
                    const errorData = await response.json();
                    alert(`Failed to update order: ${errorData.error || response.statusText}`);
                }
            } catch (error) {
                console.error('Network error updating order:', error);
                alert('A network error occurred while updating the order.');
            }
        });

        // Remove Confirmation Submission Handler (DELETE)
        document.getElementById('confirmRemoveOrder').addEventListener('click', async function () {
            const orderId = document.getElementById('removeOrderId').value;
            const apiEndpoint = `http://localhost/software_engineering/backend/orders`;

            try {
                const responseRaw = await fetch(apiEndpoint, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: orderId })
                });

                const response = await responseRaw.json();

                if (response.message !== undefined) {
                    alert(response.message);
                    const removeModalElement = document.getElementById('removeOrderModal');
                    const modalInstance = bootstrap.Modal.getInstance(removeModalElement);
                    if (modalInstance) modalInstance.hide();
                    await initializeDataTable();

                } else if (response.error !== undefined) {
                    alert(`Failed to remove order: ${response.error}`);
                } else {
                    alert(`Failed to remove order. Server response status: ${responseRaw.status}`);
                }
            } catch (error) {
                console.error('Network or Parsing error removing order:', error);
                alert('A network error occurred while removing the order.');
            }
        });
    }

    // Async function to fetch, process, and initialize/refresh the table
    async function initializeDataTable() {
        let dataForTable = [];
        const headings = [
            "Item", "Category", "Quantity", "Table Number", "Time", "Cost", "Status", "Completed", "Actions"
        ];

        try {
            const responseRaw = await fetch('http://localhost/software_engineering/backend/orders');
            if (!responseRaw.ok) {
                throw new Error(`HTTP error! Status: ${responseRaw.status}`);
            }

            const responseData = await responseRaw.json();

            if (!responseData.success || !Array.isArray(responseData.data)) {
                console.error('API response format error or unsuccessful:', responseData);
                throw new Error('Invalid API response structure or failure.');
            }

            const orders = responseData.data;

            // Process and sort the data (PRE-SORTING by Completion, then Status, then Time)
            dataForTable = orders
                .filter(order => order != null)
                .sort((a, b) => {
                    // 1. Primary Sort: Completion (No -> Yes -> N/A)
                    const completionA = getCompletionWeight(a.is_complete);
                    const completionB = getCompletionWeight(b.is_complete);

                    if (completionA !== completionB) {
                        return completionA - completionB;
                    }

                    // 2. Secondary Sort: Status (Pending -> Cooking -> Delivered)
                    const statusWeightA = getStatusWeight(a.status);
                    const statusWeightB = getStatusWeight(b.status);

                    if (statusWeightA !== statusWeightB) {
                        return statusWeightA - statusWeightB;
                    }

                    // 3. Tertiary Sort: Time/Date (Newest Date, then Oldest Time)
                    const timeA = a.order_time ?? '';
                    const timeB = b.order_time ?? '';

                    // Split into date part (index 0) and time part (index 1)
                    const [dateA, actualTimeA] = timeA.split(' ');
                    const [dateB, actualTimeB] = timeB.split(' ');

                    // 3a. Sort by Date (Newest first: Z to A)
                    const dateComparison = dateB.localeCompare(dateA);

                    if (dateComparison !== 0) {
                        return dateComparison;
                    }

                    // 3b. If Dates are the same, sort by Time (Oldest first: A to Z)
                    return actualTimeA.localeCompare(actualTimeB);
                })
                .map(order => {
                    const cost = parseFloat(order.cost ?? '0.00');
                    const quantity = parseInt(order.quantity ?? 0, 10);

                    return [
                        String(order.item_name ?? 'N/A'),
                        String(order.category_name ?? 'N/A'),
                        String(quantity),
                        String('Table ' + order.table_no ?? 'error'),
                        String(order.order_time ?? 'N/A'),
                        String('RM ' + cost.toFixed(2) ?? 'error'),
                        getStatusText(order.status ?? 'error'),
                        getCompletionStatusText(order.is_complete ?? 'N/A'),
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
                simpleDataTableInstance.destroy();

                // 🛠️ FIX: REMOVED the datatablesOrders.innerHTML = ... block
                // This fixes the 'offsetWidth' error.
                // This requires your base HTML file to already have the <thead>
            }

            // SCENARIO 1 (or Re-Initialize after destroy)
            simpleDataTableInstance = new simpleDatatables.DataTable(datatablesOrders, {
                data: {
                    headings: headings,
                    data: dataForTable
                },
                perPageSelect: [10, 25, 50, 100],
                columns: [
                    // 🛠️ FIX: Removed the 'render' functions.
                    // This fixes the 'toLowerCase' error.
                    // We only need to disable sorting on the 'Actions' column (index 8).
                    {
                        select: 8, // 'Actions' column
                        sortable: false
                    }
                ],
                labels: {
                    perPage: "",
                    info: "Displaying {start} of {end} of {rows} Orders"
                },
            });

            setupModalListeners(datatablesOrders);
        }
    }

    // 9. Start the process
    initializeDataTable();
});