<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 1rem;
            text-align: center;
        }
        p {
            margin: 0.5rem 0;
        }
        label {
            display: block;
            margin-bottom: 0.3rem;
            font-size: 14px;
            color: #555;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 1rem;
            font-size: 14px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 0.8rem;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin-bottom: 1rem;
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
        }
        .register {
            text-align: center;
            margin-top: 1rem;
            font-size: 14px;
        }
        .register a {
            color: #007bff;
            text-decoration: none;
        }
        .register a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php  
        if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
            $statusClass = $_SESSION['status'] == "200" ? "success" : "error";
            echo "<div class='message $statusClass'>{$_SESSION['message']}</div>";
        }
        unset($_SESSION['message']);
        unset($_SESSION['status']);
        ?>

        <h1>Login Now!</h1>
        <form action="core/handleForms.php" method="POST">
            <p>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </p>
            <p>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </p>
            <p>
                <input type="submit" name="loginUserBtn" value="Login">
            </p>
        </form>
        <p class="register">Don't have an account? You may register <a href="register.php">here</a>.</p>
    </div>
</body>
</html>
