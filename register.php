<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>เข้าสู่ระบบ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    /* รีเซ็ตสไตล์พื้นฐาน */
body, h1, h2, h3, p {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f0f2f5; /* สีพื้นหลังที่สว่าง */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* ความสูงทั้งหมด */
}

/* คอนเทนเนอร์สำหรับฟอร์ม */
.container {
    background-color: white; /* สีพื้นหลังสีขาวสำหรับฟอร์ม */
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px; /* จำกัดความกว้างของฟอร์ม */
    padding: 30px; /* เพิ่ม padding สำหรับระยะห่างที่ดีกว่า */
}

/* สไตล์ฟอร์ม */
.box {
    text-align: center; /* จัดให้อยู่กลาง */
}

/* สไตล์หัวข้อ */
header {
    font-size: 28px; /* ขนาดฟอนต์สำหรับหัวข้อ */
    margin-bottom: 25px; /* ระยะห่างด้านล่างหัวข้อ */
    color: #333; /* สีเข้มสำหรับหัวข้อ */
}

/* ช่องกรอกข้อมูล */
.field {
    margin-bottom: 20px; /* ระยะห่างระหว่างช่อง */
}

.field label {
    display: block; /* การแสดงผลแบบบล็อกสำหรับป้าย */
    margin-bottom: 5px; /* ระยะห่างด้านล่างป้าย */
    font-weight: 500; /* น้ำหนักฟอนต์สำหรับป้าย */
}

/* ช่องกรอกข้อมูล */
.field input {
    width: 100%; /* ความกว้างเต็มที่ */
    padding: 10px; /* Padding ในช่องกรอก */
    border: 1px solid #ccc; /* เส้นขอบสีเทา */
    border-radius: 4px; /* มุมโค้ง */
    outline: none; /* เอาเส้นขอบออกเมื่อเลือก */
}

/* สไตล์ปุ่ม */
.btn {
    background-color: #4c44b6; /* สีพื้นหลังของปุ่ม */
    color: white; /* สีข้อความในปุ่ม */
    border: none; /* ไม่มีเส้นขอบ */
    border-radius: 4px; /* มุมโค้ง */
    padding: 10px; /* Padding ในปุ่ม */
    cursor: pointer; /* แสดงเป็นตัวชี้เมื่อวางเมาส์ */
    transition: background-color 0.3s; /* เพิ่มเอฟเฟกต์การเปลี่ยนสี */
}

/* เอฟเฟกต์การเลื่อนเมาส์ */
.btn:hover {
    background-color: #3e3b93; /* เปลี่ยนสีเมื่อวางเมาส์ */
}

/* ลิงค์ */
.links {
    margin-top: 10px; /* ระยะห่างด้านบน */
}

/* สไตล์ข้อความข้อผิดพลาด */
.message {
    color: red; /* สีแดงสำหรับข้อความข้อผิดพลาด */
    margin-top: 10px; /* ระยะห่างด้านบน */
}
</style>
</head>

<body>
    <div class="container">
        <div class="box">
            <?php 
            include("connectdb.php");
            if (isset($_POST['submit'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                // แฮชรหัสผ่านด้วย MD5
                $hashed_password = md5($password);

                // ตรวจสอบข้อมูลผู้ใช้
                $stmt = $conn->prepare("SELECT * FROM userdb WHERE Email=? AND password=?");
                $stmt->bind_param("ss", $email, $hashed_password);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $_SESSION['u_id'] = $row['u_id'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: home.php");
                    exit();
                } else {
                    echo "<p class='message'>อีเมลหรือรหัสผ่านไม่ถูกต้อง!</p>";
                }
                $stmt->close();
            }
            ?>
            <header>เข้าสู่ระบบ</header>
            <form action="" method="post">
                <div class="field">
                    <label for="email">อีเมล</label>
                    <input type="text" name="email" id="email" required>
                </div>
                <div class="field">
                    <label for="password">รหัสผ่าน</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <input type="submit" class="btn" name="submit" value="เข้าสู่ระบบ">
                <div class="links">
                    ยังไม่มีบัญชี? <a href="register.php">ลงทะเบียนที่นี่</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
