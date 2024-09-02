<?php
// Include necessary files and initialize the ProductController
require_once '../config/init.php';
require_once '../controllers/ProductController.php';

$productController = new ProductController();
$products = $productController->getAllProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Cartify</title>
    <link rel="stylesheet" href="../assets/styles.css"> <!-- Ensure this path is correct -->
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .products-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }

        .product-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 20px;
            max-width: 300px;
            text-align: center;
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-card img {
            max-width: 100%;
            border-radius: 5px;
        }

        .product-card h3 {
            font-size: 24px;
            color: #333;
            margin: 10px 0;
        }

        .product-card p {
            font-size: 16px;
            color: #666;
            margin: 10px 0;
        }

        .product-card .price {
            font-size: 20px;
            font-weight: bold;
            color: #e67e22;
            margin: 15px 0;
        }

        .product-card button {
            padding: 10px 20px;
            background-color: #3498db;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .product-card button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
<div class="container">
        <h1>Welcome to Cartify!</h1>
        <p>Thank you for signing up. We're excited to have you on board.</p>
    </div>
    <div class="products-container">
        <?php foreach ($products as $product) : ?>
            <div class="product-card">
                <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <div class="price">$<?php echo htmlspecialchars($product['price']); ?></div>
                <button>Add to Cart</button>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
