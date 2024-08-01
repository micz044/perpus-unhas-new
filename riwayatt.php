<?php
// Database connection
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

// Handle restore action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $id = intval($_POST['id']);

    if ($_POST['action'] == 'restore') {
        try {
            // Fetch the dosen info from riwayat
            $queryFetch = "SELECT * FROM riwayat WHERE id = :id";
            $stmtFetch = $conn->prepare($queryFetch);
            $stmtFetch->bindParam(':id', $id);
            $stmtFetch->execute();
            $dosen = $stmtFetch->fetch(PDO::FETCH_ASSOC);

            // Start transaction
            $conn->beginTransaction();

            // Prepare SQL for tabelll
            $query1 = "INSERT INTO tabelll (nama, nidn, nip, department, status) VALUES (:nama, :nidn, :nip, :department, :status)";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bindParam(':nama', $dosen['nama']);
            $stmt1->bindParam(':nidn', $dosen['nidn']);
            $stmt1->bindParam(':nip', $dosen['nip']);
            $stmt1->bindParam(':department', $dosen['department']);
            $stmt1->bindParam(':status', $dosen['status']);

            // Prepare SQL for tabell_admin
            $query2 = "INSERT INTO tabell_admin (nama, nidn, nip, department, status) VALUES (:nama, :nidn, :nip, :department, :status)";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bindParam(':nama', $dosen['nama']);
            $stmt2->bindParam(':nidn', $dosen['nidn']);
            $stmt2->bindParam(':nip', $dosen['nip']);
            $stmt2->bindParam(':department', $dosen['department']);
            $stmt2->bindParam(':status', $dosen['status']);

            // Prepare SQL to delete from riwayat
            $query3 = "DELETE FROM riwayat WHERE id = :id";
            $stmt3 = $conn->prepare($query3);
            $stmt3->bindParam(':id', $id);

            // Execute all queries
            $stmt1->execute();
            $stmt2->execute();
            $stmt3->execute();

            // Commit transaction
            $conn->commit();

            $message = "Data dosen berhasil dipulihkan.";
        } catch (Exception $e) {
            // Rollback transaction if something failed
            $conn->rollBack();
            $message = "Terjadi kesalahan saat memulihkan data dosen: " . $e->getMessage();
        }
    } elseif ($_POST['action'] == 'delete') {
        try {
            // Delete from riwayat
            $queryDelete = "DELETE FROM riwayat WHERE id = :id";
            $stmtDelete = $conn->prepare($queryDelete);
            $stmtDelete->bindParam(':id', $id);
            $stmtDelete->execute();

            $message = "Data dosen berhasil dihapus secara permanen.";
        } catch (Exception $e) {
            $message = "Terjadi kesalahan saat menghapus data dosen: " . $e->getMessage();
        }
    }
}

// Fetch data from riwayat
$query = "SELECT * FROM riwayat ORDER BY deleted_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penghapusan Dosen</title>
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
        .message {
            text-align: center;
            margin-bottom: 20px;
            color: green;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        <h1>Riwayat Penghapusan Dosen</h1>
        <a href="admin_dashboard.php"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
    </div>
    <div class="sidebar">
        <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="#"><i class="fas fa-user-plus"></i> Tambah Data Dosen</a>
        <a href="#"><i class="fas fa-building"></i> Tambah Data Prodi</a>
        <a href="#"><i class="fas fa-user-shield"></i> Tambah Admin</a>
        <a href="#"><i class="fas fa-paint-brush"></i> Ganti Background Pustakawan dan Admin</a>
        <a href="#"><i class="fas fa-user-check"></i> Verify Pustakawan</a>
         <a href="riwayatt.php"><i class="fas fa-history"></i> Riwayat Penghapusan</a>
  </div>
    <div class="main-content">
        <h2>Riwayat Penghapusan Dosen</h2>
        <?php if (!empty($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <!-- Riwayat Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dosen</th>
                    <th>NIDN</th>
                    <th>NIP</th>
                    <th>Department (Program Studi)</th>
                    <th>Status</th>
                    <th>Dihapus Pada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($riwayat as $index => $row): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['nidn']); ?></td>
                        <td><?php echo htmlspecialchars($row['nip']); ?></td>
                        <td><?php echo htmlspecialchars($row['department']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['deleted_at']); ?></td>
                        <td>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="action" value="restore">
                                <button type="submit" onclick="return confirm('Anda yakin ingin memulihkan data ini?')">Pulihkan</button>
                            </form>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" onclick="return confirm('Anda yakin ingin menghapus data ini secara permanen?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>