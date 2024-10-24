<?php 
session_start();
include("connectdb.php");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $password = $_POST['password'];
    $user_type = 'user'; // Set user_type to "user"

    // Verifying the unique email
    $verify_query = mysqli_query($conn, "SELECT Email FROM users WHERE Email='$email'");

    if (mysqli_num_rows($verify_query) != 0) {
        echo "<div class='message'>
                  <p>This email is already in use. Please try another one!</p>
              </div> <br>";
        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
    } else {
        // Inserting user data into the database
        mysqli_query($conn, "INSERT INTO userdb(username, Email, Age, password, user_type) VALUES('$username', '$email', '$age', '$password', '$user_type')") or die("Error Occurred");

        echo "<div class='message'>
                  <p>Registration successful!</p>
              </div> <br>";
        
        // Redirect to display_users.php after successful registration
        header("Location: index.php");
        exit();
    }
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: url('images/back.jpg') no-repeat center center fixed; /* Update the image path */
            background-size: cover; /* Ensures the image covers the entire background */
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 90vh;
        }

        .box {
            background: #fdfdfd;
            display: flex;
            flex-direction: column;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 0 128px 0 rgba(0, 0, 0, 0.1),
                        0 32px 64px -48px rgba(0, 0, 0, 0.5);
        }

        .form-box {
            width: 100%;
            max-width: 450px;
            margin: 0 10px;
        }

        .form-box header {
            font-size: 25px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 1px solid #e6e6e6;
            margin-bottom: 20px; 
        }

        .form-box form .field {
            display: flex;
            margin-bottom: 15px; 
            flex-direction: column;
        }

        .form-box form .input input {
            height: 45px; 
            width: 100%;
            font-size: 16px;
            padding: 0 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-box form .input input:focus {
            border-color: #4c44b6; 
        }

        .btn {
            height: 40px; 
            background: rgba(76, 68, 182, 0.808);
            border: 0;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: all .3s ease;
            margin-top: 10px;
            padding: 0 10px;
        }

        .btn:hover {
            opacity: 0.85;
            background-color: #4c44b6; 
        }

        .submit {
            width: 100%;
        }

        .links {
            margin-bottom: 15px;
        }

        .message {
            text-align: center;
            background: #f9eded;
            padding: 15px 0;
            border: 1px solid #c71a1a; 
            border-radius: 5px;
            margin-bottom: 20px; 
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">ชื่อ-สกุล</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">อีเมล</label>
                    <input type="text" name="email" id="Email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="age">อายุ</label>
                    <input type="number" name="age" id="Age" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">รหัสผ่าน</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                <div class="links">
                    เป็นสมาชิกอยู่แล้ว? <a href="index.php">เข้าสู่ระบบ</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php } ?>
