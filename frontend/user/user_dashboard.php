<?php

// --- Get selected genre from dropdown ---
$selected_genre = isset($_GET['genre']) ? $_GET['genre'] : 'All';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Sunway SE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top { height: 200px; width: 100%; object-fit: cover; }
        .card { transition: transform 0.25s ease, box-shadow 0.25s ease; height:100%; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 6px 15px rgba(0,0,0,0.1); }
        .genre-select { width: 200px; }
        @media(max-width:576px){ .genre-select{ width:150px; font-size:0.9rem; } }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">Cakeaway</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/sunway_se-main/frontend/about.php">About</a></li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
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
                <select name="genre" id="genre" class="form-select genre-select">
                    <option value="All" <?php if ($selected_genre === 'All') echo 'selected'; ?>>All</option>
                    <option value="Coffee" <?php if ($selected_genre === 'Coffee') echo 'selected'; ?>>Coffee</option>
                    <option value="Juices" <?php if ($selected_genre === 'Juices') echo 'selected'; ?>>Juices</option>
                    <option value="Cakes" <?php if ($selected_genre === 'Cakes') echo 'selected'; ?>>Cakes</option>
                    <option value="Cookies" <?php if ($selected_genre === 'Cookies') echo 'selected'; ?>>Cookies</option>
                </select>
            </form>
        </div>
    </section>

    <!-- Product Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-3">
            <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 justify-content-center" id="productContainer">
                <!-- Products will be filled by JS -->
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
    <script src="/software_engineering/frontend/js/user_dashboard.js"></script>
</body>
</html>
