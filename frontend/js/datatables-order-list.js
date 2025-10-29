window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesOrders = document.getElementById('datatablesOrders');

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

    // 2. Helper function to create action buttons
    function getActionButtons(order) {
        // We return the raw HTML string here
        return `
            <button class="btn btn-primary btn-sm" title="Change Status">Change</button>
            <button class="btn btn-warning btn-sm" title="Edit">Edit</button>
            <button class="btn btn-danger btn-sm" title="Delete">Delete</button>
        `;
    }

    // 3. Async function to fetch, process, and initialize the table
    async function initializeDataTable() {
        let dataForTable = []; // We'll store our processed data here

        //
        // *** KEY PART 1: Define your custom sort order ***
        //
        function getStatusWeight(status) {
            switch (status) {
                case 'P': return 0; // Pending first
                case 'O': return 1; // Cooking second
                case 'D': return 2; // Delivered third
                default: return 3; // Unknown last
            }
        }

        try {
            const response = await fetch('http://localhost/software_engineering/backend/order_details');
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const orders = await response.json();

            //
            // *** KEY PART 2: Pre-sort the data before mapping ***
            //
            dataForTable = orders
                .filter(order => order != null) // 1. Filter out any null rows
                .sort((a, b) => {               // 2. Sort the data

                    // Primary Sort: Status (using our 0, 1, 2 weights)
                    const statusWeightA = getStatusWeight(a.status);
                    const statusWeightB = getStatusWeight(b.status);

                    if (statusWeightA !== statusWeightB) {
                        return statusWeightA - statusWeightB; // Sorts 0, 1, 2
                    }

                    // Secondary Sort: Time (Old to New)
                    return (a.order_time ?? '').localeCompare(b.order_time ?? '');

                })
                .map(order => {                 // 3. Map the sorted data to table rows
                    // Get values and convert to numbers, with fallbacks
                    const cost = parseFloat(order.cost ?? '0.00');
                    const quantity = parseInt(order.quantity ?? 0, 10);

                    // Perform the calculation
                    const totalCost = cost * quantity;

                    // Return the array for the row
                    return [
                        String(order.item_name ?? 'N/A'),
                        String(order.category_name ?? 'N/A'),
                        String(quantity),
                        String(order.table_no ?? 0),
                        String(order.order_time ?? 'N/A'),
                        String(totalCost.toFixed(2)), // Use the calculated total
                        getStatusText(order.status),
                        getActionButtons(order)
                    ];
                });

        } catch (error) {
            console.error('Failed to fetch or process order data:', error);
        }

        // 5. Initialize the DataTable *WITH* the pre-sorted data
        if (datatablesOrders) {
            new simpleDatatables.DataTable(datatablesOrders, {
                data: {
                    headings: [
                        "Item",
                        "Category",
                        "Quantity",
                        "Table Number",
                        "Time",
                        "Cost",
                        "Status",
                        "Actions"
                    ],
                    data: dataForTable // This data is now pre-sorted
                },

                // We remove sortBy and sortDir because the data is
                // already sorted in the exact order we want.
                perPageSelect: [10, 25, 50, 100],
                columns: [
                    // Disable sorting on the "Actions" column (index 7)
                    {
                        select: 7,        // Target the 8th column (index 7)
                        sortable: false   // Disable sorting for this column
                    }
                ]
            });
        }
    }

    // 6. Call the function
    initializeDataTable();
});