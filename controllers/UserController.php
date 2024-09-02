<?php
require_once '../config/init.php'; // Path from controllers to config

class UserController {
    private $db;

    public function __construct() {
        // Database connection details
        $host = 'localhost';
        $dbname = 'ecommerce';
        $username = 'root';
        $password = '';

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
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
            $profilePicture = '';

            // Validate inputs
            if (empty($username) || empty($email) || empty($full_name) || empty($password)) {
                echo "All fields are required.";
                return;
            }

            // Handle profile picture upload
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
                $fileName = $_FILES['profile_picture']['name'];
                $fileSize = $_FILES['profile_picture']['size'];
                $fileType = $_FILES['profile_picture']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                // Validate file type and size (example: allow only JPEG and PNG images, max 2MB)
                $allowedExtensions = array('jpg', 'jpeg', 'png');
                $maxFileSize = 2 * 1024 * 1024; // 2MB

                if (in_array($fileExtension, $allowedExtensions) && $fileSize <= $maxFileSize) {
                    // Create a unique file name and move the file to the desired directory
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                    $uploadDir = '../uploads/';
                    $destPath = $uploadDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $profilePicture = $newFileName;
                    } else {
                        echo "There was an error uploading the file.";
                        return;
                    }
                } else {
                    echo "Invalid file type or size.";
                    return;
                }
            }

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Prepare SQL query
            $sql = "INSERT INTO users (username, email, full_name, password, profile_picture) VALUES (:username, :email, :full_name, :password, :profile_picture)";

            try {
                $stmt = $pdo->prepare($sql);

                // Bind parameters
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':full_name', $full_name);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':profile_picture', $profilePicture);

                // Execute the query
                $stmt->execute();
                

                echo "Sign up successful!";
               // header('Location: welcome.php');
                exit();
                
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Invalid request method.";
        }
    }  public function login($username, $password) {
        // Assuming $this->db is already initialized
        $query = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $query->bindParam(':username', $username);
        $query->execute();
        
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            // Start a session and store user data
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            if ($user['role'] === 'admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: welcome.php");
            }
            exit;
        } else {
            return false;
        }
    }
    public function getAllUsers() {
        $query = $this->db->prepare("SELECT id, username, email, full_name, role FROM users");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteUser($userId) {
        // Prepare and execute the delete query
        $query = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $query->bindParam(':id', $userId, PDO::PARAM_INT);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

?>
