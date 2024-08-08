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
    echo "Error: " . $e->getMessage();
    die();
}

// Fungsi untuk mengembalikan data dosen yang dihapus
function pulihkanData($id) {
    global $conn;

    try {
        // Mulai transaksi
        $conn->beginTransaction();

        // Ambil data dosen dari riwayat_penghapusan
        $stmt = $conn->prepare("SELECT * FROM riwayat_penghapusan WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Query untuk mengembalikan data dosen yang dihapus ke tabel utama
        $query_pulihkan = "INSERT INTO tabelll (nama, nidn, nip, department, status) VALUES (:nama, :nidn, :nip, :department, :status)";
        $stmt_pulihkan = $conn->prepare($query_pulihkan);
        $stmt_pulihkan->bindParam(':nama', $data['nama_dosen']);
        $stmt_pulihkan->bindParam(':nidn', $data['nidn']);
        $stmt_pulihkan->bindParam(':nip', $data['nip']);
        $stmt_pulihkan->bindParam(':department', $data['department']);
        $stmt_pulihkan->bindParam(':status', $data['status']); // Menyertakan status dari riwayat_penghapusan
        $stmt_pulihkan->execute();

        // Hapus data dari tabel riwayat_penghapusan setelah dipulihkan
        $query_hapus_riwayat = "DELETE FROM riwayat_penghapusan WHERE id = :id";
        $stmt_hapus_riwayat = $conn->prepare($query_hapus_riwayat);
        $stmt_hapus_riwayat->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_hapus_riwayat->execute();

        // Commit transaksi
        $conn->commit();

        // Kirim respons JSON kembali ke klien
        echo json_encode(array('status' => 'success'));
        exit();
    } catch(PDOException $e) {
        // Rollback transaksi jika ada kesalahan
        $conn->rollBack();
        echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
        exit();
    }
}

// Fungsi untuk menghapus data dari riwayat_penghapusan
function hapusData($id) {
    global $conn;

    try {
        // Mulai transaksi
        $conn->beginTransaction();

        // Hapus data dari tabel riwayat_penghapusan
        $query_hapus_riwayat = "DELETE FROM riwayat_penghapusan WHERE id = :id";
        $stmt_hapus_riwayat = $conn->prepare($query_hapus_riwayat);
        $stmt_hapus_riwayat->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_hapus_riwayat->execute();

        // Commit transaksi
        $conn->commit();

        // Kirim respons JSON kembali ke klien
        echo json_encode(array('status' => 'success'));
        exit();
    } catch(PDOException $e) {
        // Rollback transaksi jika ada kesalahan
        $conn->rollBack();
        echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
        exit();
    }
}

// Periksa apakah ada permintaan AJAX untuk memulihkan atau menghapus data
if(isset($_POST['action'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        if ($_POST['action'] === 'pulihkanData') {
            pulihkanData($id);
        } elseif ($_POST['action'] === 'hapusData') {
            hapusData($id);
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'ID tidak valid.'));
        exit();
    }
}

// Query untuk mengambil data riwayat penghapusan
$query_riwayat = "SELECT * FROM riwayat_penghapusan ORDER BY tgl_penghapusan DESC";
$stmt_riwayat = $conn->prepare($query_riwayat);
$stmt_riwayat->execute();
$riwayat = $stmt_riwayat->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penghapusan</title>
    <style>
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
         th:nth-child(2), td:nth-child(2) {
            width: 200px; /* Atur lebar kolom Nama Dosen */

        }
        td.aksi {
            width: 200px; /* Sesuaikan lebar sesuai kebutuhan */
            white-space: nowrap; /* Mencegah tombol melompat ke baris berikutnya */
        }
        button {
            display: inline-block;
            margin-right: 5px; /* Jarak antar tombol */
        }
    </style>
</head>
<body>

<h2>Riwayat Penghapusan</h2>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Dosen</th>
            <th>NIDN</th>
            <th>NIP</th>
            <th>Department</th>
            <th>Status</th> <!-- Kolom Status dipindahkan ke sini -->
            <th>Tanggal Penghapusan</th>
            <th class="aksi">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($riwayat as $index => $row): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($row['nama_dosen'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['nidn'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['nip'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['department'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8'); ?></td> <!-- Menampilkan status -->
                <td><?php echo htmlspecialchars($row['tgl_penghapusan'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td class="aksi">
                    <button type="button" class="pulihkan-btn" data-id="<?php echo $row['id']; ?>">Pulihkan Data</button>
                    <button type="button" class="hapus-btn" data-id="<?php echo $row['id']; ?>">Hapus Data</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    // Event listener untuk tombol "Pulihkan Data" dan "Hapus Data"
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('pulihkan-btn')) {
            var id = event.target.getAttribute('data-id');
            if (id) {
                pulihkanData(id);
            } else {
                console.error('Error: ID tidak valid.');
                alert('Terjadi kesalahan, ID tidak valid.');
            }
        } else if (event.target.classList.contains('hapus-btn')) {
            var id = event.target.getAttribute('data-id');
            if (id) {
                hapusData(id);
            } else {
                console.error('Error: ID tidak valid.');
                alert('Terjadi kesalahan, ID tidak valid.');
            }
        }
    });

    // Fungsi untuk mengembalikan data dosen yang dihapus
    function pulihkanData(id) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Response berhasil diterima
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        // Sukses, lakukan tindakan sesuai kebutuhan
                        alert('Data berhasil dipulihkan.');
                        // Contoh: Refresh halaman atau lakukan aksi lainnya
                        window.location.reload();
                    } else {
                        // Ada kesalahan dalam pengolahan data di server
                        console.error('Error: ' + response.message);
                        alert('Terjadi kesalahan dalam memulihkan data.');
                    }
                } else {
                    // Gagal terhubung ke server atau error lainnya
                    console.error('Error: ' + xhr.status);
                    alert('Terjadi kesalahan saat menghubungi server.');
                }
            }
        };

        // Konfigurasi dan kirim request AJAX
        xhr.open('POST', 'riwayat.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('action=pulihkanData&id=' + id);
    }

    // Fungsi untuk menghapus data dosen dari riwayat penghapusan
    function hapusData(id) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Response berhasil diterima
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        // Sukses, lakukan tindakan sesuai kebutuhan
                        alert('Data berhasil dihapus.');
                        // Contoh: Refresh halaman atau lakukan aksi lainnya
                        window.location.reload();
                    } else {
                        // Ada kesalahan dalam pengolahan data di server
                        console.error('Error: ' + response.message);
                        alert('Terjadi kesalahan dalam menghapus data.');
                    }
                } else {
                    // Gagal terhubung ke server atau error lainnya
                    console.error('Error: ' + xhr.status);
                    alert('Terjadi kesalahan saat menghubungi server.');
                }
            }
        };

        // Konfigurasi dan kirim request AJAX
        xhr.open('POST', 'riwayat.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('action=hapusData&id=' + id);
    }
</script>

</body>
</html>