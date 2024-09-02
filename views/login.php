<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming you have a UserController and login function
    require_once '../controllers/UserController.php'; // Adjust the path if necessary
    $userController = new UserController();
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($userController->login($username, $password)) {
        // Assuming the login function sets the session on success
        header("Location: welcome.php");
        exit;
    } else {
        $error_message = "Invalid login credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cartify</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <header id="main-header">
        <h1>Cartify</h1>
    </header>

    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn">Sign In</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Cartify. All rights reserved.</p>
    </footer>
</body>
</html>
