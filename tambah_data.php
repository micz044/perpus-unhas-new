<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'perpus-unhas';
$username = 'root';
$password = '';

// Pesan error jika terjadi kesalahan
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi dan sanitasi input
    $nama = htmlspecialchars($_POST['nama'] ?? '');
    $nidn = htmlspecialchars($_POST['nidn'] ?? '');
    $nip = htmlspecialchars($_POST['nip'] ?? '');
    $department = htmlspecialchars($_POST['department'] ?? '');

    // Validasi form
    if (empty($nama)) {
        $errors[] = 'Nama dosen harus diisi';
    }
    // Lanjutkan dengan validasi lain sesuai kebutuhan

    // Jika tidak ada error, tambahkan data ke database
    if (empty($errors)) {
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Query untuk menambahkan data dosen
            $query = "INSERT INTO tabelll (nama, nidn, nip, department) VALUES (:nama, :nidn, :nip, :department)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':nama', $nama);
            $stmt->bindParam(':nidn', $nidn);
            $stmt->bindParam(':nip', $nip);
            $stmt->bindParam(':department', $department);
            $stmt->execute();

            // Redirect kembali ke halaman tabell.php setelah berhasil tambah data
            header("Location: tabell.php");
            exit();
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            die();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Dosen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .form-control {
            margin-bottom: 10px;
        }
        .form-control label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-control input {
            width: calc(100% - 20px);
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-control button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-control button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Tambah Data Dosen</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-control">
            <label for="nama">Nama Dosen:</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        <div class="form-control">
            <label for="nidn">NIDN:</label>
            <input type="text" id="nidn" name="nidn">
        </div>
        <div class="form-control">
            <label for="nip">NIP:</label>
            <input type="text" id="nip" name="nip">
        </div>
        <div class="form-control">
            <label for="department">Department (Program Studi):</label>
            <input type="text" id="department" name="department">
        </div>
        <button type="submit">Simpan</button>
    </form>

    <?php if (!empty($errors)): ?>
        <div class="error-message">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>

</body>
</html>