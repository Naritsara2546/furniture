<?php
		
        include_once("checklogin.php");
		include_once("connectdb.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FurnitureShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" hrel="http://cnd.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        *{          
            font-family: "Jost", sans-serif;
        }
        .h-font{
            font-family: "Playfair Display", serif;
        }
        .main-content{
            width: 100%;
            height: 90vh;
            background-image: url(images/1.png);
            background-size: cover;
            background-position: 70%;
        }
        .body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .product-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
                }

        .product-image img {
            width: 300px;
            height: auto;
            margin-right: 50px;
        }

        form {
            display: flex;
            align-items: center;
        }
        .icon-large {
        font-size: 1.5rem; /* Adjust the size as needed */
        }
        .navbar-nav .nav-item {
          margin-top: 10px; /* Adjust the value as needed */
          margin-bottom: 10px; /* Adjust the value as needed */
        }
        .card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 10px; /* เพิ่มความโค้งมนให้การ์ด */
}

.card:hover {
    transform: translateY(-10px); /* ทำให้การ์ดลอยขึ้นเมื่อเลื่อนเมาส์ */
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
}

.card-img-top {
    transition: transform 0.3s ease;
    border-radius: 10px 10px 0 0; /* เพิ่มความโค้งมนให้ภาพสินค้า */
}

.card:hover .card-img-top {
    transform: scale(1.05); /* ขยายภาพเล็กน้อยเมื่อเลื่อนเมาส์ */
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
    <a class="nav-link mb-2" href="insert.php">Insert</a>
    </li>
    <li class="nav-item">
            <a class="nav-link mb-2" href="orderhistory.php">orderhistory</a>
        </li>
    <li class="nav-item">
    <a class="nav-link mb-2" href="edituser.php">Edituser</a>
    </li>
      </ul>
      <ul class="navbar-nav ml-auto"> 
      <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link mb-2" href="user.php">User:<?php echo htmlspecialchars($_SESSION['username']); ?></span></a>
        </li>
    </ul>
        
    </div>
  </div>
</nav>



            <!-- Main content area -->
            
                
                <!-- Search Form -->
<form method="GET" action="" class="mb-4">
    <div class="input-group">
        <input type="text" class="form-control" name="search" placeholder="Search product by name..." aria-label="Search products by name">
        <button class="btn btn-dark" type="submit">Search</button>
    </div>
</form>

<div class="row">
    <?php
    // Initialize search variable
    $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

    // Check if 'pt' is set in the GET request
    if (isset($_GET['pt']) || !empty($searchQuery)) {
        // Initialize the product query
        $query = "SELECT * FROM product WHERE 1=1";

        // Add product type filtering
        if (isset($_GET['pt'])) {
            $selectedTypes = $_GET['pt'];
            $typesList = implode(',', array_map('intval', $selectedTypes));
            $query .= " AND pt_id IN ($typesList)";
        }

        // Add search filtering on p_name
        if (!empty($searchQuery)) {
            $query .= " AND p_name LIKE '%$searchQuery%'";
        }

        $query_product = mysqli_query($conn, $query);

        if ($query_product && mysqli_num_rows($query_product) > 0) {
            while ($product = mysqli_fetch_assoc($query_product)) {
                ?>
                <div class="col-md-3 mb-4">
                    <a href="detailproduct3.php?p_id=<?= $product['p_id']; ?>" class="text-decoration-none text-dark">
                        <div class="card h-100">
                            <img src="images/<?= $product['p_picture']; ?>" class="card-img-top" alt="<?= htmlspecialchars($product['p_name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['p_name']); ?></h5>
                                <h6>ราคา: <?= number_format($product['p_price'], 0) . ' บาท'; ?></h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="update.php?pid=<?= $product['p_id']; ?>" class="btn btn-sm btn-info">แก้ไข</a>
                                        <a href="delete_product.php?pid=<?= $product['p_id']; ?>&ext=<?= $product['p_picture']; ?>" onClick="return confirm('ยืนยันการลบ');" class="btn btn-sm btn-danger">ลบ</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
            }
        } else {
            echo "<p>No products found matching your criteria.</p>";
        }
    }
    ?>
</div>







  <?php
  // Assuming connection code from above is already included

  // Get product details from the database
  $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

  // SQL query to search for products
  $sql = "SELECT product.p_id, product.p_name, product.p_detail, product.p_price, product.p_picture, product_type.pt_name 
          FROM product 
          JOIN product_type ON product.pt_id = product_type.pt_id
          WHERE product.p_name LIKE '%$search%'";

    $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      $product = $result->fetch_assoc();
  } else {
      echo "Product not found.";
      exit;
  }
  ?>

<div class="container mt-5" id="product-section">
    <div class="row">
        <?php
        // Query to get all products
        $sql = "SELECT product.p_id, product.p_name, product.p_detail, product.p_price, product.p_picture, product_type.pt_name 
                FROM product 
                JOIN product_type ON product.pt_id = product_type.pt_id";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
    // Loop to display all products
    while ($product = $result->fetch_assoc()) {
        ?>
        <div class="col-md-3 mb-4">
            <a href="detailproduct3.php?p_id=<?php echo $product['p_id']; ?>" class="text-decoration-none text-dark">
                <div class="card h-100">
                    <img src="images/<?php echo $product['p_picture']; ?>" class="card-img-top" alt="<?php echo $product['p_name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['p_name']; ?></h5>
                        <h6>ราคา: <?php echo number_format($product['p_price'], 0) . ' บาท'; ?></h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="update.php?pid=<?php echo $product['p_id']; ?>" class="btn btn-sm btn-info">แก้ไข</a>
                                <a href="delete_product.php?pid=<?php echo $product['p_id']; ?>&ext=<?php echo $product['p_picture']; ?>" onClick="return confirm('ยืนยันการลบ');" class="btn btn-sm btn-danger">ลบ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
                <?php
            }
        } else {
            echo "No products found.";
        }
        ?>
    </div>
</div>


  <footer class="bg-dark text-white text-center p-4">
        <p>&copy; FurnitureShop. All rights reserved.</p>
    </footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
