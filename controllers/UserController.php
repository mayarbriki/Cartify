<?php
require_once '../config/init.php'; // Path from controllers to config
class UserController {

    // Method to show the signup form
    public function showSignupForm() {
        include 'views/signup.php'; // Adjust path as needed
    }

    // Method to handle the signup process
    public function processSignup() {
        global $pdo; // Use the global PDO object

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve form data
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $full_name = trim($_POST['full_name']);
            $password = trim($_POST['password']);

            // Validate inputs
            if (empty($username) || empty($email) || empty($full_name) || empty($password)) {
                echo "All fields are required.";
                return;
            }

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Prepare SQL query
            $sql = "INSERT INTO users (username, email, full_name, password) VALUES (:username, :email, :full_name, :password)";

            try {
                $stmt = $pdo->prepare($sql);

                // Bind parameters
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':full_name', $full_name);
                $stmt->bindParam(':password', $hashed_password);

                // Execute the query
                $stmt->execute();

                echo "Sign up successful!";
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Invalid request method.";
        }
    }
}
?>
