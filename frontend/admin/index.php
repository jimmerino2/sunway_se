<?php
// 1. Page Configuration
$pageTitle = "Dashboard | Cakeaway Admin";
$currentPage = "dashboard";
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'components/src/head.php'; ?>

<body class="sb-nav-fixed">

    <?php include 'components/src/top_nav.php'; ?>

    <div id="layoutSidenav">
        <?php include 'components/src/side_nav.php'; ?>

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
                                <div class="card-body">Total Sales Today (RM)</div>
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
                                <div class="card-body">Completed Orders</div>
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
                                            <select id="yearSelector" class="form-select form-select-sm" style="width: auto;"></select>
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
                            <i class="fas fa-table me-1"></i> Orders
                        </div>
                        <div class="card-body">
                            <table id="datatablesOrders" class="table table-striped">
                                <thead></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <?php include 'components/src/footer.php'; ?>
        </div>
    </div>

    <?= include 'components/src/change&remove_modal.html'; ?>

    <?php include 'components/src/scripts.php'; ?>

</body>

</html>