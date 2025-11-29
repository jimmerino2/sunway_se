<?php
$pageTitle = "Cart | Cakeaway";
$pageHeader = "My Cart";
$currentPage = "cart";
$paddingTop = "70px";
$paddingBottom = "140px";

$emptyIcon = "bi-basket3";
$emptyTitle = "Your cart is empty";
$emptyMessage = "Looks like you haven't added anything yet.";
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'components/src/head.php'; ?>

<body>
    <?php include 'components/src/top_nav.php'; ?>

    <div class="container px-3">
        <div id="cart-list" class="d-flex flex-column"></div>

        <?php include 'components/src/empty_state.php'; ?>
    </div>

    <div id="checkout-bar" class="checkout-bar d-none align-items-center justify-content-between">
        <div class="d-flex flex-column">
            <span class="text-muted small fw-bold text-uppercase">Total</span>
            <span class="fs-3 fw-bold text-primary">RM <span id="cart-total">0.00</span></span>
        </div>
        <button class="btn btn-dark rounded-pill px-4 py-2 fw-bold d-flex align-items-center gap-2" id="btn-submit-order" style="height: 50px;">
            <span>Place Order</span>
            <i class="bi bi-arrow-right-circle-fill"></i>
        </button>
    </div>


    <?php include 'components/src/cart_modal.php'; ?>
    <?php include 'components/src/bottom_nav.php'; ?>
    <?php include 'components/src/toast.html'; ?>
    <?php include 'components/src/scripts.php'; ?>
    <script src="components/js/cart.js"></script>
</body>

</html>