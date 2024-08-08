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
    echo json_encode(['success' => false, 'message' => "Error: " . $e->getMessage()]);
    die();
}

// Mendapatkan data dari permintaan POST
$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? null;

if ($id) {
    try {
        // Query untuk menghapus data
        $query = "DELETE FROM table_prodi WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan atau tidak terhapus.']);
        }
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID tidak ditemukan.']);
}
?>