<!-- Top Navigation Bar -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand -->
    <a class="navbar-brand ps-3" href="admin_dashboard.php">Cakeaway Cafe</a>

    <!-- Sidebar Toggle -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>


    <!-- Search Form -->
    <!-- <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form> -->

    <!-- Navbar User Dropdown (Far Right) -->
    <ul class="navbar-nav ms-auto mx-2">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#!">Settings</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <!-- Logout Trigger -->
                <li>
                    <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        Logout
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="logoutModalLabel">Logging Out...</h5>
            </div>
            <div class="modal-body text-center">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <p class="text-dark mb-1">Please wait while we log you out.</p>
                <p class="text-muted small">You will be redirected to the login page shortly.</p>
            </div>
        </div>
    </div>
</div>

<!-- Logout Modal Logic -->
<script>
    const sec = 2; // seconds before redirect
    const timeset = sec * 1000;
    const logoutModal = document.getElementById('logoutModal');

    logoutModal.addEventListener('shown.bs.modal', function() {
        setTimeout(function() {
            window.location.href = "../auth/login.php";
        }, timeset);
    });
</script>