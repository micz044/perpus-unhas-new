<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum, arahkan ke halaman login
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perpustakaan</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f0f0f0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .header {
      background-color: #007bff;
      color: #fff;
      padding: 0px;
      text-align: center;
      width: 100%;
    }
    .container {
      display: flex;
      flex: 1;
    }
    .menu {
      background-color: #0056b3;
      color: #fff;
      padding: 10px;
      width: 150px;
      transition: width 0.5s;
    }
    .menu.expanded {
      width: 420px;
    }
    .menu ul {
      list-style: none;
      padding: 0;
      margin: 10;
    }
    .menu ul li {
      margin-bottom: 40px;
    }
    .menu ul li a {
      display: flex;
      align-items: center;
      color: #fff;
      text-decoration: none;
      padding: 14px;
      transition: background-color 0.3s ease;
    }
    .menu ul li a:hover {
      background-color: #004080;
    }
    .menu ul li a i {
      margin-right: 15px;
    }
    .content {
      flex: 1;
      padding: 20px;
      background: url('uy.jpeg') no-repeat center center; /* Ganti dengan path ke gambar Anda */
      background-size: cover; /* Agar gambar menutupi seluruh kontainer */
      position: relative; /* Tambahkan ini untuk mengatur posisi elemen anak */
    }
    .dashboard-container {
      display: none;
      max-width: 1000px;
      margin: 20px auto;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.8); /* Background putih dengan transparansi */
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      position: relative; /* Buat posisi relatif */
      z-index: 1; /* Pastikan berada di atas background */
    }
    .dashboard-container.active {
      display: block;
    }
    .footer {
      background-color: #007bff;
      color: #fff;
      padding: 0px;
      text-align: center;
      width: 100%;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
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
    max-width: 600px;
    border-radius: 5px;
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
}
  </style>
</head>
<body>

<div class="header">
    <h1>e-Perpus NIDN</h1>
</div>

<div class="container">
    <div class="menu" id="menu">
        <ul>
            <li><a href="#" id="dashboardLink"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="#" id="namaDosenLink"><i class="fas fa-user"></i> Data Dosen</a></li>
            <li><a href="#" id="kodeProdiLink"><i class="fas fa-list"></i> Data Prodi</a></li>
            <li><a href="logout.php" id="logoutLink"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>
    <div class="content" id="content">
        <!-- Konten Dashboard -->
        <div class="dashboard-container active" id="dashboardContainer">
            <h2>Selamat Datang </h2>
            <!-- Isi konten Dashboard di sini -->
        </div>
        <!-- Konten Tabel -->
        <div class="dashboard-container" id="tableContainer">
            <input type="text" id="searchInput" placeholder="Cari dosen, NIDN, NIP...">
            <!-- Dynamic content will be loaded here -->
        </div>
    </div>
</div>
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Data Prodi</h2>
        <form id="editForm">
            <input type="hidden" id="edit_id" name="id">
            <div class="form-group">
                <label for="edit_kode_prodi">Kode Prodi:</label>
                <input type="text" id="edit_kode_prodi" name="kode_prodi" required>
            </div>
            <div class="form-group">
                <label for="edit_nama_prodi">Nama Prodi:</label>
                <input type="text" id="edit_nama_prodi" name="nama_prodi" required>
            </div>
            <div class="form-group">
                <label for="edit_strata">Strata:</label>
                <input type="text" id="edit_strata" name="strata" required>
            </div>
            <div class="form-group">
                <label for="edit_akreditasi">Akreditasi:</label>
                <input type="text" id="edit_akreditasi" name="akreditasi" required>
            </div>
            <button type="submit" class="btn-save">Simpan</button>
        </form>
    </div>
</div>

<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Tambah Data Program Studi</h3>
        <form id="addForm">
            <div class="form-group">
                <label for="kode_prodi">Kode Prodi:</label>
                <input type="text" id="kode_prodi" name="kode_prodi" required>
            </div>
            <div class="form-group">
                <label for="nama_prodi">Nama Prodi:</label>
                <input type="text" id="nama_prodi" name="nama_prodi" required>
            </div>
            <div class="form-group">
                <label for="strata">Strata:</label>
                <input type="text" id="strata" name="strata" required>
            </div>
            <div class="form-group">
                <label for="akreditasi">Akreditasi:</label>
                <input type="text" id="akreditasi" name="akreditasi" required>
            </div>
            <button type="submit" class="submit-btn">Tambah</button>
        </form>
    </div>
