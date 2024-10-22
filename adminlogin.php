<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
       * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: url('images/bg.jpg') no-repeat center center fixed; /* Update the image path */
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
    <?php 
        include("connectdb.php");

        if (isset($_POST['submit'])) {
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            // Query to check the user account for admin only
            $userResult = mysqli_query($conn, "SELECT * FROM userdb WHERE Email='$email' AND Password='$password' AND user_type='admin'") or die("Select Error");
            $userRow = mysqli_fetch_assoc($userResult);      

            if (is_array($userRow) && !empty($userRow)) {
                // Setting session variables
                $_SESSION['valid'] = $userRow['Email'];
                $_SESSION['username'] = $userRow['Username'];
                $_SESSION['age'] = $userRow['Age'];
                $_SESSION['id'] = $userRow['Id']; // Save user ID in session
                $_SESSION['uname'] = $userRow['uname'];

                // Redirect to admin home page (home2)
                header("Location: home2.php"); 
                exit();
            } else {
                echo "<div class='message'>
                        <p>Wrong Username or Password or Not an Admin</p>
                    </div>";
                echo "<a href='index.php'><button class='btn'>Go Back</button></a>";
            }
        }
    ?>
      <header>Login</header>
      <form action="" method="post">
        <div class="field input">
          <label for="email">อีเมล</label>
          <input type="text" name="email" id="email" autocomplete="off" required>
        </div>

        <div class="field input">
          <label for="password">รหัสผ่าน</label>
          <input type="password" name="password" id="password" autocomplete="off" required>
        </div>
        <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Remember me
            </label>
        </div>
        <div class="field submit">
          <input type="submit" class="btn" name="submit" value="Login" required>
        </div>
      </form>
    </div>
  </div>
</body>

</html>
