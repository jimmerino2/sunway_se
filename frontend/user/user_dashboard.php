<?php
// --- Product Data (Frontend Only) ---
$products = [
    ["name" => "Chocolate Indulgence", "price" => 40, "genre" => "Cakes", "image" => "../images/chocolate-indulgence.png"],
    ["name" => "Strawberry Bliss", "price" => 38, "genre" => "Cakes", "image" => "../images/strawberry-bliss.png"],
    ["name" => "Red Velvet", "price" => 42, "genre" => "Cakes", "image" => "../images/red-velvet.png"],
    ["name" => "Iced Latte", "price" => 12, "genre" => "Drinks", "image" => "../images/iced-latte.png"],
    ["name" => "Iced Tea", "price" => 8, "genre" => "Drinks", "image" => "../images/iced-tea.png"],
    ["name" => "Mocha Frappe", "price" => 15, "genre" => "Drinks", "image" => "../images/mocha-frappe.png"],
];

// --- Get selected genre from dropdown ---
$selected_genre = isset($_GET['genre']) ? $_GET['genre'] : 'All';

// --- Filter products ---
$filtered_products = ($selected_genre === 'All') 
    ? $products 
    : array_filter($products, fn($p) => $p['genre'] === $selected_genre);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Sunway SE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* --- Product card image & layout adjustments --- */
        .card-img-top {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }

        .genre-select {
            width: 200px;
        }

        @media (max-width: 576px) {
            .genre-select {
                width: 150px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">Cakeaway</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/sunway_se-main/frontend/about.php">About</a></li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Header-->
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
                <select name="genre" id="genre" class="form-select genre-select" onchange="this.form.submit()">
                    <option value="All" <?php if ($selected_genre === 'All') echo 'selected'; ?>>All</option>
                    <option value="Cakes" <?php if ($selected_genre === 'Cakes') echo 'selected'; ?>>Cakes</option>
                    <option value="Drinks" <?php if ($selected_genre === 'Drinks') echo 'selected'; ?>>Drinks</option>
                </select>
            </form>
        </div>
    </section>

    <!-- Product Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-3">
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

                <?php if (empty($filtered_products)): ?>
                    <p class="text-center text-muted fs-5">No products found for this genre.</p>
                <?php else: ?>
                    <?php foreach ($filtered_products as $product): ?>
                        <div class="col mb-5">
                            <div class="card h-100 shadow-sm">
                                <!-- Product image -->
                                <img class="card-img-top" src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                                <!-- Product details -->
                                <div class="card-body p-4 text-center">
                                    <h5 class="fw-bolder"><?php echo htmlspecialchars($product['name']); ?></h5>
                                    RM<?php echo number_format($product['price'], 2); ?>
                                </div>
                                <!-- Product actions -->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent text-center">
                                    <a class="btn btn-outline-dark mt-auto" href="#">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-4 bg-dark text-white-50 text-center">
        <div class="container">
            <small>© 2025 Sunway SE | All Rights Reserved</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