</div>

<div class="footer">
    <p>&copy; <span id="year"><?php echo date("Y"); ?></span> Perpustakaan Unhas - <span id="time"></span></p>
</div>

<script>
    // Ensure the Dashboard content is shown by default
    document.addEventListener("DOMContentLoaded", function(event) {
        var dashboardContainer = document.getElementById('dashboardContainer');
        dashboardContainer.classList.add('active');
    });

    // Event listeners for menu links
    document.getElementById('namaDosenLink').addEventListener('click', function(event) {
        event.preventDefault();
        loadTableContent('tabell.php');
        document.querySelector('.content').style.backgroundImage = 'none';
    });

    document.getElementById('kodeProdiLink').addEventListener('click', function(event) {
        event.preventDefault();
        loadTableContent('tabel_prodi.php');
        document.querySelector('.content').style.backgroundImage = 'none';
    });

    document.getElementById('dashboardLink').addEventListener('click', function(event) {
        event.preventDefault();
        document.querySelector('.content').style.backgroundImage = "url('uy.jpeg')";
        document.getElementById('dashboardContainer').classList.add('active');
        document.getElementById('tableContainer').classList.remove('active');
    });

 // Function to load content via AJAX
function loadTableContent(url) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('dashboardContainer').classList.remove('active');
                document.getElementById('tableContainer').classList.add('active');
                document.getElementById('tableContainer').innerHTML = xhr.responseText;
                bindEditButtons();
                bindCopyButtons();
                bindDeleteButtons(); // Pastikan ini dipanggil setelah tabel dimuat
                bindAddButtons();
                bindAddForm();
                applySearchFunctionality();
            } else {
                console.error('Error: ' + xhr.status);
            }
        }
    };
    xhr.open('GET', url, true);
    xhr.send();
}

// Function to bind delete buttons
function bindDeleteButtons() {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                fetch('delete_prodi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id=' + id
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Data berhasil dihapus.');
                        loadTableContent('tabel_prodi.php'); // Reload table content
                    } else {
                console.error('Error: ' + xhr.status);
                     }
                })
            }
        });
    });
}

// Pastikan ini dipanggil setelah loadTableContent
document.addEventListener('DOMContentLoaded', function(event) {
    bindDeleteButtons();
});
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('hapus-btn')) {
        var id = event.target.getAttribute('data-id');
        if (id) {
            hapusData(id);
        } else {
            console.error('Error: ID tidak valid.');
            alert('Terjadi kesalahan, ID tidak valid.');
        }
    }
});
function hapusData(id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    alert('Data berhasil dihapus.');
                    loadTableContent('riwayat.php'); // Reload the content after deletion
                } else {
                    console.error('Error: ' + response.message);
                    alert('Terjadi kesalahan dalam menghapus data.');
                }
            } else {
                console.error('Error: ' + xhr.status);
                alert('Terjadi kesalahan saat menghubungi server.');
            }
        }
    };

    xhr.open('POST', 'riwayat.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('action=hapusData&id=' + id);
}

// Function to bind add buttons
function bindAddButtons() {
    const addBtn = document.getElementById('addBtn');
    if (addBtn) {
        addBtn.addEventListener('click', function() {
            document.getElementById('addModal').style.display = 'block';
        });
    }
}

// Pastikan modal close buttons
document.querySelectorAll('.close').forEach(function(button) {
    button.addEventListener('click', function() {
        document.getElementById('addModal').style.display = 'none';
    });
});

window.addEventListener('click', function(event) {
    const addModal = document.getElementById('addModal');
    if (event.target == addModal) {
        addModal.style.display = 'none';
    }
});

