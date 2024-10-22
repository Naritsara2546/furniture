<?php
include_once("checklogin.php");
include("connectdb.php");

// Handle Add User
if (isset($_POST['add_user'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
    $age = intval($_POST['age']);

    // Check if password hashing was successful
    if ($password === false) {
        echo "Error hashing password.";
        exit; // Stop further execution if there's an error
    }

    $stmt = $conn->prepare("INSERT INTO userdb (Email, password, user_type, Age) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $email, $password, $user_type, $age);
    $stmt->execute();
    $stmt->close();
}

// Handle Delete User
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM userdb WHERE u_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Handle Edit User
if (isset($_POST['edit_user'])) {
    $id = intval($_POST['u_id']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
    $age = intval($_POST['Age']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_password = $_POST['new_password'];

    if (!empty($new_password)) {
        // Update with new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        if ($hashed_password === false) {
            echo "Error hashing new password.";
            exit; // Stop further execution if there's an error
        }
        $stmt = $conn->prepare("UPDATE userdb SET Email = ?, user_type = ?, Age = ?, username = ?, password = ? WHERE u_id = ?");
        $stmt->bind_param("ssisii", $email, $user_type, $age, $username, $hashed_password, $id);
    } else {
        // Update without password change
        $stmt = $conn->prepare("UPDATE userdb SET Email = ?, user_type = ?, Age = ?, username = ? WHERE u_id = ?");
        $stmt->bind_param("ssiis", $email, $user_type, $age, $username, $id);
    }
    $stmt->execute();
    $stmt->close();
}

// Fetch users
$result = $conn->query("SELECT * FROM userdb");

if (!$result) {
    // If the query failed, output the error
    echo "Error fetching users: " . $conn->error;
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="path/to/your/styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
            color: #555;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"],
        input[type="number"],
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #007BFF;
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Management</h1>

        <!-- Add User Form -->
        <h2>Add User</h2>
        <form action="" method="POST">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="user_type" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="number" name="age" placeholder="Age" required>
            <input type="submit" name="add_user" value="Add User">
        </form>

        <!-- Users Table -->
        <h2>User List</h2>
        <table>
            <tr>
                <th>u_id</th>
                <th>Email</th>
                <th>Username</th>
                <th>Age</th>
                <th>User Type</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['u_id']; ?></td>
                <td><?php echo $row['Email']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['Age']; ?></td>
                <td><?php echo $row['user_type']; ?></td>
                <td>
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="u_id" value="<?php echo $row['u_id']; ?>">
                        <input type="text" name="Email" value="<?php echo $row['Email']; ?>" required>
                        <input type="text" name="username" value="<?php echo $row['username']; ?>" required>
                        <input type="number" name="Age" value="<?php echo $row['Age']; ?>" required>
                        <select name="user_type" required>
                            <option value="user" <?php if ($row['user_type'] == 'user') echo 'selected'; ?>>User</option>
                            <option value="admin" <?php if ($row['user_type'] == 'admin') echo 'selected'; ?>>Admin</option>
                        </select>
                        <input type="password" name="new_password" placeholder="New Password (Leave blank if not changing)">
                        <input type="submit" name="edit_user" value="Edit">
                    </form>
                    <a href="?delete_id=<?php echo $row['u_id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
