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

// Query untuk mengambil data dosen
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
    <title>Daftar Dosen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            display: flex;
            align-items: center;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .copy-btn {
            float: right;
            margin-left: 10px;
            cursor: pointer;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            position: relative;
            z-index: 1;
            transition: background-color 0.3s, transform 0.1s;
        }
        .copy-btn:hover {
            background-color: #45a049;
        }
        .copy-btn:active {
            background-color: #3e8e41;
            transform: scale(0.95);
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        #searchContainer {
            position: relative;
            margin-left: 10px;
        }
        #searchInput {
            padding: 8px 30px 8px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            width: 300px;
        }
        .search-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
            cursor: pointer;
        }
        .search-icon:hover {
            color: #333;
        }
        
    </style>
</head>
<body>

<div class="header-container">
    <h2>Daftar Dosen</h2>
    <div class="button-container">
        <div id="searchContainer">
            <input type="text" id="searchInput" placeholder="Cari dosen, NIDN, NIP...">
            <i class="fas fa-search search-icon"></i>
        </div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Dosen</th>
            <th>NIDN</th>
            <th>NIP</th>
            <th>Department (Program Studi)</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dosen as $index => $row): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                <td>
                    <?php echo htmlspecialchars($row['nidn']); ?>
                    <button class="copy-btn" data-text="nidn<?php echo htmlspecialchars($row['nidn']); ?>">Copy</button>
                </td>
                <td>
                    <?php echo htmlspecialchars($row['nip']); ?>
                    <button class="copy-btn" data-text="<?php echo htmlspecialchars($row['nip']); ?>">Copy</button>
                </td>
                <td>
                    <?php echo htmlspecialchars($row['department']); ?>
                    <button class="copy-btn" data-text="<?php echo htmlspecialchars($row['department']); ?>">Copy</button>
                </td>
                <td>
                    <?php echo htmlspecialchars($row['status']); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        function bindCopyButton()
        const copyButtons = document.querySelectorAll('.copy-btn');
        copyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const textToCopy = this.getAttribute('data-text').toLowerCase();
                navigator.clipboard.writeText(textToCopy).catch(err => {
                    console.error('Failed to copy text: ', err);
                });
            });
        });

        const addModal = document.getElementById("addModal");
        const addBtn = document.getElementById("addBtn");
        const closeButtons = document.querySelectorAll(".close");

        addBtn.onclick = function() {
            addModal.style.display = "block";
        }

        closeButtons.forEach(button => {
            button.onclick = function() {
                addModal.style.display = "none";
            }
        });

        window.onclick = function(event) {
            if (event.target == addModal) {
                addModal.style.display = "none";
            }
        }

    
        function applySearchFunctionality()
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function() {
            const filter = this.value.toUpperCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const namaDosen = row.getElementsByTagName('td')[1].innerText.toUpperCase();
                const nidn = row.getElementsByTagName('td')[2].innerText.toUpperCase();
                const nip = row.getElementsByTagName('td')[3].innerText.toUpperCase();
                const department = row.getElementsByTagName('td')[4].innerText.toUpperCase();
                const status = row.getElementsByTagName('td')[5].innerText.toUpperCase();

                if (namaDosen.indexOf(filter) > -1 || nidn.indexOf(filter) > -1 || nip.indexOf(filter) > -1 || department.indexOf(filter) > -1 || status.indexOf(filter) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        searchInput.addEventListener('change', function() {
            if (this.value === '') {
                const rows = document.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    row.style.display = '';
                });
            }
        });
    });
</script>

</body>
</html>