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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../js/admin_js/floor_plan.js"></script>
</body>

</html>