<?php
// Start session and check if admin is logged in
session_start();

// Database connection
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

// Initialize message
$message = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle adding data
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $nama = htmlspecialchars($_POST['nama'] ?? '');
        $nidn = htmlspecialchars($_POST['nidn'] ?? '');
        $nip = htmlspecialchars($_POST['nip'] ?? '');
        $department = htmlspecialchars($_POST['department'] ?? '');
        $status = htmlspecialchars($_POST['status'] ?? '');

        try {
            // Start transaction
            $conn->beginTransaction();

            // Prepare SQL for tabelll
            $query1 = "INSERT INTO tabelll (nama, nidn, nip, department, status) VALUES (:nama, :nidn, :nip, :department, :status)";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bindParam(':nama', $nama);
            $stmt1->bindParam(':nidn', $nidn);
            $stmt1->bindParam(':nip', $nip);
            $stmt1->bindParam(':department', $department);
            $stmt1->bindParam(':status', $status);

            // Prepare SQL for tabell_admin
            $query2 = "INSERT INTO tabell_admin (nama, nidn, nip, department, status) VALUES (:nama, :nidn, :nip, :department, :status)";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bindParam(':nama', $nama);
            $stmt2->bindParam(':nidn', $nidn);
            $stmt2->bindParam(':nip', $nip);
            $stmt2->bindParam(':department', $department);
            $stmt2->bindParam(':status', $status);

            // Execute both queries
            $stmt1->execute();
            $stmt2->execute();

            // Commit transaction
            $conn->commit();

            $message = "Data dosen berhasil ditambahkan ke kedua tabel.";
        } catch (Exception $e) {
            // Rollback transaction if something failed
            $conn->rollBack();
            $message = "Terjadi kesalahan saat menambahkan data dosen: " . $e->getMessage();
        }
    }

    // Handle deleting data
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $id = intval($_POST['id']);
        try {
            // Fetch the dosen info before deleting
            $queryFetch = "SELECT * FROM tabelll WHERE id = :id";
            $stmtFetch = $conn->prepare($queryFetch);
            $stmtFetch->bindParam(':id', $id);
            $stmtFetch->execute();
            $dosen = $stmtFetch->fetch(PDO::FETCH_ASSOC);

            // Start transaction
            $conn->beginTransaction();

            // Prepare SQL for tabelll
            $query1 = "DELETE FROM tabelll WHERE id = :id";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bindParam(':id', $id);

            // Prepare SQL for tabell_admin
            $query2 = "DELETE FROM tabell_admin WHERE id = :id";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bindParam(':id', $id);

            // Prepare SQL for riwayat
            $query3 = "INSERT INTO riwayat (nama, nidn, nip, department, status, deleted_at) VALUES (:nama, :nidn, :nip, :department, :status, NOW())";
            $stmt3 = $conn->prepare($query3);
            $stmt3->bindParam(':nama', $dosen['nama']);
            $stmt3->bindParam(':nidn', $dosen['nidn']);
            $stmt3->bindParam(':nip', $dosen['nip']);
            $stmt3->bindParam(':department', $dosen['department']);
            $stmt3->bindParam(':status', $dosen['status']);

            // Execute all queries
            $stmt1->execute();
            $stmt2->execute();
            $stmt3->execute();

            // Commit transaction
            $conn->commit();

            $message = "Data dosen berhasil dihapus dan dicatat dalam riwayat.";
        } catch (Exception $e) {
            // Rollback transaction if something failed
            $conn->rollBack();
            $message = "Terjadi kesalahan saat menghapus data dosen: " . $e->getMessage();
        }
    }
}

// Fetch data from tabelll
$query = "SELECT * FROM tabelll";
$stmt = $conn->prepare($query);
$stmt->execute();
$dosen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Dosen</title>
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
            width: 98%;
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
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
     <div class="navbar">
        <h1>Data Dosen</h1>
        <a href="admin_dashboard.php"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
    </div>

    <div class="sidebar">
        <a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="tambah_data_dosen.php"><i class="fas fa-user-plus"></i> Tambah Data Dosen</a>
        <a href="tambah_data_prodi.php"><i class="fas fa-building"></i> Tambah Data Prodi</a>
        <a href="tambah_admin.php"><i class="fas fa-user-shield"></i> Tambah Admin</a>
        <a href="change_background.php"><i class="fas fa-paint-brush"></i> Ganti Background Pustakawan dan Admin</a>
        <a href="verify_user.php"><i class="fas fa-user-check"></i> Verify Pustakawan</a>
        <a href="riwayatt.php"><i class="fas fa-history"></i> Riwayat Penghapusan</a>
  </div>

    <div class="main-content">
        <div class="container">
            <h2>Daftar Dosen</h2>
            <?php if (!empty($message)): ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>
            <button id="addDosenBtn">Tambah Dosen</button>

            <!-- Data Dosen Table -->
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dosen</th>
                        <th>NIDN</th>
                        <th>NIP</th>
                        <th>Department (Program Studi)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dosen as $index => $row): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($row['nidn']); ?></td>
                            <td><?php echo htmlspecialchars($row['nip']); ?></td>
                            <td><?php echo htmlspecialchars($row['department']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div id="addDosenModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Tambah Data Dosen</h2>
                <form method="POST" action="">
                    <input type="hidden" name="action" value="add">
                    <div class="form-group">
                        <label for="nama">Nama Dosen</label>
                        <input type="text" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="nidn">NIDN</label>
                        <input type="text" id="nidn" name="nidn" required>
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" id="nip" name="nip" required>
                    </div>
                    <div class="form-group">
                        <label for="department">Department (Program Studi)</label>
                        <input type="text" id="department" name="department" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Non-Aktif">Non-Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit">Tambah Dosen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("addDosenModal");

        // Get the button that opens the modal
        var btn = document.getElementById("addDosenBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>