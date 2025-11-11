<?php
session_start();

// --- Show order success message if redirected from checkout ---
$order_success = $_SESSION['order_success'] ?? null;
if ($order_success) {
    unset($_SESSION['order_success']); // remove after showing once
}

// --- Fetch Products from Backend API ---
$api_url = "http://localhost/software_engineering/backend/item";
 // ✅ using index.php path
$response = @file_get_contents($api_url);

if ($response === FALSE) {
    $products = [];
} else {
    $responseData = json_decode($response, true);
    $products = $responseData['data'] ?? [];
}

// ✅ Debug: show raw response if no products found (temporary)
if (empty($products)) {
    echo "<div style='padding:20px; background:#f8d7da; color:#721c24;'>
        <strong>⚠️ Debug Notice:</strong> No products found.<br>
        <pre>" . print_r($responseData, true) . "</pre>
    </div>";
}

// --- Normalize product data ---
$products = array_map(function ($item) {
    return [
        "id" => $item['id'] ?? 0,
        "name" => $item['name'] ?? "Unnamed Item",
        "price" => $item['price'] ?? 0,
        "genre" => $item['category_name'] ?? "Other",
        "image" => "http://localhost/software_engineering/backend/public/storage" . $item['image_url'],
        "description" => $item['description'] ?? "No description available."
    ];
}, $products);


// --- Add to Cart Handling ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_name'])) {
    $product = [
        'name' => $_POST['product_name'],
        'price' => $_POST['product_price'],
        'image' => $_POST['product_image'],
        'quantity' => $_POST['quantity']
    ];

    $_SESSION['cart'][] = $product;
    header("Location: user_dashboard.php");
    exit();
}

$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

// --- Genre Filter ---
$selected_genre = $_GET['genre'] ?? 'All';
$filtered_products = ($selected_genre === 'All') ? $products : array_filter($products, fn($p) => $p['genre'] === $selected_genre);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Sunway SE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/sunway_se-main/frontend/about.php">About</a></li>
                </ul>
                <form class="d-flex">
                    <a class="btn btn-outline-dark" href="checkout.php">
                        <i class="bi bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo $cart_count; ?></span>
                    </a>
                </form>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-dark py-5 text-white text-center">
        <div class="container px-4 px-lg-5 my-5">
            <h1 class="display-5 fw-bolder">Welcome to Sunway SE</h1>
            <p class="lead fw-normal text-white-50 mb-0">Delicious Cakes & Refreshing Drinks Await</p>
        </div>
    </header>

    <!-- Genre Dropdown -->
    <section class="py-4">
        <div class="container px-4 px-lg-5 d-flex justify-content-start">
            <form method="GET" class="d-flex align-items-center">
                <label for="genre" class="me-2 fw-bold fs-5">Genre:</label>
                <select name="genre" id="genre" class="form-select" onchange="this.form.submit()">
                    <option value="All" <?= $selected_genre === 'All' ? 'selected' : '' ?>>All</option>
                    <option value="Cakes" <?= $selected_genre === 'Cakes' ? 'selected' : '' ?>>Cakes</option>
                    <option value="Coffee" <?= $selected_genre === 'Coffee' ? 'selected' : '' ?>>Coffee</option>
                    <option value="Juices" <?= $selected_genre === 'Juices' ? 'selected' : '' ?>>Juices</option>
                    <option value="Cookies" <?= $selected_genre === 'Cookies' ? 'selected' : '' ?>>Cookies</option>
                </select>
            </form>
        </div>
    </section>

    <!-- Product Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-3">
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php foreach ($filtered_products as $product): ?>
                    <div class="col mb-5">
                        <div class="card h-100 shadow-sm">
                            <img class="card-img-top" src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
                            <div class="card-body p-4 text-center">
                                <h5 class="fw-bolder"><?= htmlspecialchars($product['name']) ?></h5>
                                RM<?= number_format($product['price'], 2) ?>
                            </div>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent text-center">
                                <button class="btn btn-outline-dark mt-auto" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#productModal" 
                                    data-name="<?= htmlspecialchars($product['name']) ?>"
                                    data-price="<?= floatval($product['price']) ?>"
                                    data-image="<?= $product['image'] ?>"
                                    data-description="<?= htmlspecialchars($product['description']) ?>">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 bg-dark text-white-50 text-center">
        <div class="container">
            <small>© 2025 Sunway SE | All Rights Reserved</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?= include 'productdetails_modal.html'; ?>

    <script>
  const productModal = document.getElementById('productModal');
  const modalForm = document.getElementById('modalAddForm');

  // When modal opens, populate product details
  productModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    document.getElementById('modalName').textContent = button.getAttribute('data-name');
    document.getElementById('modalDescription').textContent = button.getAttribute('data-description');
    document.getElementById('modalPrice').textContent = parseFloat(button.getAttribute('data-price')).toFixed(2);
    document.getElementById('modalImage').src = button.getAttribute('data-image');

    // Fill hidden form fields
    document.getElementById('modalProductName').value = button.getAttribute('data-name');
    document.getElementById('modalProductPrice').value = button.getAttribute('data-price');
    document.getElementById('modalProductImage').value = button.getAttribute('data-image');
    document.getElementById('modalQuantity').value = 1;
    document.getElementById('modalQuantityHidden').value = 1;
  });

  // Quantity increase
  document.getElementById('increaseQty').addEventListener('click', () => {
    let qty = parseInt(document.getElementById('modalQuantity').value);
    qty++;
    document.getElementById('modalQuantity').value = qty;
    document.getElementById('modalQuantityHidden').value = qty;
  });

  // Quantity decrease
  document.getElementById('decreaseQty').addEventListener('click', () => {
    let qty = parseInt(document.getElementById('modalQuantity').value);
    if (qty > 1) qty--;
    document.getElementById('modalQuantity').value = qty;
    document.getElementById('modalQuantityHidden').value = qty;
  });
</script>

</body>
</html>
