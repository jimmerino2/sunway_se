<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Cakeaway Dashboard</title>
    <link rel="icon" type="image/png" href="/software_engineering/backend/public/storage/item/cakeaway.icon.png" />
    <script src="../js/admin_js/admin_guard.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/admin.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        /* --- START OF ORIGINAL CSS --- */
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
            /* **MODIFICATION: Increased height */
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

        /* === ROOM STYLES === */
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

        .storage {
            background-color: #e9ecef;
            border-style: dashed;
            border-color: #adb5bd;
        }

        .walkway {
            background-color: #f1f3f5;
            border: 1px dashed #bbb;
            border-radius: 6px;
            text-align: center;
            color: #6c757d;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* === STANDARD TABLE + CHAIR STYLES === */
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
        }

        .pool-table-visual:hover {
            transform: scale(1.01);
        }

        .table-group:hover,
        .lounge-group:hover,
        .Long_Table-group:hover,
        .fire-pit-group:hover,
        .bar-stool-horizontal:hover,
        .pool-table-visual:hover {
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

        /* === STANDARD 4-TOP === */
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

        .table-group-2top {
            width: 40px;
            height: 80px;
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

        .fire-pit-group {
            width: 120px;
            height: 120px;
        }

        .fire-pit {
            width: 50px;
            height: 50px;
            background-color: #fff;
            border: 2px solid #ff6f00;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 15px rgba(255, 111, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fire-pit i {
            color: #ff6f00;
        }

        .fire-pit-group .armchair {
            width: 30px;
            height: 30px;
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

        /* === **NEW** CSS CLASSES === */

        /* For the new vertical bars */
        .bar-vertical {
            background-color: #6c757d;
            /* Dark grey */
            border-color: #495057;
            color: #fff;
            height: 150px;
            /* Give it a set height */
            writing-mode: vertical-rl;
            /* Flips text */
            text-orientation: mixed;
            letter-spacing: 2px;
            font-weight: 600;
        }

        /* For the new Mini Bar on rooftop */
        .mini-bar {
            background-color: #ffe5b4;
            /* Same as counter */
            border-color: #ffc107;
            height: 100px;
        }

        /* === **POOL TABLE** STYLES ADJUSTED FOR 4 TABLES === */
        .pool-table-visual {
            position: relative;
            /* Reduced size for 4 tables */
            width: 45%;
            height: 45%;
            background-color: #58331A;
            border: 8px solid #7D4C2B;
            /* Reduced border size */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            display: inline-block;
            /* Allows tables to sit next to each other */
            margin: 1%;
            /* Small margin between tables */
            overflow: hidden;
        }

        .pool-table-felt {
            position: absolute;
            /* Changed to absolute positioning */
            top: 1%;
            /* Distance from the top edge of the brown frame */
            left: 1%;
            /* Distance from the left edge of the brown frame */
            right: 1%;
            /* Distance from the right edge of the brown frame */
            bottom: 1%;
            /* Distance from the bottom edge of the brown frame */

            background-color: #1a7a40;
            /* Green Felt */
            border: 2px solid #0f5228;
            border-radius: 6px;
            /* Removed width/height as top/left/right/bottom will control this */
        }

        .pool-pocket {
            position: absolute;
            width: 12px;
            /* Reduced pocket size */
            height: 12px;
            background-color: #333;
            border-radius: 50%;
            z-index: 10;
        }

        /* Corner Pockets - adjusted positions for smaller size */
        .pocket-tl {
            top: -6px;
            left: -6px;
        }

        .pocket-tr {
            top: -6px;
            right: -6px;
        }

        .pocket-bl {
            bottom: -6px;
            left: -6px;
        }

        .pocket-br {
            bottom: -6px;
            right: -6px;
        }

        /* Side Pockets - adjusted positions for smaller size */
        .pocket-tm {
            left: 50%;
            transform: translateX(-50%);
            top: -6px;
        }

        .pocket-bm {
            left: 50%;
            transform: translateX(-50%);
            bottom: -6px;
        }

        /* Ensure the room container allows tables to wrap/center */
        .room.h-100 {
            /* Keep these to center the group of tables */
            display: flex;
            flex-wrap: wrap;
            /* Allows 4 tables to wrap into 2 rows */
            justify-content: center;
            align-content: center;
            /* Centers the whole block vertically */
        }

        /* --- END OF ORIGINAL CSS --- */

        /* === ADDED CSS FOR NUMBERING AND CENTERING === */
        .clickable-seat {
            cursor: pointer;
        }

        /* Style and center the injected number element within tables */
        .numbered-element {
            /* The parent table element dictates size/position. This centers the number inside it. */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
            font-size: 14px;
            color: #343a40;
            z-index: 2;
            /* Set to same size as table so numbers appear centered */
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            /* Allows click to pass through to the parent */
        }

        /* Special handling for Bar Stools (using ::after) */
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

        /* Special handling for Fire Pit (using ::before) */
        .fire-pit[data-table-id] {
            position: relative;
            /* Ensure positioning context */
        }

        .fire-pit[data-table-id]::before {
            content: attr(data-table-id);
            font-size: 14px;
            font-weight: bold;
            color: #343a40;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 15;
        }

        /* Hide the default icon in the fire pit to show the number */
        .fire-pit[data-table-id] i {
            display: none;
        }

        /* Pool Table Numbering (Needs a dedicated space at the top) */
        .pool-table-visual .table-number {
            position: absolute;
            top: 5px;
            left: 50%;
            transform: translateX(-50%);
            font-weight: bold;
            color: #fff;
            font-size: 14px;
            z-index: 1;
            pointer-events: none;
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
                                <h5 class="text-center mb-3">Second Floor Layout</h5>
                                <div class="Building_frame">
                                    <div class="row d-flex h-100">
                                        <div class="col-md-3 d-flex flex-column">
                                            <h6><i class="fas fa-users me-2"></i> Private Room</h6>
                                            <div class="room d-flex flex-column">
                                                <div class="Long_Table-group clickable-seat" data-table-id="T33">
                                                    <div class="Long_Table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="Long_Table-group clickable-seat" data-table-id="T34">
                                                    <div class="Long_Table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                            </div>

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
                                                <div class="bar-table-horizontal">
                                                    <div class="bar-stool-horizontal clickable-seat" data-table-id="S1" style="left: 10%;"></div>
                                                    <div class="bar-stool-horizontal clickable-seat" data-table-id="S2" style="left: 25%;"></div>
                                                    <div class="bar-stool-horizontal clickable-seat" data-table-id="S3" style="left: 40%;"></div>
                                                    <div class="bar-stool-horizontal clickable-seat" data-table-id="S4" style="left: 55%;"></div>
                                                    <div class="bar-stool-horizontal clickable-seat" data-table-id="S5" style="left: 70%;"></div>
                                                    <div class="bar-stool-horizontal clickable-seat" data-table-id="S6" style="left: 85%;"></div>
                                                </div>
                                            </div>

                                            <h6><i class="fas fa-users me-2"></i> Group Work (4 Community, 5 4-Tops)</h6>
                                            <div class="seating-zone h-100">
                                                <div class="Long_Table-group clickable-seat" data-table-id="T35">
                                                    <div class="Long_Table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="Long_Table-group clickable-seat" data-table-id="T36">
                                                    <div class="Long_Table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="Long_Table-group clickable-seat" data-table-id="T37">
                                                    <div class="Long_Table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="Long_Table-group clickable-seat" data-table-id="T38">
                                                    <div class="Long_Table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T39">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T40">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T41">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T42">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T43">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T44">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T44">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T45">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                            </div>

                                            <h6><i class="fas fa-couch me-2"></i> Lounge Seating (5 Groups)</h6>
                                            <div class="seating-zone">
                                                <div class="d-flex flex-column">
                                                    <div>
                                                        <div class="lounge-group clickable-seat" data-table-id="T1">
                                                            <div class="coffee-table"></div>
                                                            <div class="sofa bottom"></div>
                                                        </div>
                                                        <div class="lounge-group clickable-seat" data-table-id="T2">
                                                            <div class="side-table"></div>
                                                            <div class="armchair left"></div>
                                                            <div class="armchair right"></div>
                                                        </div>
                                                        <div class="lounge-group clickable-seat" data-table-id="T3">
                                                            <div class="coffee-table"></div>
                                                            <div class="sofa bottom"></div>
                                                        </div>
                                                        <div class="lounge-group clickable-seat" data-table-id="T4">
                                                            <div class="side-table"></div>
                                                            <div class="armchair left"></div>
                                                            <div class="armchair right"></div>
                                                        </div>
                                                        <div class="lounge-group clickable-seat" data-table-id="T5">
                                                            <div class="coffee-table"></div>
                                                            <div class="sofa bottom"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                                <div class="bar-table-horizontal">
                                                    <div class="bar-stool-horizontal clickable-seat" data-table-id="S7" style="left: 10%;"></div>
                                                    <div class="bar-stool-horizontal clickable-seat" data-table-id="S8" style="left: 25%;"></div>
                                                    <div class="bar-stool-horizontal clickable-seat" data-table-id="S9" style="left: 40%;"></div>
                                                    <div class="bar-stool-horizontal clickable-seat" data-table-id="S10" style="left: 55%;"></div>
                                                    <div class="bar-stool-horizontal clickable-seat" data-table-id="S11" style="left: 70%;"></div>
                                                    <div class="bar-stool-horizontal clickable-seat" data-table-id="S12" style="left: 85%;"></div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="d-flex flex-column">
                                            <h6><i class="fas fa-cloud-sun me-2"></i> Open Dining</h6>
                                            <div class="seating-zone">
                                                <div class="table-group clickable-seat" data-table-id="T44">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T45">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T46">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T47">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T48">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T49">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T50">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T51">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="Long_Table-group clickable-seat" data-table-id="T52">
                                                    <div class="Long_Table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="Long_Table-group clickable-seat" data-table-id="T53">
                                                    <div class="Long_Table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="Long_Table-group clickable-seat" data-table-id="T54">
                                                    <div class="Long_Table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T55">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T56">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group clickable-seat" data-table-id="T57">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                            </div>
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
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <div class="modal fade" id="editTableModal" tabindex="-1" aria-labelledby="editTableModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTableModalLabel">Edit Table/Stool</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Click "Save changes" to confirm the action.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../js/admin_js/Monthly-income-Bar.js></script>
    <script src=" https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>

    <script>
        $(document).ready(function() {
            // Define selectors for tables/stools that need visual numbering.
            const tableElementSelectors = [
                '.table-group .table-square',
                '.table-group .table-circle',
                '.lounge-group .coffee-table',
                '.lounge-group .side-table',
                '.Long_Table-group .Long_Table',
                '.fire-pit-group .fire-pit'
            ];

            // Insert the number into the visual element using the hardcoded ID from the parent.
            tableElementSelectors.forEach(selector => {
                $(selector).each(function() {
                    const $element = $(this);
                    // The table ID is stored on the parent (e.g., .table-group)
                    const tableId = $element.closest('.clickable-seat').attr('data-table-id');

                    if (tableId) {
                        // Insert the visual number span
                        $element.prepend(`<span class="numbered-element">${tableId.replace(/[A-Za-z]/g, '')}</span>`);
                        // For Fire Pits, we need the ID on the element itself for the ::before CSS selector to work
                        if ($element.hasClass('fire-pit')) {
                            $element.attr('data-table-id', tableId);
                        }
                    }
                });
            });

            // Handle Pool Tables separately as they don't use the standard table style structure.
            $('.pool-table-visual').each(function() {
                const $element = $(this);
                const tableId = $element.attr('data-table-id');
                if (tableId) {
                    $element.prepend(`<span class="table-number">${tableId.replace(/[A-Za-z]/g, '')}</span>`);
                }
            });

            // Set up the click handler for all clickable seating elements
            $('.clickable-seat').on('click', function() {
                const tableId = $(this).attr('data-table-id');

                // Update the modal title as requested: "Edit Table 1, 2, 3"
                // Using regex to strip the prefix (T, S, P, F) for a simpler look,
                // matching the original request, e.g., 'Edit Table 1'
                const displayId = tableId.replace(/[A-Za-z]/g, '');
                $('#editTableModalLabel').text(`Edit Table ${displayId}`);

                // Show the modal
                const editModal = new bootstrap.Modal(document.getElementById('editTableModal'));
                editModal.show();
            });
        });
    </script>
</body>

</html>