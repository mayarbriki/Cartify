<?php
require_once '../config/init.php';
require_once '../controllers/UserController.php';
require_once '../controllers/ProductController.php';

$userController = new UserController();
$productController = new ProductController();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_user'])) {
        $userController->deleteUser($_POST['user_id']);
    }
    if (isset($_POST['addProduct'])) { // Ensure name matches
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $image = $_FILES['image']['name'];

        // Use __DIR__ to get the directory of the current file
        $targetDir = __DIR__ . "/../uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
            // Add product to the database
            if ($productController->addProduct($name, $description, $price, $stock, $image)) {
                echo "Product added successfully.";
            } else {
                echo "Failed to add product.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}


$products = $productController->getAllProducts();
$users = $userController->getAllUsers();

// Use isset() to avoid undefined index warning
$page = isset($_GET['page']) ? $_GET['page'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cartify</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <style>
        /* Light grey header styling */
        header {
            background-color: #f2f2f2; /* Very light grey background */
            padding: 20px;
            text-align: center;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow */
        }

        header h1 {
            margin: 0;
            color: #333; /* Dark grey text color */
        }

       
    </style>
</head>
<body>
<header>
        <h1>Admin Dashboard</h1>
        <button class="nav-toggle">☰</button> <!-- Button to toggle the nav -->
        <nav class="nav-bar">
            <ul>
                <li><a href="?page=user_management">User Management</a></li>
                <li><a href="?page=product_management">Product Management</a></li>
            </ul>
        </nav>
    </header>

    <div class="admin-dashboard">
        <?php if ($page == 'user_management') : ?>
            <h2>                                   </h2>
            <!-- User management table here -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                                    <button type="submit" name="delete_user">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php elseif ($page == 'product_management') : ?>
            
            <h3>Add New Product</h3>
            <form action="dashboard.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="name" required placeholder="Product Name">
    <textarea name="description" required placeholder="Product Description"></textarea>
    <input type="number" name="price" step="0.01" required placeholder="Product Price">
    <input type="number" name="stock" required placeholder="Stock Quantity">
    <input type="file" name="image" required>
    <input type="submit" name="addProduct" value="Add Product">
</form>


            <h3>Existing Products</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td><?php echo htmlspecialchars($product['price']); ?></td>
                            <td><?php echo htmlspecialchars($product['stock']); ?></td>
                            <td><img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" width="100"></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <h2>Welcome to the Admin Dashboard</h2>
        <?php endif; ?>
    </div>
    <script src="../assets/script.js"></script>
</body>
</html>