<?php
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $kode_prodi = $_POST['kode_prodi'];
    $nama_prodi = $_POST['nama_prodi'];
    $strata = $_POST['strata'];
    $akreditasi = $_POST['akreditasi'];

    error_log("Updating ID: $id, Kode Prodi: $kode_prodi, Nama Prodi: $nama_prodi, Strata: $strata, Akreditasi: $akreditasi");

    $query = "UPDATE table_prodi SET kode_prodi = :kode_prodi, nama_prodi = :nama_prodi, strata = :strata, akreditasi = :akreditasi WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':kode_prodi', $kode_prodi);
    $stmt->bindParam(':nama_prodi', $nama_prodi);
    $stmt->bindParam(':strata', $strata);
    $stmt->bindParam(':akreditasi', $akreditasi);

    if ($stmt->execute()) {
        echo "Data updated successfully";
        error_log("Update successful");
    } else {
        echo "Failed to update data";
        error_log("Update failed");
    }
}
?>