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

// Proses formulir tambah data jika ada data yang dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_action'])) {
    $kode_prodi = $_POST['kode_prodi'];
    $nama_prodi = $_POST['nama_prodi'];
    $strata = $_POST['strata'];
    $akreditasi = $_POST['akreditasi'];

    if ($_POST['form_action'] == 'add_prodi') {
        $query = "INSERT INTO table_prodi (kode_prodi, nama_prodi, strata, akreditasi) VALUES (:kode_prodi, :nama_prodi, :strata, :akreditasi)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':kode_prodi', $kode_prodi);
        $stmt->bindParam(':nama_prodi', $nama_prodi);
        $stmt->bindParam(':strata', $strata);
        $stmt->bindParam(':akreditasi', $akreditasi);

        if ($stmt->execute()) {
            $message = 'Data berhasil ditambahkan!';
        } else {
            $message = 'Gagal menambahkan data.';
        }
    } elseif ($_POST['form_action'] == 'edit_prodi') {
        $id = $_POST['id'];
        $query = "UPDATE table_prodi SET kode_prodi = :kode_prodi, nama_prodi = :nama_prodi, strata = :strata, akreditasi = :akreditasi WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':kode_prodi', $kode_prodi);
        $stmt->bindParam(':nama_prodi', $nama_prodi);
        $stmt->bindParam(':strata', $strata);
        $stmt->bindParam(':akreditasi', $akreditasi);

        if ($stmt->execute()) {
            $message = 'Data berhasil diperbarui!';
        } else {
            $message = 'Gagal memperbarui data.';
        }
    }
}

// Proses penghapusan data jika ada ID yang diterima
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM table_prodi WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $message = 'Data berhasil dihapus!';
    } else {
        $message = 'Gagal menghapus data.';
    }
}

// Query untuk mengambil data program studi
$query = "SELECT * FROM table_prodi";
$stmt = $conn->prepare($query);
$stmt->execute();
$prodi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Studi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 97%;
            top: 0;
            z-index: 1000;
        }
        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 8px 16px;
            background-color: #0056b3;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .navbar a:hover {
            background-color: #003f7f;
        }
        .sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            position: fixed;
            top: 60px; /* height of navbar */
            bottom: 0;
            overflow-y: auto;
            padding-top: 20px;
        }
        .sidebar a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 15px 20px;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .sidebar a.active {
            background-color: #007bff;
        }
        .main-content {
            margin-left: 250px;
            padding: 80px 20px 20px; /* margin for navbar and sidebar */
            flex: 1;
        }
        .main-content h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .btn-container {
            margin-bottom: 20px;
        }
        .add-btn {
            cursor: pointer;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .add-btn:hover {
            background-color: #0056b3;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .delete-btn, .edit-btn {
            cursor: pointer;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            color: white;
        }
        .delete-btn {
            background-color: #f44336;
        }
        .delete-btn:hover {
            background-color: #d32f2f;
        }
        .edit-btn {
            background-color: #4CAF50;
        }
        .edit-btn:hover {
            background-color: #388E3C;
        }
        .form-popup {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .form-popup-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .submit-btn {
            cursor: pointer;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Data Program Studi</h1>
        <a href="admin_dashboard.php"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
    </div>
    <div class="sidebar">
        <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="#"><i class="fas fa-user-plus"></i> Tambah Data Dosen</a>
        <a href="tambah_data_prodi.php" class="active"><i class="fas fa-building"></i> Tambah Data Prodi</a>
        <a href="#"><i class="fas fa-user-shield"></i> Tambah Admin</a>
        <a href="#"><i class="fas fa-paint-brush"></i> Ganti Background Pustakawan dan Admin</a>
        <a href="#"><i class="fas fa-user-check"></i> Verify Pustakawan</a>
        <a href="#"><i class="fas fa-history"></i> Riwayat Penghapusan</a>
    </div>
    <div class="main-content">
        <h2>Data Program Studi</h2>
        <button class="add-btn" onclick="openForm()">Tambah Data Prodi</button>
        <div id="form-popup" class="form-popup">
            <div class="form-popup-content">
                <span class="close" onclick="closeForm()">&times;</span>
                <h2 id="form-title">Tambah Data Program Studi</h2>
                <form method="POST" action="" id="form-data">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="form_action" id="form-action" value="add_prodi">
                    <div class="form-group">
                        <label for="kode_prodi">Kode Prodi</label>
                        <input type="text" id="kode_prodi" name="kode_prodi" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_prodi">Nama Prodi</label>
                        <input type="text" id="nama_prodi" name="nama_prodi" required>
                    </div>
                    <div class="form-group">
                        <label for="strata">Strata</label>
                        <input type="text" id="strata" name="strata" required>
                    </div>
                    <div class="form-group">
                        <label for="akreditasi">Akreditasi</label>
                        <input type="text" id="akreditasi" name="akreditasi" required>
                    </div>
                    <button type="submit" class="submit-btn" id="submit-btn">Tambah Data</button>
                </form>
            </div>
        </div>
        <?php if (isset($message)): ?>
            <p><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Prodi</th>
                    <th>Nama Prodi</th>
                    <th>Strata</th>
                    <th>Akreditasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prodi as $index => $row): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($row['kode_prodi']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_prodi']); ?></td>
                        <td><?php echo htmlspecialchars($row['strata']); ?></td>
                        <td><?php echo htmlspecialchars($row['akreditasi']); ?></td>
                        <td>
                            <a href="?id=<?php echo htmlspecialchars($row['id']); ?>" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                            <button class="edit-btn" onclick="editForm(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function openForm() {
            document.getElementById("form-popup").style.display = "block";
            document.getElementById("form-title").innerText = "Tambah Data Program Studi";
            document.getElementById("submit-btn").innerText = "Tambah Data";
            document.getElementById("form-action").value = "add_prodi";
            document.getElementById("form-data").reset();
        }

        function closeForm() {
            document.getElementById("form-popup").style.display = "none";
        }

        function editForm(data) {
            document.getElementById("form-popup").style.display = "block";
            document.getElementById("form-title").innerText = "Edit Data Program Studi";
            document.getElementById("submit-btn").innerText = "Edit Data";
            document.getElementById("form-action").value = "edit_prodi";
            document.getElementById("id").value = data.id;
            document.getElementById("kode_prodi").value = data.kode_prodi;
            document.getElementById("nama_prodi").value = data.nama_prodi;
            document.getElementById("strata").value = data.strata;
            document.getElementById("akreditasi").value = data.akreditasi;
        }
    </script>
</body>
</html>