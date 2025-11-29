<nav class="navbar fixed-bottom bg-white border-top shadow-sm px-0" style="height: 65px; z-index: 1030;">
    <div class="container-fluid h-100">
        <div class="row w-100 mx-0 h-100">

            <div class="col-4 px-0 h-100">
                <a href="index.php" class="nav-link-custom h-100 <?php echo ($currentPage === 'menu') ? 'active' : ''; ?>">
                    <i class="bi bi-house-door<?php echo ($currentPage === 'menu') ? '-fill' : ''; ?>"></i>
                    <span>Menu</span>
                </a>
            </div>

            <div class="col-4 px-0 h-100 position-relative">
                <a href="cart.php" class="nav-link-custom h-100 <?php echo ($currentPage === 'cart') ? 'active' : ''; ?>">
                    <div class="position-relative">
                        <i class="bi bi-basket3<?php echo ($currentPage === 'cart') ? '-fill' : ''; ?>"></i>

                        <span id="bottom-cart-badge" class="position-absolute start-100 translate-middle badge rounded-pill bg-danger border border-light" style="top: 10px; margin-left: 6px; font-size: 0.6rem; display: none;">
                            0
                        </span>

                    </div>
                    <span>Cart</span>
                </a>
            </div>

            <div class="col-4 px-0 h-100">
                <a href="orders.php" class="nav-link-custom h-100 <?php echo ($currentPage === 'orders') ? 'active' : ''; ?>">
                    <i class="bi bi-receipt"></i> <span>Orders</span>
                </a>
            </div>

        </div>
    </div>
</nav>