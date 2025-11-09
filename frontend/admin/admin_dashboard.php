<?php

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/admin.css" rel="stylesheet" />
    <script>
        // 1. Core Variables
        const token = localStorage.getItem('authToken');
        const loginPage = '/software_engineering/frontend/auth/login.php';
        const emailElementId = 'sidenavUserEmail'; // ID of the element to display the email

        // 2. Authorization Check (The Guard)
        // If no token exists, redirect immediately to the login page.
        if (!token) {
            window.location.href = loginPage;
        }

        // 3. Helper function for handling 401 Unauthorized errors
        function handleUnauthorized(response) {
            if (response.status === 401) {
                console.warn('Unauthorized access: Token invalid or expired. Redirecting to login.');
                localStorage.removeItem('authToken');
                window.location.href = loginPage;
                return true;
            }
            return false;
        }

        // 4. Function to fetch and display the logged-in user's information
        function fetchUserInfo() {
            const emailElement = document.getElementById(emailElementId);

            // Initial state update for the element
            if (emailElement) {
                emailElement.textContent = 'Fetching...';
            }

            fetch('/software_engineering/backend/user_info', {
                    // ...
                })
                .then(response => {
                    if (handleUnauthorized(response)) {
                        return null;
                    }
                    return response.json();
                })
                // In admin_dashboard.php:
                .then(data => {
                    if (emailElement) {
                        if (data && data.email) { // <--- THIS CHECK IS FAILING
                            // Success: Update the HTML element with the user's email
                            emailElement.textContent = data.email;
                        } else {
                            // Failure: Token was valid, but user data was incomplete
                            emailElement.textContent = 'User Unknown'; // <--- IT IS LIKELY HITTING THIS LINE
                        }
                    }
                })
                .catch(error => {
                    // 🛠️ CORRECTED: Only update the emailElement and log to console.
                    console.error('Error fetching user info:', error);
                    if (emailElement) {
                        emailElement.textContent = 'Error Loading User'; // Display error in the sidebar
                    }
                    // Ensure there is NO line here attempting to use 'errorMessage'
                });
        }

        // 5. Execution: Call the user info function immediately after the guard check passes
        fetchUserInfo();

        // NOTE: You would add other data fetching functions (like fetchDashboardData) here 
        // and call them below this line.
    </script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?= include 'layoutTopnav_nav.php'; ?>
    <div id="layoutSidenav">
        <?= include 'layoutSidenav_nav.php'; ?>
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
                                <div class="card-body">Primary Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white">test value 0</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">Warning Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white">test value 0</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">Success Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white">test value 0</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">Danger Card</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <div class="small text-white">test value 0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i>
                                    Order rate per day
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Monthly income Bar chart
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Orders
                        </div>
                        <div class="card-body">
                            <table id="datatablesOrders" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Table Number</th>
                                        <th>Time</th>
                                        <th>Cost</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <?= include 'change&remove_modal.html'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../js/admin_js/Order-rates-per-day.js"></script>
    <script src="../js/admin_js/Monthly-income-Bar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/admin_js/datatables-order-list.js"></script>
</body>

</html>