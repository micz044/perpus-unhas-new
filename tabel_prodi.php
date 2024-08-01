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
    <title>Daftar Program Studi</title>
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
        .button-container {
            margin-bottom: 10px;
        }
        .btn-container {
            display: flex;
            align-items: center;
        }
        .copy-btn, .edit-btn, .delete-btn {
            cursor: pointer;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            margin-left: 5px;
        }
        .copy-btn:hover, .edit-btn:hover, .delete-btn:hover {
            background-color: #45a049;
        }
        .add-btn {
            cursor: pointer;
            padding: 10px 20px;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .add-btn:hover {
            background-color: #007BB5;
        }
        .modal {
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
        .modal-content {
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
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<h2>Daftar Program Studi</h2>
<div class="button-container">
</div>
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
                <td class="btn-container">
                    <button class="copy-btn" data-text="<?php echo 'KODEPRODI' . htmlspecialchars($row['kode_prodi']) . '#' . htmlspecialchars($row['nama_prodi']) . ' - ' . htmlspecialchars($row['strata']); ?>">Copy</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
     document.addEventListener('DOMContentLoaded', function() {
        function bindCopyButtons() {
            const copyButtons = document.querySelectorAll('.copy-btn');
            copyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const textToCopy = this.getAttribute('data-text');
                    navigator.clipboard.writeText(textToCopy).then(() => {
                        alert('Teks berhasil disalin: ' + textToCopy);
                    }).catch(err => {
                        console.error('Gagal menyalin teks: ', err);
                    });
                });
            });
        }

        
</script>

</body>
</html>