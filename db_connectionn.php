<?php
$host = "localhost"; // Ganti dengan host database Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$database = "perpus-unhas"; // Ganti dengan nama database Anda

// Buat koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set karakter set UTF-8 untuk mendukung karakter internasional
$conn->set_charset("utf8");

// Sebagai contoh, Anda dapat menambahkan pemeriksaan koneksi sukses di sini
// echo "Koneksi sukses";

?>