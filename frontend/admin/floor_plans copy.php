<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>3-Story Café Floor Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/admin.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
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
            /* **MODIFICATION: Increased height */
            min-height: 900px;
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
        .community-table-group,
        .fire-pit-group {
            position: relative;
            display: inline-block;
            margin: 12px 18px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            vertical-align: top;
        }

        .table-group:hover,
        .lounge-group:hover,
        .community-table-group:hover,
        .fire-pit-group:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            cursor: pointer;
        }

        .table-circle,
        .table-square,
        .coffee-table,
        .side-table,
        .community-table {
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

        .table-group:hover .table-circle,
        .table-group:hover .table-square,
        .lounge-group:hover .coffee-table,
        .community-table-group:hover .community-table {
            background-color: #d1e7dd;
            border-color: #a3cfbb;
        }

        .table-group:hover .chair,
        .lounge-group:hover .armchair,
        .lounge-group:hover .sofa,
        .community-table-group:hover .chair,
        .fire-pit-group:hover .armchair {
            background-color: #5a8a71;
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

        .community-table-group {
            width: 200px;
            height: 80px;
        }

        .community-table {
            width: 180px;
            height: 45px;
            border-radius: 6px;
            position: relative;
            margin-top: 20px;
        }

        .community-table .chair {
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

        /* For the private room visualization */
        .private-room-visual {
            background-color: #d1e7dd;
            /* Using the old private-room green */
            border: 1px solid #a3cfbb;
            border-radius: 6px;
            padding: 10px;
            height: 200px;
            /* Set height */
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .large-meeting-table-group .chair {
            width: 12px;
            height: 12px;
            position: absolute;
            background-color: #888;
            border-radius: 4px;
        }

        /* --- CHANGED THIS --- */
        .large-meeting-table-group {
            position: relative;
            width: 300px;
            /* Increased from 200px */
            height: 100px;
        }

        /* --- CHANGED THIS --- */
        .table-rectangle-large {
            width: 260px;
            /* Increased from 160px */
            height: 60px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* For the new Mini Bar on rooftop */
        .mini-bar {
            background-color: #ffe5b4;
            /* Same as counter */
            border-color: #ffc107;
            height: 100px;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php /* include 'layoutTopnav_nav.php'; */ ?>
    <div id="layoutSidenav">
        <?php /* include 'layoutSidenav_nav.php'; */ ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid my-4">
                    <h2 class="text-center mb-3">3-Story Café Floor Plan</h2>

                    <ul class="nav nav-tabs" id="floorTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="floor1-tab" data-bs-toggle="tab" data-bs-target="#floor1" type="button" role="tab">Ground Floor</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="floor2-tab" data-bs-toggle="tab" data-bs-target="#floor2" type="button" role="tab">Second Floor</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="floor3-tab" data-bs-toggle="tab" data-bs-target="#floor3" type="button" role="tab">Rooftop (3rd Floor)</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="floorTabsContent">

                        <!-- floor 1 -->
                        <div class="tab-pane fade show active" id="floor1" role="tabpanel">
                            <div class="floor-container">
                                <h5 class="text-center mb-3">Ground Floor Layout</h5>
                                <div class="Building_frame">
                                    <!-- The h-100 class was added here -->
                                    <div class="row d-flex h-100">

                                        <div class="col-md-3 d-flex flex-column">

                                            <div class="d-flex row flex-grow-1">
                                                <div class="d-flex flex-column col-md-6">
                                                    <h6><i class="fas fa-restroom me-2"></i> Facilities</h6>

                                                    <div class="room restroom flex-grow-1">Restrooms</div>
                                                </div>

                                                <div class="d-flex flex-column col-md-6">
                                                    <h6><i class="fas fa-cash-register me-2"></i> Service</h6>
                                                    <div class="room counter" style="height: 100px;">ORDER HERE</div>

                                                    <h6><i class="fas fa-wine-glass me-2"></i> Bar</h6>
                                                    <div class="room bar-vertical flex-grow-1">B A R</div>
                                                </div>
                                            </div>

                                            <div style="margin-top: auto;">
                                                <h6><i class="fas fa-fire-burner me-2"></i> Kitchen / Prep</h6>
                                                <div class="room kitchen" style="height: 150px;">STAFF ONLY</div>

                                                <div class="room">
                                                    <i class="fas fa-stairs me-2"></i> Stairs
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-9 d-flex flex-column">
                                            <div class="walkway">
                                                <i class="fas fa-door-open me-2"></i> ENTRANCE / WALKWAY
                                            </div>

                                            <h6><i class="fas fa-couch me-2"></i> Lounge Seating (5 Groups)</h6>
                                            <div class="seating-zone">
                                                <div class="d-flex flex-column">
                                                    <div>
                                                        <div class="lounge-group">
                                                            <div class="coffee-table"></div>
                                                            <div class="sofa bottom"></div>
                                                        </div>
                                                        <div class="lounge-group">
                                                            <div class="side-table"></div>
                                                            <div class="armchair left"></div>
                                                            <div class="armchair right"></div>
                                                        </div>
                                                        <div class="lounge-group">
                                                            <div class="coffee-table"></div>
                                                            <div class="sofa bottom"></div>
                                                        </div>
                                                        <div class="lounge-group">
                                                            <div class="side-table"></div>
                                                            <div class="armchair left"></div>
                                                            <div class="armchair right"></div>
                                                        </div>
                                                        <div class="lounge-group">
                                                            <div class="coffee-table"></div>
                                                            <div class="sofa bottom"></div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="lounge-group">
                                                            <div class="coffee-table"></div>
                                                            <div class="sofa bottom"></div>
                                                        </div>
                                                        <div class="lounge-group">
                                                            <div class="side-table"></div>
                                                            <div class="armchair left"></div>
                                                            <div class="armchair right"></div>
                                                        </div>
                                                        <div class="lounge-group">
                                                            <div class="coffee-table"></div>
                                                            <div class="sofa bottom"></div>
                                                        </div>
                                                        <div class="lounge-group">
                                                            <div class="side-table"></div>
                                                            <div class="armchair left"></div>
                                                            <div class="armchair right"></div>
                                                        </div>
                                                        <div class="lounge-group">
                                                            <div class="coffee-table"></div>
                                                            <div class="sofa bottom"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <h6><i class="fas fa-utensils me-2"></i> Main Dining</h6>
                                            <div class="seating-zone">
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-square"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>
                                                <div class="table-group">
                                                    <div class="table-circle"></div>
                                                    <div class="chair top"></div>
                                                    <div class="chair bottom"></div>
                                                    <div class="chair left"></div>
                                                    <div class="chair right"></div>
                                                </div>


                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- floor 2 -->
                        <div class="tab-pane fade" id="floor2" role="tabpanel">
                            <div class="floor-container">
                                <h5 class="text-center mb-3">Second Floor Layout</h5>
                                <div class="Building_frame">
                                    <div class="row d-flex h-100">
                                        <div class="col-md-3 d-flex flex-column">
                                            <h6><i class="fas fa-users me-2"></i> Private Room</h6>

                                            <div class="private-room-visual">
                                                <div class="large-meeting-table-group">
                                                    <div class="table-rectangle-large"></div>
                                                    <div class="chair" style="top: 4px; left: 10%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="top: 4px; left: 30%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="top: 4px; left: 50%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="top: 4px; left: 70%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="top: 4px; left: 90%; transform: translateX(-50%);"></div>

                                                    <div class="chair" style="bottom: 4px; left: 10%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="bottom: 4px; left: 30%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="bottom: 4px; left: 50%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="bottom: 4px; left: 70%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="bottom: 4px; left: 90%; transform: translateX(-50%);"></div>
                                                </div>
                                            </div>

                                            <div class="private-room-visual">
                                                <div class="large-meeting-table-group">
                                                    <div class="table-rectangle-large"></div>
                                                    <div class="chair" style="top: 4px; left: 10%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="top: 4px; left: 30%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="top: 4px; left: 50%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="top: 4px; left: 70%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="top: 4px; left: 90%; transform: translateX(-50%);"></div>

                                                    <div class="chair" style="bottom: 4px; left: 10%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="bottom: 4px; left: 30%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="bottom: 4px; left: 50%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="bottom: 4px; left: 70%; transform: translateX(-50%);"></div>
                                                    <div class="chair" style="bottom: 4px; left: 90%; transform: translateX(-50%);"></div>
                                                </div>
                                            </div>

                                            <div class="d-flex row flex-grow-1">
                                                <div class="d-flex flex-column col-md-6">
                                                    <h6><i class="fas fa-restroom me-2"></i> Facilities</h6>

                                                    <div class="room restroom flex-grow-1">Restrooms</div>
                                                </div>

                                                <div class="d-flex flex-column col-md-6">
                                                    <h6><i class="fa-solid fa-trophy me-2"></i>Game</h6>
                                                    <div class="room counter" style="height: 100px;">Darts</div>

                                                    <h6><i class="fas fa-wine-glass me-2"></i> Bar</h6>
                                                    <div class="room bar-vertical flex-grow-1">B A R</div>
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
                                                    <div class="bar-stool-horizontal" style="left: 10%;"></div>
                                                    <div class="bar-stool-horizontal" style="left: 25%;"></div>
                                                    <div class="bar-stool-horizontal" style="left: 40%;"></div>
                                                    <div class="bar-stool-horizontal" style="left: 55%;"></div>
                                                    <div class="bar-stool-horizontal" style="left: 70%;"></div>
                                                    <div class="bar-stool-horizontal" style="left: 85%;"></div>
                                                </div>
                                            </div>

                                            <h6><i class="fas fa-users me-2"></i> Group Work (4 Community, 5 4-Tops)</h6>
                                            <div class="seating-zone">
                                                <div class="community-table-group">
                                                    <div class="community-table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="community-table-group">
                                                    <div class="community-table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="community-table-group">
                                                    <div class="community-table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="community-table-group">
                                                    <div class="community-table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="community-table-group">
                                                    <div class="community-table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="community-table-group">
                                                    <div class="community-table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="community-table-group">
                                                    <div class="community-table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="community-table-group">
                                                    <div class="community-table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>
                                                <div class="community-table-group">
                                                    <div class="community-table">
                                                        <div class="chair" style="top: -15px; left: 15%;"></div>
                                                        <div class="chair" style="top: -15px; left: 45%;"></div>
                                                        <div class="chair" style="top: -15px; left: 75%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                        <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                    </div>
                                                </div>


                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="floor3" role="tabpanel">
                        <div class="floor-container">
                            <h5 class="text-center mb-3">Rooftop (3rd Floor) Layout</h5>
                            <div class="Building_frame">
                                <div class="row d-flex h-100">
                                    <div class="col-md-3 d-flex flex-column">
                                        <h6><i class="fas fa-cocktail me-2"></i> Rooftop Service Bar</h6>
                                        <div class="room counter" style="height: 150px;">Service</div>
                                        <h6><i class="fas fa-box-archive me-2"></i> Storage</h6>
                                        <div class="room storage" style="height: 100px;">Staff Only</div>
                                        <div class="room" style="height: 80px; margin-top: auto;">
                                            <i class="fas fa-stairs me-2"></i> Stairs
                                        </div>
                                    </div>
                                    <div class="col-md-9 d-flex flex-column">

                                        <h6><i class="fas fa-fire me-2"></i> Fire Pit Lounge (5 Pits)</h6>
                                        <div class="seating-zone">
                                            <div class="fire-pit-group">
                                                <div class="fire-pit"><i class="fas fa-fire"></i></div>
                                                <div class="armchair top"></div>
                                                <div class="armchair bottom"></div>
                                                <div class="armchair left"></div>
                                                <div class="armchair right"></div>
                                            </div>
                                            <div class="fire-pit-group">
                                                <div class="fire-pit"><i class="fas fa-fire"></i></div>
                                                <div class="armchair top"></div>
                                                <div class="armchair bottom"></div>
                                                <div class="armchair left"></div>
                                                <div class="armchair right"></div>
                                            </div>
                                            <div class="fire-pit-group">
                                                <div class="fire-pit"><i class="fas fa-fire"></i></div>
                                                <div class="armchair top"></div>
                                                <div class="armchair bottom"></div>
                                                <div class="armchair left"></div>
                                                <div class="armchair right"></div>
                                            </div>
                                            <div class="fire-pit-group">
                                                <div class="fire-pit"><i class="fas fa-fire"></i></div>
                                                <div class="armchair top"></div>
                                                <div class="armchair bottom"></div>
                                                <div class="armchair left"></div>
                                                <div class="armchair right"></div>
                                            </div>
                                            <div class="fire-pit-group">
                                                <div class="fire-pit"><i class="fas fa-fire"></i></div>
                                                <div class="armchair top"></div>
                                                <div class="armchair bottom"></div>
                                                <div class="armchair left"></div>
                                                <div class="armchair right"></div>
                                            </div>
                                        </div>

                                        <h6><i class="fas fa-glass-martini me-2"></i> Mini Bar</h6>
                                        <div class="room mini-bar">Service</div>
                                        <div class="bar-seating-horizontal mb-3">
                                            <div class="bar-table-horizontal">
                                                <div class="bar-stool-horizontal" style="left: 10%;"></div>
                                                <div class="bar-stool-horizontal" style="left: 25%;"></div>
                                                <div class="bar-stool-horizontal" style="left: 40%;"></div>
                                                <div class="bar-stool-horizontal" style="left: 55%;"></div>
                                                <div class="bar-stool-horizontal" style="left: 70%;"></div>
                                                <div class="bar-stool-horizontal" style="left: 85%;"></div>
                                            </div>
                                        </div>

                                        <h6><i class="fas fa-cloud-sun me-2"></i> Al Fresco Dining (10 Tables)</h6>
                                        <div class="seating-zone">
                                            <div class="table-group">
                                                <div class="table-square"></div>
                                                <div class="chair top"></div>
                                                <div class="chair bottom"></div>
                                                <div class="chair left"></div>
                                                <div class="chair right"></div>
                                            </div>
                                            <div class="table-group">
                                                <div class="table-circle"></div>
                                                <div class="chair top"></div>
                                                <div class="chair bottom"></div>
                                                <div class="chair left"></div>
                                                <div class="chair right"></div>
                                            </div>
                                            <div class="table-group">
                                                <div class="table-square"></div>
                                                <div class="chair top"></div>
                                                <div class="chair bottom"></div>
                                                <div class="chair left"></div>
                                                <div class="chair right"></div>
                                            </div>
                                            <div class="table-group">
                                                <div class="table-circle"></div>
                                                <div class="chair top"></div>
                                                <div class="chair bottom"></div>
                                                <div class="chair left"></div>
                                                <div class="chair right"></div>
                                            </div>
                                            <div class="table-group">
                                                <div class="table-square"></div>
                                                <div class="chair top"></div>
                                                <div class="chair bottom"></div>
                                                <div class="chair left"></div>
                                                <div class="chair right"></div>
                                            </div>
                                            <div class="table-group">
                                                <div class="table-circle"></div>
                                                <div class="chair top"></div>
                                                <div class="chair bottom"></div>
                                                <div class="chair left"></div>
                                                <div class="chair right"></div>
                                            </div>
                                            <div class="table-group">
                                                <div class="table-square"></div>
                                                <div class="chair top"></div>
                                                <div class="chair bottom"></div>
                                                <div class="chair left"></div>
                                                <div class="chair right"></div>
                                            </div>
                                            <div class="table-group">
                                                <div class="table-circle"></div>
                                                <div class="chair top"></div>
                                                <div class="chair bottom"></div>
                                                <div class="chair left"></div>
                                                <div class="chair right"></div>
                                            </div>
                                            <div class="table-group">
                                                <div class="table-square"></div>
                                                <div class="chair top"></div>
                                                <div class="chair bottom"></div>
                                                <div class="chair left"></div>
                                                <div class="chair right"></div>
                                            </div>
                                            <div class="table-group">
                                                <div class="table-circle"></div>
                                                <div class="chair top"></div>
                                                <div class="chair bottom"></div>
                                                <div class="chair left"></div>
                                                <div class="chair right"></div>
                                            </div>
                                            <div class="community-table-group">
                                                <div class="community-table">
                                                    <div class="chair" style="top: -15px; left: 15%;"></div>
                                                    <div class="chair" style="top: -15px; left: 45%;"></div>
                                                    <div class="chair" style="top: -15px; left: 75%;"></div>
                                                    <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                    <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                    <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                </div>
                                            </div>
                                            <div class="community-table-group">
                                                <div class="community-table">
                                                    <div class="chair" style="top: -15px; left: 15%;"></div>
                                                    <div class="chair" style="top: -15px; left: 45%;"></div>
                                                    <div class="chair" style="top: -15px; left: 75%;"></div>
                                                    <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                    <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                    <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                </div>
                                            </div>
                                            <div class="community-table-group">
                                                <div class="community-table">
                                                    <div class="chair" style="top: -15px; left: 15%;"></div>
                                                    <div class="chair" style="top: -15px; left: 45%;"></div>
                                                    <div class="chair" style="top: -15px; left: 75%;"></div>
                                                    <div class="chair" style="bottom: -15px; left: 15%;"></div>
                                                    <div class="chair" style="bottom: -15px; left: 45%;"></div>
                                                    <div class="chair" style="bottom: -15px; left: 75%;"></div>
                                                </div>
                                            </div>
                                            <div class="table-group">
                                                <div class="table-square"></div>
                                                <div class="chair top"></div>
                                                <div class="chair bottom"></div>
                                                <div class="chair left"></div>
                                                <div class="chair right"></div>
                                            </div>
                                            <div class="table-group">
                                                <div class="table-circle"></div>
                                                <div class="chair top"></div>
                                                <div class="chair bottom"></div>
                                                <div class="chair left"></div>
                                                <div class="chair right"></div>
                                            </div>
                                            <div class="table-group">
                                                <div class="table-square"></div>
                                                <div class="chair top"></div>
                                                <div class="chair bottom"></div>
                                                <div class="chair left"></div>
                                                <div class="chair right"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../js/admin_js/Monthly-income-Bar.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>