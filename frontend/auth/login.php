<?php
//phpinfo();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Login Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
        <div class="left-side col-md-6 d-flex flex-column justify-content-center">
            <h2>Welcome to Website</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
            </p>
        </div>

        <div class="right-side col-md-6 d-flex flex-column justify-content-center">
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
                <div class="remember">
                    <div>
                        <input type="checkbox" id="remember"> <label for="remember">Remember</label>
                    </div>
                    <a href="#" class="text-decoration-none text-primary">Forgot password?</a>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-login w-100">LOGIN ADMIN</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.style.display = 'none';

            const apiEndpoint = '/software_engineering/backend/auth';

            // Create the data object to be sent
            const loginData = {
                email: email,
                password: password
            };

            // MODIFICATION: Log the JSON object to the console
            console.log('Sending JSON to backend:', loginData);

            fetch(apiEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(loginData) // Send the object
                })
                .then(response => response.json())
                .then(data => {
                    if (data.token) {
                        localStorage.setItem('authToken', data.token);
                        window.location.href = '/software_engineering/frontend/admin/admin_dashboard.php';
                    } else {
                        errorMessage.textContent = data.error || 'Invalid email or password.';
                        errorMessage.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Login Error:', error);
                    errorMessage.textContent = 'An error occurred. Please try again later.';
                    errorMessage.style.display = 'block';
                });
        });
    </script>
</body>

</html>