<?php
// รวมการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "2580pA"; // Empty password if not set
$dbname = "furnitureshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// ตอนนี้สามารถรันคำสั่ง SQL ได้
$product_id = 1; // รหัสสินค้าตัวอย่าง
$sql = "SELECT * FROM product WHERE p_id = $product_id";

$result = $conn->query($sql);
?>
