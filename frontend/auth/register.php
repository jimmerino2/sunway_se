<?php
// 1. Page Configuration
$pageTitle = "Register | Cakeaway Admin";
$currentPage = "Register";
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'components/src/head.php'; ?>

<body class="d-flex align-items-center justify-content-center">
    <main>
        <div class="container auth-container row g-0" style="max-width: 900px;">
            <div class="col-md-5 left-side p-5 d-flex flex-column justify-content-center">
                <h2>Welcome!</h2>
                <p>Create your account to join our community. It's fast and easy!</p>
            </div>

            <div class="col-md-7 p-5">
                <h3 class="text-center fw-light my-4">Create Account</h3>

                <div id="mainMessage" class="mb-3"></div>

                <form id="registerForm">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputFirstName" type="text"
                            placeholder="Enter your first name" required />
                        <label for="inputFirstName">Name</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputEmail" type="email"
                            placeholder="name@example.com" required />
                        <label for="inputEmail">Email address</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-control form-select" id="inputRole" aria-label="User Role"
                            required>
                            <option value="" selected disabled>Select a role</option>
                            <option value="C">Cashier</option>
                            <option value="K">Kitchen</option>
                            <option value="A">Admin</option>
                        </select>
                        <label for="inputRole">Role</label>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0 password-toggle-container">
                                <input class="form-control" id="inputPassword" type="password"
                                    placeholder="Create a password" required />
                                <label for="inputPassword">Password</label>
                                <span class="password-toggle-icon toggle-password" data-target="inputPassword">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0 password-toggle-container">
                                <input class="form-control" id="inputPasswordConfirm"
                                    type="password" placeholder="Confirm password" required />
                                <label for="inputPasswordConfirm">Confirm Password</label>
                                <span class="password-toggle-icon toggle-password" data-target="inputPasswordConfirm">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 mb-0">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-login btn-block rounded-pill" id="registerSubmitButton">
                                Create Account
                            </button>
                        </div>
                    </div>
                </form>

                <div class="text-center py-3 mt-3">
                    <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                </div>
            </div>

        </div>
    </main>

    <?php include 'components/src/admin_auth_modal.html'; ?>
    <?php include 'components/src/scripts.php'; ?>

</body>

</html>