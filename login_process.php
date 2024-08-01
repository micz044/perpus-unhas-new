<?php
session_start();
include 'db_connection.php';

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Mencegah SQL Injection
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

// Query untuk memeriksa apakah username ada di database
$sql_username = "SELECT * FROM users WHERE username = '$username'";
$result_username = $conn->query($sql_username);

if ($result_username === false) {
    die("Query error: " . $conn->error);
}

if ($result_username->num_rows > 0) {
    // Jika username ditemukan, cek password
    $user = $result_username->fetch_assoc();
    if ($user['password'] == $password) {
        // Jika password benar, set session username dan redirect ke halaman dashboard
        $_SESSION['username'] = $username;
        header("Location: tampilan.php");
        exit();
    } else {
        // Jika password salah, redirect ke halaman login dengan pesan error
        header("Location: login.php?error=2");
        exit();
    }
} else {
    // Jika username tidak ditemukan, redirect ke halaman login dengan pesan error
    header("Location: login.php?error=1");
    exit();
}

$conn->close();
?>