<?php
// Initialize variables
$plainTextPassword = null;
$hashedPassword = null;

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['password'])) {

    // 1. Get the password from the form
    $plainTextPassword = $_POST['password'];

    // 2. Hash the password
    $hashedPassword = password_hash($plainTextPassword, PASSWORD_DEFAULT);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Hasher</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 2rem;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        form {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        input[type="text"] {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            /* Important for padding to work well */
        }

        button {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 1rem;
        }

        button:hover {
            background-color: #0056b3;
        }

        .result {
            margin-top: 1.5rem;
            word-wrap: break-word;
            /* Ensures hash wraps */
        }

        textarea {
            width: 100%;
            font-family: monospace;
            padding: 0.5rem;
            border: 1px solid #ccc;
            background-color: #fafafa;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Password Hasher</h1>

        <form action="hash_password.php" method="POST">
            <div>
                <label for="password">Enter Password to Hash:</label>
                <input type="text" id="password" name="password" autofocus>
            </div>
            <button type="submit">Generate Hash</button>
        </form>

        <?php
        // 3. Display the result *only* if a hash was generated
        if ($hashedPassword):
        ?>
            <div class="result">
                <p><strong>Plain Text:</strong> <?php echo htmlspecialchars($plainTextPassword); ?></p>
                <p><strong>Copy this hash into your database:</strong></p>
                <textarea rows="4" cols="60" readonly><?php echo htmlspecialchars($hashedPassword); ?></textarea>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>