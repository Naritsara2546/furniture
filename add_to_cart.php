<?php
session_start();
include_once("connectdb.php");

// Check if product ID is set
if (isset($_POST['p_id'])) {
    $product_id = (int)$_POST['p_id'];

    // Check if cart session variable is set; if not, create an empty array
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if product is already in cart; if so, increase quantity
    if (array_key_exists($product_id, $_SESSION['cart'])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        // If not, add product to cart with quantity 1
        $_SESSION['cart'][$product_id] = 1;
    }
    // Redirect back to the product page
    header("Location: home.php");
    exit();
} else {
    // Redirect back if no product ID is found
    header("Location: home.php");
    exit();
}
?>
