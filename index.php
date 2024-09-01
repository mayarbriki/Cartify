<?php
require_once 'config/init.php';

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Cartify</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header id="main-header">
        <h1>Cartify</h1>
        <div class="auth-buttons">
            <a href="views/signin.php" class="btn">Sign In</a>
            <a href="views/signup.php" class="btn">Sign Up</a>
        </div>
    </header>
    
    <img src="assets/Home.png" alt="Background Image" class="background-img">

    <div class="container">
        <h1>Welcome to Cartify!</h1>
        <p>Your one-stop shop for all your needs.</p>
    </div>
    
    <footer>
        <p>&copy; 2024 Cartify. All rights reserved.</p>
    </footer>

    <script src="assets/script.js"></script>
</body>
</html>
