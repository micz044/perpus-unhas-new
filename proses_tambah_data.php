<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_dosen = $_POST['nama_dosen'];
    $nidn = $_POST['nidn'];
    $nip = $_POST['nip'];
    $prodi = $_POST['prodi'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'unhas');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO dosen (nama_dosen, nidn, nip, prodi) VALUES ('$nama_dosen', '$nidn', '$nip', '$prodi')";

    if ($conn->query($sql) === TRUE) {
        // Setelah berhasil tambah data, arahkan pengguna ke halaman yang sesuai
        header("Location: tampilan.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>