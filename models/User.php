<?php

class User {
    private $id;
    private $username;
    private $email;
    private $fullName;
    private $password;
    private $created_at;

    public function __construct($id = null, $username = null, $email = null, $fullName = null, $password = null) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->password = $password;
        $this->created_at = date('Y-m-d H:i:s');
    }

    // Getter and Setter methods
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    // Method to validate the password
    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }

    // Save user data to the database (for example purposes only)
    public function save() {
        // Assume $conn is your database connection
        global $conn;

        if ($this->id === null) {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, email, full_name, password, created_at) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $this->username, $this->email, $this->fullName, $this->password, $this->created_at);
            $stmt->execute();
            $this->id = $stmt->insert_id;
        } else {
            // Update existing user
            $stmt = $conn->prepare("UPDATE users SET username=?, email=?, full_name=?, password=? WHERE id=?");
            $stmt->bind_param("ssssi", $this->username, $this->email, $this->fullName, $this->password, $this->id);
            $stmt->execute();
        }
    }

    // Load a user from the database
    public static function loadById($id) {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return new self($row['id'], $row['username'], $row['email'], $row['full_name'], $row['password']);
        } else {
            return null;
        }
    }

    // Additional methods for user management can be added here
}
?>
