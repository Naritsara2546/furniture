<?php
session_start();
include_once("connectdb.php");

// Handle updating cart quantities
if (isset($_POST['update_cart'])) {
    $product_id = $_POST['product_id'];
    $action = $_POST['update_cart'];

    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Update the quantity based on the action
    if ($action === 'add') {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += 1; // Increase quantity
        } else {
            $_SESSION['cart'][$product_id] = 1; // Set quantity to 1
        }
    } elseif ($action === 'remove') {
        if (isset($_SESSION['cart'][$product_id]) && $_SESSION['cart'][$product_id] > 1) {
            $_SESSION['cart'][$product_id] -= 1; // Decrease quantity
        } elseif (isset($_SESSION['cart'][$product_id]) && $_SESSION['cart'][$product_id] === 1) {
            unset($_SESSION['cart'][$product_id]); // Remove item if quantity is 1
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        .container {
            margin-top: 50px;
        }
        .product-image {
            width: 80px;
            height: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Your Shopping Cart</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                $total_price = 0;

                foreach ($_SESSION['cart'] as $product_id => $quantity) {
                    $sql = "SELECT p_name, p_price, p_picture FROM product WHERE p_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $product_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $product = $result->fetch_assoc();
                        $price = $product['p_price'];
                        $total = $price * $quantity;
                        $total_price += $total;

                        // Create image path
                        $product_image = "images/" . htmlspecialchars($product['p_picture']);

                        echo "<tr>
                                <td><img src='$product_image' alt='" . htmlspecialchars($product['p_name']) . "' class='product-image'></td>
                                <td>" . htmlspecialchars($product['p_name']) . "</td>
                                <td>$quantity</td>
                                <td>" . number_format($price, 2) . " บาท</td>
                                <td>" . number_format($total, 2) . " บาท</td>
                                <td>
                                    <form method='POST' action=''>
                                        <input type='hidden' name='product_id' value='$product_id'>
                                        <button type='submit' name='update_cart' value='add' class='btn btn-success btn-sm'>+</button>
                                        <button type='submit' name='update_cart' value='remove' class='btn btn-danger btn-sm'>-</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                    $stmt->close();
                }

                echo "<tr>
                        <td colspan='4' class='text-end'><strong>Total Price:</strong></td>
                        <td><strong>" . number_format($total_price, 2) . " บาท</strong></td>
                      </tr>";
            } else {
                echo "<tr><td colspan='6'>Your cart is empty.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="payment.php" class="btn btn-dark mt-3">Payment</a>
    <a href="home.php" class="btn btn-primary mt-3">Back to Shopping</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
