<?php
session_start();

require 'db_connection.php'; // File to connect to your database

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Username already exists.";
    } else {
        // Insert the new admin user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, 1)");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            $success = "Admin user added successfully.";
        } else {
            $error = "Error adding admin user.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Admin</title>
    <style>
        /* Add your CSS styling here */
    </style>
</head>
<body>
    <h1>Tambah Admin</h1>
    <?php
    if (isset($error)) {
        echo '<div class="error">' . htmlspecialchars($error) . '</div>';
    } elseif (isset($success)) {
        echo '<div class="success">' . htmlspecialchars($success) . '</div>';
    }
    ?>
    <form action="add_admin.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Add Admin</button>
    </form>
</body>
</html>