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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id === false) {
        echo "ID tidak valid.";
        exit();
    }

    try {
        // Ambil data dosen sebelum dihapus
        $query_select = "SELECT * FROM tabelll WHERE id = :id";
        $stmt_select = $conn->prepare($query_select);
        $stmt_select->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_select->execute();
        $dosen = $stmt_select->fetch(PDO::FETCH_ASSOC);

        if ($dosen) {
            // Mulai transaksi
            $conn->beginTransaction();

            // Simpan ke tabel riwayat_penghapusan
            $query_riwayat = "INSERT INTO riwayat_penghapusan (nama_dosen, nidn, nip, department, status) VALUES (:nama, :nidn, :nip, :department, :status)";
            $stmt_riwayat = $conn->prepare($query_riwayat);
            $stmt_riwayat->bindParam(':nama', $dosen['nama']);
            $stmt_riwayat->bindParam(':nidn', $dosen['nidn']);
            $stmt_riwayat->bindParam(':nip', $dosen['nip']);
            $stmt_riwayat->bindParam(':department', $dosen['department']);
            $stmt_riwayat->bindParam(':status', $dosen['status']);
            $stmt_riwayat->execute();

            // Hapus data dari tabel tabelll
            $query_delete = "DELETE FROM tabelll WHERE id = :id";
            $stmt_delete = $conn->prepare($query_delete);
            $stmt_delete->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_delete->execute();

            // Commit transaksi
            $conn->commit();

            // Redirect kembali ke halaman daftar dosen
            header("Location: tampilan.php?status=success");
            exit();
        } else {
            echo "Data dosen tidak ditemukan.";
        }
    } catch (Exception $e) {
        // Rollback transaksi jika ada kesalahan
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>