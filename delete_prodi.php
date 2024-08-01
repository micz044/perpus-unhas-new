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
    echo json_encode(['status' => 'error', 'message' => 'Koneksi gagal: ' . $e->getMessage()]);
    die();
}

// Periksa apakah metode POST dan parameter id ada
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    if ($id) {
        $query = "DELETE FROM table_prodi WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan atau sudah dihapus.']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID tidak valid.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode HTTP tidak valid.']);
}
?>