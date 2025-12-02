<?php
$pageTitle = "My Orders | Cakeaway";
$pageHeader = "My Orders";
$currentPage = "orders";
$paddingTop = "70px";

$emptyIcon = "bi-receipt";
$emptyTitle = "No orders yet";
$emptyMessage = "You haven't placed any orders for this table yet.";

?>

<!DOCTYPE html>
<html lang="en">
<?php include 'components/src/head.php'; ?>

<body>
    <?php include 'components/src/top_nav.php'; ?>

    <div class="container px-3">
        <div class="summary-card d-flex justify-content-between align-items-center">
            <div>
                <small class="text-white-50 text-uppercase fw-bold" style="font-size: 0.7rem;">Total Bill</small>
                <h2 class="mb-0 fw-bold">RM <span id="total-bill">0.00</span></h2>
            </div>
            <div class="text-end">
                <small class="text-white-50 d-block mb-1">Items</small>
                <span class="badge bg-white text-dark rounded-pill px-3" id="total-items">0</span>
            </div>
        </div>

        <h6 class="text-muted fw-bold small text-uppercase mb-3 ps-1">Recent Activity</h6>
        <div id="order-list" class="d-flex flex-column"></div>

        <?php include 'components/src/empty_state.php' ?>
    </div>

    <?php include 'components/src/bottom_nav.php'; ?>
    <?php include 'components/src/toast.html'; ?>
    <?php include 'components/src/scripts.php'; ?>
    <script src="components/js/orders.js"></script>
</body>

</html>