// Event listener untuk submit form tambah data
document.getElementById('addForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('add_prodi.php', {
        method: 'POST',
        body: formData
    }).then(response => response.json()).then(data => {
        alert(data.message); // Untuk debugging
        if (data.status === 'success') {
            // Reset form
            document.getElementById('addForm').reset();
            // Load kembali konten tabel prodi
            loadTableContent('tabel_prodi.php');
            // Tutup modal
            document.getElementById('addModal').style.display = 'none';
        }
    }).catch(error => {
        console.error('Error:', error);
    });
});

// Event listener untuk submit form tambah data
function bindAddForm() {
    var addForm = document.getElementById('addForm');
    if (addForm) {
        addForm.addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            fetch('tambah_dosen.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Debugging: Tampilkan pesan dari PHP
                loadTableContent('tabell.php'); // Muat kembali tabel setelah menambahkan data
                document.getElementById('addModal').style.display = 'none'; // Tutup modal
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }
}

// Function to bind edit buttons
function bindEditButtons() {
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            fetch('get_prodi.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_kode_prodi').value = data.kode_prodi;
                    document.getElementById('edit_nama_prodi').value = data.nama_prodi;
                    document.getElementById('edit_strata').value = data.strata;
                    document.getElementById('edit_akreditasi').value = data.akreditasi;
                    document.getElementById('editModal').style.display = "block";
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        });
    });
}

// Close modal when clicking on <span> (x)
document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('editModal').style.display = "none";
});

// Close modal when clicking outside of the modal
window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('editModal')) {
        document.getElementById('editModal').style.display = "none";
    }
});

// Handle form submission
document.getElementById('editForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch('edit_prodi.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        console.log(result);
        // Reload table content after successful edit
        loadTableContent('tabel_prodi.php');
        // Hide the modal
        document.getElementById('editModal').style.display = 'none';
    })
    .catch(error => {
        console.error('Error saving data:', error);
    });
});

// Function to restore deleted data
function pulihkanData(id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    // Tidak menampilkan notifikasi toast
                    // Load tabell.php content after successful restoration
                    loadTableContent('riwayat.php');
                } else {
                    console.error('Error: ' + response.message);
                    alert('Terjadi kesalahan dalam memulihkan data.');
                }
            } else {
                console.error('Error: ' + xhr.status);
                alert('Terjadi kesalahan saat menghubungi server.');
            }
        }
    };

    xhr.open('POST', 'riwayat.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('action=pulihkanData&id=' + id);
}

// Event listener for "Pulihkan Data" button clicks
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('pulihkan-btn')) {
        var id = event.target.getAttribute('data-id');
        if (id) {
            pulihkanData(id);
        } else {
            console.error('Error: ID tidak valid.');
            alert('Terjadi kesalahan, ID tidak valid.');
        }
    }
});
    // Function to bind copy buttons
    function bindCopyButtons() {
        var copyButtons = document.querySelectorAll('.copy-btn');
        copyButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var text = this.getAttribute('data-text');
                navigator.clipboard.writeText(text).catch(err => {
                    console.error('Failed to copy text: ', err);
                });
            });
        });
    }

    // Function to apply search functionality
    function applySearchFunctionality() {
        var searchInput = document.getElementById('searchInput');
        if (!searchInput) return;

        searchInput.addEventListener('input', function() {
            var filter = this.value.toUpperCase();
            var rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                var namaDosen = row.getElementsByTagName('td')[1].innerText.toUpperCase();
                var nidn = row.getElementsByTagName('td')[2].innerText.toUpperCase();
                var nip = row.getElementsByTagName('td')[3].innerText.toUpperCase();

                if (namaDosen.indexOf(filter) > -1 || nidn.indexOf(filter) > -1 || nip.indexOf(filter) > -1) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        searchInput.addEventListener('change', function() {
            if (this.value === '') {
                var rows = document.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    row.style.display = '';
                });
            }
        });
    }


    // Function to update the current time
    function updateTime() {
        var now = new Date();
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        var seconds = String(now.getSeconds()).padStart(2, '0');
        var timeString = hours + ':' + minutes + ':' + seconds;
        document.getElementById('time').textContent = timeString;
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>

</body>
</html>