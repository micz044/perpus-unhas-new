<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Perpustakaan</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      height: 100vh;
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
    .cards {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
    }
    .card {
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin: 10px;
      flex: 1;
      min-width: 200px;
      max-width: 45%;
      text-align: center;
    }
    .card h3 {
      margin-top: 0;
      color: #007bff;
    }
    .card p {
      color: #333;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <h1>Admin Dashboard</h1>
    <a href="logout2.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
    <h2>Selamat Datang, Admin <?php echo htmlspecialchars($_SESSION['admin_username']); ?></h2>
    <div class="cards">
      <div class="card">
        <h3><i class="fas fa-user-plus"></i> Tambah Data Dosen</h3>
        <p>Kelola data dosen, tambah dosen baru, dan ubah informasi dosen.</p>
      </div>
      <div class="card">
        <h3><i class="fas fa-building"></i> Tambah Data Prodi</h3>
        <p>Kelola data program studi, tambah program studi baru, dan ubah informasi prodi.</p>
      </div>
      <div class="card">
        <h3><i class="fas fa-user-shield"></i> Tambah Admin</h3>
        <p>Tambahkan admin baru dan kelola hak akses admin.</p>
      </div>
      <div class="card">
        <h3><i class="fas fa-paint-brush"></i> Ganti Background Pustakawan dan Admin</h3>
        <p>Ubah latar belakang gambar halaman login dan register untuk Pustakawan dan Admin.</p>
      </div>
      <div class="card">
        <h3><i class="fas fa-user-check"></i> Verify Pustakawan</h3>
        <p>Verifikasi Pustakawan yang ingin mendaftar untuk membuat akun.</p>
      </div>
    </div>
  </div>
</body>
</html>