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
            background: url('images/bg.jpg') no-repeat center center fixed;
            background-size: cover;
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
                $u_name = $_POST['u_name'];
                $email = $_POST['email'];
                $age = $_POST['age'];
                $password = $_POST['password'];
                $user_type = 'user'; // Set user_type to "user"

                // Hash the password using MD5
                $hashed_password = md5($password);

                // Verifying the unique email
                $stmt = $conn->prepare("SELECT Email FROM userdb WHERE Email=?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows != 0) {
                    echo "<div class='message'>
                              <p>This email is used, Try another One Please!</p>
                          </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                } else {
                    // Insert the new user
                    $insert_stmt = $conn->prepare("INSERT INTO userdb (username, Email, Age, password, user_type) VALUES (?, ?, ?, ?, ?)");
                    $insert_stmt->bind_param("ssiss", $u_name, $email, $age, $hashed_password, $user_type);

                    if ($insert_stmt->execute()) {
                        echo "<div class='message'>
                                  <p>Registration successfully!</p>
                              </div> <br>";
                        echo "<a href='index.php'><button class='btn'>Login Now</button>";
                    } else {
                        echo "<div class='message'>
                                  <p>Error occurred during registration. Please try again.</p>
                              </div>";
                    }
                    $insert_stmt->close();
                }
                $stmt->close();
            } else {
            ?>
                <header>Sign Up</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="u_name">Username</label>
                        <input type="text" name="u_name" id="u_name" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>

                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="Register" required>
                    </div>
                    <div class="links">
                        Already a member? <a href="index.php">Login Here</a>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>
