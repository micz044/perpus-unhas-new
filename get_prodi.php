<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'perpus-unhas';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}

// Pastikan parameter id ada dan valid
$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id) {
    echo json_encode(array('error' => 'ID tidak valid'));
    exit;
}

// Query untuk mengambil data program studi berdasarkan id
$query = "SELECT id, kode_prodi, nama_prodi, strata, akreditasi FROM table_prodi WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$prodi = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika data tidak ditemukan, beri respons error
if (!$prodi) {
    echo json_encode(array('error' => 'Data tidak ditemukan'));
    exit;
}

// Mengembalikan hasil dalam format JSON
echo json_encode($prodi);
?>