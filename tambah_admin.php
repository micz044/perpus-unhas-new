<?php
session_start();

// Include database connection file
require_once 'db_connection.php';

$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Insert admin into the database
        $sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $username, $password);
            if ($stmt->execute()) {
                $success = "Admin added successfully.";
            } else {
                $error = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 98%;
            top: 0;
            z-index: 1000;
        }
        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 16px;
            background-color: #0056b3;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .navbar a:hover {
            background-color: #003f7f;
        }
        .sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            position: fixed;
            top: 60px; /* height of navbar */
            bottom: 0;
            overflow-y: auto;
            padding-top: 20px;
        }
        .sidebar a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 15px 20px;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .sidebar a.active {
            background-color: #007bff;
        }
        .main-content {
            margin-left: 250px;
            padding: 80px 20px 20px; /* margin for navbar and sidebar */
            flex: 1;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 600px;
        }
        .form-container h2 {
            margin-bottom: 20px;
        }
        .form-container input[type="text"], .form-container input[type="password"] {
            width: 50%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button {
            width: 50%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .success {
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Add New Admin</h1>
        <a href="admin_dashboard.php"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
    </div>
    <div class="sidebar">
        <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="#"><i class="fas fa-user-plus"></i> Tambah Data Dosen</a>
        <a href="#"><i class="fas fa-building"></i> Tambah Data Prodi</a>
        <a href="tambah_admin.php" class="active"><i class="fas fa-user-shield"></i> Tambah Admin</a>
        <a href="#"><i class="fas fa-paint-brush"></i> Ganti Background Pepustakawan dan Admin</a>
        <a href="#"><i class="fas fa-user-check"></i> Verify Pepustakawan</a>
        <a href="#"><i class="fas fa-history"></i> Riwayat</a>
    </div>
    <div class="main-content">
        <div class="form-container">
            <h2>Add New Admin</h2>
            <?php
            if (!empty($error)) {
                echo '<div class="error">' . htmlspecialchars($error) . '</div>';
            }
            if (!empty($success)) {
                echo '<div class="success">' . htmlspecialchars($success) . '</div>';
            }
            ?>
            <form action="tambah_admin.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Tambah</button>
            </form>
        </div>
    </div>
</body>
</html>