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
    /* Reset some default styles */
body, h1, h2, h3, p {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #f0f2f5; /* Light background color */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Full height */
}

/* Container for the form */
.container {
    background-color: white; /* White background for the form */
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px; /* Limit the width of the form */
    padding: 30px; /* Increase padding for better spacing */
}

/* Form box styles */
.box {
    text-align: center; /* Center the text */
}

/* Header style */
header {
    font-size: 28px; /* Slightly larger font size for the header */
    margin-bottom: 25px; /* Space below the header */
    color: #333; /* Darker color for the header */
}

/* Input fields */
.field {
    margin-bottom: 20px; /* Increased space between fields */
}

.field label {
    display: block; /* Block display for labels */
    margin-bottom: 5px; /* Space below the label */
    font-weight: 500; /* Bold text for labels */
}

.field input {
    width: 100%; /* Full width input */
    padding: 10px; /* Padding inside inputs */
    border: 1px solid #ddd; /* Light border */
    border-radius: 5px; /* Rounded corners */
    font-size: 16px; /* Font size for input text */
    transition: border-color 0.3s; /* Smooth transition for border color */
}

.field input:focus {
    border-color: #007bff; /* Change border color on focus */
    outline: none; /* Remove default outline */
}

/* Submit button */
.field.submit input {
    background-color: #007bff; /* Primary button color */
    color: white; /* White text color */
    border: none; /* Remove border */
    cursor: pointer; /* Change cursor on hover */
    padding: 12px; /* Add padding for a more prominent button */
    font-size: 16px; /* Consistent font size */
    transition: background-color 0.3s; /* Smooth transition */
}

.field.submit input:hover {
    background-color: #0056b3; /* Darker blue on hover */
}

/* Links */
.links {
    margin-top: 10px; /* Space above links */
}

.links a {
    color: #007bff; /* Primary link color */
    text-decoration: none; /* Remove underline */
    transition: color 0.3s; /* Smooth transition for color */
}

.links a:hover {
    color: #0056b3; /* Darker blue on hover */
}

/* Message styling */
.message {
    color: red; /* Red color for error messages */
    margin-bottom: 10px; /* Space below messages */
}

.welcome-message {
    margin-bottom: 20px; /* Space below welcome message */
    color: green; /* Green color for welcome messages */
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

            // Query to check the user account
            $userResult = mysqli_query($conn, "SELECT * FROM userdb WHERE Email='$email' AND Password='$password'") or die("Select Error");
            $userRow = mysqli_fetch_assoc($userResult);      

            if (is_array($userRow) && !empty($userRow)) {
                // Setting session variables
                $_SESSION['valid'] = $userRow['Email'];
                $_SESSION['username'] = $userRow['username'];
                $_SESSION['age'] = $userRow['Age'];
                $_SESSION['id'] = $userRow['Id']; // Save user ID in session
                $_SESSION['u_id'] = $userRow['u_id'];

                // Check user type
                if ($userRow['user_type'] == 'admin') {
                    header("Location: home2.php"); // Redirect to admin home
                } else {
                    header("Location: home.php"); // Redirect to user home
                }
                exit();
            } else {
                echo "<div class='message'>
                        <p>Wrong Username or Password</p>
                    </div>";
                echo "<a href='index.php'><button class='btn'>Go Back</button></a>";
            }
        }

        // Display the logged-in username if available
       
        
    ?>
      <header>Login</header>
      <form action="" method="post">
        <div class="field input">
          <label for="email">อีเมล อีเมล</label>
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
        
        <div class="links">
          ยังไม่เป็นสมาชิก? <a href="register.php">สมัครสมาชิก</a>
        </div>
      </form>
    </div>
  </div>
</body>

</html>
