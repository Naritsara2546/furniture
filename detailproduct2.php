<?php
session_start();
include_once("connectdb.php"); // Include database connection

// Get product ID from URL
$product_id = isset($_GET['p_id']) ? (int)$_GET['p_id'] : 0; // Default to 0 if not set

// Query to get product details
$sql = "SELECT product.p_name, product.p_detail, product.p_price, product.p_picture, product_type.pt_name 
        FROM product 
        JOIN product_type ON product.pt_id = product_type.pt_id 
        WHERE product.p_id = $product_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc(); // Fetch product details
} else {
    echo "Product not found.";
    exit; // Exit if product not found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['p_name']; ?> - FurnitureShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">    
    <style>
    * {
        font-family: "Jost", sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        background-color: #f0f2f5;
        color: #333;
    }
    .h-font {
        font-family: "Playfair Display", serif;
    }
    .navbar {
        background-color: #fff;
    }
    .navbar-brand {
        color: #343a40 !important;
        text-transform: uppercase;
    }
    .navbar-brand:hover {
        color: #007bff !important;
    }
    .nav-link {
        color: #555;
        font-size: 1rem;
        margin: 0 10px;
        padding: 5px 10px;
        text-transform: uppercase;
        transition: color 0.3s ease;
    }
    .nav-link:hover {
        color: #007bff;
    }
    .product-detail {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .product-image {
        width: 100%;
        max-width: 500px;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .carousel {
        max-width: 500px;
        margin: 20px auto;
    }
    .carousel-control-prev, .carousel-control-next {
        width: 8%;
    }
    .carousel-control-prev-icon, .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        padding: 15px;
    }
    .product-detail h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
        font-weight: 700;
    }
    .product-detail h6 {
        font-size: 1.2rem;
        margin-bottom: 20px;
        color: #28a745;
    }
    .product-detail p {
        line-height: 1.7;
        font-size: 1rem;
        color: #555;
    }
    .product-detail .btn {
        background-color: #343a40;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-transform: uppercase;
        transition: background-color 0.3s ease;
    }
    .product-detail .btn:hover {
        background-color: #007bff;
        color: #fff;
    }
</style>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="home.php">FurnitureShop</a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2" href="#product-section">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2" href="#">Type</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2" href="#">Reference</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mb-2" href="#">About</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container product-detail mt-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Carousel -->
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- Image 1 -->
                    <div class="carousel-item active">
                        <img src="images/<?php echo $product['p_picture']; ?>" class="d-block w-100 product-image" alt="<?php echo $product['p_name']; ?>">
                    </div>
                    <!-- Image 2 -->
                    <div class="carousel-item">
                        <img src="images/<?php echo $product['p_picture']; ?>" class="d-block w-100 product-image" alt="<?php echo $product['p_name']; ?> 2">
                    </div>
                    <!-- Add more images as needed -->
                </div>
                <!-- Carousel controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-md-6">
            <h1><?php echo $product['p_name']; ?></h1>
            <h6>ราคา: <?php echo number_format($product['p_price'], 2) . ' บาท'; ?></h6>
            <p>Category: <?php echo $product['pt_name']; ?></p>
            <h4>Details</h4>
            <p><?php echo nl2br($product['p_detail']); ?></p>
            <a href="home.php" class="btn btn-dark">Back to Products</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
