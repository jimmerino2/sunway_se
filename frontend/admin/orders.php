<?php
$pageTitle = "Orders Management | Cakeaway Admin";
$currentPage = "orders";
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
                    <h1 class="mt-4">All Orders</h1>
                    <div class="card mb-4 mt-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i> Order List
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

    <?php include 'components/src/change&remove_modal.html'; ?>

    <?php include 'components/src/scripts.php'; ?>

</body>

</html>