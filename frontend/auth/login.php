<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SB Admin</title>
    <link href="../css/admin.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email"
                                                placeholder="name@example.com" />
                                            <label for="inputEmail">Email address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" type="password"
                                                placeholder="Password" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox"
                                                value="" />
                                            <label class="form-check-label" for="inputRememberPassword">Remember
                                                Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password.html">Forgot Password?</a>
                                            <a class="btn btn-primary" href="index.html">Login</a>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html> -->




<!-- custom -->

<?php

//phpinfo();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Login Page</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
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

        .form-control {
            background-color: #f5f5f5;
            border: none;
            border-radius: 50px;
            padding: 12px 20px;
        }

        .form-control:focus {
            box-shadow: none;
            background-color: #f0f0f0;
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

        .remember {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
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

    <div class="login-container d-flex flex-column flex-md-row mx-3">
        <!-- Left side -->
        <div class="left-side col-md-6 d-flex flex-column justify-content-center">
            <h2>Welcome to Website</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
            </p>
        </div>

        <!-- Right side -->
        <div class="right-side col-md-6 d-flex flex-column justify-content-center">
            <h4 class="text-center mb-4 fw-semibold">USER LOGIN</h4>
            <form>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="remember">
                    <div>
                        <input type="checkbox" id="remember"> <label for="remember">Remember</label>
                    </div>
                    <a href="#" class="text-decoration-none text-primary">Forgot password?</a>
                </div>
                <!-- <div class="text-center mt-4">
                    <button type="submit" class="btn btn-login w-100">LOGIN USER</button>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-login w-100">LOGIN ADMIN</button>
                </div> -->

                <!-- temp -->
                <div class="text-center mt-4">
                    <a href="../user_page/user_dashboard.php" class="btn btn-login w-100">LOGIN USER</a>
                </div>

                <div class="text-center mt-4">
                    <a href="../admin_page/admin_dashboard.php" class="btn btn-login w-100">LOGIN ADMIN</a>
                </div>

            </form>
        </div>
    </div>

</body>

</html>