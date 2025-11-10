<?php

?>


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
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="../css/admin.css" rel="stylesheet" />
</head>

<body class="sb-nav-fixed">
    <?= include 'layoutTopnav_nav.php'; ?>
    <div id="layoutSidenav">
        <?= include 'layoutSidenav_nav.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Total Sales Today errorfix(RM)</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div id="Total_sales_today" class="small text-white">N/A</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Available Tables</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div id="Available_Tables" class="small text-white">N/A</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Completed Orders Today</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div id="Completed_Orders_Today" class="small text-white">N/A</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Pending Orders</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div id="Pending_Orders" class="small text-white">N/A</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center" style="min-height: 38.25px;">
                                        <div><i class="fas fa-chart-area me-1"></i>Order rate</div>

                                        <div id="order_rate_bar" style="width: auto;">
                                            <input type="text" id="myDateRange" class="form-control form-control-sm" style="width: 250px;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <canvas id="myAreaChart" width="100%" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center" style="min-height: 38.25px;">
                                        <div><i class="fas fa-chart-bar me-1"></i>Monthly income Bar chart</div>

                                        <div id="monthly_income_bar">
                                            <select id="yearSelector" class="form-select form-select-sm" style="width: auto;">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <canvas id="myBarChart" width="100%" height="40"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Orders
                        </div>
                        <div class="card-body">
                            <table id="datatablesOrders" class="table table-striped">
                                <thead>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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
    <?= include 'change&remove_modal.html'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="../js/admin_js/Order-rates-per-day.js"></script>
    <script src="../js/admin_js/Monthly-income-Bar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../js/admin_js/datatables-order-list.js"></script>
    <script src="../js/admin_js/today_income.js"></script>
    <script src="../js/admin_js/available_table.js"></script>
    <script src="../js/admin_js/completed_orders_today.js"></script>
    <script src="../js/admin_js/pending_orders_today.js"></script>
</body>

</html>