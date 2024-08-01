<?php
// Termasuk koneksi database
include 'db_connection.php';

// Ambil data dari form pendaftaran
$nama_lengkap = $_POST['nama_lengkap'];
$nip = $_POST['nip'];
$jabatan = $_POST['jabatan'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Mencegah SQL Injection
$nama_lengkap = mysqli_real_escape_string($conn, $nama_lengkap);
$nip = mysqli_real_escape_string($conn, $nip);
$jabatan = mysqli_real_escape_string($conn, $jabatan);
$email = mysqli_real_escape_string($conn, $email);
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

// Query untuk memeriksa apakah pengguna sudah ada di database users_register
$sql_check_user_register = "SELECT * FROM users_register WHERE username = '$username'";
$result_check_user_register = $conn->query($sql_check_user_register);

// Query untuk memeriksa apakah pengguna sudah ada di database users
$sql_check_user_login = "SELECT * FROM users WHERE username = '$username'";
$result_check_user_login = $conn->query($sql_check_user_login);

if ($result_check_user_register->num_rows > 0 || $result_check_user_login->num_rows > 0) {
    // Jika pengguna sudah ada, kembali ke halaman pendaftaran dengan pesan error
    header("Location: register.php?error=user_exists");
} else {
    // Jika pengguna belum ada, tambahkan ke database pending_users
    $sql_insert_pending_user = "INSERT INTO pending_users (nama_lengkap, nip, jabatan, email, username, password) VALUES ('$nama_lengkap', '$nip', '$jabatan', '$email', '$username', '$password')";
    
    if ($conn->query($sql_insert_pending_user) === TRUE) {
        // Jika berhasil ditambahkan, arahkan pengguna ke halaman pendaftaran
        header("Location: register.php?success=awaiting_approval");
    } else {
        // Jika gagal, kembali ke halaman pendaftaran dengan pesan error
        header("Location: register.php?error=register_failed");
    }
}

$conn->close();
?>