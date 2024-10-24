<?php 
include("connectdb.php"); // เชื่อมต่อกับฐานข้อมูล
session_start(); // เริ่ม session

if (isset($_POST['submit'])) {
    $u_name = $_POST['u_name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $password = $_POST['password'];
    $user_type = 'user'; // กำหนด user_type เป็น "user"

    // แฮชรหัสผ่านด้วย MD5
    $hashed_password = md5($password);

    // ตรวจสอบอีเมลที่ไม่ซ้ำกัน
    $stmt = $conn->prepare("SELECT Email FROM userdb WHERE Email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows != 0) {
        $message = "อีเมลนี้ถูกใช้งานแล้ว กรุณาลองอีกครั้ง!";
    } else {
        // เพิ่มผู้ใช้ใหม่
        $insert_stmt = $conn->prepare("INSERT INTO userdb (username, Email, Age, password, user_type) VALUES (?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("ssiss", $u_name, $email, $age, $hashed_password, $user_type);

        if ($insert_stmt->execute()) {
            $message = "ลงทะเบียนสำเร็จ!";
            // รีเซ็ตค่าฟอร์ม
            $_POST = array();
        } else {
            $message = "เกิดข้อผิดพลาดในการลงทะเบียน กรุณาลองอีกครั้ง.";
        }
        $insert_stmt->close();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>สมัครสมาชิก</title>
    <style>
        /* สไตล์ทั่วไป */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 30px;
        }

        header {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        .field {
            margin-bottom: 15px;
        }

        .field label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .field input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
        }

        .btn {
            background-color: #4c44b6;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #3e3b93;
        }

        .links {
            margin-top: 10px;
            text-align: center;
        }

        .message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>สมัครสมาชิก</header>
        <form action="" method="post">
            <div class="field">
                <label for="u_name">ชื่อผู้ใช้</label>
                <input type="text" name="u_name" id="u_name" value="<?php echo isset($_POST['u_name']) ? htmlspecialchars($_POST['u_name']) : ''; ?>" required>
            </div>
            <div class="field">
                <label for="email">อีเมล</label>
                <input type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div class="field">
                <label for="age">อายุ</label>
                <input type="number" name="age" id="age" value="<?php echo isset($_POST['age']) ? htmlspecialchars($_POST['age']) : ''; ?>" required>
            </div>
            <div class="field">
                <label for="password">รหัสผ่าน</label>
                <input type="password" name="password" id="password" required>
            </div>
            <input type="submit" class="btn" name="submit" value="ลงทะเบียน">
            <div class="links">
                เป็นสมาชิกแล้ว? <a href="index.php">เข้าสู่ระบบที่นี่</a>
            </div>
            <?php if (isset($message)) { ?>
                <div class="message"><?php echo $message; ?></div>
            <?php } ?>
        </form>
    </div>
</body>
</html>
