<?php
// Pastikan request datang dari metode GET dan ada parameter id yang dikirim
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Ambil nilai id dari parameter GET
    $id = $_GET['id'];

    // Lakukan validasi id jika diperlukan

    // Lakukan penghapusan data dari database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "unhas";

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk menghapus data
    $sql = "DELETE FROM prodi WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil dihapus";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
