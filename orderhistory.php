<?php
include_once("checklogin.php");
include_once("connectdb.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$username = $_SESSION['username']; // Retrieve the username from the session

// Fetch the user's u_id and user_type
$sql_user_check = "SELECT u_id, user_type FROM userdb WHERE username = ?";
$stmt_user_check = $conn->prepare($sql_user_check);
$stmt_user_check->bind_param("s", $username);
$stmt_user_check->execute();
$result_user_check = $stmt_user_check->get_result();

if ($result_user_check->num_rows == 0) {
    die("User not found in the system.");
} else {
    $user_data = $result_user_check->fetch_assoc();
    $u_id = $user_data['u_id']; // Get the u_id of the logged-in user
    $is_admin = ($user_data['user_type'] == 'admin'); // Check if the user is an admin
}
$stmt_user_check->close();

// Fetch orders based on user type
if ($is_admin) {
    // Admin can see orders for all users
    $sql_orders = "SELECT o.oid, o.odate, o.ototal, u.username FROM orders AS o JOIN userdb AS u ON o.u_id = u.u_id ORDER BY o.oid DESC";
} else {
    // Regular user can only see their own orders
    $sql_orders = "SELECT o.oid, o.odate, o.ototal FROM orders AS o WHERE o.u_id = ? ORDER BY o.oid DESC";
}

// Prepare and execute the order query
$stmt_orders = $conn->prepare($sql_orders);
if ($is_admin) {
    $stmt_orders->execute(); // No binding necessary for admin query
} else {
    $stmt_orders->bind_param("i", $u_id); // Use u_id to fetch orders for regular user
    $stmt_orders->execute();
}
$rs_orders = $stmt_orders->get_result();
?>

<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>ประวัติการสั่งซื้อ</title>
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }
        table {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
        }
        th {
            background-color: #343a40;
            color: #fff;
            font-weight: 600;
        }
        td {
            color: #495057;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #e9ecef;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #dc3545; /* Red for no data */
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            font-size: 14px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h1>ประวัติการสั่งซื้อ</h1>

<table>
    <thead>
        <tr>
            <th>หมายเลขคำสั่งซื้อ</th>
            <th>วันที่</th>
            <th>ราคารวม</th>
            <?php if ($is_admin): ?>
                <th>ผู้สั่งซื้อ</th>
            <?php endif; ?>
            <th>รายละเอียด</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($rs_orders->num_rows > 0): ?>
            <?php while ($order = $rs_orders->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['oid']); ?></td>
                    <td><?php echo date('d-m-Y', strtotime($order['odate'])); ?></td>
                    <td><?php echo number_format($order['ototal'], 2); ?> บาท</td>
                    <?php if ($is_admin): ?>
                        <td><?php echo htmlspecialchars($order['username']); ?></td>
                    <?php endif; ?>
                    <td>
                        <a href="orderdetailadmin.php?a=<?php echo $order['oid']; ?>" class="btn">ดูรายละเอียด</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="<?php echo $is_admin ? '4' : '3'; ?>" class="no-data">ไม่มีประวัติการสั่งซื้อ</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<div style="text-align: center;">
    <a href="home2.php" class="btn">กลับ</a>
</div>
</body>
</html>

<?php
mysqli_close($conn); // Close database connection
?>
