<?php
session_start();
include_once("connectdb.php");

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php"); // Redirect if the cart is empty
    exit();
}

// Calculate total price from the cart
$total_price = 0;
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $sql = "SELECT p_price FROM product WHERE p_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $total_price += $product['p_price'] * $quantity;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f4f8;
            color: #333;
        }
        .container {
            margin-top: 50px;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #007bff;
        }
        h4 {
            font-size: 1.5rem;
            margin-bottom: 30px;
            color: #333;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1.2rem;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Payment</h1>
    
    <!-- Displaying the username -->
    <?php if (isset($_SESSION['username'])): ?>
        <p class="mb-4">Logged in as: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
    <?php else: ?>
        <p class="mb-4">You are not logged in.</p>
    <?php endif; ?>

    <h4>Total Amount: <?php echo number_format($total_price, 2); ?> บาท</h4>

    <form id="payment-form" method="POST" action="checkout.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="account-number">Account Number</label>
            <input type="text" name="account_number" id="account-number" class="form-control" value="278-238274-6" required readonly>
        </div>

        <div class="form-group mt-3">
            <label for="address">Shipping Address</label>
            <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
        </div>

        <div class="form-group mt-3">
            <label for="receipt">Upload Payment Receipt</label>
            <input type="file" name="receipt" id="receipt" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Checkout</button>
        <a href="cart.php" class="btn btn-secondary mt-3">Back to Cart</a>
    </form>
</div>
</body>
</html>
