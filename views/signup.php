<?php
require_once '../config/init.php'; // Path from views to config
require_once '../controllers/UserController.php'; // Path from views to controllers

// Create an instance of UserController
$userController = new UserController();

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Call the processSignup method to handle form submission
    $userController->processSignup();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Cartify</title>
    <link rel="stylesheet" href="../assets/styles.css"> <!-- Ensure this path is correct -->
</head>
<body>
    <header id="main-header">
        <h1>Cartify</h1>
        
    </header>
    <img src="../assets/Home.png" alt="Background Image" class="background-img">

    
    <div class="container">
        <h1>Sign Up</h1>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn">Sign Up</button>
        </form>
    </div>
    
    <footer>
        <p>&copy; 2024 Cartify. All rights reserved.</p>
    </footer>
</body>
</html>
