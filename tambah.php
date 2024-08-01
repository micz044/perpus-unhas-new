<?php
// Konfigurasi database
$servername = "localhost";
$username = "root"; // Sesuaikan dengan username phpMyAdmin Anda
$password = ""; // Sesuaikan dengan password phpMyAdmin Anda
$dbname = "unhas";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data dari form
$nama_dosen = $_POST['nama_dosen'];
$nidn = $_POST['nidn'];
$nip = $_POST['nip'];
$departemen = $_POST['departemen'];

// Menyiapkan query untuk menambah data ke database
$sql = "INSERT INTO prodi (nama_dosen, nidn, nip, departemen) VALUES ('$nama_dosen', '$nidn', '$nip', '$departemen')";

// Menjalankan query
if ($conn->query($sql) === TRUE) {
    echo "Data berhasil ditambahkan";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>