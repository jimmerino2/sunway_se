<?php
// 1. Page Configuration
$pageTitle = "Login | Cakeaway Admin";
$currentPage = "login";
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'components/src/head.php'; ?>

<body class="d-flex align-items-center justify-content-center">
    <main>
        <div class="auth-container row g-0" style="max-width: 900px;">

            <div class="left-side col-md-5 p-5 p-md-4 d-flex flex-column justify-content-center">
                <h2>Welcome to Cakeaway Cafe!</h2>
                <p>
                    Savor the moment with our fresh-baked delights, available for pickup or delivery.
                    Browse our menu, place an order, or check your loyalty rewards below!
                </p>
            </div>

            <div class="col-md-7 p-5 d-flex flex-column justify-content-center">
                <h4 class="text-center mb-4 fw-semibold">USER LOGIN</h4>

                <form id="loginForm">

                    <div id="errorMessage" class="alert alert-danger" style="display: none;" role="alert">
                    </div>

                    <div class="mb-3">
                        <input type="email" id="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" id="password" class="form-control" placeholder="Password" required>
                    </div>

                    <div class="d-flex justify-content-end align-items-center small mt-2 mb-4">
                        <a href="register.php" class="text-decoration-none text-primary">Register?</a>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-login w-100 rounded-pill">LOGIN DASHBOARD</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include 'components/src/footer.php'; ?>
    <?php include 'components/src/scripts.php'; ?>
</body>

</html>