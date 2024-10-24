<?php
include_once("checklogin.php");
include_once("connectdb.php");

// Fetch product details based on p_id from the URL
$p_id = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
$sql1 = "SELECT * FROM product WHERE p_id = '{$p_id}'";
$rs1 = mysqli_query($conn, $sql1);
$data1 = mysqli_fetch_array($rs1);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>furnitureshop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            background-color: #fff;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], textarea, select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="file"] {
            margin-bottom: 10px;
        }
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        hr {
            border: 1px solid #eaeaea;
            margin: 20px 0;
        }
        .form-label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
    </style>
</head>
<body>
<h1>furnitureshop</h1>

<form method="post" action="" enctype="multipart/form-data">
    ชื่อสินค้า <input type="text" name="pname" required autofocus value="<?= htmlspecialchars($data1['p_name']); ?>"><br>
    รายละเอียดสินค้า<br>
    <textarea name="pdetail" rows="5" cols="50"><?= htmlspecialchars($data1['p_detail']); ?></textarea><br>
    ราคา <input type="text" name="pprice" required value="<?= htmlspecialchars($data1['p_price']); ?>"><br>
    รูปภาพ <input type="file" name="pimg"><br>
    ประเภทสินค้า 
    <select name="pt_id" required>
    <?php
    $sql2 = "SELECT * FROM `product_type` ORDER BY pt_name ASC";
    $rs2 = mysqli_query($conn, $sql2);
    while ($data2 = mysqli_fetch_array($rs2)) {
    ?>
        <option value="<?= $data2['pt_id']; ?>" <?= ($data1['pt_id'] == $data2['pt_id']) ? "selected" : ""; ?>><?= htmlspecialchars($data2['pt_name']); ?></option>
    <?php } ?>
    </select>
    <br><br>
    <button type="submit" name="Submit"> บันทึก </button>
</form> 
<hr>

<?php
if (isset($_POST['Submit'])) {
    $p_name = mysqli_real_escape_string($conn, $_POST['pname']);
    $p_detail = mysqli_real_escape_string($conn, $_POST['pdetail']);
    $p_price = floatval($_POST['pprice']);
    $pt_id = intval($_POST['pt_id']);

    if (empty($_FILES['pimg']['name'])) {
        // Update without changing the image
        $sql = "UPDATE product SET p_name = '{$p_name}', p_detail = '{$p_detail}', p_price = '{$p_price}', pt_id = '{$pt_id}' WHERE p_id = '{$p_id}'";
    } else {
        // Update with a new image
        $old_image = $data1['p_picture'];
        $file_name = $_FILES['pimg']['name'];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_image_name = "{$p_id}_" . time() . ".{$ext}";

        // Delete the old image if it exists
        if (!empty($old_image) && file_exists("images/{$old_image}")) {
            unlink("images/{$old_image}");
        }

        // Update with new image name
        $sql = "UPDATE product SET p_name = '{$p_name}', p_detail = '{$p_detail}', p_price = '{$p_price}', pt_id = '{$pt_id}', p_picture = '{$new_image_name}' WHERE p_id = '{$p_id}'";

        // Move the uploaded file
        move_uploaded_file($_FILES['pimg']['tmp_name'], "images/{$new_image_name}");
    }

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('แก้ไขข้อมูลสินค้าสำเร็จ'); window.location='home2.php';</script>";
    } else {
        echo "แก้ไขข้อมูลสินค้าไม่สำเร็จ: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
</body>
</html>
