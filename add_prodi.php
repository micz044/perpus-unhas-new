<?php
// Konfigurasi database
$host = 'localhost';
$dbname = 'unhas';
$username = 'root';
$password = '';

// Membuat koneksi ke database
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Gagal terhubung ke database: ' . $e->getMessage()]);
    die();
}

// Memeriksa apakah request adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_prodi = $_POST['kode_prodi'];
    $nama_prodi = $_POST['nama_prodi'];
    $strata = $_POST['strata'];
    $akreditasi = $_POST['akreditasi'];

    // Memasukkan data ke tabel prodi
    $query = "INSERT INTO table_prodi (kode_prodi, nama_prodi, strata, akreditasi) VALUES (:kode_prodi, :nama_prodi, :strata, :akreditasi)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':kode_prodi', $kode_prodi);
    $stmt->bindParam(':nama_prodi', $nama_prodi);
    $stmt->bindParam(':strata', $strata);
    $stmt->bindParam(':akreditasi', $akreditasi);

    // Eksekusi query dan periksa hasil
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Data program studi berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan data program studi']);
    }
}
?>