<?php
session_start();

// Handle item removal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'])) {
    $index = $_POST['remove_item'];
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex array
    }

    // Redirect to home if cart is empty after removal
    if (empty($_SESSION['cart'])) {
        header("Location: user_dashboard.php");
        exit();
    }
}

// Handle order confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    // Here, you can send order data to backend API using cURL or store it in DB later.
    // For now, we simply clear the session cart.

    unset($_SESSION['cart']); // clear cart
    $_SESSION['order_success'] = "Order confirmed successfully!";

    header("Location: user_dashboard.php");
    exit();
}

// Fetch current cart
$cart_items = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Sunway SE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
        .remove-btn {
            background-color: transparent;
            border: none;
            color: #dc3545;
            font-size: 1.2rem;
        }
        .remove-btn:hover {
            color: #b02a37;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#">Cakeaway</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="user_dashboard.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/sunway_se-main/frontend/about.php">About</a></li>
                </ul>
                <form class="d-flex">
                    <a class="btn btn-outline-dark" href="checkout.php">
                        <i class="bi bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill"><?= count($cart_items) ?></span>
                    </a>
                </form>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-dark py-5 text-white text-center">
        <div class="container px-4 px-lg-5 my-5">
            <h1 class="display-5 fw-bolder">Checkout</h1>
            <p class="lead fw-normal text-white-50 mb-0">Review your items before confirming your order</p>
        </div>
    </header>

    <!-- Cart Items -->
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <?php if (empty($cart_items)): ?>
                <p class="text-center fs-5 text-muted">Your cart is empty.</p>
            <?php else: ?>
                <?php foreach ($cart_items as $index => $item): ?>
                    <div class="d-flex justify-content-between align-items-center border-bottom py-3 cart-item">
                        <div class="d-flex align-items-center">
                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="me-3">
                            <div>
                                <h5 class="mb-1"><?= htmlspecialchars($item['name']) ?></h5>
                                <small class="text-muted">RM<?= number_format($item['price'], 2) ?> × <?= $item['quantity'] ?></small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <p class="fw-bold mb-0 me-3">RM<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                            <form action="checkout.php" method="POST" class="m-0">
                                <input type="hidden" name="remove_item" value="<?= $index ?>">
                                <button type="submit" class="remove-btn" title="Remove Item"><i class="bi bi-x-circle"></i></button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="text-end mt-4">
                    <h4>Total: RM<?= number_format($total, 2) ?></h4>
                    <form action="checkout.php" method="POST">
                        <button type="submit" name="confirm_order" class="btn btn-dark mt-3 px-4">Confirm Order</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-dark text-white-50 text-center">
        <div class="container">
            <small>© 2025 Sunway SE | All Rights Reserved</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
