<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <header id="main-header">
        <h1>Admin Dashboard</h1>
    </header>

    <div class="container">
        <h2>Welcome, Admin</h2>
        <p>This is the admin dashboard.</p>
        <!-- Add more admin-specific functionality here -->
    </div>

    <footer>
        <p>&copy; 2024 Cartify. All rights reserved.</p>
    </footer>
</body>
</html>
