<?php
session_start();
include("connectdb.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    die("กรุณาเข้าสู่ระบบก่อนทำการดูรายละเอียดคำสั่งซื้อ");
}

// Check if the order ID is set in the URL and validate it
if (!isset($_GET['a']) || !is_numeric($_GET['a'])) {
    die("เลขที่ใบสั่งซื้อไม่ถูกต้อง");
}

$od_id = intval($_GET['a']);

// Fetch order details using prepared statements
$sql = "SELECT od.item, p.p_name, p.p_price, o.address FROM orders_detail od
        JOIN product p ON od.p_id = p.p_id
        JOIN orders o ON od.oid = o.oid
        WHERE od.oid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $od_id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

if ($result->num_rows == 0) {
    die("ไม่พบเลขที่ใบสั่งซื้อ");
}

$order_details = $result->fetch_assoc(); // Fetch the first row for address
$address = htmlspecialchars($order_details['address']); // Store address
?>

<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>รายละเอียดคำสั่งซื้อ</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/background.jpg') no-repeat center center fixed; 
            background-size: cover;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9); 
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #dee2e6;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9ecef;
        }
        .btn-primary {
            display: inline-block;
            padding: 10px 20px;
            margin: auto;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-top: 20px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>รายละเอียดคำสั่งซื้อ</h2>
    
    <p><strong>ที่อยู่การจัดส่ง:</strong> <?php echo $address; ?></p> <!-- Display address -->

    <table>
        <thead>
            <tr>
                <th>ชื่อสินค้า</th>
                <th>ราคา</th>
                <th>จำนวน</th> <!-- New column for quantity -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Reset the result pointer to fetch again for the table
            $result->data_seek(0);
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['p_name']); ?></td>
                    <td><?php echo number_format($row['p_price'], 2); ?> บาท</td>
                    <td><?php echo htmlspecialchars($row['item']); ?></td> <!-- Display quantity -->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="orderhistoryuser.php" class="btn-primary">กลับไปยังประวัติการสั่งซื้อ</a>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
