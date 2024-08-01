<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Perpustakaan</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('uploads/user_background.jpeg');
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .container {
      background-color: rgba(255, 255, 255, 0.8);
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
      width: 320px;
      text-align: center;
    }
    .form-group {
      margin-bottom: 10px;
      position: relative;
      text-align: left;
    }
    .form-group label {
      display: flex;
      align-items: center;
      margin-bottom: 3px;
      font-weight: bold;
      font-size: 0.85em;
    }
    .form-group label i {
      margin-right: 5px;
      color: #333;
    }
    .form-group input {
      width: calc(100% - 20px);
      padding: 8px;
      border: none;
      border-radius: 5px;
      background-color: #f9f9f9;
      margin-top: 3px;
      margin-bottom: 6px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      font-size: 0.85em;
    }
    .password-toggle {
      position: relative;
    }
    .password-toggle .toggle-password {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 18px;
      color: #ccc;
    }
    .password-toggle .toggle-password:hover {
      color: #333;
    }
    .btn {
      display: inline-block;
      background-color: #28a745;
      color: #fff;
      padding: 8px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
      width: 100%;
      font-size: 0.85em;
    }
    .btn:hover {
      background-color: #218838;
    }
    h2 {
      margin-bottom: 10px;
      color: #333;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1em;
    }
    .icon-register {
      font-size: 20px;
      color: #28a745;
      margin-right: 5px;
    }
    p {
      margin-top: 10px;
      font-size: 0.85em;
    }
    a {
      color: #28a745;
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
    .username-hint, .password-hint {
      font-size: 0.75em;
      color: #666;
      margin-top: 3px;
      text-align: left;
    }
    #toast, #error-toast, #pending-toast {
      visibility: hidden;
      min-width: 250px;
      margin-left: -125px;
      background-color: #333;
      color: #fff;
      text-align: center;
      border-radius: 2px;
      padding: 16px;
      position: fixed;
      z-index: 1;
      left: 50%;
      bottom: 30px;
      font-size: 17px;
    }
    #toast.show, #error-toast.show, #pending-toast.show {
      visibility: visible;
      -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
      animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }
    @-webkit-keyframes fadein {
      from {bottom: 0; opacity: 0;}
      to {bottom: 30px; opacity: 1;}
    }
    @keyframes fadein {
      from {bottom: 0; opacity: 0;}
      to {bottom: 30px; opacity: 1;}
    }
    @-webkit-keyframes fadeout {
      from {bottom: 30px; opacity: 1;}
      to {bottom: 0; opacity: 0;}
    }
    @keyframes fadeout {
      from {bottom: 30px; opacity: 1;}
      to {bottom: 0; opacity: 0;}
    }
  </style>
</head>
<body>

  <div class="container">
    <h2><i class="fas fa-user-plus icon-register"></i>Register to the Library</h2>
    <form action="proses_register.php" method="post" onsubmit="return validateForm()">
      <div class="form-group">
        <label for="nama_lengkap"><i class="fas fa-user"></i> Nama Lengkap:</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" required>
      </div>
      <div class="form-group">
        <label for="nip"><i class="fas fa-id-card"></i> NIP:</label>
        <input type="text" id="nip" name="nip" required>
      </div>
      <div class="form-group">
        <label for="jabatan"><i class="fas fa-briefcase"></i> Jabatan:</label>
        <input type="text" id="jabatan" name="jabatan" required>
      </div>
      <div class="form-group">
        <label for="email"><i class="fas fa-envelope"></i> Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="username"><i class="fas fa-user"></i> Username:</label>
        <input type="text" id="username" name="username" required>
        <p class="username-hint">Tidak Boleh Menggunakan Spasi</p>
      </div>
      <div class="form-group password-toggle">
        <label for="password"><i class="fas fa-lock"></i> Password:</label>
        <input type="password" id="password" name="password" required>
        <span class="toggle-password">&#x1F441;</span>
      </div>
      <p class="password-hint">Isi Menggunakan Huruf dan Angka</p>
      <button type="submit" class="btn">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
  </div>

  <div id="toast">Akun berhasil terdaftar!</div>
  <div id="error-toast">Akun sudah terdaftar!</div>
  <div id="pending-toast">Akun berhasil terdaftar, menunggu persetujuan!</div>

  <script>
    function validateForm() {
      var username = document.getElementById("username").value;
      var password = document.getElementById("password").value;
      
      if (username.length > 10 || password.length > 10) {
        alert("Username dan password harus terdiri dari 10 karakter atau kurang.");
        return false; // Prevent form submission
      }
      return true; // Allow form submission
    }

    function togglePassword() {
      var passwordField = document.getElementById("password");
      var toggleIcon = document.querySelector(".toggle-password");
      if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.innerHTML = "&#x1F440;";
      } else {
        passwordField.type = "password";
        toggleIcon.innerHTML = "&#x1F441;";
      }
    }
    document.querySelector(".toggle-password").addEventListener("click", togglePassword);

    function showToast(message, id) {
      var toast = document.getElementById(id);
      toast.innerText = message;
      toast.className = "show";
      setTimeout(function() { toast.className = toast.className.replace("show", ""); }, 3000);
    }

    document.addEventListener("DOMContentLoaded", function() {
      const urlParams = new URLSearchParams(window.location.search);
      console.log(urlParams.toString()); // Print URL parameters
      if (urlParams.has('success')) {
        console.log('Success parameter:', urlParams.get('success'));
        if (urlParams.get('success') === 'awaiting_approval') {
          showToast('Akun berhasil terdaftar, menunggu persetujuan!', 'pending-toast');
        } else if (urlParams.get('success') === 'registered') {
          showToast('Akun berhasil terdaftar!', 'toast');
        }
      }
      if (urlParams.has('error') && urlParams.get('error') === 'user_exists') {
        showToast('Akun sudah terdaftar!', 'error-toast');
      }
    });

    function formatFirstLetterUppercase(event) {
      var input = event.target;
      var value = input.value;
      if (value.length > 0) {
        input.value = value.charAt(0).toUpperCase() + value.slice(1);
      }
    }

    document.getElementById("username").addEventListener("input", formatFirstLetterUppercase);
    document.getElementById("password").addEventListener("input", formatFirstLetterUppercase);
  </script>

</body>
</html>