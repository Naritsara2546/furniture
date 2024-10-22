<?php
include_once("checklogin.php");
?>

<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>เพิ่มสินค้า</title>
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
    <h1>เพิ่มสินค้า</h1>

    <form method="post" action="" enctype="multipart/form-data">
        ชื่อสินค้า <input type="text" name="pname" required autofocus><br>
        รายละเอียดสินค้า<br>
        <textarea name="pdetail" rows="5" cols="50"></textarea><br>
        ราคา <input type="text" name="pprice" required><br>
        รูปภาพ <input type="file" name="pimg" required><br>
        ประเภทสินค้า 
        <select name="pcat">
        <?php	
        include_once("connectdb.php");
        $sql2 = "SELECT * FROM `product_type` ORDER BY pt_name ASC ";
        $rs2 = mysqli_query($conn, $sql2);
        while ($data2 = mysqli_fetch_array($rs2)) {
        ?>
            <option value="<?=$data2['pt_id'];?>"><?=$data2['pt_name'];?></option>
        <?php } ?>
        </select>
        <br><br>
        <button type="submit" name="Submit"> เพิ่ม </button>
    </form>
    <hr>

    <?php
    if (isset($_POST['Submit'])) {
        // ตรวจสอบรูปภาพ
        $file_name = $_FILES['pimg']['name'];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);

        // SQL INSERT
        $sql = "INSERT INTO `product` (`p_id`, `p_name`, `p_detail`, `p_price`, `p_picture`, `pt_id`) 
                VALUES (NULL, '{$_POST['pname']}', '{$_POST['pdetail']}', '{$_POST['pprice']}', '{$file_name}', '{$_POST['pcat']}');";
        
        if (mysqli_query($conn, $sql)) {
            $idauto = mysqli_insert_id($conn);
            move_uploaded_file($_FILES['pimg']['tmp_name'], "images/" . $idauto . "." . $ext);
            echo "<script>alert('เพิ่มข้อมูลสินค้าสำเร็จ'); window.location='home2.php';</script>";
        } else {
            echo "เพิ่มข้อมูลสินค้าไม่สำเร็จ: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
    ?>
</body>
</html>
