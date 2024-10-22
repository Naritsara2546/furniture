<?php
session_start();
include_once("connectdb.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$username = $_SESSION['username']; // Retrieve the username from the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the cart is empty
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        header("Location: cart.php"); // Redirect if the cart is empty
        exit();
    }

    // Capture the address from the payment form
    $address = $_POST['address']; // Retrieve the address

    // Fetch the user's u_id
    $sql_user_check = "SELECT u_id FROM userdb WHERE username = ?";
    $stmt_user_check = $conn->prepare($sql_user_check);
    $stmt_user_check->bind_param("s", $username);
    $stmt_user_check->execute();
    $result_user_check = $stmt_user_check->get_result();

    if ($result_user_check->num_rows == 0) {
        die("User not found in the system.");
    } else {
        $user_data = $result_user_check->fetch_assoc();
        $u_id = $user_data['u_id']; // Get the u_id of the logged-in user
    }
    $stmt_user_check->close();

    // Calculate total price from the cart
    $total_price = 0;
    $order_items = []; // Array to store order items for database

    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        $sql = "SELECT p_price FROM product WHERE p_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $total_price += $product['p_price'] * $quantity;
            $order_items[] = [
                'product_id' => $product_id,
                'quantity' => $quantity,
                'p_price' => $product['p_price'], // Store the product price
            ];
        }
        $stmt->close();
    }

    // Insert order into the database
            // แทรกคำสั่งลงในฐานข้อมูล
            $stmt = $conn->prepare("INSERT INTO orders (ototal, odate, u_id, username, address) VALUES (?, NOW(), ?, ?, ?)");
            $stmt->bind_param("diss", $total_price, $u_id, $username, $address); // แก้ไขสตริงประเภท
            $stmt->execute();
            $order_id = $stmt->insert_id; // รับ ID ของคำสั่งซื้อที่เพิ่งแทรก
            $stmt->close();


        // Insert order items
        foreach ($order_items as $item) {
            $stmt = $conn->prepare("INSERT INTO orders_detail (oid, p_id, item, p_price, u_id, address) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiiiss", $order_id, $item['product_id'], $item['quantity'], $item['p_price'], $u_id, $address);
            $stmt->execute();
            $stmt->close();
        }

    // Clear the cart after checkout
    unset($_SESSION['cart']);

    // Display success message
    $success_message = "Payment successful. Your order is being processed.";
} else {
    // Redirect back to the payment page if accessed directly
    header("Location: payment.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Success</title>
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
            color: #007bff;
        }
        p {
            font-size: 1.5rem;
            color: #28a745; /* Green color for success */
        }
    </style>
    <script>
        // Redirect to home after 5 seconds
        setTimeout(function() {
            window.location.href = "home.php";
        }, 5000);
    </script>
</head>
<body>
<div class="container">
    <h1>Checkout Successful</h1>
    <?php if (isset($success_message)): ?>
        <p><?php echo $success_message; ?></p>
    <?php else: ?>
        <p>Something went wrong. Please try again.</p>
    <?php endif; ?>
</div>
</body>
</html>
