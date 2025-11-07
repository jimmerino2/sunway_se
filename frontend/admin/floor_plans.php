<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
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
            /* Added min-height for better structure */
            min-height: 500px;
        }

        .room {
            background-color: #e9ecef;
            border: 1px solid #ccc;
            border-radius: 6px;
            text-align: center;
            padding: 15px;
            font-weight: 500;
            /* Ensure rooms fill height in flex columns */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .private-room {
            background-color: #d1e7dd;
        }

        .counter {
            background-color: #ffe5b4;
        }

        /* TABLE + CHAIR STYLES */
        .table-group {
            position: relative;
            display: inline-block;
            /* Adjusted margins for a 4-column grid */
            margin: 15px;
            width: 80px;
            height: 80px;
        }

        .table-circle,
        .table-square,
        .table-sofa {
            background-color: #dee2e6;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .table-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .table-square {
            width: 40px;
            height: 40px;
        }

        .table-sofa {
            width: 50px;
            height: 30px;
            border-radius: 5px;
        }

        .chair {
            width: 12px;
            height: 12px;
            background-color: #adb5bd;
            border-radius: 2px;
            position: absolute;
        }

        .chair.top {
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .chair.bottom {
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .chair.left {
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        .chair.right {
            right: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        /* WALKWAY SIMULATION */
        .walkway {
            background-color: #f1f3f5;
            border: 1px dashed #bbb;
            border-radius: 6px;
            text-align: center;
            color: #6c757d;
            padding: 10px;
            font-size: 14px;
        }

        .Building_frame {
            border: 1px solid black;
        }

        h5 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?= include 'layoutTopnav_nav.php'; ?>
    <div id="layoutSidenav">
        <?= include 'layoutSidenav_nav.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container my-4">
                    <h2 class="text-center mb-3">2-Story Café Floor Plan</h2>

                    <ul class="nav nav-tabs" id="floorTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="floor1-tab" data-bs-toggle="tab" data-bs-target="#floor1" type="button" role="tab">Ground Floor</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="floor2-tab" data-bs-toggle="tab" data-bs-target="#floor2" type="button" role="tab">Second Floor</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="floorTabsContent">

                        <div class="tab-pane fade show active" id="floor1" role="tabpanel">
                            <div class="floor-container">
                                <h5 class="text-center mb-3">Ground Floor Layout</h5>
                                <div class="Building_frame">
                                    <div class="row" style="min-height: 500px;">

                                        <div class="col-md-3 d-flex flex-column">

                                            <div class="room bg-white border-0" style="height: 60px;"></div>

                                            <div class="row g-1 mb-1 flex-grow-1">
                                                <div class="col-8">
                                                    <div class="room h-100">Kitchen</div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="room counter h-100">Counter</div>
                                                </div>
                                            </div>

                                            <div class="room" style="height: 50px;">Stairs</div>

                                        </div>

                                        <div class="col-md-9">

                                            <div class="d-flex flex-wrap justify-content-around">

                                                <?php
                                                // Set the total number of tables you want to generate.
                                                // I counted 32 in your original HTML, so I've set it to 32.
                                                $numberOfTables = 32;

                                                // Loop from 1 up to the total number of tables
                                                for ($i = 1; $i <= $numberOfTables; $i++) {

                                                    // Use the modulo operator (%) to check if $i is odd or even.
                                                    // If $i is odd (1, 3, 5...), $i % 2 will be 1, and we use 'table-square'.
                                                    // If $i is even (2, 4, 6...), $i % 2 will be 0, and we use 'table-circle'.
                                                    $tableClass = ($i % 2 == 1) ? 'table-square' : 'table-circle';

                                                    // Now we output the HTML for each table group.
                                                    // We use PHP's `echo $i;` and `echo $tableClass;` to insert the dynamic values.
                                                ?>

                                                    <!-- This is table group #<?php echo $i; ?> -->
                                                    <div class="table-group" id="table-group-<?php echo $i; ?>">
                                                        <div class="<?php echo $tableClass; ?>" id="table-<?php echo $i; ?>"></div>
                                                        <div class="chair top"></div>
                                                        <div class="chair bottom"></div>
                                                        <div class="chair left"></div>
                                                        <div class="chair right"></div>
                                                    </div>

                                                <?php
                                                } // This brace closes the for loop
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="floor2" role="tabpanel">
                            <div class="floor-container">
                                <h5 class="text-center mb-3">Second Floor Layout</h5>
                                <div class="row g-3">
                                    <div class="col-md-8 room">
                                        <div>Lounge Area</div>
                                        <div class="d-flex flex-wrap justify-content-center mt-3">
                                            <div class="table-group">
                                                <div class="table-sofa"></div>
                                                <div class="chair top"></div>
                                                <div class="chair bottom"></div>
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
                                    <div class="col-md-4 room private-room">Meeting Room</div>
                                    <div class="col-md-6 room">Balcony / Terrace</div>
                                    <div class="col-md-6 room">Storage / Utility</div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../js/admin_js/Monthly-income-Bar.js></script>
    <script src=" https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>