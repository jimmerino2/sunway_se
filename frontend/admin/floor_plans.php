<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cakeaway Dashboard - Floor Plan</title>
    <link rel="icon" type="image/png" href="/software_engineering/backend/public/storage/item/cakeaway.icon.png" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="../js/admin_js/admin_guard.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/admin.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        /* --- All your existing CSS (unchanged) --- */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .floor-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            min-height: 950px;
        }

        .Building_frame {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            background-color: #fdfdfd;
        }

        h5 {
            margin-bottom: 20px;
            font-weight: 600;
        }

        h6 {
            font-weight: 600;
            color: #495057;
            margin-top: 15px;
            margin-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 5px;
            display: flex;
            align-items: center;
        }

        .room {
            background-color: #e9ecef;
            border: 1px solid #ccc;
            border-radius: 6px;
            text-align: center;
            padding: 15px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 50px;
            margin-bottom: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .private-room {
            background-color: #d1e7dd;
            border-color: #a3cfbb;
        }

        .counter {
            background-color: #ffe5b4;
            border-color: #ffc107;
        }

        .kitchen {
            background-color: #f5d0d0;
            border-color: #d9a0a0;
        }

        .restroom {
            background-color: #cff4fc;
            border-color: #9eeaf9;
        }

        .table-group,
        .lounge-group,
        .Long_Table-group,
        .fire-pit-group {
            position: relative;
            display: inline-block;
            margin: 12px 18px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            vertical-align: top;
        }

        .table-group:hover,
        .lounge-group:hover,
        .Long_Table-group:hover,
        .fire-pit-group:hover,
        .bar-stool-horizontal:hover {
            transform: scale(1.25);
            cursor: pointer;
        }

        .table-circle,
        .table-square,
        .coffee-table,
        .side-table,
        .Long_Table {
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.2s ease;
        }

        .chair,
        .armchair,
        .sofa {
            background-color: #cddade;
            border-radius: 3px;
            position: absolute;
            transition: background-color 0.2s ease;
        }

        .table-group {
            width: 80px;
            height: 80px;
        }

        .table-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .table-square {
            width: 40px;
            height: 40px;
            border-radius: 4px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .chair {
            width: 12px;
            height: 12px;
        }

        .lounge-group {
            width: 120px;
            height: 90px;
        }

        .sofa {
            width: 100px;
            height: 35px;
            border-radius: 6px;
        }

        .armchair {
            width: 35px;
            height: 35px;
            border-radius: 6px;
        }

        .coffee-table {
            width: 70px;
            height: 35px;
            border-radius: 4px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .side-table {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .Long_Table-group {
            width: 200px;
            height: 80px;
        }

        .Long_Table {
            width: 180px;
            height: 45px;
            border-radius: 6px;
            position: relative;
            margin-top: 20px;
        }

        .Long_Table .chair {
            width: 12px;
            height: 12px;
        }

        .chair.top,
        .armchair.top,
        .sofa.top {
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .chair.bottom,
        .armchair.bottom,
        .sofa.bottom {
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .chair.left,
        .armchair.left {
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        .chair.right,
        .armchair.right {
            right: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        .bar-seating-horizontal {
            padding: 10px;
            text-align: center;
        }

        .bar-table-horizontal {
            width: 90%;
            height: 25px;
            background-color: #dee2e6;
            border: 1px solid #adb5bd;
            border-radius: 4px;
            margin: 0 auto;
            position: relative;
        }

        .bar-stool-horizontal {
            width: 12px;
            height: 12px;
            background-color: #adb5bd;
            border-radius: 50%;
            position: absolute;
            bottom: -20px;
        }

        .seating-zone {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #f1f3f5;
            min-height: 150px;
        }

        .clickable-seat {
            cursor: pointer;
        }

        .numbered-element {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
            font-size: 14px;
            color: #343a40;
            z-index: 2;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .bar-stool-horizontal[data-table-id]::after {
            content: attr(data-table-id);
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 10px;
            font-weight: bold;
            color: #343a40;
            width: 20px;
            text-align: center;
        }

        .status-free {
            background-color: var(--bs-success) !important;
            border-color: var(--bs-success-border-subtle) !important;
        }

        .status-pending {
            background-color: var(--bs-warning) !important;
            border-color: var(--bs-warning-border-subtle) !important;
        }

        .status-occupied {
            background-color: var(--bs-danger) !important;
            border-color: var(--bs-danger-border-subtle) !important;
        }

        .status-free .numbered-element,
        .status-pending .numbered-element,
        .status-occupied .numbered-element {
            color: #fff;
            font-weight: 600;
        }

        .bar-stool-horizontal.status-free::after,
        .bar-stool-horizontal.status-pending::after,
        .bar-stool-horizontal.status-occupied::after {
            color: #000;
            font-weight: bold;
        }

        .modal-order-price {
            display: inline-block;
            width: 90px;
            text-align: left;
            margin-right: 1rem;
        }

        /* This is the new rule */
        #editTableModal .order-status-badge {
            /* Behaves like 'inline' but keeps its 'flex' powers */
            display: inline-flex;

            /* This ensures vertical alignment with the text */
            vertical-align: middle;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?= include 'layoutTopnav_nav.php'; ?>
    <div id="layoutSidenav">
        <?= include 'layoutSidenav_nav.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid my-4">
                    <ul class="nav nav-tabs" id="floorTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="floor1-tab" data-bs-toggle="tab"
                                data-bs-target="#floor1" type="button" role="tab">Ground Floor</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="floor2-tab" data-bs-toggle="tab" data-bs-target="#floor2"
                                type="button" role="tab">Second Floor</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="floorTabsContent">
                        <div class="tab-pane fade show active" id="floor1" role="tabpanel">
                            <div class="floor-container">
                                <h5 class="text-center mb-3">Ground Floor Layout</h5>
                                <div class="Building_frame">
                                    <div class="row d-flex h-100">
                                        <div class="col-md-3 d-flex flex-column">
                                            <h6><i class="fas fa-users me-2"></i> Private Room</h6>
                                            <div class="room d-flex flex-column" id="private-room-container"></div>
                                            <div class="d-flex row flex-grow-1">
                                                <div class="d-flex flex-column col-md-6">
                                                    <h6><i class="fas fa-restroom me-2"></i> Facilities</h6>
                                                    <div class="room restroom flex-grow-1">Restrooms</div>
                                                </div>
                                                <div class="d-flex flex-column col-md-6">
                                                    <h6><i class="fas fa-cash-register me-2"></i> Service</h6>
                                                    <div class="room counter" style="height: 100px;">ORDER HERE</div>
                                                    <h6><i class="fas fa-fire-burner me-2"></i> Kitchen</h6>
                                                    <div class="room kitchen" style="height: 150px;">STAFF ONLY</div>
                                                </div>
                                            </div>
                                            <div class="room" style="height: 80px; margin-top: auto;">
                                                <i class="fas fa-stairs me-2"></i> Stairs
                                            </div>
                                        </div>
                                        <div class="col-md-9 d-flex flex-column">
                                            <h6><i class="fas fa-laptop me-2"></i> Solo Work Bar</h6>
                                            <div class="bar-seating-horizontal mb-3">
                                                <div class="bar-table-horizontal" id="solo-bar-container"></div>
                                            </div>
                                            <h6><i class="fas fa-users me-2"></i> Group Work</h6>
                                            <div class="seating-zone h-100" id="group-work-container"></div>
                                            <h6><i class="fas fa-couch me-2"></i> Lounge Seating</h6>
                                            <div class="seating-zone" id="lounge-seating-container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="floor2" role="tabpanel">
                            <div class="floor-container">
                                <h5 class="text-center mb-3">Rooftop Layout</h5>
                                <div class="Building_frame">
                                    <div class="row d-flex h-100">
                                        <div class="d-flex flex-column">
                                            <h6><i class="fas fa-glass-martini me-2"></i> Mini Bar</h6>
                                            <div class="room mini-bar">Service</div>
                                            <div class="bar-seating-horizontal mb-3">
                                                <div class="bar-table-horizontal" id="mini-bar-container"></div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6><i class="fas fa-cloud-sun me-2"></i> Open Dining</h6>
                                            <div class="seating-zone" id="open-dining-container"></div>
                                        </div>
                                        <div class="row d-flex h-100 mt-2">
                                            <div class="col-md-3 d-flex flex-column">
                                                <div class="room" style="height: 80px;">
                                                    <i class="fas fa-stairs me-2"></i> Stairs
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <?= include 'clear_table_modal.html'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            // --- 1. API URLs ---
            const API_SEATING_URL = 'http://localhost/software_engineering/backend/seating';
            const API_GET_ORDERS_URL = 'http://localhost/software_engineering/backend/orders?is_complete=N';
            const API_CLEAR_ORDERS_URL = 'http://localhost/software_engineering/backend/orders';

            let allOrdersData = [];

            // --- 2. Load Seating ---
            async function loadSeatingPlan() {
                try {
                    const response = await fetch(API_SEATING_URL);
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    const result = await response.json();
                    if (Array.isArray(result)) {
                        renderAllTables(result);
                    } else if (result.success && Array.isArray(result.data)) {
                        renderAllTables(result.data);
                    } else {
                        console.error('API (seating) data is not in the expected array format.');
                    }
                } catch (error) {
                    console.error('Error fetching seating data:', error);
                }
            }

            // --- 3. Load Orders ---
            async function loadOrders() {
                try {
                    const response = await fetch(API_GET_ORDERS_URL);
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    const result = await response.json();

                    if (Array.isArray(result)) {
                        allOrdersData = result;
                    } else if (result.success && Array.isArray(result.data)) {
                        allOrdersData = result.data;
                    } else {
                        console.error('API (orders) data is not in the expected format.');
                        allOrdersData = [];
                    }
                } catch (error) {
                    console.error('Error fetching orders data:', error);
                    allOrdersData = [];
                }
            }

            // --- 4. Render Tables ---
            function renderAllTables(tables) {
                const containers = {
                    privateRoom: $('#private-room-container'),
                    soloBar: $('#solo-bar-container'),
                    groupWork: $('#group-work-container'),
                    lounge: $('#lounge-seating-container'),
                    miniBar: $('#mini-bar-container'),
                    openDining: $('#open-dining-container')
                };
                for (const key in containers) containers[key].empty();
                tables.sort((a, b) => a.table_no - b.table_no);
                tables.forEach(table => {
                    const statusClass = getStatusClass(table.status);
                    const tableHtml = generateTableHtml(table, statusClass);
                    const container = getTargetContainer(table, containers);
                    if (container && tableHtml) container.append(tableHtml);
                });
                initializeNumbering();
            }

            // --- 5. Get Target Container ---
            function getTargetContainer(table, containers) {
                const floor = parseInt(table.floor, 10);
                const type = table.type;
                if (floor === 1) {
                    if (type === 'Private Room') return containers.privateRoom;
                    if (type === 'Solo Work Bar') return containers.soloBar;
                    if (type === 'Group Work Table') return containers.groupWork;
                    if (type === 'Lounge') return containers.lounge;
                } else if (floor === 2) {
                    if (type === 'Minibar') return containers.miniBar;
                    if (type === 'Open Dining') return containers.openDining;
                }
                return null;
            }

            // --- 6. Generate HTML ---
            function generateTableHtml(table, statusClass) {
                const tableApiId = table.id;
                const tableDisplayNumber = table.table_no;
                const status = table.status;
                const ttype = table.ttype;
                switch (ttype) {
                    case 'Long Table':
                    case 'Long':
                        return `
    <div class="Long_Table-group clickable-seat" data-api-id="${tableApiId}" data-display-number="${tableDisplayNumber}" data-status="${status}">
        <div class="Long_Table ${statusClass}">
            <div class="chair" style="top: -15px; left: 15%;"></div><div class="chair" style="top: -15px; left: 45%;"></div><div class="chair" style="top: -15px; left: 75%;"></div>
            <div class="chair" style="bottom: -15px; left: 15%;"></div><div class="chair" style="bottom: -15px; left: 45%;"></div><div class="chair" style="bottom: -15px; left: 75%;"></div>
        </div>
    </div>`;
                    case 'Round':
                        return `
    <div class="table-group clickable-seat" data-api-id="${tableApiId}" data-display-number="${tableDisplayNumber}" data-status="${status}">
        <div class="table-circle ${statusClass}"></div>
        <div class="chair top"></div><div class="chair bottom"></div><div class="chair left"></div><div class="chair right"></div>
    </div>`;
                    case 'Square':
                        return `
    <div class="table-group clickable-seat" data-api-id="${tableApiId}" data-display-number="${tableDisplayNumber}" data-status="${status}">
        <div class="table-square ${statusClass}"></div>
        <div class="chair top"></div><div class="chair bottom"></div><div class="chair left"></div><div class="chair right"></div>
    </div>`;
                    case 'Sofa':
                        return `
    <div class="lounge-group clickable-seat" data-api-id="${tableApiId}" data-display-number="${tableDisplayNumber}" data-status="${status}">
        <div class="coffee-table ${statusClass}"></div><div class="sofa bottom"></div>
    </div>`;
                    case 'Stool':
                        return `
    <div class="lounge-group clickable-seat" data-api-id="${tableApiId}" data-display-number="${tableDisplayNumber}" data-status="${status}">
        <div class="side-table ${statusClass}"></div><div class="armchair left"></div><div class="armchair right"></div>
    </div>`;
                    case 'Bar Stool':
                        const containerId = (table.type === 'Solo Work Bar') ? 'solo-bar-container' : 'mini-bar-container';
                        const stoolCount = $(`#${containerId}`).children().length;
                        const position = (stoolCount * 16) + 10;
                        return `
    <div class="bar-stool-horizontal clickable-seat ${statusClass}" 
         data-api-id="${tableApiId}" data-display-number="${tableDisplayNumber}" data-status="${status}" style="left: ${position}%;">
    </div>`;
                    default:
                        return '';
                }
            }

            // --- 7. Helper functions ---
            function getStatusClass(status) {
                switch (status) {
                    case 'F':
                        return 'status-free';
                    case 'P':
                        return 'status-pending';
                    case 'C':
                        return 'status-occupied';
                    default:
                        return 'status-free';
                }
            }

            function getStatusText(status) {
                switch (status) {
                    case 'F':
                        return 'Free (Available)';
                    case 'P':
                        return 'Pending (Reserved)';
                    case 'C':
                        return 'Occupied (Closed)';
                    default:
                        return 'Unknown';
                }
            }

            // --- 8. Initialize Numbering ---
            function initializeNumbering() {
                const tableElementSelectors = [
                    '.table-group .table-square', '.table-group .table-circle',
                    '.lounge-group .coffee-table', '.lounge-group .side-table',
                    '.Long_Table-group .Long_Table'
                ];
                tableElementSelectors.forEach(selector => {
                    $(selector).each(function() {
                        const $element = $(this);
                        // Prevent re-numbering if element already has a number
                        if ($element.find('.numbered-element').length === 0) {
                            const tableDisplayNum = $element.closest('.clickable-seat').attr('data-display-number');
                            if (tableDisplayNum) {
                                $element.prepend(`<span class="numbered-element">${tableDisplayNum}</span>`);
                            }
                        }
                    });
                });
                $('.bar-stool-horizontal.clickable-seat').each(function() {
                    const $element = $(this);
                    if (!$element.attr('data-table-id')) {
                        const tableDisplayNum = $element.attr('data-display-number');
                        if (tableDisplayNum) $element.attr('data-table-id', tableDisplayNum);
                    }
                });
            }


            // --- 9. Modal & Click Handling (NEW WORKFLOW) ---

            // Initialize All Three Modals
            var editModal = new bootstrap.Modal(document.getElementById('editTableModal'));
            var incompleteModal = new bootstrap.Modal(document.getElementById('incompleteOrdersModal'));
            var checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal')); // New modal

            // --- Helper Functions ---

            /**
             * Helper function to populate the "Incomplete Orders" modal list.
             */
            function populateIncompleteModal(orders) {
                const $list = $('#incomplete-order-list');
                $list.empty();
                orders.forEach(order => {
                    let statusBadge = '';
                    if (order.status === 'P') {
                        statusBadge = '<span class="badge bg-warning text-dark ms-2">Pending</span>';
                    } else if (order.status === 'O') {
                        statusBadge = '<span class="badge bg-info text-dark ms-2">Cooking</span>';
                    }

                    $list.append(`
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <span class="badge bg-primary rounded-pill me-2">${order.quantity}x</span>
                            ${order.item_name}
                        </span>
                        ${statusBadge}
                    </li>
                `);
                });
            }

            /**
             * NEW Helper function to populate the "Checkout" modal.
             */
            function populateCheckoutModal(orders, tableApiId, tableDisplayNum) {
                const $list = $('#checkout-order-list');
                $list.empty();
                let totalCost = 0;

                // Set modal title
                $('#checkoutModalLabel').text(`Checkout Bill for Table ${tableDisplayNum}`);

                // Pass table ID to the final clear button
                $('#final-clear-table-btn').data('api-id', tableApiId);

                // Populate items
                orders.forEach(order => {
                    const itemCost = parseFloat(order.cost);
                    totalCost += itemCost;

                    let statusBadge = '';
                    if (order.status === 'D') {
                        statusBadge = '<span class="badge bg-success ms-2">Delivered</span>';
                    }

                    $list.append(`
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <span class="badge bg-primary rounded-pill me-2">${order.quantity}x</span>
                            ${order.item_name}
                        </span>
                        <span>
                            <small class="text-muted modal-order-price">RM ${itemCost.toFixed(2)}</small>
                            ${statusBadge}
                        </span>
                    </li>
                `);
                });

                // Handle case with no orders (e.g., table was 'Pending' but no items)
                if (orders.length === 0) {
                    $list.append('<li class="list-group-item text-muted">No billed items for this table.</li>');
                }

                // Set total cost
                $('#checkout-total-cost').text(`RM ${totalCost.toFixed(2)}`);
            }

            // --- Click Handlers ---

            /**
             * Event Handler: Click on any .clickable-seat
             * (Populates the main 'Edit Table' modal)
             */
            $('#layoutSidenav_content').on('click', '.clickable-seat', function() {
                const $clickedItem = $(this);
                const tableApiId = $clickedItem.data('api-id');
                const tableDisplayNum = $clickedItem.data('display-number');
                const currentStatus = $clickedItem.data('status');

                // Get the button inside the edit modal
                const $checkoutBtn = $('#checkout-btn-from-edit');

                // 1. Set Modal Title
                $('#editTableModalLabel').text(`Table ${tableDisplayNum} Details`);

                // 2. Set Current Status Badge
                const statusText = getStatusText(currentStatus);
                const $statusBadge = $('#modal-current-status');
                $statusBadge.text(statusText).removeClass('bg-success bg-warning text-dark bg-danger');
                if (currentStatus === 'F') $statusBadge.addClass('bg-success');
                else if (currentStatus === 'P') $statusBadge.addClass('bg-warning text-dark');
                else $statusBadge.addClass('bg-danger');

                // 3. Configure "Checkout" button
                $checkoutBtn.data('api-id', tableApiId);
                $checkoutBtn.data('display-number', tableDisplayNum);

                if (currentStatus === 'F') {
                    $checkoutBtn.hide(); // Hide button if table is already 'Free'
                } else {
                    $checkoutBtn.show();
                }

                // 4. Populate Active Order List (in edit modal)
                const $orderList = $('#modal-order-list');
                const $noOrdersMsg = $('#modal-no-orders-msg');
                $orderList.empty();

                const activeOrders = allOrdersData.filter(order => order.table_id == tableApiId);

                if (activeOrders.length > 0) {
                    $noOrdersMsg.hide();
                    $orderList.show();
                    activeOrders.forEach(order => {
                        let statusBadge = '';
                        switch (order.status) {
                            case 'P':
                                statusBadge = '<span class="badge order-status-badge order-status-pending bg-warning text-dark ms-2">Pending</span>';
                                break;
                            case 'O':
                                statusBadge = '<span class="badge order-status-badge order-status-cooking bg-info text-dark ms-2">Cooking</span>';
                                break;
                            case 'D':
                                statusBadge = '<span class="badge order-status-badge order-status-delivered bg-success ms-2">Delivered</span>';
                                break;
                        }
                        const orderHtml = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <span class="badge bg-primary rounded-pill me-2">${order.quantity}x</span>
                            ${order.item_name}
                        </span>
                        <span>
                            <small class="text-muted modal-order-price">RM ${parseFloat(order.cost).toFixed(2)}</small>
                            ${statusBadge}
                        </span>
                    </li>`;
                        $orderList.append(orderHtml);
                    });
                } else {
                    $orderList.hide();
                    $noOrdersMsg.show();
                }

                // 5. Show the modal
                editModal.show();
            });

            /**
             * Event Handler: Click on "Checkout" button (#checkout-btn-from-edit)
             *
             * This handles the new logic flow.
             */
            $('#checkout-btn-from-edit').on('click', function() {
                const tableApiId = $(this).data('api-id');
                const tableDisplayNum = $(this).data('display-number');

                // 1. Find ALL orders for this table
                const allTableOrders = allOrdersData.filter(order =>
                    order.table_id == tableApiId
                );

                // 2. Find ONLY incomplete orders (Pending or Cooking)
                const incompleteOrders = allTableOrders.filter(order =>
                    order.status === 'P' || order.status === 'O'
                );

                // 3. Check workflow
                if (incompleteOrders.length > 0) {
                    // --- Case 1: Incomplete orders exist ---
                    editModal.hide(); // Hide edit modal
                    populateIncompleteModal(incompleteOrders);
                    incompleteModal.show(); // Show incomplete modal

                } else {
                    // --- Case 2: No incomplete orders ---
                    // We can proceed to checkout.
                    editModal.hide(); // Hide edit modal
                    // We pass ALL orders (which are 'Delivered' or empty) to the checkout
                    populateCheckoutModal(allTableOrders, tableApiId, tableDisplayNum);
                    checkoutModal.show(); // Show the new checkout modal
                }
            });


            // --- 10. "Confirm & Clear Table" Button Click Logic (MOVED FROM OLD BUTTON) ---
            $('#final-clear-table-btn').on('click', async function() {
                const $thisButton = $(this);
                const tableApiId = $thisButton.data('api-id');

                if (!tableApiId) {
                    alert('Error: Table ID not found.');
                    return;
                }

                // No need to check for incomplete orders here,
                // as that check was done before this modal could be shown.

                // Proceed with clearing the table
                $thisButton.html('<i class="fas fa-spinner fa-spin"></i> Clearing...').prop('disabled', true);

                try {
                    const [clearResponse, statusResponse] = await Promise.all([
                        // 1. Mark all orders for this table as complete
                        fetch(API_CLEAR_ORDERS_URL, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                table_id: tableApiId,
                                action: 'clear_table'
                            })
                        }),
                        // 2. Set the table status back to 'F' (Free)
                        fetch(API_SEATING_URL, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id: tableApiId,
                                status: 'F'
                            })
                        })
                    ]);

                    if (!clearResponse.ok) {
                        const errorResult = await clearResponse.json();
                        throw new Error(errorResult.error || 'Failed to clear orders');
                    }

                    if (!statusResponse.ok) {
                        const errorResult = await statusResponse.json();
                        throw new Error(errorResult.error || 'Failed to update table status');
                    }

                    // --- UI Update on Success ---

                    // 1. Update the visual status of the table on the floor plan
                    const newStatusClass = getStatusClass('F');
                    const $tableGroup = $(`.clickable-seat[data-api-id="${tableApiId}"]`);
                    $tableGroup.data('status', 'F'); // Update data attribute

                    let $visualElement = $tableGroup.hasClass('bar-stool-horizontal') ? $tableGroup :
                        $tableGroup.find('.table-square, .table-circle, .Long_Table, .coffee-table, .side-table');

                    $visualElement.removeClass('status-free status-pending status-occupied').addClass(newStatusClass);

                    // 2. Reload the global orders data (so it's fresh for the next modal click)
                    await loadOrders();

                    // 3. Hide the checkout modal
                    checkoutModal.hide();

                } catch (error) {
                    console.error('Error clearing table:', error);
                    alert('Error: ' + error.message);

                } finally {
                    // Reset the button
                    $thisButton.html('<i class="fas fa-check-double me-2"></i>Confirm & Clear Table').prop('disabled', false);
                }
            });

            // --- 11. Initial Load ---
            async function initializePage() {
                // Load orders first to ensure data is available for seating status
                await loadOrders();
                // Then load seating, which will render and apply status
                await loadSeatingPlan();

                console.log('Orders and seating loaded.');
            }

            initializePage();

        });
    </script>


</body>

</html>