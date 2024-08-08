<?php
session_start();
// Check for POST request and handle file uploads
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $upload_dir = 'uploads/';
    $user_bg = $upload_dir . 'user_background.jpeg';
    $admin_bg = $upload_dir . 'admin_background.jpeg';

    // Create upload directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Set maximum file size and allowed file types
    $maxFileSize = 5 * 1024 * 1024; // 5MB
    $allowedExts = array('jpg', 'jpeg', 'png', 'gif');

    // Handle user background image upload
    if (isset($_FILES['user_bg']) && $_FILES['user_bg']['error'] === UPLOAD_ERR_OK) {
        $user_file_tmp = $_FILES['user_bg']['tmp_name'];
        $user_file_name = $_FILES['user_bg']['name'];
        $user_file_size = $_FILES['user_bg']['size'];
        $user_file_extension = strtolower(pathinfo($user_file_name, PATHINFO_EXTENSION));

        // Validate file size and type
        if ($user_file_size > $maxFileSize) {
            $user_message = "User background image exceeds the 5MB size limit.";
        } elseif (!in_array($user_file_extension, $allowedExts)) {
            $user_message = "Invalid file type for user background image. Please upload jpg, jpeg, png, or gif files.";
        } else {
            if (move_uploaded_file($user_file_tmp, $user_bg)) {
                $user_message = "User background image updated successfully.";
            } else {
                $user_message = "Error updating user background image.";
            }
        }
    }

    // Handle admin background image upload
    if (isset($_FILES['admin_bg']) && $_FILES['admin_bg']['error'] === UPLOAD_ERR_OK) {
        $admin_file_tmp = $_FILES['admin_bg']['tmp_name'];
        $admin_file_name = $_FILES['admin_bg']['name'];
        $admin_file_size = $_FILES['admin_bg']['size'];
        $admin_file_extension = strtolower(pathinfo($admin_file_name, PATHINFO_EXTENSION));

        // Validate file size and type
        if ($admin_file_size > $maxFileSize) {
            $admin_message = "Admin background image exceeds the 5MB size limit.";
        } elseif (!in_array($admin_file_extension, $allowedExts)) {
            $admin_message = "Invalid file type for admin background image. Please upload jpg, jpeg, png, or gif files.";
        } else {
            if (move_uploaded_file($admin_file_tmp, $admin_bg)) {
                $admin_message = "Admin background image updated successfully.";
            } else {
                $admin_message = "Error updating admin background image.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Background</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 97%;
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
            padding: 8px 16px;
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
        .main-content h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .upload-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            max-width: 600px;
        }
        .upload-form input[type="file"] {
            display: block;
            margin-bottom: 10px;
        }
        .upload-form button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .upload-form button:hover {
            background-color: #0056b3;
        }
        .success-message {
            color: green;
            margin-bottom: 20px;
        }
        .error-message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Change Background</h1>
        <a href="admin_dashboard.php"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
    </div>
    <div class="sidebar">
    <a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="tambah_data_dosen.php"><i class="fas fa-user-plus"></i> Tambah Data Dosen</a>
    <a href="tambah_data_prodi.php"><i class="fas fa-building"></i> Tambah Data Prodi</a>
    <a href="tambah_admin.php"><i class="fas fa-user-shield"></i> Tambah Admin</a>
    <a href="change_background.php"><i class="fas fa-paint-brush"></i> Ganti Background Pustakawan dan Admin</a>
    <a href="verify_user.php"><i class="fas fa-user-check"></i> Verify Pustakawan</a>
    <a href="riwayatt.php"><i class="fas fa-history"></i> Riwayat Penghapusan</a>
    </div>
    <div class="main-content">
        <h2>Ganti Background</h2>
        <div class="upload-form">
            <?php 
            if (isset($user_message)) echo '<div class="success-message">' . $user_message . '</div>'; 
            if (isset($admin_message)) echo '<div class="success-message">' . $admin_message . '</div>'; 
            ?>
            <form action="change_background.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="user_bg">User Login Background:</label>
                    <input type="file" name="user_bg" id="user_bg" accept="image/*">
                </div>
                <div>
                    <label for="admin_bg">Admin Login Background:</label>
                    <input type="file" name="admin_bg" id="admin_bg" accept="image/*">
                </div>
                <button type="submit">Upload</button>
            </form>
        </div>
    </div>
</body>
</html>