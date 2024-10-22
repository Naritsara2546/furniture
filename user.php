<?php
include_once("connectdb.php"); // Include your database connection

// Start the session
session_start();

// Get the logged-in user's u_id from the session
$u_id = $_SESSION['u_id']; // Make sure to set this during login

// Fetch the user information based on the u_id
$sql1 = "SELECT * FROM userdb WHERE u_id='$u_id'";
$rs1 = mysqli_query($conn, $sql1); 
if (!$rs1 || mysqli_num_rows($rs1) == 0) { 
    die("User not found");
}
$data1 = mysqli_fetch_array($rs1);

// Get the necessary keys from the array
$usernameValue = isset($data1['username']) ? htmlspecialchars($data1['username']) : '';
$emailValue = isset($data1['email']) ? htmlspecialchars($data1['email']) : '';
$ageValue = isset($data1['age']) ? htmlspecialchars($data1['age']) : ''; // Assuming 'age' is a column in your table
$addressValue = isset($data1['u_address']) ? htmlspecialchars($data1['u_address']) : ''; // Assuming 'u_address' is a column in your table
?> 

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Edit My Profile</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        padding: 20px;
    }
    .container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center;
        color: #333;
    }
    label {
        display: block;
        margin: 10px 0 5px;
    }
    input[type="text"], input[type="number"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    input[type="email"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #f0f0f0; /* Optional: to visually indicate it's read-only */
        color: #555; /* Optional: dimmed text color */
        pointer-events: none; /* Prevent any interaction */
    }
    button {
        background-color: #4c44b6;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
    }
    button:hover {
        background-color: #3a3299;
    }
</style>
</head>

<body>
<div class="container">
<h1>Edit My Profile</h1>

<form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" name="username" required autofocus value="<?= $usernameValue; ?>">

    <label for="email">Email:</label>
    <input type="email" name="email" required value="<?= $emailValue; ?>" readonly> <!-- Email field is now read-only -->

    <label for="age">Age:</label>
    <input type="number" name="age" required value="<?= $ageValue; ?>" min="0"> <!-- Added age field -->

    <label for="u_address">Address:</label>
    <input type="text" name="u_address" required value="<?= $addressValue; ?>"> <!-- Added address field -->

    <button type="submit" name="Submit">Save</button>
</form>
</div>

<?php
if (isset($_POST['Submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $u_address = mysqli_real_escape_string($conn, $_POST['u_address']); // Get the updated address from the form

    // Process the update
    $sql = "UPDATE userdb SET username = '$username', u_address = '$u_address' WHERE u_id = '$u_id';"; // Update both username and address

    if (!mysqli_query($conn, $sql)) {
        die("Could not update user information: " . mysqli_error($conn));
    }

    // Notify successful update
    echo "<script>";
    echo "alert('User information updated successfully');";
    echo "window.location='home.php';"; // Redirect back to home page
    echo "</script>";
}

mysqli_close($conn);
?>
</body>
</html>
