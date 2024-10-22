<?php

if (isset($_GET['pid'])) {
    include("connectdb.php");
    $pid = intval($_GET['pid']);

    // ดึงชื่อไฟล์รูปภาพจากฐานข้อมูล
    $sql = "SELECT p_picture FROM product WHERE p_id = '{$pid}'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        // ลบข้อมูลออกจากฐานข้อมูล
        $delete_sql = "DELETE FROM product WHERE p_id = '{$pid}'";
        if (mysqli_query($conn, $delete_sql)) {
            // ถ้าลบข้อมูลสำเร็จ ลบไฟล์รูปภาพ
            $image_path = "images/" . $data['p_picture'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
            echo "<script>";
            echo "alert('ลบข้อมูลสินค้าสำเร็จ');";
            echo "window.location='home2.php';";
            echo "</script>";
        } else {
            echo "ไม่สามารถลบข้อมูลสินค้าได้: " . mysqli_error($conn);
        }
    } else {
        echo "ไม่พบข้อมูลสินค้า";
    }

    mysqli_close($conn);
}
?>
