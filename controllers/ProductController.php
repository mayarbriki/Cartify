<?php
class ProductController {
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

    public function addProduct($name, $description, $price, $stock, $image) {
        // Example query to add product to the database
        $sql = "INSERT INTO products (name, description, price, stock, image) VALUES (:name, :description, :price, :stock, :image)";
        $stmt = $this->db->prepare($sql);
        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':image', $image);
        // Execute the statement
        return $stmt->execute();
    }

    public function getAllProducts() {
        $query = "SELECT * FROM products";
        $stmt = $this->db->query($query);

        if ($stmt === false) {
            die("Error fetching products: " . $this->db->errorInfo()[2]);
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
