<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        /* Your custom styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        }

        .login-container {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            max-width: 900px;
            width: 100%;
        }

        .left-side {
            background: linear-gradient(135deg, #8e2de2 0%, #4a00e0 100%);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left-side h2 {
            font-weight: 600;
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .left-side p {
            font-size: 0.95rem;
            line-height: 1.6;
            opacity: 0.9;
        }

        .right-side {
            padding: 60px 50px;
        }

        .form-control,
        .form-select {
            /* Applied to form-select as well */
            background-color: #f5f5f5;
            border: none;
            border-radius: 50px;
            padding: 12px 20px;
            height: calc(3.5rem + 2px);
            /* Match form-floating height */
            line-height: 1.25;
            /* Match form-floating line-height */
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: none;
            background-color: #f0f0f0;
        }

        /* Fix for floating label select padding */
        .form-floating>label {
            padding-top: 0.9rem;
        }

        .form-floating>.form-control {
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }

        .form-floating>.form-select {
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }


        .btn-login {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            border: none;
            border-radius: 50px;
            color: white;
            padding: 10px 30px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: linear-gradient(90deg, #2575fc, #6a11cb);
            transform: scale(1.05);
        }

        .forgot-password {
            display: flex;
            justify-content: end;
            align-items: center;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        @media (max-width: 767.98px) {
            .left-side {
                text-align: center;
                padding: 40px 20px;
            }

            .right-side {
                padding: 40px 30px;
            }
        }
    </style>
</head>

<body>

    <div>
        <div>
            <main>
                <div class="container d-flex align-items-center justify-content-center min-vh-100 py-5">

                    <div class="login-container row">

                        <div class="col-md-5 left-side">
                            <h2>Welcome!</h2>
                            <p>Create your account to join our community. It's fast and easy!</p>
                        </div>

                        <div class="col-md-7 right-side">
                            <h3 class="text-center font-weight-light my-4">Create Account</h3>

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
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputPassword" type="password"
                                                placeholder="Create a password" required />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputPasswordConfirm"
                                                type="password" placeholder="Confirm password" required />
                                            <label for="inputPasswordConfirm">Confirm Password</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 mb-0">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-login btn-block" data-bs-toggle="modal"
                                            data-bs-target="#adminAuthModal">
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
                </div>
            </main>
        </div>
    </div>

    <?= include 'src/admin_auth_modal.html'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>

    <script src="components/js/create_user.js"></script>
</body>

</html>