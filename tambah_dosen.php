<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'unhas';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}

// Periksa apakah data dari form telah terkirim
if(isset($_POST['nama']) && isset($_POST['nidn']) && isset($_POST['nip']) && isset($_POST['department']) && isset($_POST['status'])) {
    // Ambil data dari form tambah dosen
    $nama = $_POST['nama'];
    $nidn = $_POST['nidn'];
    $nip = $_POST['nip'];
    $department = $_POST['department'];
    $status = $_POST['status'];

    // Lakukan proses penambahan data ke dalam database
    $query = "INSERT INTO tabelll (nama, nidn, nip, department, status) VALUES (:nama, :nidn, :nip, :department, :status)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':nidn', $nidn);
    $stmt->bindParam(':nip', $nip);
    $stmt->bindParam(':department', $department);
    $stmt->bindParam(':status', $status);
    
    // Eksekusi query
    try {
        $stmt->execute();
        echo "Data berhasil ditambahkan.";
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>